<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection {
    /**
     * @param Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable|mixed
     */
    public function toArray(Request $request) {
        return $this->resource;
    }
}
