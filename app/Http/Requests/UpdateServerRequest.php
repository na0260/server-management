<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class UpdateServerRequest extends FormRequest
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
        $serverId = $this->route('server')->id;

        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('servers')
                    ->ignore($serverId, 'id')
                    ->where(function($query) {
                        $query->where('provider', $this->provider ?? $this->route('server')->provider);
                    })
            ],
            'provider'    => ['sometimes', 'in:aws,digitalocean,vultr,other'],
            'ip_address' => [
                'sometimes',
                'ipv4',
                Rule::unique('servers')->ignore($serverId, 'id')
            ],
            'status'      => ['sometimes', 'in:active,inactive,maintenance'],
            'cpu_cores'   => ['sometimes', 'integer', 'min:1', 'max:128'],
            'ram_mb'      => ['sometimes', 'integer', 'min:512', 'max:1048576'],
            'storage_gb'  => ['sometimes', 'integer', 'min:10', 'max:1048576'],
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
