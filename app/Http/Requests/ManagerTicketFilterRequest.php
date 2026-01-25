<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerTicketFilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string'],
        ];
    }

    public function filters(): array
    {
        return $this->only([
            'q',
            'status',
        ]);
    }
}
