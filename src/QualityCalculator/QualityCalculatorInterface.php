<?php


namespace App\QualityCalculator;


interface QualityCalculatorInterface
{
    public function calculateNonSpecial($item);

    public function calculateSpecial($item);

    public function calculateLegendary($item);
}