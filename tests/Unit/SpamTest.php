<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SpamTest extends TestCase
{
    use DatabaseMigrations;

    public function testItChecksForInvalidKeywords()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));

        $this->assertTrue($spam->detect('microsoft'));
    }

    public function testItChecksForAnyKeyBeingHeldDown()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Hello world'));

        $this->assertTrue($spam->detect('Hello world aaaaaaaaaaaa'));
    }
}
