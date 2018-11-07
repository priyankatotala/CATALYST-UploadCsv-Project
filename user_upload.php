<?php 

// Connecting to the created database postgres

$con = pg_connect("host=localhost dbname=postgres user=username password=password");
if(!$con) {
	echo "Error: Database could not be opened";
	}

// Query to create users table
$pgsql1 =<<<EOF
	CREATE TABLE users
	(
	id serial NOT NULL,
	name varchar(50),
	surname varchar(50),
	email varchar(50));
EOF;
 
	$query1 = pg_query($con, $pgsql1);
	if(!$pgsql1)
	{
		echo pg_last_error($con);
	}
		
// path of the csv file location
define('CSV_PATH',"\home\priyanka\Desktop\");

// Name of the csv file
$csv_user = CSV_PATH. 'users.csv';

// Reading the csv file
if (($csvopen = fopen($csv_user, 'r')) !== FALSE) 
	{
fgetcsv($csvopen);
while (($data = fgetcsv($csvopen, 1000, ",")) !== FALSE) 
	{
	$num = count ($csvData);
	for ($c=0; $c < $num; $c++) 
	{
	$col[$c] = $csvData[$c];
	}

// Convert name and surname to First letter capital and rest in lowercase alphabets
$csvData[0] = ucfirst(strtolower(pg_escape_string($csvData[0])));
$csvData[1] = ucfirst(strtolower(pg_escape_string($csvData[1])));
			
// Check for email format and convert email to lower cases
$csvData[2] = strtolower(filter_var($csvData[2], FILTER_VALIDATE_EMAIL));

// Query to insert data into database
			if(!empty($csvData[2]))
			{
			$pgsql2 =<<<EOF
	       		INSERT into users (name,surname,email) 
                  	values ('$csvData[0]','$csvData[1]','$csvData[2]');
EOF;
                   $query2 = pg_query($con, $pgsql2);  
			echo 'file imported';				
 			}
			else { echo 'invalid email format'; }
	}
	}
	fclose($csvopen);
pg_close($con);
?>
