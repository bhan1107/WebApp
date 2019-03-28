<!DOCTYPE html>
<html>
<head>
		<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
	  <div class="row">
    <nav id="navigation" class="navigation-main" role="navigation">
      <div class="menu-street-container"><ul id="menu-street" class="menu">
        <li class="menu-item"><a href="http://benhan.ddns.net:8889">Home</a></li>
        </ul>
      </div>
    </nav>
  </div>
	<div id="centerContainer">
<h3>Employee Information</h3>

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
    //echo "Connected successfully\n";
	echo "<br>";
	//echo "$formName" . " HELLO!" . "<br>";
	//echo "$action" . " is action name <br>";
	//if($action == "add"){
	//	echo "Add<br>";
	//}else{
	//	echo "List <br>";
	//}
    if($action == "add" && $formName == "sponsorInsert"){
    	//echo "sponsor insert if statement called";
    	echo "<br>";
    	$firstName = $_POST["firstname"];                      
		$lastName = $_POST["lastname"];
		$sponsorID = $_POST["sponsorID"];
		$fee = $_POST["sponsorFee"];                      
		$companyName = $_POST["companyName"];
    	insertSponsor($conn,$firstName, $lastName, $sponsorID, $fee, $companyName);
	}

	else if($formName == "sponsorInsert" && $action == "list"){
		//echo "Sponsor List is called";
    	listSponsor($conn);
	}
	
    else if($formName == "professionalInsert"){
    	//echo "professional insert if statement called";
    	echo "<br>";
        $professionalID = $_POST["professionalID"];
    	$firstName = $_POST["firstname"];                      
		$lastName = $_POST["lastname"];
		$fee = $_POST["professionalFee"];                      
    	insertProfesional($conn, $professionalID, $firstName, $lastName, $fee);
	}
    
    else if($formName == "studentInsert"){
    	//echo "student insert if statement called";
    	echo "<br>";
        $studentID = $_POST["studentID"];
    	$firstName = $_POST["firstname"];                      
		$lastName = $_POST["lastname"];
		$fee = $_POST["studentFee"]; 
        $room = $_POST["roomNumber"];  
    	insertStudent($conn, $studentID, $firstName, $lastName, $fee, $room);
	}
    
   
    else if($formName == "viewCompany" && $action == "delete"){
    	echo "company delete is statement called <br>";                
    	deleteCompany($conn);
	}
    
    else if($formName == "viewCompany" && $action == "add"){
    	echo "company add is statement called <br>";                
    	addCompany($conn);
	}
    
    else if($formName == "companyInsert"){
    	echo "company insert if statement called";
    	echo "<br>";
        $Name = $_POST["Name"];
    	$Fee = $_POST["Fee"];                      
		$Tier = $_POST["Tier"];
		$Email_Num = $_POST["Email_Num"]; 
        $Email_Sent = $_POST["Email_Sent"];        
    	insertCompany($conn, $Name, $Fee, $Teir, $Email_Num, $Email_Sent);
	}
    
    else if ($formName == "deleteCompanyForm"){
    	$selected_Name = $_POST['companyChoose'];
    	deleteSelectedCompany($selected_Name, $conn);
	}
    
    
	else if ($formName == "viewSubCommittees"){
		showSubcommittees($conn);
	}
	else if ($formName == "subcMembersForm"){
		echo "<br>";
    	$selected_subc = $_POST['subcommitteeChosen'];
    	showSubMembers($selected_subc, $conn);
	}
	else if($formName == "listJobs"){
		//echo "list Jobs called";
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
    else if ($formName == "viewSession" && $action == "schedule"){
		showSession($conn);
	}
    else if ($formName == "sessionDateForm"){
		echo "<br>";
    	$selected_date = $_POST['dateChosen'];
    	showSessionDate($selected_date, $conn);
	}
    
    else if($formName == "viewSession" && $action == "delete"){
    	echo "session delete is statement called <br>";                
    	deleteSession($conn);
	}
    
    else if($formName == "viewSession" && $action == "add"){
    	echo "session add is statement called <br>";                
    	addSession($conn);
	}
    
     else if($formName == "sessionInsert"){
    	//echo "student insert if statement called";
    	echo "<br>";
        $sessionID = $_POST["sessionID"];
    	$speaker = $_POST["speaker"];                      
		$roomNum = $_POST["roomNum"];
		$startDate = $_POST["startDate"]; 
        $startTime = $_POST["startTime"]; 
        $endTime = $_POST["endTime"];         
    	insertSession($conn, $sessionID, $speaker, $roomNum, $startDate, $startTime, $endTime);
	}
    
    else if ($formName == "deleteSessionForm"){
		echo "<br>";
    	$selected_ID = $_POST['sessionChosen'];
    	deleteSessionDate($selected_ID, $conn);
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

    function deleteSelectedCompany($date, $conn){

	$sql = "DELETE FROM CISC332.company WHERE Name = '$date'";
		$conn->exec($sql);
		echo "Delete successfully";
	
}
    
 function deleteCompany($conn) {
	
    
    $sql = "SELECT `Name`, `Fee`, `Tier`, `Email_Num`, `Email_Sent` FROM  `company`";
		foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
			echo 'Name: ' . $row['Name'] . ' ';
			echo 'Fee: ' . $row['Fee'] . ' ';
            echo 'Tier: ' . $row['Tier'] . ' ';
            echo 'Email_Num: ' . $row['Email_Num'] . ' ';
            echo 'Email_Sent: ' . $row['Email_Sent'] . '<br>';
		}
    
    $stmt = $conn->prepare("SELECT `Name` FROM  `company`");

	$stmt->execute();

	$array = $stmt->fetchAll(PDO::FETCH_COLUMN);

	$arrayRemovedDupes = array_unique($array);


	echo "<br>Here is a drop down of all the company name currently in use:<br>";
	?> 
	<form id="compForm" action="firstphp.php" method="post">
	<select name="companyChoose">
	<?php
	foreach ($arrayRemovedDupes as $company){
		?>
		<option value="<?php echo $company; ?>"><?php echo $company; ?></option>
		<?php

	}
	?>

	</select>
	<input type="hidden" name="formName" value="deleteCompanyForm">
  	<input type="submit" name="SubmitButton" value="Select company"/>
	</form>
	<?php 
    }
    
function addCompany($conn) {  
    ?>
    <div class="content">
    <form id="compForm" action="firstphp.php" method ="post">
    <p>Company Name:</p>
    <input type="text" name="Name">
    <p>Fee:</p>
    <input type="text" name="Fee">
    <p>Tier:</p>
    <input type="text" name="Tier">
    <p>Email Number:</p>
    <input type="text" name="Email_Num">
    <p>Email Sent:</p>
    <input type="text" name="Email_Sent"><br>
    <input type="hidden" name="formName" value="companyInsert">
    <br>
    <input type="submit">
    </form> 
  </div>
  <?php
 }

 function insertCompany($conn, $Name, $Fee, $Tier, $Email_Num, $Email_Sent){
	
		$sql = "INSERT INTO CISC332.company(Name, Fee, Tier, Email_Num, Email_Sent) 
		VALUES ('$Name', '$Fee', '$Tier', '$Email_Num', '$Email_Sent')";
		try{
		$conn->exec($sql);
		echo "Inserted successfully";
		}
		catch (PDOException $e){
			if ($e->errorInfo[1] == 1062){
				echo "<p class='ErrorText'>Error, that company already exists</p>";
			}
		}
    }
    
function viewIntake($conn){

    $studentIntake = "SELECT (((SELECT COUNT(*) FROM `student`) * 50) + ((SELECT COUNT(*) FROM `professional`) * 100)) AS `total`";
      
    $sponsorIntake = "SELECT (SELECT DISTINCT CAST(SUM(Fee) AS unsigned) FROM `company`) AS `sponsor`";
    
    foreach($conn->query($studentIntake, PDO::FETCH_ASSOC) as $row){
		echo 'Total Intake: $' . $row['total'] . '<br>';
	}
    
    foreach($conn->query($sponsorIntake, PDO::FETCH_ASSOC) as $row){
		echo 'Sponsor Intake: $' . $row['sponsor'] . '<br>';
	}
    
}      

function listAttendees($conn){
        echo '<br>';
        echo "Students:";
        echo '<br>';

        echo "<table class='centerTable' border='1'>";

		echo "<tr>";
		echo "<th>First Name</th>";
		echo "<th>Last Name</th>";
		echo "</tr>";
    
        $sql = "SELECT `FirstName`, `LastName` FROM `student`";
		foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
			echo "<tr>";
			echo "<td>" . $row['FirstName'] . "</td>";
			echo "<td>" . $row['LastName'] . "</td>";
			echo"</tr>";
		}
		echo "</table>";
        
        echo '<br>';
        echo "Professionals:";
        echo '<br>';

        echo "<table class='centerTable' border='1'>";

		echo "<tr>";
		echo "<th>First Name</th>";
		echo "<th>Last Name</th>";
		echo "</tr>";
        
        $sql = "SELECT `FirstName`, `LastName` FROM `professional`";
        foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
		echo "<tr>";
		echo "<td>" . $row['FirstName'] . "</td>";
		echo "<td>" . $row['LastName'] . "</td>";
		echo "</tr>";
		}
		echo "</table>";
        
        echo '<br>';
        echo "Sponsors:";
        echo '<br>';

        echo "<table class='centerTable' border='1'>";

		echo "<tr>";
		echo "<th>First Name</th>";
		echo "<th>Last Name</th>";
		echo "</tr>";
        
        $sql = "SELECT `FirstName`, `LastName` FROM `sponsor`";
        foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
     		echo "<tr>";
			echo "<td>" . $row['FirstName'] . "</td>";
			echo "<td>" . $row['LastName'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
    }
    
    
