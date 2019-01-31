<?php
require_once "Pinterest.php";

$res = Pinterest::getPins("mathematical riddles fun");

echo "<img src='{$res[0]}'>";
 ?>
