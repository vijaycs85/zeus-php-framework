<?php
	
	require 'core-0/.003/core.php';
	
	$file = new Zeus_Image('./media/images/myimage.jpg');
	
	$file->crop(200, 200)->render();
	
	
	
?>