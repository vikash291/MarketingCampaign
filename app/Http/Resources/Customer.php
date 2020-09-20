<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Customer extends JsonResource
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
        if(isset($this->error)) {
            return [
                "error" => $this->error
            ];
        }else {
            return [
                "name" => $this->name,
                "email" => $this->email,
                "phone" => $this->phone,
                "discount" => $this->discount
            ];
        }
    }
}
