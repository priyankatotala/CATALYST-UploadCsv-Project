<!DOCTYPE html>
<html>
<head>
	<title>Upload CSV file intoPostgreSQL using php</title>

	
</head>

<!-- form to upload the csv file -->
<body>


<?php 

// Connecting to the created database dbcsv

$con = pg_connect("host=localhost dbname=postgres user=username password=password");
if(!$con) {
	echo "Error: Database could not be opened";
	}

// Query to create users table
$pgsql1 =<<<EOF
	CREATE TABLE users
	(
	id serial NOT NULL,
	name character varying(50),
	surname character varying(50),
	email character varying(50));
EOF;
 
	$query = pg_query($con, $pgsql1);
	if(!$pgsql1)
	{
		echo pg_last_error($con);
	}
		
		
 	 if(isset($_POST["submit"])){
		
		$filename = $_FILES['csvusers']['name'];		
 
 
		 if($_FILES["csvusers"]["size"] > 0)
		 {
			
			$fname = $_FILES['csvusers'] ['tmp_name'];
		  	$file = fopen($fname, "r");
			fgetcsv($file);

	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {

			// Convert name and surname to First letter capital and rest in lowercase alphabets
	         	$getData[0] = ucfirst(strtolower(pg_escape_string($getData[0])));
			
			$getData[1] = ucfirst(strtolower(pg_escape_string($getData[1])));
			
 			// Check for email format and convert email to lower cases
			
			
			$getData[2] = strtolower(filter_var($getData[2], FILTER_VALIDATE_EMAIL));
				
			if(!empty($getData[2]))
				{
				$pgsql2 =<<<EOF
	       		INSERT into users (name,surname,email) 
                  	values ('$getData[0]','$getData[1]','$getData[2]');
EOF;
                   $result = pg_query($con, $pgsql2);  
			echo "<script type=\"text/javascript\">
				alert(\"CSV file uploadedsuccessfully\");
				window.location = \"user_upload.php\"
			      </script>";
 				 }
						
			
	         }

			
	         fclose($file);	
		 }
	} 	 


pg_close($con);



?>

<form method='POST'  enctype='multipart/form-data'>
	Upload CSV file: 
	<input type="file" name="csvusers" />
	<input type="submit" name="submit" value="UPLOAD">

</form>
 
</body>
</html>


