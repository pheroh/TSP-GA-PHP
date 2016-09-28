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


/*
import java.util.ArrayList;

public class TourManager {

    // Holds our cities
    private static ArrayList destinationCities = new ArrayList<City>();

    // Adds a destination city
    public static void addCity(City city) {
        destinationCities.add(city);
    }

    // Get a city
    public static City getCity(int index){
        return (City)destinationCities.get(index);
    }

    // Get the number of destination cities
    public static int numberOfCities(){
        return destinationCities.size();
    }
}
 */
