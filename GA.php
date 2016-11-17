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

        // Keep our best individual if elitism is enabled
        if (self::$elitism) {
            $newPopulation->saveTour(0, $pop->getFittest());
            $elitismOffset = 1;
        }

        // Crossover population
        // Loop over the new population's size and create individuals from
        // Current population
        for ($i = $elitismOffset, $len = $newPopulation->populationSize(); $i < $len; $i++) {
            $parent1 = self::tournamentSelection($pop);
            $parent2 = self::tournamentSelection($pop);

            $child = self::crossover($parent1, $parent2);
            $newPopulation->saveTour($i, $child);
        }

        // Mutate the new population a bit to add some new genetic material
        for ($i = $elitismOffset, $len = $newPopulation->populationSize(); $i < $len; $i++) {
            self::mutate($newPopulation->getTour($i));
        }

        return $newPopulation;
    }

    static public function crossover(Tour $parent1, Tour $parent2)
    {
        $child = new Tour();

        $startPos = (int) (TourManager::Random() * $parent1->tourSize());
        $endPos   = (int) (TourManager::Random() * $parent1->tourSize());

        for ($i = 0, $len = $child->tourSize(); $i < $len; $i++) {
            if ($startPos < $endPos && $i > $startPos && $i < $endPos) {
                $child->setCity($i, $parent1->getCity($i));
            } else if ($startPos > $endPos && !($i < $startPos && $i > $endPos)) {
                $child->setCity($i, $parent1->getCity($i));
            }
        }

        for ($i = 0, $len = $parent2->tourSize(); $i < $len; $i++) {
            if (!$child->containsCity($parent2->getCity($i))) {
                for ($ii = 0, $len2 = $child->tourSize(); $ii < $len2; $ii++) {
                    if ($child->getCity($ii) == null) {
                        $child->setCity($ii, $parent2->getCity($i));
                        break;
                    }
                }
            }
        }

        return $child;
    }

    // Mutate a tour using swap mutation
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

        // For each place in the tournament get a random candidate tour and
        // add it
        for ($i = 0; $i < self::$tournamentSize; $i++) {
            $randomId = (int) (TourManager::Random() * $pop->populationSize());
            $tournament->saveTour($i, $pop->getTour($randomId));
        }

        $fittest = $tournament->getFittest();
        return $fittest;
    }

}
