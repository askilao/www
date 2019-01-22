<?php
  require_once "../../twig/vendor/autoload.php";

  $loader = new Twig_Loader_Filesystem('views');
  $twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache',
));
 

  $dsn = 'mysql:dbname=labuke3;host=127.0.0.1';
  $user = 'root';
  $password = '';

  try {
      $dbh = new PDO($dsn, $user, $password);
  } catch (PDOException $e) {
      // NOTE IKKE BRUK DETTE I PRODUKSJON
      echo 'Connection failed: ' . $e->getMessage();
  }

  $sql = 'SELECT * FROM kontaktinfo';
  $sth = $dbh->prepare ($sql);
  $sth-> execute ();
  $result['contacts'] = $sth->fetchAll();

 echo $twig->render('showContacts.html', $result);



?>
