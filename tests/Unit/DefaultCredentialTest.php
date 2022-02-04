<?php

namespace Tests\Unit;

use App\Models\DefaultCredential;
use Tests\TestCase;

class DefaultCredentialTest extends TestCase
{
    public function test_can_get_default_oc_credentials()
    {
        $credentials = DefaultCredential::getOc();

        $this->assertNotEmpty($credentials['username']);
        $this->assertNotEmpty($credentials['password']);
    }

    public function test_can_get_default_wp_credentials()
    {
        $credentials = DefaultCredential::getWp();

        $this->assertNotEmpty($credentials['username']);
        $this->assertNotEmpty($credentials['password']);
    }
}
