<?php

require_once "./classes/DB.php";
require_once "./twig/vendor/autoload.php";

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array());


$db = DB::getDBConnection();

$sql = 'SELECT id, owner, size, description FROM filesOnDisc ORDER BY name';
$sth = $db->prepare ($sql);
$sth->execute();

$result = $sth->fetchAll(PDO::FETCH_ASSOC);

echo $twig->render('index.html', array ('files'=>$result));
?>
