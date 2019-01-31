<?php
  require_once "../../twig/vendor/autoload.php";
  require_once "Contacts.php";

  $loader = new Twig_Loader_Filesystem('views');
  $twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache',
));

  if (isset($_GET['type'])) {
    $id = $_GET['id'];
    
    $contacts = new Contacts();
    $result = $contacts->getContact($id);
    if ($_GET['type']=='edit') { 
        echo $twig->render('editContact.html', $result);
    } else if ($_GET['type']=='delete') {
        $contacts->deleteContact($id);
        $result= $contacts->showContact();
        echo $twig->render('showContacts.html', $result);

    }
  } else if ($_POST['updateContact']){
            $data['id'] = $_POST['id'];
            $data['name'] = $_POST['name'];
            $data['telephone'] = $_POST['telephone'];
            $data['email'] = $_POST['email'];
            
            $contacts = new Contacts(); 
            $contacts->updateContact($data);

            $result= $contacts->showContact();
            echo $twig->render('showContacts.html', $result);

  }
                                              
    
        #$result= $contacts->showContact();
        #echo $twig->render('showContacts.html', $result);

;

?>
