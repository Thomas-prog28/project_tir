<?php

namespace App\Enum;

enum BowType: string
{
    case CLASSIQUE = 'classique';
    case POULIES = 'poulies';
    case LONGBOW = 'longbow';
    case NU = 'nu';

    public function label(): string
    {
        return match($this) {
            self::CLASSIQUE => 'Arc classique',
            self::POULIES => 'Arc à poulies',
            self::LONGBOW => 'Longbow',
            self::NU => 'Arc nu',
        };
    }
}