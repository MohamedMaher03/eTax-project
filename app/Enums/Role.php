<?php

namespace App\Enums;

enum Role: int
{
    case ADMIN = 0;
    case USER = 1;
    case USER_ADVISOR = 2;

    public static function fromString(string $roleName): self
    {
        return match (strtolower($roleName)) {
            'admin' => self::ADMIN,
            'user' => self::USER,
            'useradvisor' => self::USER_ADVISOR,
            default => throw new \InvalidArgumentException('Invalid role name'),
        };
    }
}
