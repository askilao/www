<?php
require_once "./classes/DB.php";

$db = DB::getDBConnection();

if (isset($_GET['thumbnail'])) {
	$sql = "SELECT name, mime, image FROM filesOnDisc WHERE id=?";
	$sth = $db->prepare ($sql);
	$sth->execute(array($_GET['id']));
	if ($row=$sth->fetch(PDO::FETCH_ASSOC)) {
   		header('Content-type: '.$row['mime']);
    	header('Content-Disposition: inline; filename='.$row['name']);
    	header('Content-Length: ' . strlen($row['image']));
    	echo ($row['image']);
    	die();		
	}
}

$sql = "SELECT name, mime, size, id, owner FROM filesOnDisc WHERE id=?";
$sth = $db->prepare ($sql);
$sth->execute(array($_GET['id']));

if ($row=$sth->fetch(PDO::FETCH_ASSOC)) {
  if (file_exists("uploadedFiles/{$row['owner']}/{$row['id']}")) {
    header('Content-type: '.$row['mime']);
    header('Content-Disposition: attachment; filename='.$row['name']);
    header('Content-Length: ' . $row['size']);
    readfile ("uploadedFiles/{$row['owner']}/{$row['id']}");
    die();
  }
}
header("HTTP/1.0 404 Not Found");
?>