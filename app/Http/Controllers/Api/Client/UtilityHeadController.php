<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\UtilityHeadResource;
use App\Http\Resources\Client\WithdrawResource;
use App\Models\Withdraw;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UtilityHeadController extends Controller
{
    #Utility List
    public function index(Request $request){
        $utility_heads = $request->user()->business_organization->utility_heads();
        $utility_heads = build_collection_response($request, $utility_heads);
        $utility_heads = UtilityHeadResource::collection($utility_heads);

        return collection_response($utility_heads, 'Success', ResponseAlias::HTTP_OK, 'Utility heads get successfully');
    }

    #Utility Show
    public function Show(Request $request, $id){
        try {
            $utility_head = $request->user()->business_organization->utility_heads()->where('id', $id)->first();
            if (empty($utility_head)){
                throw new Exception('Utility head not found');
            }

            $utility_head = new UtilityHeadResource($utility_head);
            return json_response('Success', ResponseAlias::HTTP_OK, $utility_head, 'Utility head get successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Utility Store
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'head_name' => 'required|max:55',
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            $utility_head = $request->user()->business_organization->utility_heads()->create([
                'head_name' => $request->get('head_name'),
                'status' => Withdraw::Status['Active']
            ]);

            if (empty($utility_head)){
                throw new Exception('Could not create utility head. Please try again');
            }
            $utility_head = new UtilityHeadResource($utility_head);
            return json_response('Success', ResponseAlias::HTTP_OK, $utility_head, 'Utility head added successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Utility Update
    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'head_name' => 'required|max:55',
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            $utility_head = $request->user()->business_organization->utility_heads()->where('id', $id)->first();
            if (empty($utility_head)){
                throw new Exception('Utility head not found');
            }
            $utility_headU = $utility_head->update([
                'head_name' => $request->get('head_name'),
                'status' => Withdraw::Status['Active']
            ]);

            if (empty($utility_headU)){
                throw new Exception('Could not update utility head. Please try again');
            }
            $utility_head = new UtilityHeadResource($utility_head);
            return json_response('Success', ResponseAlias::HTTP_OK, $utility_head, 'Utility head updated successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Utility Delete
    public function destroy(Request $request){

    }
}
