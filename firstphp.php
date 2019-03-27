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
	echo "$formName" . " HELLO!" . "<br>";
	echo "$action" . " is action name <br>";
	if($action == "add"){
		echo "Add<br>";
	}else{
		echo "List <br>";
	}
    if($action == "add" && $formName == "sponsorInsert"){
    	echo "sponsor insert if statement called";
    	echo "<br>";
    	$firstName = $_POST["firstname"];                      
		$lastName = $_POST["lastname"];
		$sponsorID = $_POST["sponsorID"];
		$fee = $_POST["sponsorFee"];                      
		$companyName = $_POST["companyName"];
    	insertSponsor($conn,$firstName, $lastName, $sponsorID, $fee, $companyName);
	}

	else if($formName == "sponsorInsert" && $action == "list"){
		echo "Sponsor List is called";
    	listSponsor($conn);
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
    	$firstName = $_POST["firstname"];                      
		$lastName = $_POST["lastname"];
		$fee = $_POST["studentFee"]; 
        $room = $_POST["roomNumber"];  
    	insertStudent($conn, $studentID, $firstName, $lastName, $fee, $room);
	}
    else if($formName == "company" && $action == "add"){
    	echo "company insert if statement called";
    	echo "<br>";
    	$companyName = $_POST["companyName"];
        $fee = $_POST["companyFee"];
		$tier = $_POST["tier"];
		$emailNumber = $_POST["emailNumber"];
		$emailSent = $_POST["emailSent"];                      
    	insertCompany($conn, $companyName, $fee, $tier, $emailNumber, $emailSent);
	}
	else if ($formName == "viewSubCommittees"){
		showSubcommittees($conn);
	}
	else if ($formName == "subcMembersForm"){
		echo "<br>";
    	$selected_subc = $_POST['subcommitteeChosen'];
    	showSubMembers($selected_subc, $conn);
	}
	else if($formName == "company" && $action == "delete"){
    	echo "company delete is statement called";
    	echo "<br>";
    	$companyName = $_POST["companyName"];
        $fee = $_POST["companyFee"];        
		$tier = $_POST["tier"];
		$emailNumber = $_POST["emailNumber"];
		$emailSent = $_POST["emailSent"];                 
    	deleteCompany($conn, $companyName, $fee, $tier, $emailNumber, $emailSent);
	}
	else if($formName == "listJobs"){
		echo "list Jobs called";
		echo "<br>";
		$companyName = $_POST["companyName"];
		listJobs($conn, $companyName);
	}	
	else if ($formName == "viewRooms"){
		showHotelRooms($conn);
	}
	else if ($formName == "studentsInRoomForm"){
		echo "<br>";
    	$selected_room = $_POST['roomNumChosen'];
    	showStudentsInRoom($selected_room, $conn);
	}
    else if ($formName == "viewSession"){
		showSession($conn);
	}
    else if ($formName == "sessionDateForm"){
		echo "<br>";
    	$selected_date = $_POST['dateChosen'];
    	showSessionDate($selected_date, $conn);
	}
    else if ($formName == "viewAttendee"){
		listAttendees($conn);
	}
    else if ($formName == "viewTotalIntake"){
		viewIntake($conn);
	}
    

    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

function viewIntake($conn){

    $studentIntake = "SELECT (((SELECT COUNT(*) FROM `student`) * 50) + ((SELECT COUNT(*) FROM `professional`) * 100)) AS `KKK`";
      
    $sponsorIntake = "SELECT (SELECT DISTINCT CAST(SUM(Fee) AS unsigned) FROM `company`) AS `BLM`";
    
    foreach($conn->query($studentIntake, PDO::FETCH_ASSOC) as $row){
		echo 'Total Intake: $' . $row['KKK'] . '<br>';
	}
    
    foreach($conn->query($sponsorIntake, PDO::FETCH_ASSOC) as $row){
		echo 'Sponsor Intake: $' . $row['BLM'] . '<br>';
	}
    
}      

