<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Services\Admin\Product\ProductInterface;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{
    public function __construct(private ProductInterface $product) {
    }

    /**
     * @OA\Post(
     *     path="/product/create",
     *     description="Create a new product",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"title", "category_uuid", "price", "metadata", "description"},
     *            @OA\Property(property="title", type="string", format="string", example="New product"),
     *            @OA\Property(property="category_uuid", type="string", format="string", example="1234-5678"),
     *            @OA\Property(property="price", type="integer", format="integer", example="100"),
     *            @OA\Property(property="metadata[file_uuid]", type="string", format="string", example="1234-5678"),
     *            @OA\Property(property="metadata[brand_uuid]", type="string", format="string", example="1234-5678"),
     *            @OA\Property(property="description", type="string", format="string", example="Lorem ipsum.."),
     *         ),
     *      ),
     *     @OA\Response(
     *          response="201",
     *          description="Product created successfully",
     *       ),
     *      @OA\Response(
     *          response="400",
     *          description="Something went wrong",
     *      ),
     * )
     */
    public function createNewProduct(StoreProductRequest $request) {
        return $this->product->createNewProduct($request);
    }

    /**
     * @OA\Put(
     *     path="/product/{uuid}",
     *     description="Update product",
     *     @OA\Parameter(name="uuid", in="path", description="UUID of product", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"title", "category_uuid", "price", "metadata", "description"},
     *            @OA\Property(property="title", type="string", format="string", example="New product"),
     *            @OA\Property(property="category_uuid", type="string", format="string", example="1234-5678"),
     *            @OA\Property(property="price", type="integer", format="integer", example="100"),
     *            @OA\Property(property="metadata[file_uuid]", type="string", format="string", example="1234-5678"),
     *            @OA\Property(property="metadata[brand_uuid]", type="string", format="string", example="1234-5678"),
     *            @OA\Property(property="description", type="string", format="string", example="Lorem ipsum.."),
     *         ),
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="Product updated successfully",
     *       ),
     *      @OA\Response(
     *          response="400",
     *          description="Product not found",
     *      ),
     * )
     */
    public function updateProduct(StoreProductRequest $request, $uuid) {
        return $this->product->updateProduct($request, $uuid);
    }

    /**
     * @OA\Delete(
     *     path="/product/{uuid}",
     *     description="Delete product",
     *     @OA\Parameter(name="uuid", in="path", description="UUID of product", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\Response(
     *          response="200",
     *          description="Product deleted successfully",
     *       ),
     *      @OA\Response(
     *          response="400",
     *          description="Product not found",
     *      ),
     * )
     */
    public function deleteProduct($uuid) {
        return $this->product->deleteProduct($uuid);
    }
}
