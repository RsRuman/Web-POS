<?php

namespace App\Http\Controllers\Admin\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\BusinessOrganizationResource;
use App\Http\Resources\Client\ClientResource;
use App\Models\BusinessOrganization;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ClientController extends Controller
{
    #List Client
    public function index(Request $request){
        $clients = User::whereHas('roles', function($q){
            return $q->where('slug', 'client');
        })->with('business_organization')->notDelete();

        $clients = build_collection_response($request, $clients);
        $clients = ClientResource::collection($clients);
        return inertia('Client/ClientList', compact('clients'));
    }

    #Create Client
    public function create(){
        return inertia('Client/CreateClient');
    }

    #Client Store
    public function store(Request $request){
        $request->validate(([
            'name' => 'required|min:3|max:25',
            'email' => 'required|email|max:55|unique:users',
            'phone_no' => 'required|max:11|unique:users',
            'password' => 'required|min:8|max:15|confirmed',
            'bus_name' => 'required|max:55',
            'bus_phone_no' => 'required|max:11|unique:business_organizations',
            'bus_email' => 'required|max:55|email|unique:business_organizations',
            'bus_type' => 'required',
            'district_id' => 'nullable',
            'upazila_id' => 'nullable',
            'postal_code' => 'required'
        ]));

        try {
            DB::beginTransaction();
            $business_organization = BusinessOrganization::create([
                'bus_name' => $request->input('bus_name'),
                'bus_phone_no' => $request->input('bus_phone_no'),
                'bus_email' => $request->input('bus_email'),
                'bus_type' => $request->input('bus_type'),
                'district_id' => $request->input('district_id'),
                'upazila_id' => $request->input('upazila_id'),
                'postal_code' => $request->input('postal_code'),
                'status' => config('constant.active')
            ]);

            if (!empty($business_organization)){
                $user = $business_organization->users()->create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone_no' => $request->input('phone_no'),
                    'is_verified' => User::IsVerified['Verified'],
                    'status' => User::Status['Active'],
                    'password' => Hash::make($request->input('password')),
                ]);

                if (!empty($user)){
                    $user->roles()->attach(Role::where('slug', 'client')->first());
                    $user->permissions()->sync([1,2,3,4]);

                    DB::commit();
                    return Redirect::route('admin.client.index')->with('success', 'Client and Business organization created successfully');
                }
                throw new Exception('Could not create user');
            }
            throw new Exception('Could not create business organization');
        }catch (Exception $exception){
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }

    #Client Edit
    public function edit(Request $request, $id){
        $client = User::where('id', $id)->whereHas('roles', function($q){
            return $q->where('slug', 'client');
        })->with('business_organization')->first();

        $client = new ClientResource($client);

        if (empty($client)){
            return abort(404);
        }
        return inertia('Client/EditClient', compact('client'));
    }

    #Client Update
    public function update(Request $request, $id){
        $client = User::where('id', $id)->whereHas('roles', function($q){
            return $q->where('slug', 'client');
        })->with('business_organization')->first();


        $request->validate(([
            'name' => 'required|min:3|max:25',
            'email' => 'required|email|max:55|unique:users,email,'.$client->id,
            'phone_no' => 'required|max:11|unique:users,phone_no,'.$client->id,
            'bus_phone_no' => 'required|max:11|unique:business_organizations,bus_phone_no,'.$client->business_organization->id,
            'bus_email' => 'required|max:55|email|unique:business_organizations,bus_email,'.$client->business_organization->id,
            'bus_type' => 'required',
            'district_id' => 'nullable',
            'upazila_id' => 'nullable',
            'postal_code' => 'required'
        ]));

        try {
            DB::beginTransaction();
            $client = User::where('id', $id)->whereHas('roles', function($q){
                return $q->where('slug', 'client');
            })->with('business_organization')->first();

            if(empty($client)){
                throw new Exception('Client not found');
            }

            $client_business_organizationU = $client->business_organization->update([
                'bus_name' => $request->input('bus_name'),
                'bus_phone_no' => $request->input('bus_phone_no'),
                'bus_email' => $request->input('bus_email'),
                'bus_type' => $request->input('bus_type'),
                'district_id' => $request->input('district_id'),
                'upazila_id' => $request->input('upazila_id'),
                'postal_code' => $request->input('postal_code'),
                'status' => BusinessOrganization::Status['Active']
            ]);

            if (!empty($client_business_organizationU)){
                $client = $client->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone_no' => $request->input('phone_no'),
                    'status' => User::Status['Active'],
                ]);
                if (!empty($client)){
                    DB::commit();
                    return Redirect::route('admin.client.index')->with('success', 'Client and Business organization updated successfully');
                }
                throw new Exception('Could not update user');
            }
            throw new Exception('Could not update business organization');
        }catch (Exception $exception){
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }

    #Client Destroy
    public function destroy($id){
        try {
            $client = User::where('id', $id)->whereHas('roles', function($q){
                return $q->where('slug', 'client');
            })->with('business_organization')->first();

            if (empty($client)){
                throw new Exception('Client and business organization not found');
            }
            $client->business_organization->delete();
            $client->delete();

            return json_response('Success', ResponseAlias::HTTP_OK, '', 'Client organization deleted successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

}
