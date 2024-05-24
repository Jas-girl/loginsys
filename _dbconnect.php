<?php

$dbhost = 'localhost:4306'; // Remove the port number if it's the default MySQL port
$dbuser = 'root'; // Remove the extra space after root
$dbpass = ''; // Provide the correct password if set, otherwise keep it empty
$db     = 'goodhealth';


// Establishing connection to the database
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

// Check if the connection was successful
if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}



// Attempting to execute an SQL query
$sql = 'SELECT "Connected Successfully" AS message';
$retvalue = mysqli_query($conn, $sql);

// Check if the query was executed successfully
if (!$retvalue) {
    die('Cannot execute SQL query: ' . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($retvalue);


// Closing the database connection
mysqli_close($conn);

?>
