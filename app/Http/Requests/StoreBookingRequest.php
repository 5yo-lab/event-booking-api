<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'customer_email' => ['required', 'email'],
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
