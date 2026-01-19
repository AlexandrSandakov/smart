<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|regex:/^\+[1-9]\d{1,14}$/', // E164 format validation
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // Example file validation
        ];
    }

    protected function prepareForValidation()
    {

        $this->merge([
            'customer_name' => is_string($this->customer_name) ? trim($this->customer_name) : $this->customer_name,
            'customer_email' => is_string($this->customer_email) ? trim($this->customer_email) : $this->customer_email,
            'customer_phone' => is_string($this->customer_phone) ? trim($this->customer_phone) : $this->customer_phone,
            'subject' => is_string($this->subject) ? trim($this->subject) : $this->subject,
            'message' => is_string($this->message) ? trim($this->message) : $this->message,
        ]);
    }
}
