<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed,cancelled',
            'order_date' => 'required|date',
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'customer_id.required' => 'Please select a customer.',
            'customer_id.exists' => 'Selected customer does not exist.',
            'amount.required' => 'Order amount is required.',
            'amount.numeric' => 'Amount must be a number.',
            'amount.min' => 'Amount cannot be negative.',
            'status.required' => 'Order status is required.',
            'status.in' => 'Invalid status selected.',
            'order_date.required' => 'Order date is required.',
            'order_date.date' => 'Please provide a valid date.',
        ];
    }
}