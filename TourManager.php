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

    // As PHP doesn't have a native 0.0 to 1.0 random float, this method is added 
    static public function Random()
    {
        return mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
    }
}
