<?php
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


echo $twig->render('registerUser.html', array(
));

if (isset($_POST['register'])) {
  $data['username'] = $_POST['username'];
  $data['password'] = $_POST['password'];
  $data['optional'] = $_POST['optional'];
  $user = new User($db);
  $user->addUser($data);
  header("Location: index.php");
}
?>