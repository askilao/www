<pre>
<?php

require __DIR__ . '/vendor/autoload.php';

use seregazhuk\PinterestBot\Factories\PinterestBot;

$bot = PinterestBot::create();

$pins = $bot->pins
    ->search('cats')
    ->take(100)
    ->toArray();
print_r($pins[0]);
