<?php

namespace App;

final class GildedRose {

    private $items = [];

    /**Default minimum quality
     * @var int
     */
    private $minQuality = 0;

    /** Default maximum quality
     * @var int
     */
    private $maxQuality = 50;

    /** Construct
     * GildedRose constructor.
     * @param $items
     */
    public function __construct($items) {
        $this->items = $items;
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
     * Get items
     * @return array
     */
    public function getItems()
    {
        return $this->items;
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

    /**
     * Update item quality
     */
    public function updateQuality() {
        foreach ($this->items as $type => $items) {
            foreach ($items as $item) {
                if($type == 'legendary') {
                    // Legendary item does not have to be sold, that is why we dont calculate sell_in for it and just return the same quality
                    $item->quality = $this->setQuality($item, $type);
                } else {
                    // For others we decrease sell_in and calculate quality
                    if($item->quality >= $this->getMinQuality() && $item->quality <= $this->getMaxQuality()) {
                        $item->quality = $this->setQuality($item, $type);
                    } else {
                        // if it is non special item then we return minimum default quality otherwise maximum default quality
                        if($item->quality < 0) {
                            $item->quality = $this->getMinQuality();
                        } else {
                            $item->quality = $this->getMaxQuality();
                        }
                    }
                    // Decrease sell in date
                    $item->sell_in = $item->sell_in - 1;
                }
            }
        }
    }

    /**
     * Set quality
     * @param $item
     * @param $type
     * @return int|mixed
     */
    protected function setQuality($item, $type)
    {
        $qualityCalculator = new QualityCalculator\QualityCalculator();
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

