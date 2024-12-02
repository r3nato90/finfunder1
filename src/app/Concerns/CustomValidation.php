<?php

namespace App\Concerns;

use App\Enums\Frontend\InputField;
use Illuminate\Support\Arr;

trait CustomValidation
{
    public function parameterValidation(array $parameters, bool $isIdentify = false): array
    {

        $rules = [];
        if ($parameters) {
            foreach ($parameters as $parameter) {

                $fieldType = Arr::get($parameter, 'field_type', 'text');
                $name = Arr::get($parameter, 'field_name');

                if ($isIdentify) {
                    $name = getInputName(Arr::get($parameter, 'field_label'));
                }

                $rules[$name] = match ($fieldType) {
                    InputField::TEXT->value => ['required', 'string', 'max:255'],
                    InputField::FILE->value => ['required', 'max:2048', 'file'],
                    InputField::TEXTAREA->value => ['required', 'string', 'max:500'],
                    InputField::SELECT->value => ['required'],
                    default => null,
                };
            }
        }


        return $rules;
    }

}
