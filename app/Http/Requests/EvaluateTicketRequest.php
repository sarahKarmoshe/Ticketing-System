<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EvaluateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $ticket= request()->route()->parameter('ticket');

        if(Auth::guard('clients')->user()->id == $ticket->client_id){
            return true;
        }
        return false;    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'evaluation_id'=>['required',Rule::exists('evaluations','id')],
            'clients_notes'=>['required','string']
        ];
    }
}
