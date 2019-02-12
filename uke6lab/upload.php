<?php

require_once "./classes/DB.php";
require_once "./twig/vendor/autoload.php";
define("IMAGE_H", 75);
define("IMAGE_W", 75);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array());
$height = 150;
$width = 150;

if (!isset($_FILES['files'])) {
	echo $twig->render('upload.html', array (
	));
	exit();
}
$db = DB::getDBConnection();

if(is_uploaded_file($_FILES['files']['tmp_name'])) {
	$size = $_FILES['files']['size'];

	$mime = $_FILES['files']['type'];
	$name = $_FILES['files']['name'];
	$sql = "INSERT INTO filesOnDisc (owner, name, mime, size, description, image) VALUES (?, ?, ?, ?, ?, ?)";
	$sth = $db->prepare($sql);
	$content = file_get_contents($_FILES['files']['tmp_name']);
	$name = substr($name, 0, strrpos($name, '.')).'.png';
	$scaledContent = scale(imagecreatefromstring($content),$width,$height);
	unset($content);
	$sth-> execute(array ($_POST['uid'], $name, $mime, $size, $_POST['description'], $scaledContent));

	if($sth->rowCount()==1) {
		$id = $db->lastInsertId();
		if(!file_exists('uploadedFiles/'.$_POST['uid'])) {
			@mkdir ('uploadedFiles/'.$_POST['uid']);
		}
		if (@move_uploaded_file($_FILES['files']['tmp_name'], "uploadedFiles/{$_POST['uid']}/$id")) {
			echo $twig->render('uploadSucc.html', array('fileName'=>$name, 'size'=>$size));
		} else {
			$sql = "DELETE FROM filesOnDisc where id=$id";
			$db->exec($sql);
			echo $twig->render('uploadFailed.html', array (
			));
		}
	} else {
		echo $twig->render('upload.html', array (
		));
	}
}

function scale ($img, $new_width, $new_height) {
  $old_x = imageSX($img);
  $old_y = imageSY($img);

  if($old_x > $old_y) {                     // Image is landscape mode
    $thumb_w = $new_width;
    $thumb_h = $old_y*($new_height/$old_x);
  } else if($old_x < $old_y) {              // Image is portrait mode
    $thumb_w = $old_x*($new_width/$old_y);
    $thumb_h = $new_height;
  } if($old_x == $old_y) {                  // Image is square
    $thumb_w = $new_width;
    $thumb_h = $new_height;
  }

  if ($thumb_w>$old_x) {                    // Don't scale images up
    $thumb_w = $old_x;
    $thumb_h = $old_y;
  }

  $dst_img = ImageCreateTrueColor($thumb_w,$thumb_h);
  imagecopyresampled($dst_img,$img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);

  ob_start();                         // flush/start buffer
  imagepng($dst_img,NULL,9);          // Write image to buffer
  $scaledImage = ob_get_contents();   // Get contents of buffer
  ob_end_clean();                     // Clear buffer
  return $scaledImage;

}
?>
