<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\InvestmentResource;
use App\Http\Resources\Client\SupplierResource;
use App\Models\Investment;
use App\Models\Supplier;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class InvestmentController extends Controller
{
    #Investment List
    public function index(Request $request){
        $investments = $request->user()->business_organization->investments()->with('investor')->notDelete();
        $investments = build_collection_response($request, $investments);
        $investments = InvestmentResource::collection($investments);

        return collection_response($investments, 'Success', ResponseAlias::HTTP_OK, 'Investments get successfully');
    }

    #Investment Store
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'investment_date' => 'nullable|date',
            'investment_amount' => 'required',
            'investor_id' => 'required',
            'note' => 'nullable|max:255',
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            $investment = Investment::create([
                'user_id' => $request->investor_id,
                'bus_org_id' => $request->user()->bus_org_id,
                'investment_date' => !empty($request->get('investment_date')) ? Carbon::parse( $request->get('investment_date'))->format('Y-m-d'): today(),
                'investment_amount' => $request->get('investment_amount'),
                'note' => !empty($request->get('note'))? $request->get('note'): null,
                'status' => config('app.active')
            ]);

            if (empty($investment)){
                throw new Exception('Could not create investment. Please try again');
            }
            $investment = new InvestmentResource($investment);
            return json_response('Success', ResponseAlias::HTTP_OK, $investment, 'Investment added successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Investment Show
    public function show(Request $request, $id){
        try {
            $investment = $request->user()->business_organization->investments()
                ->where('id', $id)
                ->with('investor')
                ->first();
            if (empty($investment)){
                throw new Exception('Investment not found');
            }

            $investment = new InvestmentResource($investment);
            return json_response('Success', ResponseAlias::HTTP_OK, $investment, 'Investment get successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Investment Update
    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'investment_date' => 'nullable|date',
            'investment_amount' => 'required',
            'investor_id' => 'required',
            'note' => 'nullable|max:255',
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            $investment = $request->user()->business_organization->investments()->where('id', $id)->first();
            if (empty($investment)){
                throw new Exception('Investment not found');
            }
            $investmentU = $investment->update([
                'user_id'=> $request->investor_id,
                'investment_date' => !empty($request->get('investment_date')) ? Carbon::parse($request->get('investment_date'))->format('Y-m-d') : today(),
                'investment_amount' => $request->get('investment_amount'),
                'note' => !empty($request->get('note')) ? $request->get('note') : null,
                'status' => config('app.active')
            ]);

            if (empty($investmentU)){
                throw new Exception('Could not update investment. Please try again');
            }
            $investment = new InvestmentResource($investment->load('investor'));
            return json_response('Success', ResponseAlias::HTTP_OK, $investment, 'Investment updated successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Investment Delete
    public function destroy(Request $request, $id){
        try {

            $investment = $request->user()->business_organization->investments()->where('id', $id)->first();
            if (empty($investment)){
                throw new Exception('Investment not found');
            }
            $investmentU = $investment->update([
                'status'=>config('app.delete')
            ]);
            if (empty($investmentU)){
                throw new Exception('Invalid Investment information');
            }
            return json_response('Success', ResponseAlias::HTTP_OK, '', 'Investment deleted successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }
}
