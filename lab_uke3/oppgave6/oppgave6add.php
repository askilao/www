<?php
  require_once "../../twig/vendor/autoload.php";

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

    $dbh = dbload();
    $sql = 'INSERT INTO kontaktinfo (navn, telefon, epost) values (?, ?, ?)';
    $sth = $dbh->prepare ($sql);
    $sth-> execute (array ($name, $telephone, $email));

    echo "Contact Created";
    
}
   function checkContact($email) {

    $dbh = dbload();
    $sql = 'SELECT * FROM kontaktinfo WHERE epost = ?';
    $sth = $dbh->prepare ($sql);
    $sth-> execute (array ($email));
    if ($sth->rowCount()>=1) {
      return true;
    } else {
      return false;
  }
}


if (isset($_POST['addContact'])) {

  $name = $_POST['name'];
  $telephone = $_POST['telephone'];
  $email = $_POST['email'];


  if (checkContact($email)) {
    echo "Contact already exists";
  } else {
    addContact($name, $telephone, $email);
  }

}


?>
