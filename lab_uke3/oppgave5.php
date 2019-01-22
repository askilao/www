<?php
	require_once "Pinterest.php";
	require_once "../../twig/vendor/autoload.php";

	$loader = new Twig_Loader_Filesystem('views');
	$twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache',
));
	$res = Pinterest::getPinsWithURLS("mathematical riddles fun");
	
	$data["pins"] = $res;
	

	echo $twig->render('oppgave5.html', $data);

?>
