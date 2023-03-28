<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
{

    public function rules(): array
    {
        $rules = [
            'is_active' => 'nullable|boolean',
            'country_id' => 'required|exists:countries,id',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255|unique:area_translations,name,' . $this->area . ',area_id';
            $rules["$locale.description"] = 'nullable|string|max:500';
        }
        return $rules;
    }
}
