<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PetSpecies: string implements HasLabel
{
    case Dog = 'dog';
    case Cat = 'cat';
    case Rabbit = 'rabbit';
    case Bird = 'bird';
    case Hamster = 'hamster';
    case GuineaPig = 'guinea_pig';
    case Ferret = 'ferret';
    case Turtle = 'turtle';
    case Fish = 'fish';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::Dog => 'Cane',
            self::Cat => 'Gatto',
            self::Rabbit => 'Coniglio',
            self::Bird => 'Uccello',
            self::Hamster => 'Criceto',
            self::GuineaPig => 'Cavia',
            self::Ferret => 'Furetto',
            self::Turtle => 'Tartaruga',
            self::Fish => 'Pesce',
            self::Other => 'Altro',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Dog => '🐕',
            self::Cat => '🐈',
            self::Rabbit => '🐇',
            self::Bird => '🐦',
            self::Hamster => '🐹',
            self::GuineaPig => '🐹',
            self::Ferret => '🦦',
            self::Turtle => '🐢',
            self::Fish => '🐠',
            self::Other => '🐾',
        };
    }
}