function listAttendees($conn){
        echo '<br>';
        echo "Students:";
        echo '<br>';
    
        $sql = "SELECT `FirstName`, `LastName` FROM `student`";
		foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
			echo 'First Name: ' . $row['FirstName'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
			echo 'Last Name: ' . $row['LastName'] . '<br>';
		}
        
        echo '<br>';
        echo "Professionals:";
        echo '<br>';
        
        $sql = "SELECT `FirstName`, `LastName` FROM `professional`";
        foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
			echo 'First Name: ' . $row['FirstName'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
			echo 'Last Name: ' . $row['LastName'] . '<br>';
		}
        
        echo '<br>';
        echo "Sponsors:";
        echo '<br>';
        
        $sql = "SELECT `FirstName`, `LastName` FROM `sponsor`";
        foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
			echo 'First Name: ' . $row['FirstName'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
			echo 'Last Name: ' . $row['LastName'] . '<br>';
		}
    }
    
function insertCompany($conn, $companyName, $fee, $tier, $emailNumber, $emailSent) #Insert company
	{
		echo "function called";
		echo "<br>";
		$sql = "INSERT INTO CISC332.company(Name,Fee,Tier,Email_Num,Email_Sent) 
		VALUES ('$companyName', '$fee', '$tier', '$emailNumber', '$emailSent')";
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
    
function insertSponsor($conn, $firstName, $lastName, $sponsorID, $fee, $companyName) #Insert sponsor
	{
		echo "function called";
		echo "<br>";
		$sql = "INSERT INTO CISC332.sponsor(Sponsor_ID,FirstName,LastName,Fee,Company_Name) 
		VALUES ('$sponsorID','$firstName','$lastName','$fee','$companyName')";
		$conn->exec($sql);
		echo "Inserted successfully";
	}
	
function listSponsor($conn)
	{
		$sql = "SELECT `Name`, `Tier` FROM `company`";
		foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
			echo 'Company: ' . $row['Name'] . ' ';
			echo 'Sponsorship Level: ' . $row['Tier'] . '<br>';
		}
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
    
function insertStudent($conn, $studentID, $firstName, $lastName, $fee, $room) #Insert student
	{
		echo "function called";
		echo "<br>";
        $sql = "SELECT `bedNum`, `Occupancy` FROM `rooms` WHERE `roomNum` = '$room'";
        foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
            if ($row['Occupancy'] >= $row['bedNum']){
                echo "Error, too many people already living in that room";
            
            } else {
                
                $sql = "INSERT INTO CISC332.student(Student_ID,FirstName,LastName,Fee,fk_roomNum) 
                VALUES ('$studentID','$firstName','$lastName','$fee','$room')";
                $conn->exec($sql);
                echo "Inserted successfully";
                $OccupancyUpdate = $row['Occupancy'] + 1;
                $sql = "UPDATE rooms SET Occupancy = '$OccupancyUpdate' WHERE roomNum = '$room'";
                $conn->exec($sql);
            }
        }
    }
    function deleteCompany($conn, $companyName, $fee, $tier, $emailNumber, $emailSent) #Insert company
	{
		echo "Delete Company Function Called";
		echo "<br>";
		$sql = "DELETE FROM CISC332.company WHERE Name = '$companyName' AND Tier = '$tier'; ";
		$conn->exec($sql);
		echo "Delete successfully";
    }
    function listJobs($conn, $companyName)
    {
    	echo "list job Function Called";
		echo "<br>";
		if(empty($companyName)){
			$sql = "SELECT `Company_Name`, `Title`, `City`, `Province`, `Payrate` FROM `job`";
		}
		else{
			$sql = "SELECT `Company_Name`, `Title`, `City`, `Province`, `Payrate` FROM `job` WHERE `Company_Name` = '$companyName'";
		}
		
 
		foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
    	echo 'Company: ' . $row['Company_Name'] . ' ';
    	echo 'Title: ' . $row['Title'] . ' ';
    	echo 'Payrate: ' . $row['Payrate'] . ' ' ;
    	echo 'City: ' . $row['City'] . ' ';
    	echo 'Province: ' . $row['Province'] . '<br>';

		}
    }


function showSubMembers($subcommitteeName, $conn){

	$stmt = $conn->prepare("SELECT Member FROM CISC332.subCommittee WHERE Name = '$subcommitteeName'");

	$stmt->execute();
	$array = $stmt->fetchAll(PDO::FETCH_COLUMN);

	echo "Here are all the members in the $subcommitteeName subcommittee:<br>";
	for ($x = 0; $x < sizeof($array); $x++){
		$temp = $x + 1;
		echo "Member {$temp}: $array[$x]<br>";
	}
}

