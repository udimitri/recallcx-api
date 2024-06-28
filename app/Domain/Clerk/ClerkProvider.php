<?php

namespace App\Domain\Clerk;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class ClerkProvider implements UserProvider
{

    public function retrieveByToken($identifier, $token)
    {
        throw new \LogicException("This method is not supported");
    }

    public function retrieveById($identifier)
    {
        throw new \LogicException("This method is not supported");
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        throw new \LogicException("This method is not supported");
    }

    public function retrieveByCredentials(array $credentials)
    {
        throw new \LogicException("This method is not supported");
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        throw new \LogicException("This method is not supported");
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {
        throw new \LogicException("This method is not supported");
    }
}
