<?php

namespace App\Domain\Clerk;

use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class ClerkGuard implements Guard
{
    private ?Authenticatable $user = null;

    public function __construct(
        private ClerkApi $api,
        private Request $request
    ) {
    }

    public function check(): bool
    {
        return !is_null($this->user());
    }

    public function guest(): bool
    {
        return !$this->check();
    }

    public function user()
    {
        if ($this->hasUser()) {
            return $this->user;
        }

        $user = null;

        $token = $this->request->bearerToken();

        if ($token) {
            $user = $this->fromToken($token);
        }

        return $this->user = $user;
    }

    public function fromToken(string $token)
    {
        $keys = JWK::parseKeySet($this->api->jwks());
        // it already checks for expired tokens & not before tokens
        $key = JWT::decode($token, $keys);

        // should check azp claim
        $user_id = $key->sub;

        return new ClerkUser($user_id);
    }

    public function id()
    {
        return $this->user->getAuthIdentifier();
    }

    public function validate(array $credentials = [])
    {
        throw new \LogicException("This method is not supported");
    }

    public function hasUser()
    {
        return !is_null($this->user);
    }

    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }
}
