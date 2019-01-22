<?php
  require_once "../twig/vendor/autoload.php";

  $loader = new Twig_Loader_Filesystem('views');
  $twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache',
));
 

  echo $twig->render('addContact.html', array(
  ));
function dbload() {
  $dsn = 'mysql:dbname=labuke3;host=127.0.0.1';
  $user = 'root';
  $password = '';

  try {
      $dbh = new PDO($dsn, $user, $password);
  } catch (PDOException $e) {
      // NOTE IKKE BRUK DETTE I PRODUKSJON
      echo 'Connection failed: ' . $e->getMessage();
  }
  return $dbh;
}
  function addContact($name, $telephone, $email) {

    
}
   function checkContact() {

    $dbh = dbload();
    $sql = 'SELECT * FROM kontaktinfo WHERE epost = '".$username."'';
    $sth = $dbh->prepare ($sql);
    $sth-> execute (array ($_POST['email']));
    if ($sth->rowCount()>=1) {
      return true;
    } else {
      return false;
  }
}


if (isset($_POST['addContact'])) {
  
  if (checkContact()) {
    echo "true";
  } else {
    echo "false";
  }

}


?>
