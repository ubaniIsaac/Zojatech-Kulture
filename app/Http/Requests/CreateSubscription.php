<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;



class CreateSubscription extends FormRequest
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
     *
     * @return array<string>
     */
    public function rules(): array
    {
        return [
            'plan' => 'nullable|unique:subscriptions|string|max:255',
            'description' => 'nullable|string|max:500',
            'price' => 'nullable|int',
            'upload_limit' => 'nullable|int',
        ];
    }
}
