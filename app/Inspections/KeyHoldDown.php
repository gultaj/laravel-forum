<?php

namespace App\Inspections;

class KeyHoldDown implements Inspections
{
    public function detect($body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new \Exception('Your reply contains spam');
        }
    }
}