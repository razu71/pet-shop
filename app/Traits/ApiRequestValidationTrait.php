<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

trait ApiRequestValidationTrait {
    /**
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator) {
        if ($this->header('accept') === 'application/json') {
            $errors = [];
            if ($validator->fails()) {
                $e = $validator->errors()->all();
                foreach ($e as $error) {
                    $errors[] = $error;
                }
            }
            $json = [
                'code'    => 422,
                'success' => FALSE,
                'message' => $errors[0],
                'data'    => []
            ];
            $response = new JsonResponse($json, 422);

            throw (new ValidationException($validator, $response))->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
        }
        $json = [
            'code'    => 400,
            'success' => FALSE,
            'message' => __('Header accept must be application/json'),
            'data'    => []
        ];
        $response = new JsonResponse($json, 400);
        throw (new ValidationException($validator, $response))->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
    }
}
