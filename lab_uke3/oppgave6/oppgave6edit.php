<?php
  require_once "../../twig/vendor/autoload.php";
  require_once "Contacts.php";

  $loader = new Twig_Loader_Filesystem('views');
  $twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache',
));

 if (isset($_GET['type'])) {
 	echo $_GET['email'];

  	#echo $twig->render('showContacts.html', $result);
}
;

?>