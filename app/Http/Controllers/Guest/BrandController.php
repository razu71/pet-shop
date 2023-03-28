<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class BrandController extends Controller {
    /**
     * @OA\Get(
     *     path="/brands",
     *     description="Brand list",
     *     @OA\Parameter(name="page", in="query", description="No. of page", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *     @OA\Parameter(name="limit", in="query", description="How many record you want to get", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *     @OA\Response(
     *          response="200",
     *          description="Brand retrieved successfully",
     *       ),
     * )
     */
    public function __invoke(Request $request) {
        $limit = $request->limit ?: 5;
        $brands = Brand::paginate($limit);
        return successResponse(__('found', ['key' => 'Brand']), $brands);
    }
}
