<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class InvoiceRequest extends FormRequest {

    private $rules = [
        'first_name' => 'required',
        'phone_number' => 'required|numeric',
        'device_type_id' => 'required',
        'name' => 'required',
        'problem' => 'required',
        'services' => 'required_without_all'
    ];

    private $messages = [
        'first_name.required' => 'Nav norādīts Vārds.',
        'phone_number.required' => 'Nav norādīts Telefona nummurs',
        'phone_number.numeric' => 'Telefona nummurs ir ievadīts kļūdaini.',
        'device_type_id.required' => 'Nav norādīts Tips.',
        'name.required' => 'Nav norādīts Nosaukums.',
        'problem.required' => 'Nav norādīta Porblēma.'
    ];

    public function __construct(ValidationFactory $validationFactory) {
        $validationFactory->extend('service_test', function ($attribute, $value, $parameters, $validator) {
            return in_array(null, $validator->getData()['new_service_description']) && $value != null;
        }, 'Ņebija visi mājās.');
    }

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
                return $this->rules;
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
                return $this->messages;
        }
    }
}
