<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ProductResource;
use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends Controller
{
    #Product List
    public function index(Request $request){
        $products = $request->user()->business_organization
            ->products()
            ->searchBy($request)
            ->with(['product_image', 'category','brand', 'unit', 'color', 'size']);
        $products = build_collection_response($request, $products);
        $products = ProductResource::collection($products);

        return collection_response($products, 'Success', ResponseAlias::HTTP_OK, 'Products get successfully');
    }

    #Product Show
    public function show(Request $request, $id){
        try {
            $product = $request->user()->business_organization->products()->where('id', $id)
                ->with('category', 'brand', 'unit', 'color', 'size', 'product_image')->first();
            if (empty($product)){
                throw new Exception('Product not found');
            }

            $product = new ProductResource($product);
            return json_response('Success', ResponseAlias::HTTP_OK, $product, 'Product get successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Product Store
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|max:55',
            'product_code' => 'required|max:55',
            'low_stock' => 'required',
            'variation_products' => 'required',
            'product_details' => 'nullable|max:255'
        ], [
            'variation_products.*price' => 'required',
            'variation_products.*current_stock' => 'required',
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            DB::beginTransaction();
            foreach ($request->get('variation_products') as $variant_product){
                $product = $request->user()->business_organization->products()->create([
                    'category_id' => $request->get('category_id'),
                    'brand_id' => $request->get('brand_id'),
                    'unit_id' => !empty($request->get('unit')) ? $request->get('unit') : null,
                    'color_id' => !empty($variant_product['color']) ? $variant_product['color'] : null,
                    'size_id' => !empty($variant_product['size']) ? $variant_product['size'] : null,
                    'product_name' =>$request->get('product_name'),
                    'product_code' => $request->get('product_code'),
                    'product_slug' =>  Str::slug($request->get('product_name')),
                    'product_price' => $variant_product['price'],
                    'product_stock_qty' => $variant_product['current_stock'],
                    'low_stock' => $request->get('low_stock'),
                    'product_details' => $request->get('product_details'),
                    'product_barcode' => $request->get('product_barcode'),
                    'is_variant' => $request->get('is_variant'),
                    'status' => Product::Status['Active']
                ]);
                if (empty($product)){
                    throw new Exception('Could not create product');
                }
            }

            if ($request->get('image')) {
                $new_name = $this->uploadImage($request);

                $product_image = $product->product_image()->create([
                    'image_name' => $new_name,
                    'image_original_name' => $new_name,
                    'image_path' => 'storage/'.$new_name,
                    'status' => ProductImage::Status['Active']
                ]);
                if (empty($product_image)){
                    throw new Exception('Could not create product image');
                }
            }

            /*if ($request->hasFile('image')){
                $original_name = $request->image->getClientOriginalName();
                $file_path = Storage::disk('public')->put('product_images', $request->image);


                $product_image = $product->product_image()->create([
                    'image_name' => $original_name,
                    'image_original_name' => $original_name,
                    'image_path' => $file_path,
                    'status' => ProductImage::Status['Active']
                ]);

                if (empty($product_image)){
                    throw new Exception('Could not create product image');
                }
            }*/
            DB::commit();
            $product = new ProductResource($product->load(['product_image', 'category','brand', 'unit', 'color', 'size']));

            return json_response('Success', ResponseAlias::HTTP_OK, $product, 'Product added successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Product Update
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|max:55',
            'product_code' => 'required|max:55',
            'low_stock' => 'required',
            'variation_product' => 'required',
            'product_details' => 'nullable|max:255'
        ], [
            'variation_product.*price' => 'required',
            'variation_product.*current_stock' => 'required',
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            $product = $request->user()->business_organization->products()->where('id', $id)->first();
            if (empty($product)){
                throw new Exception('Product not found');
            }

            $productU = $product->update([
                'category_id' => $request->get('category_id'),
                'brand_id' => $request->get('brand_id'),
                'unit_id' => !empty($request->get('unit')) ? $request->get('unit') : null,
                'color_id' => !empty($request->get('variation_product')['color']) ? $request->get('variation_product')['color'] : null,
                'size_id' => !empty($request->get('variation_product')['size']) ? $request->get('variation_product')['size'] : null,
                'product_name' =>$request->get('product_name'),
                'product_code' => $request->get('product_code'),
                'product_slug' =>  Str::slug($request->get('product_name')),
                'product_price' => $request->get('variation_product')['price'],
                'product_stock_qty' => $request->get('variation_product')['current_stock'],
                'low_stock' => $request->get('low_stock'),
                'product_details' => $request->get('product_details'),
                'product_barcode' => $request->get('product_barcode'),
                'is_variant' => $request->get('is_variant'),
                'status' => Product::Status['Active']
            ]);
            if (empty($productU)){
                throw new Exception('Could not updated product');
            }
            if ($request->get('image')) {
                $new_name = $this->uploadImage($request);
                $product_image = $product->product_image()->update([
                    'image_name' => $new_name,
                    'image_original_name' => $new_name,
                    'image_path' => 'storage/'.$new_name,
                    'status' => ProductImage::Status['Active']
                ]);
                if (empty($product_image)){
                    throw new Exception('Could not create product image');
                }
            }
            $product = $product->fresh();
            $product = new ProductResource($product->load('category', 'brand', 'unit', 'color', 'size', 'product_image'));
            return json_response('Success', ResponseAlias::HTTP_OK, $product, 'Product updated successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Product Delete
    public function destroy(Request $request, $id){
        try {
            $product = $request->user()->business_organization->products()->where('id', $id)->first();;
            if (empty($product)){
                throw new Exception('Product not found');
            }
            $product->delete();
            return json_response('Success', ResponseAlias::HTTP_OK, '', 'Product deleted successfully', true);
        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    #Product Status Update
    public function update_status(Request $request, $id){
        try {
            $product = $request->user()->business_organization->products()->where('id', $id)->first();
            if (empty($product)){
                throw new Exception('Product not found');
            }

            $productU = $product->update([
                'status' => $request->get('status')
            ]);
            if (empty($productU)){
                throw new Exception('Product status could not updated');
            }
            $product = new ProductResource($product->load('category', 'brand', 'unit', 'color', 'size', 'product_image')->fresh());
            return json_response('Success', ResponseAlias::HTTP_OK, $product, 'Product status updated successfully', true);
        } catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function uploadImage(Request $request): string
    {
        $file_data = $request->get('image');
        $image_parts = explode(";base64,", $file_data);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $new_name = Str::random(20) . '.' . $image_type;
        if ($file_data) {
            Storage::disk('public')->put($new_name, base64_decode($image_parts[1]));
        }
        return $new_name;
    }
}
