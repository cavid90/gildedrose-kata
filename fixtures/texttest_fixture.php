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
 * After this grouping it was simple to write code with DRY, KISS and SOLID principles
 */
$items = [
    // The item quality increase
    new Item('Aged Brie', 2, 0),
    new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20),
    new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49),
    new Item('Backstage passes to a TAFKAL80ETC concert', 6, 7),

    // The item quality decreases
    new Item('Conjured Mana Cake', 5, 7),
    new Item('+5 Dexterity Vest', 10, 20),
    new Item('Elixir of the Mongoose', 5, 15),

    // The item quality does not change
    new Item('Sulfuras, Hand of Ragnaros', 0, 80),
    new Item('Sulfuras, Hand of Ragnaros', -1, 80)

];

// Define container and bind GildedRose class
$container = new \DI\Container();
$app = $container->get(GildedRose::class);
$app->setMinQuality(0)->setMaxQuality(50);

$days = 2;
if (count($argv) > 1) {
    $days = (int) $argv[1];
}

// First show the existing result
echo("################### First result #########################\n");
echo("name, sellIn, quality\n");
foreach ($items as $item) {
    echo $item . PHP_EOL."-------------------------------".PHP_EOL;
}
echo PHP_EOL;

// Update and show results day by day
for ($i = $days; $i > 0; $i--) {
    echo("################### day ".($i)." #########################\n");
    echo("name, sellIn, quality\n");
    foreach ($items as $item) {
        $app->setItem($item)->updateQualityByOne();
        echo $item . PHP_EOL."-------------------------------".PHP_EOL;
    }
    echo PHP_EOL;

}
