<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SMSRequest extends FormRequest
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
            'API_key' => 'required|min:3|max:255',
            'template' => 'required|min:3|max:255',
            'param' => 'required|url|min:3|max:255',
            'list' => 'required|file|mimes:xlsx,xls',
        ];
    }
}
