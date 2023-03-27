<?php

namespace App\Services\Admin\File;

interface FileInterface {
    /**
     * @param $file
     * @param $path
     * @param null $old_file
     * upload file in disc
     *
     * @return mixed
     */
    public function fileUpload($file, $path, $old_file = NULL);

    /**
     * @param $file
     * @param $file_name
     * make image data
     *
     * @return mixed
     */
    public function imageData($file, $file_name);

    /**
     * @param $file
     * @param string $path
     * @param null $old_file
     *
     * @return mixed
     */
    public function store($file, $path = 'public', $old_file = NULL);

    /**
     * @param $image
     * delete image
     *
     * @return mixed
     */
    public function deleteImage($image);

    /**
     * @param $uuid
     * get a single file by uuid
     *
     * @return mixed
     */
    public function getSingleFile($uuid);
}
