<?php

namespace App\Http\Resources;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource {

    /**
     * @param Request $request
     * Transform product resource into an array.
     *
     * @return array
     */
    public function toArray(Request $request): array {
        return [
            'id'            => $this->id,
            'uuid'          => $this->uuid,
            'category_uuid' => $this->category_uuid,
            'title'         => $this->title,
            'price'         => $this->price,
            'description'   => $this->description,
            'metadata'      => $this->metadata,
            'category'      => $this->category,
            'brand'         => Brand::where('uuid', $this->metadata['brand_uuid'])->first(),
        ];
    }
}
