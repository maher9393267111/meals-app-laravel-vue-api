<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NutrientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "category_id" => $this->category_id,
            "category" => new CategoryResource($this->whenLoaded('category')),
            "carbs_in_hundred" => $this->carbs_in_hundred,
            "unit" => $this->unit,
            "standard_amount" => $this->standard_amount,
            "favourite_order" => $this->favourite_order
        ];
    }
}
