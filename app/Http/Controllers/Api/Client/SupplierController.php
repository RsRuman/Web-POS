<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\SupplierResource;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SupplierController extends Controller
{
    #Supplier List
    public function index(Request $request){
        $suppliers = $request->user()->business_organization->suppliers()->notDelete();
        $suppliers = build_collection_response($request, $suppliers);
        $suppliers = SupplierResource::collection($suppliers);
        return collection_response($suppliers, 'Success', ResponseAlias::HTTP_OK, 'Suppliers get successfully');
    }

    #Supplier Show
    public function show(Request $request, $id){
        try {
            $supplier = $request->user()->business_organization->suppliers()->where('id', $id)->first();
            if (empty($supplier)){
                throw new Exception('Supplier not found');
            }

            $supplier = new SupplierResource($supplier);
            return json_response('Success', ResponseAlias::HTTP_OK, $supplier, 'Supplier get successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Supplier Store
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'supplier_code' => 'required|max:255',
            'supplier_name' => 'required|max:255',
            'supplier_phone' => 'required|max:11|unique:suppliers',
            'supplier_email' => 'required|email|unique:suppliers',
            'supplier_address' => 'required|max:255',
            'supplier_due' => 'nullable',
            'supplier_advance' => 'nullable',
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            $supplier = $request->user()->business_organization->suppliers()->create([
                'supplier_code' => $request->get('supplier_code'),
                'supplier_name' => $request->get('supplier_name'),
                'supplier_phone' => $request->get('supplier_phone'),
                'supplier_email' => $request->get('supplier_email'),
                'supplier_address' => $request->get('supplier_address'),
                'supplier_due' => !empty($request->get('supplier_due')) ? $request->get('supplier_due') : 0,
                'supplier_advance' => !empty($request->get('supplier_advance')) ? $request->get('supplier_advance') : 0,
                'status' => config('app.active')
            ]);

            if (empty($supplier)){
                throw new Exception('Could not create supplier. Please try again');
            }
            $supplier = new SupplierResource($supplier);
            return json_response('Success', ResponseAlias::HTTP_OK, $supplier, 'Supplier added successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Supplier Update
    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'supplier_code' => 'required|max:255',
            'supplier_name' => 'required|max:255',
            'supplier_phone' => 'required|max:11|unique:suppliers,supplier_phone,'.$id,
            'supplier_email' => 'required|email|unique:suppliers,supplier_email,'.$id,
            'supplier_address' => 'required|max:255',
            'supplier_due' => 'nullable',
            'supplier_advance' => 'nullable',
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            $supplier = $request->user()->business_organization->suppliers()->where('id', $id)->first();
            if (empty($supplier)){
                throw new Exception('Supplier not found');
            }
            $supplierU = $supplier->update([
                'supplier_code' => !empty($request->get('supplier_code')) ? $request->get('supplier_code') : $supplier->supplier_code,
                'supplier_name' => !empty($request->get('supplier_name')) ? $request->get('supplier_name') : $supplier->supplier_name,
                'supplier_phone' => !empty($request->get('supplier_phone')) ? $request->get('supplier_phone') : $supplier->supplier_phone,
                'supplier_email' => !empty($request->get('supplier_email')) ? $request->get('supplier_email') : $supplier->supplier_email,
                'supplier_address' => !empty($request->get('supplier_address')) ? $request->get('supplier_address') : $supplier->supplier_address,
                'supplier_due' => !empty($request->get('supplier_due')) ? $request->get('supplier_due') : $supplier->supplier_due,
                'supplier_advance' => !empty($request->get('supplier_advance')) ? $request->get('supplier_advance') : $supplier->supplier_advance,
                'status' => config('app.active')
            ]);

            if (empty($supplierU)){
                throw new Exception('Could not update supplier. Please try again');
            }
            $supplier = new SupplierResource($supplier);
            return json_response('Success', ResponseAlias::HTTP_OK, $supplier, 'Supplier updated successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Supplier Delete
    public function destroy(Request $request){

    }
}
