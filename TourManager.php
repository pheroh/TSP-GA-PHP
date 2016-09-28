<?php
namespace tsp;

Class TourManager
{
    static public $destinationCities = array();

    static public function addCity(City $city) {
        self::$destinationCities[] = $city;
    }

    static public function getCity($index) {
        return self::$destinationCities[$index];
    }

    static public function numberOfCities() {
        return count(self::$destinationCities);
    }

    static public function Random()
    {
        return mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
    }
}
