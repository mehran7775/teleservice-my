<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
          'file_type' =>$this->file_type,
          'file_size' => $this->file_size,
          'file_name' => $this->file_name,
           'file_what' =>$this->file_what
        ];
    }
}
