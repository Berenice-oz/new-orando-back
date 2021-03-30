<?php

namespace App\DataFixtures\Provider;

class WalkDbProvider
{

    private $color = [
        '#E1645F',
        '#678E62',
        '#EDA80A',
        '#FD827D',
        '#FDF6F5',
        '#8C9F75',
        '#FFCF34',
        '#FEFAF0',
    ];

    private $difficulty = [
        'facile',
        'moyen',
        'difficile',
    ];


    private $status = [
        'A venir',
        'Annuler',
        'Terminée',
    ];

   
    /**
     * Return a color of area randomly
     */
    public function areaColor()
    {
        return $this->color[array_rand($this->color)];
    }

    /**
     * Return a walk's status randomly
     */
    public function walkStatus()
    {
        return $this->status[array_rand($this->status)];
    }

    /**
     * Return a difficulty of walk randomly
     */
    public function walkDifficulty()
    {
        return $this->difficulty[array_rand($this->difficulty)];
    }

}