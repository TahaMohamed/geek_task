<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{

    public function rules(): array
    {
        $rules = [
            'is_active' => 'nullable|boolean',
//            'area_id' => 'nullable|exists:areas,id',
            'country_id' => 'required|exists:countries,id',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255|unique:city_translations,name,' . $this->city . ',city_id';
            $rules["$locale.description"] = 'nullable|string|max:500';
        }
        return $rules;
    }
}
