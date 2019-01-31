<?php
  require_once "../../twig/vendor/autoload.php";
  require_once "Contacts.php";

  $loader = new Twig_Loader_Filesystem('views');
  $twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache',
));

 echo $twig->render('searchContact.html',array ());
 if (isset($_GET['searchButton'])) {
 	$keyword = $_GET['search'];

 	$contacts = new Contacts();
  	$result = $contacts->searchContact($keyword);

  	echo $twig->render('showContacts.html', $result);
}
;

?>
