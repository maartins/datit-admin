<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest {

    private $rules = [
        'first_name' => 'required',
        'phone_number' => 'numeric',
        'device_type_id' => 'required',
        'name' => 'required',
        'problem' => 'required',
        'services' => 'required_without:new_service_description,new_service_price',
        'new_service_description.*' => 'required_without:services',
        'new_service_price.*' => 'required_without:services'
    ];

    private $messages = [
        'first_name.required' => 'Nav norādīts Vārds.',
        'phone_number.required' => 'Nav norādīts Telefona nummurs',
        'phone_number.numeric' => 'Telefona nummurs ir ievadīts kļūdaini.',
        'device_type_id.required' => 'Nav norādīts Tips.',
        'name.required' => 'Nav norādīts Nosaukums.',
        'problem.required' => 'Nav norādīta Porblēma.',
        'services.required_without' => 'Nav norādīti Darbi.',
        'new_service_description.*.required_without' => 'Nav norādīti Darbi.',
        'new_service_price.*.required_without' => 'Nav norādīti Darbi.'
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
