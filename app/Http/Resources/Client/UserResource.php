<?php

namespace App\Http\Resources\Client;

use App\Models\Permission;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phoneNo' => $this->phone_no,
            'busOrgId' => $this->bus_org_id,
            'isVerified' => $this->is_verified,
            'status' => $this->status,
            'statusLabel' => $this->status_label,
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'businessOrganization' => new BusinessOrganizationResource($this->whenLoaded('business_organization')),
        ];
    }
}
