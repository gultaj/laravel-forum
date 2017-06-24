<?php

namespace App\Inspections;

class InvalidKeywords implements Inspections
{
    protected $keywords = [
        'Microsoft',
    ];

    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (\stripos($body, $keyword) !== false) {
                throw new \Exception('Your reply contains spam');
            }
        }
    }
}