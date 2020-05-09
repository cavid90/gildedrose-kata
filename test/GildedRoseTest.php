<?php

namespace App;
use \PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase {

    /**
     * Testing legendary item quality
     */
    public function testLegendaryItemQuality() {
        $items = [
            "legendary" => [
                new Item("Sulfuras, Hand of Ragnaros", 3, 80)
                ]
        ];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals(80, $items["legendary"][0]->quality);
    }

    /**
     * Test non special item quality - 1 day
     */
    public function testNonSpecialItemQuality()
    {
        $items = [
            "non-special" => [
                new Item('Elixir of the Mongoose', 5, 7)
            ]
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals(6, $items["non-special"][0]->quality);
    }

    /**
     * Test non special item quality- 7 days. Quality: 15
     * Also if sell in goes lower than zero
     * then should decrease twice as fast
     * 7 day - 15 - 1
     * 6 day - 14 - 1
     * 5 day - 13 - 1
     * 4 day - 12 - 1
     * 3 day - 11 - 1
     * As we reached 0 day for item then it will continue twice as fast
     * 2 - 10 - 2
     * 1 - 8 - 2
     * 0 - Last day result is 6
     */
    public function testNonSpecialItemQualityPassedSellDate()
    {
        $items = [
            "non-special" => [
                new Item('Elixir of the Mongoose', 5, 15)
            ]
        ];

        $gildedRose = new GildedRose($items);
        $days = 7;
        for($i=$days; $i >= 1; $i--) {
            $gildedRose->updateQuality();
        }
        $this->assertEquals(6, $items["non-special"][0]->quality);
    }

    /**
     * If quality is less than zero then return zero. Quality 10
     * 7 day - 10 - 1
     * 6 day - 9 - 1
     * 5 day - 8 - 1
     * 4 day - 7 - 1
     * 3 day - 6 - 1
     * 2 day - 5 - 2
     * 1 day - 3 - 2
     * 0 - Last day - 1
     */
    public function testNonSpecialItemQualityLessThanZeroReturnZero()
    {
        $items = [
            "non-special" => [
                new Item('Elixir of the Mongoose', 5, 10)
            ]
        ];

        $gildedRose = new GildedRose($items);
        $days = 7;
        for($i=$days; $i >= 1; $i--) {
            $gildedRose->updateQuality();
        }

        $this->assertEquals(1, $items["non-special"][0]->quality);
    }

    /**
     * Conjured mana cake decreases twice as fast than others
     */
    public function testNonSpecialItemQualityConjuredManaCake()
    {
        $items = [
            "non-special" => [
                new Item('Conjured Mana Cake', 5, 7)
            ]
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals(5, $items["non-special"][0]->quality);
    }

    /**
     * Check the result for Conjured mana cake for 3 days. Quality: 7
     * 3 day - 7
     * 2 day - 5
     * 1 day - 3
     * 0 - Last day result 1
     */
    public function testNonSpecialItemQualityConjuredManaCakeThreeDays()
    {
        $items = [
            "non-special" => [
                new Item('Conjured Mana Cake', 5, 7)
            ]
        ];

        $gildedRose = new GildedRose($items);
        $days = 3;
        for($i=$days; $i >= 1; $i--) {
            $gildedRose->updateQuality();
        }

        $this->assertEquals(1, $items["non-special"][0]->quality);
    }


    /**
     * Test special item quality - 1 day
     */
    public function testSpecialItemQuality()
    {
        $items = [
            "special" => [
                new Item('Aged Brie', 5, 3)
            ]
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals(4, $items["special"][0]->quality);
    }

    /**
     * Testing Backstage passes 6 days result. Quality: 7
     * 6 day - 7 + 2
     * 5 day - 9 + 3
     * 4 day - 12 + 3
     * 3 day - 15 + 3
     * 2 day - 18 + 3
     * 1 day - 21 + 3
     * 0 - last result - 24
     */
    public function testSpecialItemQualityBackstagePasses6Days()
    {
        $items = [
            "special" => [
                new Item('Backstage passes to a TAFKAL80ETC concert', 6, 7)
            ]
        ];

        $gildedRose = new GildedRose($items);
        $days = 6;
        for($i=$days; $i >= 1; $i--) {
            $gildedRose->updateQuality();
        }

        $this->assertEquals(24, $items["special"][0]->quality);
    }

}
