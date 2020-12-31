<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CaseResource extends JsonResource
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
            'fullNameSick' =>$this->sick->full_name,
            'meliNumber' =>$this->sick->number_meli,
            'category' => $this->category->name,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'expired_at'=>$this->expired_at
        ];
    }
    // public function with(){
    //     return[
    //         'fullNameSick' =>$this->sick
    //     ];
    // }
}