function showSubcommittees($conn){

	$stmt = $conn->prepare("SELECT Name FROM CISC332.subCommittee");

	$stmt->execute();
	$array = $stmt->fetchAll(PDO::FETCH_COLUMN);

	$arrayRemovedDupes = array_unique($array);


	echo "<br>Here is a drop down of all the existing subcommittees:<br>";
	?> 
	<form id="subcMembersForm" action="firstphp.php" method="post">
	<select name="subcommitteeChosen">
	<?php
	foreach ($arrayRemovedDupes as $subc){
		?>
		<option value="<?php echo $subc; ?>"><?php echo $subc; ?></option>
		<?php

	}
	?>

	</select>
	<input type="hidden" name="formName" value="subcMembersForm">
  	<input type="submit" name="SubmitButton" value="Select subcommittee"/>
	</form>
	<?php 
}

function showStudentsInRoom($roomNum, $conn){

	$stmt = "SELECT `Student_ID`, `FirstName`, `LastName` FROM `student` WHERE `fk_roomNum` = '$roomNum'";

	$count = 1;
	foreach($conn->query($stmt, PDO::FETCH_ASSOC) as $row){
		echo "Student {$count}: ";
    	echo 'Student ID: ' . $row['Student_ID'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
    	echo 'First Name: ' . $row['FirstName'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
    	echo 'Last Name: ' . $row['LastName'] . '<br>';
    	$count = $count + 1;
		}
}

function showHotelRooms($conn){

	$stmt = $conn->prepare("SELECT roomNum FROM CISC332.rooms");

	$stmt->execute();

	$array = $stmt->fetchAll(PDO::FETCH_COLUMN);

	$arrayRemovedDupes = array_unique($array);


	echo "<br>Here is a drop down of all the room numbers currently in use:<br>";
	?> 
	<form id="studentsInRoomForm" action="firstphp.php" method="post">
	<select name="roomNumChosen">
	<?php
	foreach ($arrayRemovedDupes as $roomNum){
		?>
		<option value="<?php echo $roomNum; ?>"><?php echo $roomNum; ?></option>
		<?php

	}
	?>

	</select>
	<input type="hidden" name="formName" value="studentsInRoomForm">
  	<input type="submit" name="SubmitButton" value="Select room number"/>
	</form>
	<?php 
}

function showSessionDate($date, $conn){

	$stmt = "SELECT `Session_ID`, `Speaker`, `Room_Number`, `Start_Date`, `Start_Time`, `End_Time`  FROM `session` WHERE `Start_Date` = '$date'";
	$count = 1;
	foreach($conn->query($stmt, PDO::FETCH_ASSOC) as $row){
		echo " {$count}: ";
    	echo 'Session ID: ' . $row['Session_ID'] . ' ';
        echo 'Speaker: ' . $row['Speaker'] . ' ';
        echo 'Start_Date: ' . $row['Start_Date'] . ' ';
        echo 'Start_Time: ' . $row['Start_Time'] .' ';
        echo 'End_Time: ' . $row['End_Time'] . '<br>';;
    	$count = $count + 1;
		}
	
}

function showSession($conn){
    
    $stmt = $conn->prepare("SELECT Start_Date FROM CISC332.session");

	$stmt->execute();

	$array = $stmt->fetchAll(PDO::FETCH_COLUMN);

	$arrayRemovedDupes = array_unique($array);


	echo "<br>Here is a drop down of all the session currently in use:<br>";
	?> 
	<form id="sessionDateForm" action="firstphp.php" method="post">
	<select name="dateChosen">
	<?php
	foreach ($arrayRemovedDupes as $date){
		?>
		<option value="<?php echo $date; ?>"><?php echo $date; ?></option>
		<?php

	}
	?>

	</select>
	<input type="hidden" name="formName" value="sessionDateForm">
  	<input type="submit" name="SubmitButton" value="Select date"/>
	</form>
	<?php 
}
?>

</body>
</html> 

