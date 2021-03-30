<?php

namespace App\DataFixtures\Data;
use Faker;

/**
 * Data of Walk
 */
class WalkData
{
    private $faker;
    private $startingPoint;
    private $endPoint;
    private $date;
    private $duration;
    private $elevation;
    private $maxNbPersons;
    private $status;

   

    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_FR');
        $this->startingPoint = $this->faker->streetAddress();
        $this->endPoint = $this->faker->streetAddress();
        $this->date = $this->faker->dateTimeInInterval('-1 week', '+2 weeks');
        $this->duration = $this->faker->randomDigitNotNull();
        $this->elevation = $this->faker->randomNumber(3, true);
        $this->maxNbPersons = $this->faker->numberBetween(1, 30);
        $this->status = $this->faker->numberBetween(0, 2);


    }
    
    static $walksData = [
        
        1 => ["title" => "Circuit découverte de la Presqu'île de Crozon", "description" => "Cadre idyllique pour profiter d'une vue sur le large à 180 degrés.", "areaId" => 1],
        2 => ["title" => "Randonnée à la Pointe de Saint Mathieu", "description" => "Circuit de l'île d'Ouessant à l'île de Sein.", "area_id" => 1],
        3 => ["title" => "Côte de Granit Rose", "description" => "Découverte de ce musée à ciel ouvert sur les sentiers de Ploumanac'h.", "areaId" => 1],
        4 =>  ["title" => "La Forêt de la Madeleine et l'Abbaye de Port-Royal-des-Champs ", "description" => "Balade historique sur les pas de Jean Racine", "areaId" => 5],
        5 => ["title" => "Le Circuit des 25 bosses", "description" => "Ascension de 25 buttes qui forment un tour de la Forêt des Trois Pignons. Une randonnée sportive qui s'annonce !", "area_id" => 5],
        6 => ["title" => "Le Sentier des Belvédères", "description" => "Un parcours sur les hauteurs, avec de très beaux points de vue sur le Massif des Trois Pignons.", "areaId" => 5],
        7 => ["title" => "La Tour de Capanella et Porto Pollo à Serra di Ferro", "description" => "Un circuit pittoresque au travers du maquis.", "areaId" => 11],
        8 => ["title" => "Soccia au lac Creno", "description" => "Le chemin est agréable, une partie en sous bois. L'arrivée au lac est un moment magique.", "areaId" => 11],
        9 => ["title" => "Lac de Nino à partir de Poppaghia", "description" => "Une ascension vers un lac d'altitude, dans une belle ambiance montagnarde", "areaId" => 11],
        10 => ["title" => "La Roche Virginie", "description" => "Le sentier, situé en forêt domaniale de Régina, traverse des forêts primaires.", "areaId" => 18],
        11 => ["title" => "Sentier du Rorota", "description" => "Randonnée qui pourrait amener à la rencontre de paresseux.", "areaId" => 18],
      

       
       
    ];
}