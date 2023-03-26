<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use App\Traits\ApiRequestValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest {
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
        $rules = [
            'uuid'         => ['required'],
            'avatar'       => ['nullable'],
            'first_name'   => ['required', 'min:3'],
            'last_name'    => ['required', 'min:3'],
            'email'        => ['required', 'email', Rule::unique('users')->ignore($this->uuid, 'uuid')],
            'phone_number' => ['required', Rule::unique('users')->ignore($this->uuid, 'uuid')],
        ];
        if ($this->has('password') && $this->password != '') {
            $rules['password'] = ['required', 'min:8', 'confirmed'];
        }

        return $rules;
    }
}
