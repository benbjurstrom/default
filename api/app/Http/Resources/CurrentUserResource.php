<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrentUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = null)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'email_pending' => $this->email_pending,
            'gravatar'      => md5($this->email),
            'verified'      => optional($this->email_verified_at)->toDateString(),
            'roles'         => $this->whenLoaded('roles', function () {
                return new RoleCollection($this->roles);
            }),
            'permissions' => $this->whenLoaded('permissions', function () {
                return new PermissionCollection($this->getAllPermissions());
            })
        ];
    }
}
