<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'is_active' => 'nullable|boolean',
            'phone_code' => 'nullable|numeric|gt:0|digits_between:2,5'
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255|unique:country_translations,name,' . $this->country . ',country_id';
            $rules["$locale.description"] = 'nullable|string|max:500';
        }
        return $rules;

    }
}
