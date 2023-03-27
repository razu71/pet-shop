<?php

namespace App\Services\Admin\Product;

use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductService implements ProductInterface {

    /**
     * @param StoreProductRequest $request
     * create a new product
     *
     * @return mixed
     */
    public function createNewProduct(StoreProductRequest $request) {
        try {
            $data = $this->makeData($request);
            $data['uuid'] = uuid();
            $product = Product::create($data);
            return successResponse(__('created', ['key' => 'Product']), $product->load('category'), 201);
        } catch (\Exception $exception) {
            info(json_encode($exception->getMessage()));
            return errorResponse();
        }
    }

    /**
     * @param $request
     * prepare data for store and update data
     *
     * @return mixed
     */
    public function makeData($request) {
        return [
            'category_uuid' => $request->category_uuid,
            'title'         => $request->title,
            'price'         => $request->price,
            'description'   => $request->description,
            'metadata'      => $request->metadata,
        ];
    }

    /**
     * @param StoreProductRequest $request
     * update product
     *
     * @return mixed
     */
    public function updateProduct(StoreProductRequest $request, $uuid) {
        try {
            $product = Product::where('uuid', $uuid)->first();
            if (!$product){
                return errorResponse(__('not_found',['key' => 'Product']));
            }
            $data = $this->makeData($request);
            $product->update($data);
            return successResponse(__('updated', ['key' => 'Product']), $product->refresh());
        }catch (\Exception $exception){
            info(json_encode($exception->getMessage()));
            return errorResponse();
        }
    }

    /**
     * @param $uuid
     * delete a product
     *
     * @return mixed
     */
    public function deleteProduct($uuid) {
        try {
            $product = Product::where('uuid', $uuid)->first();
            if (!$product){
                return errorResponse(__('not_found',['key'=>'Product']));
            }
            $product->delete();
            return successResponse(__('deleted',['key' => 'Product']));
        }catch (\Exception $exception){
            info(json_encode($exception->getMessage()));
            return errorResponse();
        }
    }

    /**
     * @param $uuid
     * get a single product details
     *
     * @return mixed
     */
    public function getSingleProduct($uuid) {
        $product = Product::with('category')->where('uuid', $uuid)->first();
        if (!$product) {
            return errorResponse(__('not_found', ['key' => 'Product']));
        }
        $product->brand = Brand::where('uuid', $product->metadata['brand_uuid'])->first();
        return successResponse(__('found', ['key' => 'Product']), $product);
    }

    /**
     * @param Request $request
     * get all products
     *
     * @return mixed
     */
    public function getProducts(Request $request) {
        $products = Product::with('category');
        if ($request->has('title') && $request->title != '') {
            $products = $products->where('title', $request->title);
        }
        if ($request->has('category') && $request->category != '') {
            $products = $products->where('category_uuid', $request->category);
        }
        if ($request->has('uuid') && $request->uuid != '') {
            $products = $products->where('uuid', $request->uuid);
        }
        if ($request->has('page') && $request->page != '' && $request->has('limit') && $request->limit != '') {
            $products = $products->paginate($request->limit);
        } else {
            $products = $products->get();
        }

        foreach ($products as $product) {
            $product->brand = Brand::where('uuid', $product->metadata['brand_uuid'])->first();
        }

        return successResponse(__('found', ['key' => 'Product']), $products);
    }
}
