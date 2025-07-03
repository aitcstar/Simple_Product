<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            //'id' => $this->id,
            //'variations' => $this->variations,
            'price' => $this->price,
        ];
    }
}
