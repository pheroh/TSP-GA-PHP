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

/*public class Population {

    // Holds population of tours
    Tour[] tours;

    // Construct a population
    public Population(int populationSize, boolean initialise) {
        tours = new Tour[populationSize];
        // If we need to initialise a population of tours do so
        if (initialise) {
            // Loop and create individuals
            for (int i = 0; i < populationSize(); i++) {
                Tour newTour = new Tour();
                newTour.generateIndividual();
                saveTour(i, newTour);
            }
        }
    }
    // Saves a tour
    public void saveTour(int index, Tour tour) {
        tours[index] = tour;
    }

    // Gets a tour from population
    public Tour getTour(int index) {
        return tours[index];
    }

    // Gets the best tour in the population
    public Tour getFittest() {
        Tour fittest = tours[0];
        // Loop through individuals to find fittest
        for (int i = 1; i < populationSize(); i++) {
            if (fittest.getFitness() <= getTour(i).getFitness()) {
                fittest = getTour(i);
            }
        }
        return fittest;
    }

    // Gets population size
    public int populationSize() {
        return tours.length;
    }
}
*/