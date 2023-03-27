<?php

namespace App\Services\Admin\Product;

use App\Http\Requests\Admin\StoreProductRequest;
use Illuminate\Http\Request;

interface ProductInterface {
    /**
     * @param StoreProductRequest $request
     * create a new product
     *
     * @return mixed
     */
    public function createNewProduct(StoreProductRequest $request);

    /**
     * @param $request
     * prepare data for store and update data
     *
     * @return mixed
     */
    public function makeData($request);

    /**
     * @param StoreProductRequest $request
     * update product
     *
     * @return mixed
     */
    public function updateProduct(StoreProductRequest $request, $uuid);

    /**
     * @param $uuid
     * delete a product
     *
     * @return mixed
     */
    public function deleteProduct($uuid);

    /**
     * @param $uuid
     * get a single product details
     *
     * @return mixed
     */
    public function getSingleProduct($uuid);

    /**
     * @param Request $request
     * get all products
     *
     * @return mixed
     */
    public function getProducts(Request $request);
}
