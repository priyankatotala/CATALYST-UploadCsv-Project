<!DOCTYPE html>
<html>
<head>
	<title>Upload CSV file intoPostgreSQL using php</title>

 <!-- Javascript checks for the CSV file to get uploaded. -->

	
</head>

<!-- form to upload the csv file -->
<body>
<form method='POST' id='frmCSVImport' enctype='multipart/form-data'>
	Upload CSV file: 
	<input type="file" name="csvusers" />
	<input type="submit" name="submit" value="UPLOAD">

</form>

<?php 

// Connecting to the created database dbcsv

$con = pg_connect("host=localhost dbname=dbcsv user=username password=password");
if(!$con) {
	echo "Error: Database could not be opened";
}
else {
	echo "Database is opened successfully";
}
// Query to create users table
$pgsql1 =<<<EOF
	CREATE TABLE test
	(
	id serial NOT NULL,
	name character varying(50),
	surname character varying(50),
	email character varying(50));
EOF;
 
	$query = pg_query($con, $pgsql1);
	if(!$query){
		echo pg_last_error($con);
		}
		else
		{
			echo "Succesfully created the table";
		}

		
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
 


 if(isset($_POST["submit"])){
		
		$filename = $_FILES['csvusers']['name'];		
 
 
		 if($_FILES["csvusers"]["size"] > 0)
		 {
			$fname = $_FILES['csvusers'] ['tmp_name'];
		  	$file = fopen($fname, "r");
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {
	         			

  
			$pgsql2 =<<<EOF
	       		INSERT into test (name,surname,email) 
                   values ('$getData[0]','$getData[1]','$getData[2]');
EOF;
                   $result = pg_query($con, $pgsql2);
				if(!isset($result))
				{
					echo "<script type=\"text/javascript\">
							alert(\"Invalid Format:Please Upload CSV Format.\");
							window.location = \"user_upload.php\"
						  </script>";		
				}
				else {
					  echo "<script type=\"text/javascript\">
						alert(\"CSV File has been imported successfully.\");
						window.location = \"user_upload.php\"
					</script>";
				}
	         }
			
	         fclose($file);	
		 }
	}	 


pg_close($con);



?>
 
</body>
</html>


