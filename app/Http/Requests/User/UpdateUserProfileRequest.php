<?php

namespace App\Http\Requests\User;

use App\Traits\ApiRequestValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest {
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
            'first_name'   => ['required', 'min:3'],
            'last_name'    => ['required', 'min:3'],
            'address'      => ['required'],
            'is_marketing' => ['required', 'boolean'],
            'avatar'       => ['nullable'],
        ];
    }
}
