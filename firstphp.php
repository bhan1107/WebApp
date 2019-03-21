<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h2>Employee Information</h2>

 <?php
$servername = "localhost:3307";
$username = "bhan1107";
$password = "ss1ss2ss";
$dbname = "CISC332";
$formName = $_POST['formName'];


try { //connecting to the DB
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully\n";
    if($formName == "sponsorInsert"){
    	echo "If-statement called\n";
    	$firstName = $_POST["firstname"];                      
		$lastName = $_POST["lastname"];
		$sponsorID = $_POST["sponsorID"];
		$fee = $_POST["sponsorFee"];                      
		$companyName = $_POST["companyName"];
    	insertSponsor($conn,$firstName, $lastName, $sponsorID, $fee, $companyName);
	} 
    if($formName == "professionalInsert"){
    	echo "If-statement called\n";
        $professionalID = $_POST["professionalID"];
    	$firstName = $_POST["firstname"];                      
		$lastName = $_POST["lastname"];
		$professionalFee = $_POST["professionalFee"];                      
    	insertProfessional($conn, $professionalID, $firstName, $lastName, $professionalFee);
	}
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

function insertSponsor($conn,$firstName, $lastName, $sponsorID, $fee, $companyName) #Insert sponsor
	{
		echo "function called";
		$sql = "INSERT INTO CISC332.sponsor(Sponsor_ID,FirstName,LastName,Fee,Company_Name) 
		VALUES ('$sponsorID','$firstName','$lastName','$fee','$companyName')";
		$conn->exec($sql);
		echo "Inserted successfully";
    }
function insertProfessional($conn,$firstName, $lastName, $sponsorID, $fee, $companyName) #Insert professional
	{
		echo "function called";
		$sql = "INSERT INTO CISC332.sponsor(Professiona_ID,FirstName,LastName,Fee,Company_Name) 
		VALUES ('$professionalID','$firstName','$lastName','$professionalFee')";
		$conn->exec($sql);
		echo "Inserted successfully";
    }
?> 



</body>
</html> 

