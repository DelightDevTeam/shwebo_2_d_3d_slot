<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required', 'string',
            'bank_account_name' => ['required' , 'string'],
            'bank_account_no' => ['required', 'integer'],
            'image' => ['image']
        ];
    }
}
