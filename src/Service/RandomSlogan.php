<?php

namespace App\Service;

class RandomSlogan
{
    public const SLOGANS = [
        'May the force be with you',
        'This is the way',
        'I have the high-ground',
        'I\'m justice'
    ];

    /**
     * Return a random slogan.
     * @return string
     */
    public function getSlogan(): string
    {
        return self::SLOGANS[array_rand(self::SLOGANS)];
    }
}
