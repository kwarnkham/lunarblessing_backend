<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !is_null($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'mobile' => ['required', 'numeric'],
            'address' => ['required'],
            'note' => [''],
            'items' => ['required', 'array'],
            'items.*' => ['array', 'required'],
            'items.*.id' => ['required', 'exists:items,id'],
            'items.*.quantity' => ['required', 'numeric'],
            'items.*.text' => [''],
            'items.*.dimmed_lid' => ['boolean'],
        ];
    }
}
