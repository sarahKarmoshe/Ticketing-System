<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->guard('admin')){
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $client = request()->route()->parameter('client');
        return [
            'name' => ['required', 'string'],
            'phone_number' => ['required', Rule::unique('clients')->ignore($client->id)],
            'password' => ['required','min:8'],
            'confirm_password' => ['required', 'same:password'],
        ];
    }
}
