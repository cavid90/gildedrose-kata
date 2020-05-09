<?php

namespace App;

class GildedRoseTest extends \PHPUnit\Framework\TestCase {
    public function testFoo() {
        $items      = [
            "special" => [
                new Item("foo", 0, 0)
                ]
        ];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals("fixme", $items["special"][0]->name);
    }
}
