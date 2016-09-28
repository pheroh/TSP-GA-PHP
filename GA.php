<?php
namespace tsp;

class GA
{
    static private $mutationRate = 0.015;
    static private $tournamentSize = 5;
    static private $elitism = true;

    static public function evolvePopulation(Population $pop)
    {
        $newPopulation = new Population($pop->populationSize(), false);

        $elitismOffset = 0;

        if (self::$elitism) {
            $newPopulation->saveTour(0, $pop->getFittest());
            $elitismOffset = 1;
        }

        for ($i = $elitismOffset; $i < $newPopulation->populationSize(); $i++) {
            $parent1 = self::tournamentSelection($pop);
            $parent2 = self::tournamentSelection($pop);

            $child = self::crossover($parent1, $parent2);
            $newPopulation->saveTour($i, $child);
        }

        for ($i = $elitismOffset; $i < $newPopulation->populationSize(); $i++) {
            self::mutate($newPopulation->getTour($i));
        }

        return $newPopulation;
    }

    static public function crossover(Tour $parent1, Tour $parent2)
    {
        $child = new Tour();

        $startPos = (int) (TourManager::Random() * $parent1->tourSize());
        $endPos = (int) (TourManager::Random() * $parent1->tourSize());

        for ($i = 0; $i < $child->tourSize(); $i++) {
            if ($startPos < $endPos && $i > $startPos && $i < $endPos) {
                $child->setCity($i, $parent1->getCity($i));
            } else if ($startPos > $endPos) {
                if (!($i < $startPos && $i > $endPos)) {
                    $child->setCity($i, $parent1->getCity($i));
                }
            }
        }

        for ($i = 0; $i < $parent2->tourSize(); $i++) {
            if (!$child->containsCity($parent2->getCity($i))) {
                for ($ii = 0; $ii < $child->tourSize(); $ii++) {
                    if ($child->getCity($ii) == null) {
                        $child->setCity($ii, $parent2->getCity($i));
                        break;
                    }
                }
            }
        }

        return $child;
    }

    static private function mutate(Tour $tour)
    {
        for ($tourPos1 = 0; $tourPos1 < $tour->tourSize(); $tourPos1++) {

            if (TourManager::Random() < self::$mutationRate) {
                $tourPos2 = (int) ($tour->tourSize() * TourManager::Random());

                $city1 = $tour->getCity($tourPos1);
                $city2 = $tour->getCity($tourPos2);

                $tour->setCity($tourPos2, $city1);
                $tour->setCity($tourPos1, $city2);
            }
        }
    }

    static private function tournamentSelection(Population $pop)
    {
        $tournament = new Population(self::$tournamentSize, false);

        for ($i = 0; $i < self::$tournamentSize; $i++) {
            $randomId = (int) (TourManager::Random() * $pop->populationSize());
            $tournament->saveTour($i, $pop->getTour($randomId));
        }

        $fittest = $tournament->getFittest();
        return $fittest;
    }

}

/*
public class GA {

    private static final double mutationRate = 0.015;
    private static final int tournamentSize = 5;
    private static final boolean elitism = true;
    // Evolves a population over one generation
    public static Population evolvePopulation(Population pop) {
        Population newPopulation = new Population(pop.populationSize(), false);

        // Keep our best individual if elitism is enabled
        int elitismOffset = 0;
        if (elitism) {
            newPopulation.saveTour(0, pop.getFittest());
            elitismOffset = 1;
        }

        // Crossover population
        // Loop over the new population's size and create individuals from
        // Current population
        for (int i = elitismOffset; i < newPopulation.populationSize(); i++) {
            // Select parents
            Tour parent1 = tournamentSelection(pop);
            Tour parent2 = tournamentSelection(pop);
            // Crossover parents
            Tour child = crossover(parent1, parent2);
            // Add child to new population
            newPopulation.saveTour(i, child);
        }

        // Mutate the new population a bit to add some new genetic material
        for (int i = elitismOffset; i < newPopulation.populationSize(); i++) {
            mutate(newPopulation.getTour(i));
        }

        return newPopulation;
    }
    // Applies crossover to a set of parents and creates offspring
    public static Tour crossover(Tour parent1, Tour parent2) {
        // Create new child tour
        Tour child = new Tour();

        // Get start and end sub tour positions for parent1's tour
        int startPos = (int) (Math.random() * parent1.tourSize());
        int endPos = (int) (Math.random() * parent1.tourSize());
        // Loop and add the sub tour from parent1 to our child
        for (int i = 0; i < child.tourSize(); i++) {
            // If our start position is less than the end position
            if (startPos < endPos && i > startPos && i < endPos) {
                child.setCity(i, parent1.getCity(i));
            } // If our start position is larger
            else if (startPos > endPos) {
                if (!(i < startPos && i > endPos)) {
                    child.setCity(i, parent1.getCity(i));
                }
            }
        }

        // Loop through parent2's city tour
        for (int i = 0; i < parent2.tourSize(); i++) {
            // If child doesn't have the city add it
            if (!child.containsCity(parent2.getCity(i))) {
                // Loop to find a spare position in the child's tour
                for (int ii = 0; ii < child.tourSize(); ii++) {
                    // Spare position found, add city
                    if (child.getCity(ii) == null) {
                        child.setCity(ii, parent2.getCity(i));
                        break;
                    }
                }
            }
        }
        return child;
    }

    // Mutate a tour using swap mutation
    private static void mutate(Tour tour) {
        // Loop through tour cities
        for(int tourPos1=0; tourPos1 < tour.tourSize(); tourPos1++){
            // Apply mutation rate
            if(Math.random() < mutationRate){
                // Get a second random position in the tour
                int tourPos2 = (int) (tour.tourSize() * Math.random());

                // Get the cities at target position in tour
                City city1 = tour.getCity(tourPos1);
                City city2 = tour.getCity(tourPos2);

                // Swap them around
                tour.setCity(tourPos2, city1);
                tour.setCity(tourPos1, city2);
            }
        }
    }

    // Selects candidate tour for crossover
    private static Tour tournamentSelection(Population pop) {
        // Create a tournament population
        Population tournament = new Population(tournamentSize, false);
        // For each place in the tournament get a random candidate tour and
        // add it
        for (int i = 0; i < tournamentSize; i++) {
            int randomId = (int) (Math.random() * pop.populationSize());
            tournament.saveTour(i, pop.getTour(randomId));
        }
        // Get the fittest tour
        Tour fittest = tournament.getFittest();
        return fittest;
    }
}

*/