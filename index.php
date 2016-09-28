<?php
require_once 'City.php';
require_once 'GA.php';
require_once 'Tour.php';
require_once 'TourManager.php';
require_once 'Population';

use tsp\City;
use tsp\GA;
use tsp\Population;
use tsp\TourManager;

//Create and add our cities
$city1 = new City(60, 200);
TourManager::addCity($city1);
$city2 = new City(180, 200);
TourManager::addCity($city2);
$city3 = new City(80, 180);
TourManager::addCity($city3);
$city4 = new City(140, 180);
TourManager::addCity($city4);
$city5 = new City(20, 160);
TourManager::addCity($city5);
$city6 = new City(100, 160);
TourManager::addCity($city6);
$city7 = new City(200, 160);
TourManager::addCity($city7);
$city8 = new City(140, 140);
TourManager::addCity($city8);
$city9 = new City(40, 120);
TourManager::addCity($city9);
$city10 = new City(100, 120);
TourManager::addCity($city10);
$city11 = new City(180, 100);
TourManager::addCity($city11);
$city12 = new City(60, 80);
TourManager::addCity($city12);
$city13 = new City(120, 80);
TourManager::addCity($city13);
$city14 = new City(180, 60);
TourManager::addCity($city14);
$city15 = new City(20, 40);
TourManager::addCity($city15);
$city16 = new City(100, 40);
TourManager::addCity($city16);
$city17 = new City(200, 40);
TourManager::addCity($city17);
$city18 = new City(20, 20);
TourManager::addCity($city18);
$city19 = new City(60, 20);
TourManager::addCity($city19);
$city20 = new City(160, 20);
TourManager::addCity($city20);


$pop = new Population(50, true);
print("Initial distance: " . $pop->getFittest()->getDistance());

// Evolve population for 100 generations
$pop = GA::evolvePopulation($pop);
for ($i = 0; $i < 100; $i++) {
    $pop = GA::evolvePopulation($pop);
}

// Print final results
print("<br>Finished.");
print("<br>Final distance: " . $pop->getFittest()->getDistance());
print("<br>Solution:");
print($pop->getFittest());

