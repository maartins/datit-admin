<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest {
    private $rules = [
        'first_name' => 'required',
        'phone_number' => 'numeric'
    ];

    private $messages = [
        'first_name.required' => 'Nav norādīts Vārds.',
        'phone_number.required' => 'Nav norādīts Telefona nummurs',
        'phone_number.numeric' => 'Telefona nummurs ir ievadīts kļūdaini.'
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        if ($this->client_type == 'company') {
            $this->rules['company_name'] = 'required';
        }

        switch ($this->input('action')) {
            case 'back':
                return [];
            default:
                return $this->rules;
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        if ($this->client_type == 'company') {
            $this->messages['company_name.required'] = 'Nav norādīts Uzņēmuma nosaukums.';
        }
        
        switch ($this->input('action')) {
            case 'back':
                return [];
            default:
                return $this->messages;
        }
    }
}
