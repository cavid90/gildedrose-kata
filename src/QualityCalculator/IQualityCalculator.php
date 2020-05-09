<?php


namespace App\QualityCalculator;


interface IQualityCalculator
{
    public function calculateNonSpecial($item);

    public function calculateSpecial($item);

    public function calculateLegendary($item);
}