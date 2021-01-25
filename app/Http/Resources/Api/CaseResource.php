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
            'id' => $this->id,
            'fullNameSick' =>$this->sick->full_name,
            'name' => $this->name,
            'meliNumber' =>$this->sick->number_meli,
            'category' => $this->category->name,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'expired_at'=>$this->expired_at,
            'caseFile' =>asset('storage/files/cases'.$this->name)
        ];
    }
    // public function with(){
    //     return[
    //         'fullNameSick' =>$this->sick
    //     ];
    // }
}
