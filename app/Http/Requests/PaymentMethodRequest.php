<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //
            'card_type' => 'required',
            'name' => 'required',
            'expiry_date' => 'required',
            'last_four_digit' => 'required|max:4',
            'cvv' => 'required|max:3',
            'is_active' => ''
        ];
    }
}
