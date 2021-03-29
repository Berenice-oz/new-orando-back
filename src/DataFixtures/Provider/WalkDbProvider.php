<?php

namespace App\DataFixtures\Provider;

class WalkDbProvider
{

    private $name = [
        'Bretagne',
        'Normandie',
        'Hauts-de-France',
        'Pays de la Loire',
        'Île-de-France',
        'Centre-Val de Loire',
        'Nouvelle-Aquitaine',
        'Occitanie',
        'Auvergne-Rhône-Alpes',
        'Provence-Alpes-Côte d\'Azur',
        'Corse',
        'Grand-Est',
        'Bourgogne-Franche-Comté',
        'Mayotte',
        'Martinique',
        'Guadeloupe',
        'Réunion',
        'Guyane',
    
    ];

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

    private $tagName = [
        'En famille',
        'Animaux bienvenus',
        'Urbaine',
        'Bord de mer',
        'Montagne',
        'Nocturne',
    ];

    private $tagColor = [
        '#84258E',
        '#5A5F62',
        '#FF6600',
        '#02D5E6',
        '#64391F',
        '#0E3151',
    ];

    /**
     * Return a name of area randomly
     */
    public function areaName()
    {
        return $this->name[array_rand($this->name)];
    }

    /**
     * Return a color of area randomly
     */
    public function areaColor()
    {
        return $this->color[array_rand($this->color)];
    }

    /**
     * Return a difficulty of walk randomly
     */
    public function walkDifficulty()
    {
        return $this->difficulty[array_rand($this->difficulty)];
    }

    /**
     * Return a walk's status randomly
     */
    public function walkStatus()
    {
        return $this->status[array_rand($this->status)];
    }

    /**
     * Return a tag's name randomly
     */
    public function tagName()
    {
        return $this->tagName[array_rand($this->tagName)];
    }

    /**
     * Return a tag's solor randomly
     */
    public function tagColor()
    {
        return $this->tagColor[array_rand($this->tagColor)];
    }


}