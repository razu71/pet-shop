<?php

namespace App\Services\Admin\File;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileService implements FileInterface {

    /**
     * @param $file
     * @param $path
     * @param null $old_file
     * upload file in disc
     *
     * @return mixed
     */
    public function fileUpload($file, $path, $old_file = NULL) {
        if ($old_file) {
            $this->deleteImage($old_file);
        }
        $client_file_name = array_filter(explode('.', $file->getClientOriginalName()));
        $file_name = $client_file_name[0] .'-'. time() . '.' . $file->extension();
        $file->storeAs($path, $file_name);
        return $file_name;
    }

    /**
     * @param $file
     * @param $file_name
     * make image data
     *
     * @return mixed
     */
    public function imageData($file, $file_name) {
        return [
            'uuid' => uuid(),
            'name' => $file_name,
            'path' => asset('storage/'.$file_name),
            'size' => $file->getSize(),
            'type' => $file->getClientMimeType(),
        ];
    }

    /**
     * @param $file
     * @param string $path
     * @param null $old_file
     *
     * @return mixed
     */
    public function store($file, $path = 'public', $old_file = NULL) {
        try {
            $file_name = $this->fileUpload($file, $path, $old_file);
            $media = $this->imageData($file, $file_name);
            $file = File::create($media);
            return successResponse(__('created', ['key' => 'File']), $file, 201);
        } catch (\Exception $exception) {
            info(json_encode($exception->getMessage()));
            return errorResponse();
        }
    }

    /**
     * @param $image
     * delete image
     *
     * @return mixed
     */
    public function deleteImage($image) {
        if (Storage::disk('public')->exists($image)) {
            Storage::disk('public')->delete($image);
        }
    }

    /**
     * @param $uuid
     * get a single file by uuid
     *
     * @return mixed
     */
    public function getSingleFile($uuid) {
        $file = File::where('uuid', $uuid)->first();
        if (!$file){
            return errorResponse(__('not_found',['key' => 'File']));
        }
        return successResponse(__('found',['key'=>'File']), $file);
    }
}
