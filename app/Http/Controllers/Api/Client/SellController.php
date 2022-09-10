<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\SellMasterResource;
use App\Models\Product;
use App\Models\SellItem;
use App\Models\SellMaster;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SellController extends Controller
{
    public function index(Request $request){
        $sell_masters = SellMaster::with(['sell_items', 'customer']);
        $sell_masters = build_collection_response($request, $sell_masters);
        $sell_masters = SellMasterResource::collection($sell_masters);

        return collection_response($sell_masters, 'Success', ResponseAlias::HTTP_OK, 'Sell masters get successfully');
    }

    public function show(Request $request, $id){

    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
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
            $sell_master = SellMaster::create([
                'bus_org_id' => $request->user()->business_organization->id,
                'customer_id' => $request->get('customer_id'),
                'invoice_no' => 'PM'.Str::random(16),
                'total_qty' => count($request->get('products')),
                'sub_total_amount' => array_sum(array_map( function ($item) {
                    return $item['item_subtotal'];
                }, $request->get('products'))),
                'total_amount' => array_sum(array_map( function ($item) {
                    return $item['item_total'];
                }, $request->get('products'))),
                'discount_amount' => array_sum(array_map(function ($item) {
                    return $item['item_discount'];
                }, $request->get('products'))),
                'due_amount' => $request->get('due_amount'),
                'status' => SellMaster::Status['Active']
            ]);
            if (empty($sell_master)){
                throw new Exception('Sell master not created');
            }

            foreach ($request->get('products') as $product){
                $purchase_item = $sell_master->sell_items()->create([
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
                    'status' => SellItem::Status['Active']
                ]);
                if (empty($purchase_item)){
                    throw new Exception('Product not created');
                }
            }

            DB::commit();
            $data = new SellMasterResource($sell_master->load('sell_items'));
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
