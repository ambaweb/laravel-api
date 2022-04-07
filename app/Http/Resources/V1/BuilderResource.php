<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\DivisionResource;
use App\Models\Division;
use Illuminate\Http\Resources\Json\JsonResource;

class BuilderResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'address2' => $this->address2,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'is_active' => $this->is_active,
            'divisions' => new DivisionCollection($this->whenLoaded('divisions'))
        ];
    }
}
