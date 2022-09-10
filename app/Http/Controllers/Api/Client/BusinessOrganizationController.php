<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Resources\UserShortResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BusinessOrganization;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Client\BusinessOrganizationResource;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Str;

class BusinessOrganizationController extends Controller
{
    public function show(Request $request){
        $business_organization = $request->user()->business_organization;
        $business_organization = new BusinessOrganizationResource($business_organization);
        return json_response('Success', ResponseAlias::HTTP_OK, $business_organization, 'Business organization get successfully', true);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bus_name' => 'required',
            "bus_phone_no" => 'required|max:11|unique:business_organizations,bus_phone_no,'.$request->user()->business_organization->id,
            'bus_email' => 'required|email|unique:business_organizations,bus_email,'.$request->user()->business_organization->id,
            'bus_type' => 'required',
            'upazila_id' => 'required',
            'district_id' => 'required',
            'postal_code' => 'required',
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        try {
            DB::beginTransaction();
            $business_organization = $request->user()->business_organization;

            if (empty($business_organization)){
                throw new Exception('Could find business organization');
            }

            $business_organizationU = $business_organization->update([
                'bus_name' => $request->get('bus_name'),
                'bus_phone_no' => $request->get('bus_phone_no'),
                'bus_email' => $request->get('bus_email'),
                'bus_type' => $request->get('bus_type'),
                'district_id' => $request->get('district_id'),
                'upazila_id' => $request->get('upazila_id'),
                'postal_code' => $request->get('postal_code')
            ]);

            if (empty($business_organizationU)){
                throw new Exception('Could not update business organization');
            }

            DB::commit();
            $business_organization = new BusinessOrganizationResource($business_organization->fresh());
            return json_response('Success', ResponseAlias::HTTP_OK, $business_organization, 'Business organization updated successfully', true);
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_response('Failed', ResponseAlias::HTTP_UNAUTHORIZED, '',  $ex->getMessage(), false);

        }
    }

    public function investor_list(Request $request)
    {
        $investors = $request->user()->business_organization->users()->isActive()->get();
        $investors = UserShortResource::collection($investors);
        return collection_response($investors, 'Success', ResponseAlias::HTTP_OK, 'Investor get successfully');
    }
}
