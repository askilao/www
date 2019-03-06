<?php
session_start();

$test = 2;
require_once "./classes/User.php";
require_once "./classes/DB.php";
require_once "./twig/vendor/autoload.php";

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array());


$db = DB::getDBConnection();
if ($db==null) {
    echo $twig->render('nodb.html', array('errmessage' => 'Error: no DB connection'));
    die();
}
$user = new User($db);

if (isset($_POST['register'])) {
  $data['username'] = $_POST['username'];
  $data['password'] = $_POST['password'];
  $data['optional'] = $_POST['optional'];
  $user->addUser($data);
}

if ($user->loggedIn()) {
    echo $twig->render('index.html', array('loggedin' => 'yes' ));
  } else {
    echo $twig->render('index.html', array(
    ));
  }

