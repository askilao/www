<?php
session_start();

$test = 2;
require_once "./classes/User.php";
require_once "./classes/DB.php";
require_once "../twig/vendor/autoload.php";

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array());


$db = DB::getDBConnection();
if ($db==null) {
    echo $twig->render('nodb.html', array('errmessage' => 'Error: no DB connection'));
    die();
}
$user = new User($db);
$userdata['username'] = "email@email";
$userdata['password'] = "password";
$user->addUser($userdata);
?>
<form id="login" method="POST" action="index.php">
  <input type="hidden" name="login" value="1"><!-- Must have a field other than the button for Mink -->
  <input type="submit" value="logg inn">
</form>
<form id="logout" method="POST" action="index.php">
  <input type="hidden" name="logout" value="1"><!-- Must have a field other than the button for Mink -->
  <input type="submit" value="logg ut">
</form>

<?php
  if ($user->loggedIn()) {
    echo "<h1>Hemmelig</h1>";
  } else {
    echo "<p>Ikke logget inn</p>";
  }
 ?>
