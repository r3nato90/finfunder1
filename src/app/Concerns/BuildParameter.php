<?php

namespace App\Concerns;

use Illuminate\Http\Request;

trait BuildParameter
{
    public function buildParameters(Request $request): array
    {
        $parameters = [];
        if ($request->has('field_name')) {
            for ($i = 0; $i < count($request->input('field_name')); $i++) {
                $fieldDetails = $this->buildFieldDetails($request, $i);
                $parameters[$fieldDetails['field_name']] = $fieldDetails;
            }
        }

        return $parameters;
    }

    public function buildFieldDetails(Request $request, int $index): array
    {
        $fieldLabel = $request->input("field_name.{$index}");
        $fieldName = strtolower(str_replace(' ', '_', $fieldLabel));
        $fieldType = $request->input("field_type.{$index}");

        return [
            'field_label' => $fieldLabel,
            'field_name' => $fieldName,
            'field_type' => $fieldType,
        ];
    }


}
