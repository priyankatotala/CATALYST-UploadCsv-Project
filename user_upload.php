<?php 



// Create database and table and users

$host = 'localhost';
$dbuser = 'username';
$dbpass = 'password';


$db = new PDO("pgsql:host=$host", $dbuser,$dbpass);
$dbcreate = "CREATE DATABASE dbcsv";

$db->exec($dbcreate);
echo "Database created successfully<br>";

$dbname = 'dbcsv';


// Connecting to the created database dbcsv

$con = pg_connect("$host $dbname $dbuser $dbpass");
if(!$con) {
	echo "Error: Database could not be opened";
}
else {
	echo "Database is opened successfully";
}

// Query to create users table
$pgsql =<<<EOF
	CREATE TABLE users
	(ID INT PRIMARY KEY NOT NULL,
	name TEXT NOT NULL,
	surname TEXT NOT NULL,
	email TEXT NOT NULL);
EOF;
 
	$query = pg_query($con, $pgsql);
	if(!$query){
		echo pg_last_error($con);
		}
		else
		{
			echo "Succesfully created the table";
		}

		pg_close($con);







?>