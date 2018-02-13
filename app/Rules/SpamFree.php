<?php

namespace App\Rules;

use App\Inspections\Spam;


class SpamFree
{
    public function passes($attribute, $value)
    {
        return !resolve(Spam::class)->detect($value);
    }

    public function message()
    {
        return 'The :attribute have spam';
    }
}