<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Resources\Client\CustomerResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Illuminate\Support\Facades\Validator;
use Exception;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = $request->user()->business_organization->customers()->notDetete();
        $customers = build_collection_response($request, $customers);
        $customers = CustomerResource::collection($customers);
        return collection_response($customers, 'Success', ResponseAlias::HTTP_OK, 'Customers get successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_code' => 'required|max:25',
            'customer_name' => 'required|max:55',
            'customer_phone' => 'nullable|max:11|unique:customers',
            'customer_email' => 'nullable|email|max:25|unique:customers',
            'customer_address' => 'nullable|max:255',
            'customer_due' => 'nullable',
            'customer_advance' => 'nullable'
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            DB::beginTransaction();
            $customer = $request->user()->business_organization->customers()->create([
                'customer_code' => $request->get('customer_code'),
                'customer_name' => $request->get('customer_name'),
                'customer_phone' => $request->get('customer_phone'),
                'customer_email' => $request->get('customer_email'),
                'customer_address' => $request->get('customer_address'),
                'customer_due' => !empty($request->get('customer_due'))? $request->get('customer_due'): 0,
                'customer_advance' => !empty($request->get('customer_advance'))? $request->get('customer_advance'): 0,
                'status' => config('app.active')
            ]);
            if (empty($customer)) {
                throw new Exception('Could not create customer');
            }
            DB::commit();
            $customer = new CustomerResource($customer);
            return json_response('Success', ResponseAlias::HTTP_OK, $customer, 'Customer created successfully', true);
        } catch (Exception $ex) {
            DB::rollBack();
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    public function show(Request $request, $id){
        try {
            $customer = $request->user()->business_organization->customers()->where('id', $id)->first();
            if (empty($customer)){
                throw new Exception('Customer not found');
            }
            $customer = new CustomerResource($customer);
            return json_response('Success', ResponseAlias::HTTP_OK, $customer, 'Customer get successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_code' => 'required|max:25',
            'customer_name' => 'required|max:55',
            'customer_phone' => 'nullable|max:11|unique:customers,customer_phone,'.$id,
            'customer_email' => 'nullable|email|max:25|unique:customers,customer_email,'.$id,
            'customer_address' => 'nullable|max:255',
            'customer_due' => 'nullable',
            'customer_advance' => 'nullable'
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            DB::beginTransaction();
            $customer = $request->user()->business_organization->customers()->where('id', $id)->first();
            if (empty($customer)){
                throw new Exception('Customer not found');
            }

            $customerU = $customer->update([
                'customer_code' => $request->get('customer_code'),
                'customer_name' => $request->get('customer_name'),
                'customer_phone' => $request->get('customer_phone'),
                'customer_email' => $request->get('customer_email'),
                'customer_address' => $request->get('customer_address'),
                'customer_due' => $request->get('customer_due'),
                'customer_advance' => $request->get('customer_advance')
            ]);

            if (empty($customerU)){
                throw new Exception('Could not update customer');
            }
            DB::commit();
            $customer = new CustomerResource($customer->fresh());
            return json_response('Success', ResponseAlias::HTTP_OK, $customer, 'Customer updated successfully', true);
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $customer = $request->user()->business_organization->customers()->where('id', $id)->first();
            if (empty($customer)) {
                throw new Exception('Invalid Customer Information');
            }
            $customer->delete();
            return json_response('Success', ResponseAlias::HTTP_OK, '', 'Customer deleted successfully', true);
        } catch (Exception $ex) {
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }
}
