<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest {

    private $client_rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'phone_number' => 'numeric',
        'address' => 'required',
        'device_type_id' => 'required',
        'name' => 'required',
        'additions' => 'required',
        'problem' => 'required',
        'note' => 'required',
        'services' => 'required'
    ];

    private $client_messages = [
        'first_name.required' => 'Nav norādīts Vārds.',
        'last_name.required' => 'Nav norādīts Uzvārds.',
        'phone_number.required' => 'Nav norādīts Telefona nummurs',
        'phone_number.numeric' => 'Telefona nummurs ir ievadīts kļūdaini.',
        'address.required' => 'Nav norādīta Adrese.',
        'device_type_id.required' => 'Nav norādīts Tips.',
        'name.required' => 'Nav norādīts Nosaukums.',
        'additions.required' => 'Nav norādīta Komplektācija.',
        'problem.required' => 'Nav norādīta Porblēma.',
        'note.required' => 'Nav norādītas Piezīmes.',
        'services.required' => 'Nav norādīti Darbi.'
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
        //dd($this);
        switch ($this->input('action')) {
            case 'back':
                return [];
            default:
                return $this->client_rules;
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        switch ($this->input('action')) {
            case 'back':
                return [];
            default:
                return $this->client_messages;
        }
    }
}
