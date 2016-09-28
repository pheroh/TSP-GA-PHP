<?php
namespace tsp;

class Population {
    private $tours = array();

    public function __construct($populationSize, $initialize)
    {
        $this->tours = array_fill(0, $populationSize, null);

        if ($initialize) {
            for ($i = 0; $i < $this->populationSize(); $i++) {
                $newTour = new Tour();
                $newTour->generateIndividual();
                $this->saveTour($i, $newTour);
            }
        }
    }

    public function saveTour($index, Tour $tour)
    {
        $this->tours[$index] = $tour;
    }

    public function getTour($index)
    {
        return $this->tours[$index];
    }

    public function getFittest()
    {
        $fittest = $this->tours[0];

        for ($i = 1; $i < $this->populationSize(); $i++) {
            if ($fittest->getFitness() <= $this->getTour($i)->getFitness()) {
                $fittest = $this->getTour($i);
            }
        }

        return $fittest;
    }

    public function populationSize()
    {
        return count($this->tours);
    }
}
