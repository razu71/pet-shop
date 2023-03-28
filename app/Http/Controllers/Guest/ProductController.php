<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Services\Admin\Product\ProductInterface;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ProductController extends Controller {
    public function __construct(private ProductInterface $product) {
    }

    /**
     * @OA\Get(
     *     path="/product/{uuid}",
     *     description="Get single product",
     *     @OA\Parameter(name="uuid", in="path", description="UUID of product", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\Response(
     *          response="200",
     *          description="Product retrieved successfully",
     *       ),
     *      @OA\Response(
     *          response="400",
     *          description="Product not found",
     *      ),
     * )
     */
    public function getSingleProduct($uuid) {
        return $this->product->getSingleProduct($uuid);
    }

    /**
     * @OA\Get(
     *     path="/products",
     *     description="Get all product",
     *     @OA\Response(
     *          response="200",
     *          description="Product retrieved successfully",
     *       ),
     * )
     */
    public function getProducts(Request $request) {
        return $this->product->getProducts($request);
    }
}
