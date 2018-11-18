<?php

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Override the be method to enable Passport
     *
     * @see \Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication
     * @param UserContract $user
     * @param string $driver
     * @return $this
     */
    public function be(UserContract $user, $driver = null)
    {
        Passport::actingAs($user);

        return $this;
    }
}
