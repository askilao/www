<?php
  require_once "../../twig/vendor/autoload.php";
  require_once "Contacts.php";

  $loader = new Twig_Loader_Filesystem('views');
  $twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache',
));
 

  echo $twig->render('addContact.html', array(
  ));


if (isset($_POST['addContact'])) {
  $data['id'] = md5(time());
  $data['name'] = $_POST['name'];
  $data['telephone'] = $_POST['telephone'];
  $data['email'] = $_POST['email'];

  $contacts = new Contacts();
  $res = $contacts->addContact($data);
  echo $res['status'];
}


?>
