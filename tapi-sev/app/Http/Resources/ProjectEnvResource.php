<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectEnvResource extends JsonResource
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
            'id'      => $this->id,
            'pid'     => $this->pid,
            'name'    => $this->name,
            'protocol'=> $this->protocol,
            'domain'  => $this->domain,
            'httpUrl' => $this->protocol.$this->domain,
        ];
    }
}
