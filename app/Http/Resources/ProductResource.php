<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,

            $this->mergeWhen(!is_null($this->price), [
                'price' => $this->price,
            ]),
            $this->mergeWhen(!is_null($this->original_price), [
                'original_price' => $this->original_price,
            ]),

            'type' => $this->type,
            'image' => $this->image,
            $this->mergeWhen(!is_null($this->discount), [
                'discount' => $this->discount,
            ]),
            'is_featured' => $this->is_featured,
            'ai_suggested' => $this->ai_suggested,
            $this->mergeWhen(
                $this->type === 'variable',
                fn () => [
                    'variations' => ProductVariationResource::collection(
                        $this->whenLoaded('variations')
                    ),
                ]
            ),
        ];
    }
}
