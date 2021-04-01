<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 *
 *
 * @package App\Http\Resources
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid'      => $this->uuid,
            'email'     => $this->email,
            'name'      => $this->name,
            'role'      => $this->role,
            'roleName'  => map_role($this->role),
            'avatar'    => asset('statics/images/head_default.png'),
        ];
    }
}