function insertSponsor($conn, $firstName, $lastName, $sponsorID, $fee, $companyName) #Insert sponsor
	{
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
		$sql = "INSERT INTO CISC332.professional(Professional_ID,FirstName,LastName,Fee) 
		VALUES ('$professionalID','$firstName','$lastName','$fee')";
		$conn->exec($sql);
		echo "Inserted successfully";
    }
    
function insertStudent($conn, $studentID, $firstName, $lastName, $fee, $room) #Insert student
	{
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
    
    function listJobs($conn, $companyName)
    {
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
	$stmt = "SELECT FirstName, LastName, person_ID FROM subCommittee NATURAL JOIN person WHERE Member = Person_ID";

	echo "Here are all the members in the $subcommitteeName subcommittee:<br>";
	echo "<br>";

	echo "<table class='centerTable' border='1'>";

	echo "<tr>";
	echo "<th>Member ID</th>";
	echo "<th>First Name</th>";
	echo "<th>Last Name</th>";
	echo "</tr>";
	//foreach ($array as $memberId){
	foreach($conn->query($stmt, PDO::FETCH_ASSOC) as $row){
		echo "<tr>";
		echo "<td>" . $row['person_ID'] . "</td>";
		echo "<td>" . $row['FirstName'] . "</td>";
		echo "<td>" . $row['LastName'] . "</td>";
		echo "</tr>";
	}

	echo "</table>";

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


	echo "<table class='centerTable' border='1'>";
	echo "<tr>";
	echo "<th>Student ID</th>";
	echo "<th>First Name</th>";
	echo "<th>Last Name</th>";
	echo "</tr>";
	foreach($conn->query($stmt, PDO::FETCH_ASSOC) as $row){
		echo "<tr>";
		echo "<td>" . $row['Student_ID'] . "</td>";
		echo "<td>" . $row['FirstName'] . "</td>";
		echo "<td>" . $row['LastName'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
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

function insertSession($conn, $sessionID, $speaker, $roomNum, $startDate, $startTime, $endTime){
	
		$sql = "INSERT INTO CISC332.session(Session_ID, Speaker, Room_Number, Start_Date, Start_Time, End_Time) 
		VALUES ('$sessionID', '$speaker', '$roomNum', '$startDate', '$startTime', '$endTime')";
		try{
		$conn->exec($sql);
		echo "Inserted successfully";
		}
		catch (PDOException $e){
			if ($e->errorInfo[1] == 1062){
				echo "<p class='ErrorText'>Error, that session already exists</p>";
			}
		}
    }

function addSession($conn) {
     ?>
     <div class="content">
      <form id="sessionForm" action="firstphp.php" method ="post">
      <p>SessionID:</p>
      <input type="text" name="sessionID">
      <p>Speaker:</p>
      <input type="text" name="speaker">
      <p>RoomNumber:</p>
      <input type="text" name="roomNum">
      <p>StartDate:</p>
      <input type="text" name="startDate">
      <p>StartTime:</p>
      <input type="text" name="startTime">
      <p>endTime:</p>
      <input type="text" name="endTime">
      <input type="hidden" name="formName" value="sessionInsert">
      <br>
      <input type="submit">
      </form> 
  </div>
  <?php
 }

 function deleteSession($conn) {
	
    
    $sql = "SELECT `Session_ID`, `Start_Date`, `Start_Time`, `End_Time` FROM  `session`";
		foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
			echo 'Session_ID: ' . $row['Session_ID'] . ' ';
			echo 'Start_Date: ' . $row['Start_Date'] . ' ';
            echo 'Start_Time: ' . $row['Start_Time'] . ' ';
            echo 'End_Time: ' . $row['End_Time'] . '<br>';
		}
    
    $stmt = $conn->prepare("SELECT `Session_ID` FROM  `session`");

	$stmt->execute();

	$array = $stmt->fetchAll(PDO::FETCH_COLUMN);

	$arrayRemovedDupes = array_unique($array);


	echo "<br>Here is a drop down of all the sessions currently in use:<br>";
	?> 
	<form id="sessionsForm" action="firstphp.php" method="post">
	<select name="sessionChosen">
	<?php
	foreach ($arrayRemovedDupes as $session){
		?>
		<option value="<?php echo $session; ?>"><?php echo $session; ?></option>
		<?php

	}
	?>

	</select>
	<input type="hidden" name="formName" value="deleteSessionForm">
  	<input type="submit" name="SubmitButton" value="Select session"/>
	</form>
	<?php 
    }

function deleteSessionDate($date, $conn){

	$sql = "DELETE FROM CISC332.session WHERE Session_ID = '$date'";
		$conn->exec($sql);
		echo "Delete successfully";
	
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
</div>
</body>
</html> 

