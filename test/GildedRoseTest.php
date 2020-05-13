<?php

namespace App;
use \PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase {

    /**
     * Testing legendary item quality
     */
    public function testLegendaryItemQuality() {
        $items = [
            new Item("Sulfuras, Hand of Ragnaros", 3, 80)
        ];
        $gildedRose = new GildedRose();
        $gildedRose->setItem($items[0]);
        $gildedRose->updateQualityByOne();
        $this->assertEquals(80, $items[0]->quality);
    }

    /**
     * Test non special item quality - 1 day
     */
    public function testNonSpecialItemQuality()
    {
        $items = [
            new Item('Elixir of the Mongoose', 5, 7)
        ];

        $gildedRose = new GildedRose();
        $gildedRose->setItem($items[0]);
        $gildedRose->updateQualityByOne();
        $this->assertEquals(6, $items[0]->quality);
    }

    /**
     * Test non special item quality- 7 days. Quality: 15
     * Also if sell in goes lower than zero
     * then should decrease twice as fast
     */
    public function testNonSpecialItemQualityPassedSellDate()
    {
        $items = [
            new Item('Elixir of the Mongoose', 5, 15)
        ];

        $gildedRose = new GildedRose();
        $gildedRose->setItem($items[0]);
        $days = 7;
        for($i=$days; $i >= 1; $i--) {
            $gildedRose->updateQualityByOne();
        }
        $this->assertEquals(6, $items[0]->quality);
    }

    /**
     * If quality is less than zero then return zero. Quality 10
     */
    public function testNonSpecialItemQualityLessThanZeroReturnZero()
    {
        $items = [
            new Item('Elixir of the Mongoose', 5, 10)
        ];

        $gildedRose = new GildedRose();
        $gildedRose->setItem($items[0]);
        $days = 7;
        for($i=$days; $i >= 1; $i--) {
            $gildedRose->updateQualityByOne();
        }

        $this->assertEquals(1, $items[0]->quality);
    }

    /**
     * Conjured mana cake decreases twice as fast than others
     */
    public function testNonSpecialItemQualityConjuredManaCake()
    {
        $items = [
            new Item('Conjured Mana Cake', 5, 7)
        ];

        $gildedRose = new GildedRose();
        $gildedRose->setItem($items[0]);
        $gildedRose->updateQualityByOne();
        $this->assertEquals(5, $items[0]->quality);
    }

    /**
     * Check the result for Conjured mana cake for 3 days. Quality: 7
     * 0 - Last day result 1
     */
    public function testNonSpecialItemQualityConjuredManaCakeThreeDays()
    {
        $items = [
            new Item('Conjured Mana Cake', 5, 7)
        ];

        $gildedRose = new GildedRose();
        $gildedRose->setItem($items[0]);
        $days = 3;
        for($i=$days; $i >= 1; $i--) {
            $gildedRose->updateQualityByOne();
        }

        $this->assertEquals(1, $items[0]->quality);
    }


    /**
     * Test special item quality - 1 day
     */
    public function testSpecialItemQuality()
    {
        $items = [
            new Item('Aged Brie', 5, 3)
        ];

        $gildedRose = new GildedRose();
        $gildedRose->setItem($items[0]);
        $gildedRose->updateQualityByOne();
        $this->assertEquals(4, $items[0]->quality);
    }

    /**
     * Testing Backstage passes 6 days result. Quality: 7
     */
    public function testSpecialItemQualityBackstagePasses6Days()
    {
        $items = [
            new Item('Backstage passes to a TAFKAL80ETC concert', 6, 7)
        ];

        $gildedRose = new GildedRose();
        $gildedRose->setItem($items[0]);
        $days = 6;
        for($i=$days; $i >= 1; $i--) {
            $gildedRose->updateQualityByOne();
        }

        $this->assertEquals(24, $items[0]->quality);
    }

}
