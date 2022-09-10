<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\InvestmentResource;
use App\Http\Resources\Client\UserResource;
use App\Models\Investment;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ManagerController extends Controller
{
    #Manager List
    public function index(Request $request){
        $managers = User::where('bus_org_id', $request->user()->business_organization->id)
            ->whereHas('roles', function($q){
            return $q->where('slug', 'manager');
        })->with('roles', 'permissions');

        $managers = build_collection_response($request, $managers);
        $managers = UserResource::collection($managers);

        return collection_response($managers,'Success', ResponseAlias::HTTP_OK, 'Manager List Get Successfully');
    }

    #Manager Show
    public function show(Request $request, $id){
        $manager = User::where('bus_org_id', $request->user()->business_organization->id)
            ->where('id', $id)
            ->whereHas('roles', function($q){
                return $q->where('slug', 'manager');
            })
            ->with('permissions')
            ->first();
        if (empty($manager)){
            return json_response('Failed', ResponseAlias::HTTP_NOT_FOUND, '', 'Manager information not found', false);
        }

        $manager = new UserResource($manager);
        return json_response('Success', ResponseAlias::HTTP_OK, $manager, 'Manager get successfully', true);
    }

    #Manager Store
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|max:25',
            'email' => 'required|email|max:55|unique:users',
            'phone_no' => 'required|max:11|unique:users',
            'password' => 'required|min:8|max:15|confirmed',
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            DB::beginTransaction();
            $manager = User::create([
                'bus_org_id' => $request->user()->bus_org_id,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone_no' => $request->input('phone_no'),
                'password' => Hash::make($request->input('password')),
                'is_verified' => User::IsVerified['Verified'],
                'status' => config('app.active')
            ]);

            if (!empty($manager)){
                $manager->roles()->attach(Role::where('slug', 'manager')->first());
                //TODO add default some permission as per client set
                $manager->permissions()->sync([1,2,3,4]);

                $manager = new UserResource($manager->load('roles', 'permissions'));
                DB::commit();
                return json_response('Success', ResponseAlias::HTTP_OK, $manager, 'Manager created successfully', true);
            }
            throw new Exception('Could not create manager');
        }catch (\Exception $ex){
            DB::rollBack();
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Manager Update
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|max:25',
            'email' => 'required|email|max:55|unique:users,email,'.$id,
            'phone_no' => 'required|max:11|unique:users,phone_no,'.$id,
            'password' => 'required|min:8|max:15|confirmed',
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            DB::beginTransaction();
            $manager = User::where('bus_org_id', $request->user()->bus_org_id)
                ->where('id', $id)
                ->whereHas('roles', function($q){
                    return $q->where('slug', 'manager');
                })->first();
            if (empty($manager)){
                throw new Exception('Manager not found');
            }
            $managerU = $manager->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone_no' => $request->input('phone_no'),
                'password' => Hash::make($request->input('password')),
                'is_verified' => User::IsVerified['Verified'],
                'status' =>  !empty($request->status)? $request->status: $manager->status
            ]);

            if (!empty($managerU)){
                $manager = new UserResource($manager->load('roles', 'permissions'));
                DB::commit();
                return json_response('Success', ResponseAlias::HTTP_OK, $manager, 'Manager updated successfully', true);
            }
            throw new Exception('Could not update manager');
        }catch (\Exception $ex){
            DB::rollBack();
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Assign Permission To Manager
    public function assign_permissions(Request $request, $id){
        try {
            $manager = User::where('bus_org_id', $request->user()->bus_org_id)
                ->where('id', $id)
                ->whereHas('roles', function($q){
                    return $q->where('slug', 'manager');
                })->first();

            if (empty($manager)){
                throw new Exception('Manager not found');
            }
            $manager->permissions()->sync($request->get('permissions'));
            $manager = new UserResource($manager->load('roles', 'permissions'));

            return json_response('Success', ResponseAlias::HTTP_OK, $manager, 'Manager permission updated successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Update Permissions
    public function update_permissions(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'permissions' => 'required|array'
        ]);

        if ($validator->fails()) {
            return validation_response($validator->errors()->getMessages());
        }

        try {
            $manager = $request->user()->business_organization->users()
                ->where('id', $id)
                ->whereHas('roles', function ($q) {
                    return $q->where('slug', 'manager');
                })->first();

            if (empty($manager)) {
                throw new Exception('Manager not found');
            }

            $permissions_check = Permission::whereIn('id', $request->get('permissions'))->pluck('id');
            $manager->permissions()->sync($permissions_check);
            $manager = new UserResource($manager->load('permissions'));
            return json_response('Success', ResponseAlias::HTTP_OK, $manager, 'Permission updated successfully', true);
        } catch (Exception $ex) {
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }
}
