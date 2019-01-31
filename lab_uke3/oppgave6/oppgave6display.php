<?php
  require_once "../../twig/vendor/autoload.php";
  require_once "Contacts.php";

  $loader = new Twig_Loader_Filesystem('views');
  $twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache',
));
 

  $contacts = new Contacts();
  $result = $contacts->showContact();

 echo $twig->render('showContacts.html', $result);



?>
