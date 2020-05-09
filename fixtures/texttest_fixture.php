<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\GildedRose;
use App\Item;

echo "OMGHAI!\n";

/**
 * After thinking a little time I saw that it is better to group items by three types:
 * Special - which increases
 * Non special - which decreases
 * Legendary - remains the same, does not change
 * After this groupping it was simple to write code with DRY, KISS and SOLID principles
 */
$itemsByTypes = array(
    // The item quality increase
    "special" => [
        new Item('Aged Brie', 2, 0),
        new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20),
        new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49),
        new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49)
    ],
    // The item quality decreases
    "non-special" => [
        new Item('Conjured Mana Cake', 3, 6),
        new Item('+5 Dexterity Vest', 10, 20),
        new Item('Elixir of the Mongoose', 5, 7)
    ],
    // The item quality does not change
    "legendary" => [
        new Item('Sulfuras, Hand of Ragnaros', 0, 80),
        new Item('Sulfuras, Hand of Ragnaros', -1, 80)
    ]

);

$app = new GildedRose($itemsByTypes);
$app->setMinQuality(0)->setMaxQuality(50);

$days = 2;
if (count($argv) > 1) {
    $days = (int) $argv[1];
}

for ($i = 0; $i < $days; $i++) {
    echo("################### day ".($i+1)." #########################\n");
    echo("name, sellIn, quality\n");
    foreach ($itemsByTypes as $type => $items) {
        foreach ($items as $item) {
            echo $item . PHP_EOL."-------------------------------".PHP_EOL;
        }
    }
    echo PHP_EOL;
    $app->updateQuality();
}
