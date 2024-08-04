<?php

namespace Tests;

use App\Domain\Twilio\LookupClient;
use App\Models\User;
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

    public function unitTestUser(): User
    {
        return User::query()->firstOrCreate([
            'email' => 'test@recallcx.com'
        ]);
    }
}
