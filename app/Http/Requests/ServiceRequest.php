<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest {
    private $rules = [
        'service_category_id' => 'required',
        'description' => 'required',
        'price' => 'required|numeric'
    ];
    private $messages = [
        'service_category_id.required' => 'Nav norādīta Kategorija.',
        'description.required' => 'Nav norādīts Apraksts.',
        'price.required' => 'Nav norādīta Cena.',
        'price.numeric' => 'Cena nav pareizi norādīta.'
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
