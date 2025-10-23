<?php
	$mysqli = new mysqli("localhost","2432878","Santoryu11037","db2432878");
	if ($mysqli -> connect_errno) {
	echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	exit();
	}
?>