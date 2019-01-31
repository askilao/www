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


if ($user->loggedIn()) {
    echo $twig->render('index.html', array('loggedin' => 'yes' ));
  } else {
    echo $twig->render('index.html', array(
    ));
  }
if (isset($_POST['createUser'])) {
  $data['username'] = $_POST['createUsername'];
  $data['password'] = $_POST['CreatePassword'];
  $data['optional'] = $_POST['CreateOptional'];

  $res = $user->addUser($data);
  echo $res['status'];
}
