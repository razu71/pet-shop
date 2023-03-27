<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\UploadFileRequest;
use App\Services\Admin\File\FileInterface;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class FileUploadController extends Controller
{
    public function __construct(private FileInterface $file) {
    }

    /**
     * @OA\Post(
     *     path="/api/v1/file/upload",
     *     description="Upload a file",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"file"},
     *            @OA\Property(property="file", type="file", format="file", example="example.jpg"),
     *         ),
     *      ),
     *     @OA\Response (
     *          response=200,
     *          description="File uploaded successfully",
     *     ),
     *      @OA\Response (
     *          response=400,
     *          description="Something went wrong",
     *     )
     * )
     */
    public function uploadFile(UploadFileRequest $request) {
        return $this->file->store($request->file);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/file/{uuid}",
     *     description="Get a file",
     *     @OA\Parameter(name="uuid", in="path", description="UUID of file", required=true,
     *        @OA\Schema(type="uuid")
     *    ),
     *     @OA\Response (
     *          response=200,
     *          description="File retrieved successfully",
     *     ),
     *      @OA\Response (
     *          response=400,
     *          description="File not found",
     *     )
     * )
     */
    public function getFile($uuid) {
        return $this->file->getSingleFile($uuid);
    }
}
