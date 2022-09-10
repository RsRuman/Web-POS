<?php

namespace App\Http\Controllers\Admin\Measurement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\UnitResource;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UnitController extends Controller
{
    #Unit List
    public function index(Request $request){
        $unitList = Unit::query()->notDetete();
        $unitList = build_collection_response($request, $unitList);
        $unitList = UnitResource::collection($unitList);
        return inertia('Measurement/Unit', compact('unitList'));
    }

    #Unit Store
    public function store(Request $request){
        $request->validate([
            'unit_name' => 'required|max:25|unique:units',
            'short_form' => 'required|max:25'
        ]);

        try {
            $unit = Unit::create([
                'unit_name' => $request->get('unit_name'),
                'short_form' => $request->get('short_form'),
                'status' => config('constant.active')
            ]);
            if (empty($unit)){
                throw new Exception('Could create unit');
            }

            return Redirect::route('admin.unit.index')->with('success', 'Unit created successfully');
        } catch (Exception $ex){
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    #Unit Update
    public function update(Request $request, $id){
        $request->validate([
            'unit_name' => 'required|max:25|unique:units,unit_name,'.$id,
            'short_form' => 'required|max:25'
        ]);

        try {
            $unit = Unit::find($id);
            if (empty($unit)){
                throw new Exception('Unit not found');
            }

            $unitU = $unit->update([
                'unit_name' => $request->get('unit_name'),
                'short_form' => $request->get('short_form')
            ]);
            if (empty($unitU)){
                throw new Exception('Could not update unit');
            }

            return Redirect::route('admin.unit.index')->with('success', 'Unit updated successfully');
        } catch (Exception $ex){
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    #Unit Delete
    public function destroy($id){
        try {
            $unit = Unit::find($id);
            if (empty($unit)){
                throw new Exception('Unit not found');
            }

            $unit->delete();
            return json_response('Success', ResponseAlias::HTTP_OK, '', 'Unit deleted successfully', true);

        }catch (Exception $ex){
            return json_response('Failed', ResponseAlias::HTTP_BAD_REQUEST, '', $ex->getMessage(), false);
        }
    }
}
