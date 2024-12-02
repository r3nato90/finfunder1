<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxLimit implements Rule
{
    protected $minLimit;

    public function __construct($minLimit)
    {
        $this->minLimit = $minLimit;
    }

    public function passes($attribute, $value): bool
    {
        return $this->minLimit < $value;
    }

    public function message(): string
    {
        return "The :attribute must be greater than the min limit.";
    }
}
