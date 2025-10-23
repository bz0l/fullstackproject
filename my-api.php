<?php
header('Access-Control-Allow-Origin: *');

// Connect to database
$mysqli = new mysqli("localhost","2432878","y8q18b","db2432878");
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

// Execute SQL query
$sql = "SELECT *
	FROM weather
	WHERE city = '{$_GET['city']}'
	AND weather_time >= DATE_SUB(NOW(), INTERVAL 10 SECOND)
	ORDER BY weather_time DESC limit 1";

$result = $mysqli -> query($sql);

// Error ?
if($result == false) {
	echo("<h4>SQL error description: " . $mysqli -> error . "</h4>");
}

// No data? Import fresh data and run query again!
if ($result->num_rows == 0) {
	include('data-import.php');
	$result = $mysqli -> query($sql); // Run query again after import
}

// Get data, convert to JSON and print
$row = $result -> fetch_assoc();
print json_encode($row);

// Free result set and close connection
$result -> free_result();
$mysqli -> close();

?>

