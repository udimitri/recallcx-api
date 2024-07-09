<?php

namespace Tests;

use App\Domain\Clerk\ClerkUser;
use App\Domain\Twilio\LookupClient;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Stubs\StubLookupClient;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->singleton(LookupClient::class, function () {
            return new StubLookupClient();
        });
    }

    public function unitTestUser(): ClerkUser
    {
        return new ClerkUser('user_test');
    }
}
