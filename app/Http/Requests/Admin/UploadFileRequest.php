<?php

namespace App\Http\Requests\Admin;

use App\Traits\ApiRequestValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest {
    use ApiRequestValidationTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array {
        return [
            'file' => ['required', 'mimes:jpg,png,jpeg,svg,JPG,PNG,JPEG,SVG']
        ];
    }
}
