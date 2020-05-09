<?php


namespace App\QualityCalculator;


class QualityCalculator implements IQualityCalculator
{
    /**
     * Calculation for special items
     * @param $item
     * @return int
     */
    public function calculateSpecial($item)
    {
        if($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
            if($item->sell_in > 10) {
                $num = 1;
            } elseif ($item->sell_in <= 10 && $item->sell_in > 5) {
                $num = 2;
            } elseif($item->sell_in >= 0 && $item->sell_in <= 5) {
                $num = 3;
            } else {
                $num = -$item->quality;
            }
        } else {
            $num = 1;
        }
        $newQuality = $item->quality + $num;
        return $newQuality;
    }

    /**
     * Calculation for non-special items
     * @param $item
     * @return int
     */
    public function calculateNonSpecial($item)
    {
        $num = $item->name == 'Conjured Mana Cake' ? 2 : 1;
        $newQuality = $item->quality - $num;
        return $newQuality;
    }

    /**
     * Calculation for legendary items (return just the same quality at the moment)
     * @param $item
     * @return mixed
     */
    public function calculateLegendary($item)
    {
        return $item->quality;
    }
}