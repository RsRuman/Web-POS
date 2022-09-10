<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\InvestmentResource;
use App\Http\Resources\Client\WithdrawResource;
use App\Models\Investment;
use App\Models\Supplier;
use App\Models\Withdraw;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class WithdrawController extends Controller
{
    #Withdraw List
    public function index(Request $request){
        $withdraws = $request->user()->business_organization->withdraws()->notDelete()->with('investor');
        $withdraws = build_collection_response($request, $withdraws);
        $withdraws = WithdrawResource::collection($withdraws);
        return collection_response($withdraws, 'Success', ResponseAlias::HTTP_OK, 'Withdraws get successfully');
    }

    #Withdraw Show
    public function show(Request $request, $id){
        try {
            $withdraw = $request->user()->business_organization->withdraws()
                ->where('id', $id)
                ->with('investor')
                ->first();
            if (empty($withdraw)){
                throw new Exception('Withdraw not found');
            }

            $withdraw = new WithdrawResource($withdraw);
            return json_response('Success', ResponseAlias::HTTP_OK, $withdraw, 'Withdraw get successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Withdraw Store
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'withdraw_date' => 'nullable|date',
            'withdraw_amount' => 'required',
            'investor_id' => 'required',
            'note' => 'nullable|max:255',
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            //TODO Check total amount of user or business organization wallet
            $withdraw =$request->user()->business_organization->withdraws()->create([
                'user_id' => $request->investor_id,
                'withdraw_date' => !empty($request->get('withdraw_date')) ? Carbon::parse($request->get('withdraw_date'))->format('Y-m-d'): today(),
                'withdraw_amount' => $request->get('withdraw_amount'),
                'note' => $request->get('note'),
                'status' => config('app.active')
            ]);

            if (empty($withdraw)){
                throw new Exception('Could not create withdraw. Please try again');
            }
            $withdraw = new WithdrawResource($withdraw->load('investor'));
            return json_response('Success', ResponseAlias::HTTP_OK, $withdraw, 'Withdraw added successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Withdraw Update
    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'withdraw_date' => 'nullable|date',
            'withdraw_amount' => 'required',
            'investor_id' => 'required',
            'note' => 'nullable|max:255',
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            $withdraw = $request->user()->business_organization->withdraws()->where('id', $id)->first();
            if (empty($withdraw)){
                throw new Exception('Investment not found');
            }
            $withdrawU = $withdraw->update([
                'user_id'=>$request->investor_id,
                'withdraw_date' => !empty($request->get('withdraw_date')) ? Carbon::parse($request->get('withdraw_date'))->format('Y-m-d') : today(),
                'withdraw_amount' => $request->get('withdraw_amount'),
                'note' => $request->get('note'),
                'status' => config('app.active')
            ]);

            if (empty($withdrawU)){
                throw new Exception('Could not update withdraw. Please try again');
            }
            $withdraw = new WithdrawResource($withdraw->load('investor'));
            return json_response('Success', ResponseAlias::HTTP_OK, $withdraw, 'Withdraw updated successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Withdraw Delete
    public function destroy(Request $request){

    }
}
