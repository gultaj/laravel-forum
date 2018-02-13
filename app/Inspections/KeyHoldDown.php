<?php

namespace App\Inspections;

class KeyHoldDown implements Inspections
{
    public function detect($body)
    {
        return preg_match('/(.)\\1{4,}/', $body);
    }
}