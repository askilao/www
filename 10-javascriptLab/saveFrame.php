<?php

if (isset($_POST['imageURL'])) {
	$base64 = explode( ',', $_POST['imageURL']);
	$filetype = multiexplode(array(":","/",";"), $base64[0]);
	$filename = 'image.'.$filetype[2];
	$image = base64_decode($base64[1]);
	file_put_contents($filename, $image);
}

function multiexplode ($delimiters,$string) {
    
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}