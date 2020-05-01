<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest {

    private $clien_rules = [
        'name' => 'required',
        'phone_number' => 'numeric',
        'address' => 'required'
    ];

    private $client_messages = [
        'name.required' => 'Nav norādīts Vārds.',
        'phone_number.required' => 'Nav norādīts Telefona nummurs',
        'phone_number.numeric' => 'Telefona nummurs ir ievadīts kļūdaini.',
        'address.required' => 'Nav norādīta Adrese.'
    ];

    private $device_rules = [
        'device_type' => 'required',
        'device_name' => 'required',
        'device_addition' => 'required'
    ];

    private $device_messages = [
        'device_type.required' => 'Nav norādīts Tips.',
        'device_name.required' => 'Nav norādīts Nosaukums.',
        'device_addition.required' => 'Nav norādīta Komplektācija.'
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
        switch ($this->input('action')) {
            case 'new':
                return $this->clien_rules;
            case 'new_device':
                return $this->device_rules;
            case 'back':
                return [];
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        switch ($this->input('action')) {
            case 'new':
                return $this->client_messages;
            case 'new_device':
                return $this->device_messages;
            case 'back':
                return [];
        }
    }
}
