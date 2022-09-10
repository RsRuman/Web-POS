<?php

namespace App\Http\Controllers\Admin\Measurement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\SizeResource;
use App\Models\Size;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SizeController extends Controller
{
    #Size List
    public function index(Request $request){
        $sizeList = Size::query()->notDelete();
        $sizeList = build_collection_response($request, $sizeList);
        $sizeList = SizeResource::collection($sizeList);
        return inertia('Measurement/Size', compact('sizeList'));
    }

    #Size Store
    public function store(Request $request){
        $request->validate([
            'size_name' => 'required|max:25|unique:sizes',
            'short_form' => 'required|max:25'
        ]);

        try {
            $size = Size::create([
                'size_name' => $request->get('size_name'),
                'short_form' => $request->get('short_form'),
                'status' => config('constant.active')
            ]);
            if (empty($size)){
                throw new Exception('Could create size');
            }

            return Redirect::route('admin.size.index')->with('success', 'Size created successfully');
        } catch (Exception $ex){
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    #Size Update
    public function update(Request $request, $id){
        $request->validate([
            'size_name' => 'required|max:25|unique:sizes,size_name,'.$id,
            'short_form' => 'required|max:25'
        ]);

        try {
            $size = Size::find($id);
            if (empty($size)){
                throw new Exception('Size not found');
            }

            $sizeU = $size->update([
                'size_name' => $request->get('size_name'),
                'short_form' => $request->get('short_form')
            ]);
            if (empty($sizeU)){
                throw new Exception('Could not update size');
            }

            return Redirect::route('admin.size.index')->with('success', 'Size updated successfully');
        } catch (Exception $ex){
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    #Size Delete
    public function destroy($id){
        try {
            $size = Size::find($id);
            if (empty($size)){
                throw new Exception('Size not found');
            }

            $size->delete();
            return json_response('Success', ResponseAlias::HTTP_OK, '', 'Size deleted successfully', true);

        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }
}
