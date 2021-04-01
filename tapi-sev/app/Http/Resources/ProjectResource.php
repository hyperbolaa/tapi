<?php

namespace App\Http\Resources;

use App\Models\Follow;
use App\Services\FollowServer;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'id'       => $this->id,
            'name'     => $this->name,
            'desc'     => $this->desc,
            'uuid'     => $this->uuid,
            'tid'      => $this->tid,
            'path'     => $this->path,
            'follow'   => FollowServer::isFolow($this->id),
            'created'  => formatDate($this->created_at),
        ];
    }


}
