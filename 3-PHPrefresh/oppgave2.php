<?php
	require_once "Pinterest.php";
	require_once "../twig/vendor/autoload.php";

	$loader = new Twig_Loader_Filesystem('views');
	$twig = new Twig_Environment($loader);
	$res = Pinterest::getPins("mathematical riddles fun");
	
	
	$data["pins"] = $res;
	

	echo $twig->render('oppgave2.html', $data);

?>


