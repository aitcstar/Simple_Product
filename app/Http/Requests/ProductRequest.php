<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'type' => 'required|in:simple,variable',
            'name' => 'required|array',
            'name.en' => 'required|string',
            'name.ar' => 'required|string',
            'price' => 'nullable|numeric',
            'original_price' => 'nullable|numeric',
            'image' => 'nullable|string|url',
            'discount' => 'nullable|numeric|min:0',
            'is_featured' => 'boolean',
            'ai_suggested' => 'boolean',
        ];

        if ($this->input('type') === 'variable') {
            $rules['variations'] = 'required|array|min:1';
            $rules['variations.*.variations'] = 'required|array';
            $rules['variations.*.price'] = 'required|numeric';
        }

        return $rules;
    }
}
