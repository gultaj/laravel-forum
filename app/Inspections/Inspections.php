<?php

namespace App\Inspections;

interface Inspections
{
    public function detect($body);
}