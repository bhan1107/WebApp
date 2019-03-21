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
    
    else if($formName == "professionalInsert"){
    	echo "professional insert if statement called";
    	echo "<br>";
        $professionalID = $_POST["professionalID"];
    	$firstName = $_POST["firstname"];                      
		$lastName = $_POST["lastname"];
		$fee = $_POST["professionalFee"];                      
    	insertProfesional($conn, $professionalID, $firstName, $lastName, $fee);
	}
    
    else if($formName == "studentInsert"){
    	echo "student insert if statement called";
    	echo "<br>";
        $studentID = $_POST["studentID"];
    	$firstName = $_POST["sfirstname"];                      
		$lastName = $_POST["slastname"];
		$fee = $_POST["studentFee"];                      
    	insertStudent($conn, $studentID, $firstName, $lastName, $fee);
	}
    
    else if($formName == "company" && $action == "add"){
    	echo "company insert if statement called";
    	echo "<br>";
    	$companyName = $_POST["companyName"];                      
		$tier = $_POST["tier"];
		$emailNumber = $_POST["emailNumber"];
		$emailSent = $_POST["emailSent"];                      
    	insertCompany($conn, $companyName, $tier, $emailNumber, $emailSent);
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
		$conn->exec($sql);
		echo "Inserted successfully";
    }
    
function insertSponsor($conn,$firstName, $lastName, $sponsorID, $fee, $companyName) #Insert sponsor
	{
		echo "function called";
		echo "<br>";
		$sql = "INSERT INTO CISC332.sponsor(Sponsor_ID,FirstName,LastName,Fee,Company_Name) 
		VALUES ('$sponsorID','$firstName','$lastName','$fee','$companyName')";
		$conn->exec($sql);
		echo "Inserted successfully";
    }
    
function insertProfesional($conn, $professionalID, $firstName, $lastName, $fee) #Insert professional
	{
		echo "function called";
		echo "<br>";
		$sql = "INSERT INTO CISC332.professional(Professional_ID,FirstName,LastName,Fee) 
		VALUES ('$professionalID','$firstName','$lastName','$fee')";
		$conn->exec($sql);
		echo "Inserted successfully";
    }
    
function insertStudent($conn, $studentID, $firstName, $lastName, $fee) #Insert student
	{
		echo "function called";
		echo "<br>";
		$sql = "INSERT INTO CISC332.student(Student_ID,FirstName,LastName,Fee) 
		VALUES ('$studentID','$firstName','$lastName','$fee')";
		$conn->exec($sql);
		echo "Inserted successfully";
    }

?> 



</body>
</html> 

