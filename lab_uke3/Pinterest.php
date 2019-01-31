<?php

require __DIR__ . '/vendor/autoload.php';

use seregazhuk\PinterestBot\Factories\PinterestBot;

/**
 * Contains methods to search pinterest for images.
 */
class Pinterest {

  /**
   * Searches pinterest for images matching the given search query.
   *
   * @return an array with urls to images matching the search query.
   */
  public static function getPins ($searchString) {
    $bot = PinterestBot::create();

    $pins = $bot->pins
        ->search(str_replace (" ", "%20", $searchString))
        ->take(25)
        ->toArray();
    $tmp = [];
    foreach($pins as $pin) {
      $tmp[] = $pin['images']['orig']['url'];
    }
    return $tmp;
  }
  public static function getPinsWithURLS ($searchString) {
     $bot = PinterestBot::create();

     $pins = $bot->pins
         ->search(str_replace (" ", "%20", $searchString))
         ->take(25)
         ->toArray();
     $tmp = [];
     foreach($pins as $pin) {
       $tmp[] = array ("img" => $pin['images']['orig']['url'], "url" => "https://no.pinterest.com/pin/{$pin['id']}/", "text" => $pin['description_html']);
     }
     return $tmp;
  }
}
