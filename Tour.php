<?php
namespace tsp;

class Tour
{
    private $tour = array();
    private $fitness = 0;
    private $distance = 0;

    public function __construct()
    {
        $this->tour = array_fill(0, TourManager::numberOfCities(), null);
    }

    public function generateIndividual()
    {
        for ($cityIndex = 0, $len = TourManager::numberOfCities(); $cityIndex < $len; $cityIndex++) {
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

            for ($cityIndex = 0, $len = $this->tourSize(); $cityIndex < $len; $cityIndex++) {
                $fromCity = $this->getCity($cityIndex);
                $destinationCity = null;
                
                // Check we're not on our tour's last city, if we are set our
                // tour's final destination city to our starting city
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

    public function __toString()
    {
        return implode('|', $this->tour);
    }

}
