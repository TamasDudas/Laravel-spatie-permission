<?php

namespace App\Enum;

enum RolesEnum: string
{
    case Admin = 'admin';
    case Commenter = 'commenter';
    case User = 'user';

    public function label()
    {
        return match($this) {
            self::Admin => 'Admin',
            self::Commenter => 'Commenter',
            self::User => 'User',
        };
    }
}
