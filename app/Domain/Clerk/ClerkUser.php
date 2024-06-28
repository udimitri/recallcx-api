<?php

namespace App\Domain\Clerk;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class ClerkUser implements Authenticatable, Arrayable, Jsonable, \JsonSerializable
{

    public function __construct(
        public string $user_id,
    ) {
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->user_id;
    }


    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function getAuthPassword()
    {
        throw new \LogicException("This method is not supported");
    }

    public function getRememberToken()
    {
        throw new \LogicException("This method is not supported");
    }

    public function setRememberToken($value)
    {
        throw new \LogicException("This method is not supported");
    }

    public function getRememberTokenName()
    {
        throw new \LogicException("This method is not supported");
    }

    public function getAuthPasswordName()
    {
        throw new \LogicException("This method is not supported");
    }
}
