<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamMemberResource extends JsonResource
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
            'id'    => $this->id,
            'tid'   => $this->tid,
            'uuid'  => $this->uuid,
            'uname' => $this->user->name,
            'role'  => map_team_role($this->role),
        ];
    }
}
