<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Report;

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
            'cost' => $this->cost,
            'created_at' => $this->created_at,
            'expired_at'=>$this->expired_at,
            // 'report' => $this->report()->pluck('content'),
            // 'report' => $this->when($this->reports()->content!=Null,888),
            // $this->mergeWhen($this->report,[
            //     'report' => Report::where('case_id',$this->id)->pluck('content'),
            // ]),
            $this->mergeWhen($this->report()->first(),[
                'report' => $this->report()->get()->pluck('content')->implode(''),
                // 'report' => $this->report()->get()->map->only('content'),
            ]),
            'caseFile' =>asset('storage/files/cases'.$this->name)
        ];
    }
    // public function with(){
    //     return[
    //         'fullNameSick' =>$this->sick
    //     ];
    // }
}
