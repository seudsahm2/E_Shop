<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->user()->id,
            'company_name' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:2',
            'address' => 'nullable|string|max:255',
            'town' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'phone_number' => 'nullable|string|max:20',
        ];
    }
}
