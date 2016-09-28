<?php
namespace tsp;

class Tour
{
    private $tour = array();
    private $fitness = 0;
    private $distance = 0;

    public function __construct()
    {
        for ($i = 0; $i < TourManager::numberOfCities(); $i++) {
            $this->tour[] = null;
        }
    }

    public function generateIndividual()
    {
        for ($cityIndex = 0; $cityIndex < TourManager::numberOfCities(); $cityIndex++) {
            $this->setCity($cityIndex, TourManager::getCity($cityIndex));
        }

        shuffle($this->tour);
    }

    public function getCity($tourPosition)
    {
        return $this->tour[$tourPosition];
    }

    public function setCity($tourPosition, City $city)
    {
        $this->tour[$tourPosition] = $city;

        $this->fitness = 0;
        $this->distance = 0;
    }

    public function getFitness()
    {
        if ($this->fitness == 0)
            $this->fitness = 1 / (double) $this->getDistance();

        return $this->fitness;
    }

    public function getDistance()
    {
        if ($this->distance == 0) {
            $tourDistance = 0;

            for ($cityIndex = 0; $cityIndex < $this->tourSize(); $cityIndex++) {
                $fromCity = $this->getCity($cityIndex);
                $destinationCity = null;

                if ($cityIndex + 1 < $this->tourSize()) {
                    $destinationCity = $this->getCity($cityIndex + 1);
                } else {
                    $destinationCity = $this->getCity(0);
                }

                $tourDistance += $fromCity->distanceTo($destinationCity);
            }

            $this->distance = $tourDistance;
        }

        return $this->distance;
    }

    public function tourSize()
    {
        return count($this->tour);
    }

    public function containsCity(City $city)
    {
        return in_array($city, $this->tour);
    }

    // DIFFERENT CODE
    public function __toString()
    {
        $genString = "|";

        for ($i = 0; $i < $this->tourSize(); $i++) {
            $genString .= $this->getCity($i) . '|';
        }

        return $genString;

        //return implode($genString, $this->tour);
    }

}

/*
import java.util.ArrayList;
import java.util.Collections;
public class Tour{
    // Holds our tour of cities
    private ArrayList tour = new ArrayList<City>();
    // Cache
    private double fitness = 0;
    private int distance = 0;

    // Constructs a blank tour
    public Tour(){
        for (int i = 0; i < TourManager.numberOfCities(); i++) {
            tour.add(null);
        }
    }

    public Tour(ArrayList tour){
        this.tour = tour;
    }
    // Creates a random individual
    public void generateIndividual() {
        // Loop through all our destination cities and add them to our tour
        for (int cityIndex = 0; cityIndex < TourManager.numberOfCities(); cityIndex++) {
          setCity(cityIndex, TourManager.getCity(cityIndex));
        }
        // Randomly reorder the tour
        Collections.shuffle(tour);
    }
    // Gets a city from the tour
    public City getCity(int tourPosition) {
        return (City)tour.get(tourPosition);
    }
    // Sets a city in a certain position within a tour
    public void setCity(int tourPosition, City city) {
        tour.set(tourPosition, city);
        // If the tours been altered we need to reset the fitness and distance
        fitness = 0;
        distance = 0;
    }

    // Gets the tours fitness
    public double getFitness() {
        if (fitness == 0) {
            fitness = 1/(double)getDistance();
        }
        return fitness;
    }
    // Gets the total distance of the tour
    public int getDistance(){
        if (distance == 0) {
            int tourDistance = 0;
            // Loop through our tour's cities
            for (int cityIndex=0; cityIndex < tourSize(); cityIndex++) {
                // Get city we're travelling from
                City fromCity = getCity(cityIndex);
                // City we're travelling to
                City destinationCity;
                // Check we're not on our tour's last city, if we are set our
                // tour's final destination city to our starting city
                if(cityIndex+1 < tourSize()){
                    destinationCity = getCity(cityIndex+1);
                }
                else{
                    destinationCity = getCity(0);
                }
                // Get the distance between the two cities
                tourDistance += fromCity.distanceTo(destinationCity);
            }
            distance = tourDistance;
        }
        return distance;
    }
    // Get number of cities on our tour
    public int tourSize() {
        return tour.size();
    }

    // Check if the tour contains a city
    public boolean containsCity(City city){
        return tour.contains(city);
    }

    @Override
    public String toString() {
        String geneString = "|";
        for (int i = 0; i < tourSize(); i++) {
            geneString += getCity(i)+"|";
        }
        return geneString;
    }
}

 */