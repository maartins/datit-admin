<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest {
    private $rules = [
        'type' => 'required',
        'name' => 'required',
        'additions' => 'required'
    ];

    private $messages = [
        'type.required' => 'Nav norādīts Tips.',
        'name.required' => 'Nav norādīts Nosaukums.',
        'additions.required' => 'Nav norādīta Komplektācija.'
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
            case 'update':
                return $this->rules;
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
            case 'update':
                return $this->messages;
            case 'back':
                return [];
        }
    }
}
