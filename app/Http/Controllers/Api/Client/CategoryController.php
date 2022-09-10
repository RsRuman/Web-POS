<?php

namespace App\Http\Controllers\Api\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Client\CategoryResource;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = $request->user()->business_organization->categories();
        $categories = build_collection_response($request, $categories);
        $categories = CategoryResource::collection($categories);
        return collection_response($categories, 'Success', ResponseAlias::HTTP_OK, 'Category list get successfully');
    }

    public function show(Request $request, $id){
        try {
            $category = $request->user()->business_organization->categories()->where('id', $id)->first();
            if (empty($category)){
                throw new Exception('Category not found');
            }

            $category = new CategoryResource($category);
            return json_response('Success', ResponseAlias::HTTP_OK, $category, 'Category get successfully', true);
        }catch (Exception $ex){
            return json_response('Success', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'nullable',
            'category_name' => 'required|max:55|unique:categories',
            'icon' => 'nullable'
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            DB::beginTransaction();
            $category = $request->user()->business_organization->categories()->create([
                'parent_id' => $request->get('parent_id'),
                'category_name' => $request->get('category_name'),
                'category_slug' => Str::slug($request->get('category_name')),
                'icon' => $request->get('icon'),
                'status' => Category::Status['Active']
            ]);

            if (empty($category)){
                throw new Exception('Could not create category');
            }

            DB::commit();
            $category = new CategoryResource($category);
            return json_response('Success', ResponseAlias::HTTP_OK, $category, 'Category created successfully', true);
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'nullable',
            'category_name' => 'required|max:55|unique:categories,category_name,'.$id,
            'icon' => 'nullable'
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            DB::beginTransaction();
            $category = $request->user()->business_organization->categories()->where('id', $id)->first();
            if (empty($category)){
                throw new Exception('Category not found');
            }

            $categoryU = $category->update([
                'parent_id' => $request->get('parent_id'),
                'category_name' => $request->get('category_name'),
                'category_slug' => Str::slug($request->get('category_name'))
            ]);

            if (empty($categoryU)){
                throw new Exception('Could not update category');
            }

            DB::commit();
            $category = new CategoryResource($category->fresh());
            return json_response('Success', ResponseAlias::HTTP_OK, $category, 'Category updated successfully', true);
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $category = $request->user()->business_organization->categories()->where('id', $id)->first();
            if (empty($category)){
                throw new Exception('Category not found');
            }
            $category->delete();
            return json_response('Success', ResponseAlias::HTTP_OK, '', 'Category deleted successfully', true);
        } catch (Exception $ex) {
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }
}
