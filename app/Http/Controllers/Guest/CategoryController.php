<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class CategoryController extends Controller {
    /**
     * @OA\Get(
     *     path="/categories",
     *     description="Category list",
     *     @OA\Parameter(name="page", in="query", description="No. of page", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *     @OA\Parameter(name="limit", in="query", description="How many record you want to get", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *     @OA\Response(
     *          response="200",
     *          description="Category retrieved successfully",
     *       ),
     * )
     */
    public function __invoke(Request $request) {
        $limit = $request->limit ?: 5;
        $category = Category::paginate($limit);
        return successResponse(__('found', ['key' => 'Category']), $category);
    }
}
