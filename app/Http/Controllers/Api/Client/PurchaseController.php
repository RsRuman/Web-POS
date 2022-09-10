<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\PurchaseMasterResource;
use App\Models\Product;
use App\Models\PurchaseItem;
use App\Models\PurchaseMaster;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PurchaseController extends Controller
{
    public function index(Request $request){
        $purchase_masters = PurchaseMaster::with(['purchase_items', 'supplier']);
        $purchase_masters = build_collection_response($request, $purchase_masters);
        $purchase_masters = PurchaseMasterResource::collection($purchase_masters);

        return collection_response($purchase_masters, 'Success', ResponseAlias::HTTP_OK, 'Purchase masters get successfully');
    }

    public function show(Request $request, $id){

    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'products' => 'required|array',
            'due_amount' => 'required'
        ], [
            'products.*product_id' => 'required',
            'products.*unit_id' => 'required',
            'products.*unit_form' => 'required|max:255',
            'products.*unit_price' => 'required',
            'products.*product_type' => 'required',
            'products.*color_id' => 'nullable',
            'products.*variation_sku' => 'nullable',
            'products.*item_qty' => 'required',
            'products.*item_subtotal' => 'required',
            'products.*item_discount' => 'required',
            'products.*item_total' => 'required'
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            DB::beginTransaction();
            $purchase_master = PurchaseMaster::create([
                'bus_org_id' => $request->user()->business_organization->id,
                'supplier_id' => $request->get('supplier_id'),
                'invoice_no' => 'PM'.Str::random(16),
                'purchase_date' => now(),
                'total_qty' => count($request->get('products')),
                'sub_total' => array_sum(array_map( function ($item) {
                    return $item['item_subtotal'];
                }, $request->get('products'))),
                'discount_amount' => array_sum(array_map(function ($item) {
                    return $item['item_discount'];
                }, $request->get('products'))),
                'due_amount' => $request->get('due_amount'),
                'status' => PurchaseMaster::Status['Active']
            ]);
            if (empty($purchase_master)){
                throw new Exception('Purchase master not created');
            }

            foreach ($request->get('products') as $product){
                $purchase_item = $purchase_master->purchase_items()->create([
                    'product_id' => $product['product_id'],
                    'product_name' => Product::find($product['product_id'])->product_name,
                    'unit_id' => $product['unit_id'],
                    'unit_form' => $product['unit_form'],
                    'unit_price' => $product['unit_price'],
                    'product_type' => $product['product_type'],
                    'color_id' => $product['color_id'],
                    'variation_sku' => $product['variation_sku'],
                    'item_qty' => $product['item_qty'],
                    'item_subtotal' => $product['item_subtotal'],
                    'item_discount' => $product['item_discount'],
                    'item_total' => $product['item_total'],
                    'status' => PurchaseItem::Status['Active']
                ]);
                if (empty($purchase_item)){
                    throw new Exception('Product not created');
                }
            }

            DB::commit();
            $data = new PurchaseMasterResource($purchase_master->load('purchase_items'));
            return json_response('Success', ResponseAlias::HTTP_OK, $data, 'Products added successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    public function update(Request $request, $id){

    }

    public function destroy(Request $request, $id){

    }
}
