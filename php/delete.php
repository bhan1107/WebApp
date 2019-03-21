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
$action = $_POST['action'];


try { //connecting to the DB
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully\n";
	echo "<br>";
    if($formName == "sponsorInsert"){
    	echo "sponsor insert if statement called";
    	echo "<br>";
    	$firstName = $_POST["firstname"];                      
		$lastName = $_POST["lastname"];
		$sponsorID = $_POST["sponsorID"];
		$fee = $_POST["sponsorFee"];                      
		$companyName = $_POST["companyName"];
    	insertSponsor($conn,$firstName, $lastName, $sponsorID, $fee, $companyName);
	}
    
        }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

function insertCompany($conn, $companyName, $tier, $emailNumber, $emailSent) #Insert company
	{
		echo "function called";
		echo "<br>";
		$sql = "INSERT INTO CISC332.company(Name,Tier,Email_Num,Email_Sent) 
		VALUES ('$companyName', '$tier', '$emailNumber', '$emailSent')";
		try{
		$conn->exec($sql);
		echo "Inserted successfully";
		}
		catch (PDOException $e){
			if ($e->errorInfo[1] == 1062){
				echo "Error, that company already exists";
			}
		}
    }
 

?> 



</body>
</html> 

