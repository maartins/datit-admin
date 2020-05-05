<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest {

    private $client_rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'phone_number' => 'numeric',
        'address' => 'required'
    ];

    private $client_messages = [
        'first_name.required' => 'Nav norādīts Vārds.',
        'last_name.required' => 'Nav norādīts Uzvārds.',
        'phone_number.required' => 'Nav norādīts Telefona nummurs',
        'phone_number.numeric' => 'Telefona nummurs ir ievadīts kļūdaini.',
        'address.required' => 'Nav norādīta Adrese.'
    ];

    private $device_rules = [
        'device_type_id' => 'required',
        'device_name' => 'required',
        'device_addition' => 'required',
        'device_problem' => 'required',
        'device_note' => 'required'
    ];

    private $device_messages = [
        'device_type_id.required' => 'Nav norādīts Tips.',
        'device_name.required' => 'Nav norādīts Nosaukums.',
        'device_addition.required' => 'Nav norādīta Komplektācija.',
        'device_problem.required' => 'Nav norādīta Problēma.',
        'device_note.required' => 'Nav norādīta Piezīmes.'
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
                //dd($this);
                return $this->client_rules;
            case 'new_device':
                //dd($this);
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
