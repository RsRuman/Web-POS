<?php

namespace App\Http\Controllers\Admin\Measurement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ColorResource;
use App\Models\Color;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ColorController extends Controller
{
    #Color List
    public function index(Request $request){
        $colorList = Color::query()->notDelete();
        $colorList = build_collection_response($request, $colorList);
        $colorList = ColorResource::collection($colorList);
        return inertia('Measurement/Color', compact('colorList'));
    }

    #Color Store
    public function store(Request $request){
        $request->validate([
            'color_name' => 'required|max:25|unique:colors',
            'color_code' => 'required|max:25'
        ]);

        try {
            $color = Color::create([
                'color_name' => $request->get('color_name'),
                'color_code' => $request->get('color_code'),
                'status' => Color::Status['Active']
            ]);
            if (empty($color)){
                throw new Exception('Could create color');
            }

            return Redirect::route('admin.color.index')->with('success', 'Color created successfully');
        } catch (Exception $ex){
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    #Color Update
    public function update(Request $request, $id){
        $request->validate([
            'color_name' => 'required|max:25|unique:colors,color_name,'.$id,
            'color_code' => 'required|max:25'
        ]);

        try {
            $color = Color::find($id);
            if (empty($color)){
                throw new Exception('Color not found');
            }

            $colorU = $color->update([
                'color_name' => $request->get('color_name'),
                'color_code' => $request->get('color_code')
            ]);
            if (empty($colorU)){
                throw new Exception('Could not update color');
            }

            return Redirect::route('admin.color.index')->with('success', 'Color updated successfully');
        } catch (Exception $ex){
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    #Color Delete
    public function destroy($id){
        try {
            $color = Color::find($id);
            if (empty($color)){
                throw new Exception('Color not found');
            }

            $color->delete();
            return json_response('Success', ResponseAlias::HTTP_OK, '', 'Color deleted successfully', true);

        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }
}
