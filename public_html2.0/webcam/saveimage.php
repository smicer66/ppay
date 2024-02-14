<?php

//set random name for the image, used time() for uniqueness

$filename =  time() . '.jpg';
$filepath = 'C:'.DIRECTORY_SEPARATOR.'xampp'.DIRECTORY_SEPARATOR.'htdocs'.DIRECTORY_SEPARATOR.'smartschoolbox'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR;
//read the raw POST data and save the file with file_put_contents()
//echo file_get_contents('php://input');
$result = file_put_contents( $filepath.$filename, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}

echo $filename;
?>
