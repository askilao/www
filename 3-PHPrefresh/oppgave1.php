<!DOCTYPE html>
<html>
<head>
<title>Lab 3 oppgave 1</title>
</head>
<body>
	<?php
	require_once "Pinterest.php";

	$res = Pinterest::getPins("mathematical riddles fun");

	foreach ($res as $key) {
	echo "$key<br/>";
	}

?>


</body>
</html>
