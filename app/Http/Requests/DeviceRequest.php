<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest {
    private $rules = [
        'device_type_id' => 'required',
        'name' => 'required',
        'problem' => 'required'
    ];

    private $messages = [
        'device_type_id.required' => 'Nav norādīts Tips.',
        'name.required' => 'Nav norādīts Nosaukums.',
        'problem.required' => 'Nav norādīta Problēma.'
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
