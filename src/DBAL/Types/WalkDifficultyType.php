<?php
namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class WalkDifficultyType extends AbstractEnumType
{
    public const EASY = 'Facile';
    public const MEDIUM = 'Moyen';
    public const HARD = 'Difficile';

    protected static $choices = [
        self::EASY => 'Facile',
        self::MEDIUM => 'Moyen',
        self::HARD => 'Difficile',
    ];
}