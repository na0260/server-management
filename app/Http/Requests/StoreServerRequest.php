<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreServerRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'provider' => 'required|in:aws,digitalocean,vultr,other',
            'ip_address' => 'required|ipv4|unique:servers,ip_address',
            'status' => 'required|in:active,inactive,maintenance',
            'cpu_cores' => 'required|integer|min:1|max:128',
            'ram_mb' => 'required|integer|min:512|max:1048576',
            'storage_gb' => 'required|integer|min:10|max:1048576',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors'  => $validator->errors()
        ], 422));
    }
}
