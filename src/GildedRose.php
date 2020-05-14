<?php

namespace App;

use App\QualityCalculator\QualityCalculator;

final class GildedRose {

    /** Item instance
     * @var
     */
    private $item;

    /**
     * Quality calculator
     * @var QualityCalculator
     */
    private $qualityCalculator;

    /**Default minimum quality
     * @var int
     */
    private $minQuality = 0;

    /** Default maximum quality
     * @var int
     */
    private $maxQuality = 50;

    /**
     * GildedRose constructor.
     * @param QualityCalculator $qualityCalculator
     */
    public function __construct(QualityCalculator $qualityCalculator) {
        $this->qualityCalculator = $qualityCalculator;
    }

    public function setItem(Item $item) {
        $this->item = $item;
        return $this;
    }
    /**
     * Set minimum default quality
     * @param $quality
     * @return $this
     */
    public function setMinQuality($quality)
    {
        $this->minQuality = $quality;
        return $this;
    }

    /**
     * Set maximum default quality
     * @param $quality
     * @return $this
     */
    public function setMaxQuality($quality)
    {
        $this->maxQuality = $quality;
        return $this;
    }

    /**
     * Return minimum default quality
     * @return int
     */
    public function getMinQuality()
    {
        return $this->minQuality;
    }

    /**
     * Return maximum default quality
     * @return int
     */
    public function getMaxQuality()
    {
        return $this->maxQuality;
    }

    /** Update quality one by one
     * @return mixed
     */
    public function updateQualityByOne() {

        if($this->item->name == 'Sulfuras, Hand of Ragnaros') {
            // Legendary item does not have to be sold, that is why we dont calculate sell_in for it and just return the same quality
            $this->item->quality = $this->setQuality('legendary');
        } else {
            if($this->isQualityBetweenMinAndMax($this->item)) {
                if($this->item->name == 'Aged Brie' || $this->item->name == 'Backstage passes to a TAFKAL80ETC concert') {
                    $this->item->quality = $this->setQuality('special');
                } else {
                    $this->item->quality = $this->setQuality('non-special');
                }
            } else {
                if($this->item->quality < 0) {
                    $this->item->quality = $this->getMinQuality();
                } else {
                    $this->item->quality = $this->getMaxQuality();
                }
            }
        }
        // Decrease sell in date
        $this->item->sell_in = $this->item->sell_in - 1;
        return $this->item;

    }

    /** Validate item minimum/maximum quality
     * @param $item
     * @return bool
     */
    public function isQualityBetweenMinAndMax($item)
    {
        return $item->quality >= $this->getMinQuality() && $item->quality <= $this->getMaxQuality();
    }

    /**
     * Set quality
     * @param $item
     * @param $type
     * @return int|mixed
     */
    protected function setQuality($type)
    {
        $item = $this->item;
        $qualityCalculator = $this->qualityCalculator;
        switch ($type) {
            case "non-special":
                $newQuality = $qualityCalculator->calculateNonSpecial($item);
                return $newQuality < $this->getMinQuality() ? $this->getMinQuality() : $newQuality; // if quality lower than default minimum quality then set it to default minimum quality
                break;

            case "special":
                $newQuality = $qualityCalculator->calculateSpecial($item);
                return $newQuality > $this->getMaxQuality() ? $this->getMaxQuality() : $newQuality; // if quality greater than default maximum quality then set it to default maximum quality
                break;

            default:
                $newQuality = $qualityCalculator->calculateLegendary($item);
                return $newQuality;
        }
    }
}

