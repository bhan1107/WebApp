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
	echo "<br>";

    if($action == "add" && $formName == "sponsorInsert"){
    	echo "<br>";
    	$firstName = $_POST["firstname"];                      
		$lastName = $_POST["lastname"];
		$sponsorID = $_POST["sponsorID"];
		$fee = $_POST["sponsorFee"];                      
		$companyName = $_POST["companyName"];
    	insertSponsor($conn,$firstName, $lastName, $sponsorID, $fee, $companyName);
	}

	else if($formName == "sponsorInsert" && $action == "list"){
    	listSponsor($conn);
	}
	
    else if($formName == "professionalInsert"){
    	echo "<br>";
        $professionalID = $_POST["professionalID"];
    	$firstName = $_POST["firstname"];                      
		$lastName = $_POST["lastname"];
		$fee = $_POST["professionalFee"];                      
    	insertProfesional($conn, $professionalID, $firstName, $lastName, $fee);
	}
    
    else if($formName == "studentInsert"){
    	echo "<br>";
        $studentID = $_POST["studentID"];
    	$firstName = $_POST["firstname"];                      
		$lastName = $_POST["lastname"];
		$fee = $_POST["studentFee"]; 
        $room = $_POST["roomNumber"];  
    	insertStudent($conn, $studentID, $firstName, $lastName, $fee, $room);
	}
    
   
    else if($formName == "viewCompany" && $action == "delete"){
    	echo "<br>";     
    	deleteCompany($conn);
	}
    
    else if($formName == "viewCompany" && $action == "add"){
    	echo "<br>";            
    	addCompany($conn);
	}
    
    else if($formName == "companyInsert"){
    	echo "<br>";
        $Name = $_POST["Name"];
    	$Fee = $_POST["Fee"];                      
		$Tier = $_POST["Tier"];
		$Email_Num = $_POST["Email_Num"]; 
        $Email_Sent = $_POST["Email_Sent"];        
    	insertCompany($conn, $Name, $Fee, $Teir, $Email_Num, $Email_Sent);
	}
    
    else if ($formName == "deleteCompanyForm"){
    	echo "<br>";
    	$selected_Name = $_POST['companyChoose'];
    	deleteSelectedCompany($selected_Name, $conn);
	}
    
    
	else if ($formName == "viewSubCommittees"){
		echo "<br>";
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
		echo "<br>";
		showHotelRooms($conn);
	}
	else if ($formName == "studentsInRoomForm"){
		echo "<br>";
    	$selected_room = $_POST['roomNumChosen'];
    	showStudentsInRoom($selected_room, $conn);
	}
    else if ($formName == "viewSession" && $action == "schedule"){
    	echo "<br>";
		showSession($conn);
	}
    else if ($formName == "sessionDateForm"){
		echo "<br>";
    	$selected_date = $_POST['dateChosen'];
    	showSessionDate($selected_date, $conn);
	}
    
    else if($formName == "viewSession" && $action == "delete"){
    	echo "<br>";        
    	deleteSession($conn);
	}
    
    else if($formName == "viewSession" && $action == "add"){
    	echo "<br>";             
    	addSession($conn);
	}
    
     else if($formName == "sessionInsert"){
    	echo "<br>";
        $sessionID = $_POST["sessionID"];
    	$speaker = $_POST["speaker"];                      
		$roomNum = $_POST["roomNum"];
		$startDate = $_POST["startDate"]; 
        $startTime = $_POST["startTime"]; 
        $endTime = $_POST["endTime"];         
    	insertSession($conn, $sessionID, $speaker, $roomNum, $startDate, $startTime, $endTime);
	}
    
     else if($formName == "sessionModify"){
    	echo "<br>";
        $sessionID = $_POST["sessionID"];    
		$roomNum = $_POST["roomNum"];
		$startDate = $_POST["startDate"]; 
        $startTime = $_POST["startTime"]; 
        $endTime = $_POST["endTime"];         
    	modifySelectedSession($conn, $sessionID, $roomNum, $startDate, $startTime, $endTime);
	}
    
    
    else if ($formName == "deleteSessionForm"){
		echo "<br>";
    	$selected_ID = $_POST['sessionChosen'];
    	deleteSessionDate($selected_ID, $conn);
	}
    
    else if($formName == "viewSession" && $action == "modify"){
    	echo "<br>";           
    	modifySession($conn);
	}
    
    
    else if ($formName == "viewAttendee"){
    	echo "<br>";
		listAttendees($conn);
	}
    else if ($formName == "viewTotalIntake"){
    	echo "<br>";
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
		echo 'Student and Professional Intake: $' . $row['total'] . '<br>';
	}
    $intake = $row['total'];
    foreach($conn->query($sponsorIntake, PDO::FETCH_ASSOC) as $row){
		echo 'Sponsor Intake: $' . $row['sponsor'] . '<br>';
	}
    echo "Total Intake :" . ((int)$intake + (int)$row['sponsor']);
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
		echo "<table class='centerTable' border='1'>";

		echo "<tr>";
		echo "<th>Company</th>";
		echo "<th>Sponsorship Level</th>";
		echo "</tr>";
    
		$sql = "SELECT `Name`, `Tier` FROM `company`";
		foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
     		echo "<tr>";
			echo "<td>" . $row['Name'] . "</td>";
			echo "<td>" . $row['Tier'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
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
			$sql = "SELECT `Company_Name`, `Title`, `City`, `Province`, `Payrate`, `Posted_Date` FROM `job`";
		}
		else{
			$sql = "SELECT `Company_Name`, `Title`, `City`, `Province`, `Payrate`, `Posted_Date` FROM `job` WHERE `Company_Name` = '$companyName'";
		}
		
 		echo "<table class='centerTable' border='1'>";

		echo "<tr>";
		echo "<th>Company</th>";
		echo "<th>Title</th>";
		echo "<th>Payrate</th>";
		echo "<th>City</th>";
		echo "<th>Province</th>";
		echo "<th>Posted Date</th>";
		echo "</tr>";
		foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
     		echo "<tr>";
			echo "<td>" . $row['Company_Name'] . "</td>";
			echo "<td>" . $row['Title'] . "</td>";
			echo "<td>" . $row['City'] . "</td>";
			echo "<td>" . $row['Province'] . "</td>";
			echo "<td>" . $row['Payrate'] . "</td>";
			echo "<td>" . $row['Posted_Date'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
    }


function showSubMembers($subcommitteeName, $conn){
	$stmt = "SELECT FirstName, LastName, person_ID FROM subCommittee NATURAL JOIN person WHERE Member = Person_ID and subCommittee.Name = '$subcommitteeName'";

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
    
function modifySelectedSession($conn, $sessionID, $roomNum, $startDate, $startTime, $endTime){
        
		$sql = "UPDATE `session` SET `Room_Number`='$roomNum',`Start_Date`= '$startDate',`Start_Time`= '$startTime',`End_Time`='$endTime' WHERE `Session_ID`='$sessionID'";

		try{
		$conn->exec($sql);
		echo "modified successfully";
		}
		catch (PDOException $e){
			if ($e->errorInfo[1] == 1062){
				echo "<p class='ErrorText'>Error, cannot modify</p>";
			}
		}
}
    
    
function modifySession($conn) {
    
	echo "<table class='centerTable' border='1'>";
	echo "<tr>";
	echo "<th>Session ID</th>";
	echo "<th>Room Number</th>";
	echo "<th>Start Date</th>";
	echo "<th>Start Time</th>";
	echo "<th>End Time</th>";
	echo "</tr>";

    $sql = "SELECT `Session_ID`, `Room_Number`, `Start_Date`, `Start_Time`, `End_Time` FROM  `session`";
		foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
		echo "<tr>";
		echo "<td>" . $row['Session_ID'] . "</td>";
		echo "<td>" . $row['Room_Number'] . "</td>";
		echo "<td>" . $row['Start_Date'] . "</td>";
		echo "<td>" . $row['Start_Time'] . "</td>";
		echo "<td>" . $row['End_Time'] . "</td>";
		echo "</tr>";
		}
	echo "</table>";
    
     ?>
     <div class="content">
      <form id="sessionForm" action="firstphp.php" method ="post">
      <p>SessionID:</p>
      <input type="text" name="sessionID">
      <p>RoomNumber:</p>
      <input type="text" name="roomNum">
      <p>StartDate:</p>
      <input type="text" name="startDate">
      <p>StartTime:</p>
      <input type="text" name="startTime">
      <p>endTime:</p>
      <input type="text" name="endTime">
      <input type="hidden" name="formName" value="sessionModify">
      <br>
      <input type="submit">
      </form> 
  </div>
  <?php
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

	echo "<table class='centerTable' border='1'>";
	echo "<tr>";
	echo "<th>Session ID</th>";
	echo "<th>Room Number</th>";
	echo "<th>Start Date</th>";
	echo "<th>Start Time</th>";
	echo "<th>End Time</th>";
	echo "</tr>";

    $sql = "SELECT `Session_ID`, `Room_Number`, `Start_Date`, `Start_Time`, `End_Time` FROM  `session`";
		foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row){
		echo "<tr>";
		echo "<td>" . $row['Session_ID'] . "</td>";
		echo "<td>" . $row['Room_Number'] . "</td>";
		echo "<td>" . $row['Start_Date'] . "</td>";
		echo "<td>" . $row['Start_Time'] . "</td>";
		echo "<td>" . $row['End_Time'] . "</td>";
		echo "</tr>";
		}
	echo "</table>";

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

	echo "<table class='centerTable' border='1'>";
	echo "<tr>";
	echo "<th>Session ID</th>";
	echo "<th>Room Number</th>";
	echo "<th>Speaker</th>";
	echo "<th>Start Date</th>";
	echo "<th>Start Time</th>";
	echo "<th>End Time</th>";
	echo "</tr>";

	$stmt = "SELECT `Session_ID`, `Room_Number`, `Speaker`, `Room_Number`, `Start_Date`, `Start_Time`, `End_Time`  FROM `session` WHERE `Start_Date` = '$date'";

	foreach($conn->query($stmt, PDO::FETCH_ASSOC) as $row){
		echo "<td>" . $row['Session_ID'] . "</td>";
		echo "<td>" . $row['Room_Number'] . "</td>";
		echo "<td>" . $row['Speaker'] . "</td>";
		echo "<td>" . $row['Start_Date'] . "</td>";
		echo "<td>" . $row['Start_Time'] . "</td>";
		echo "<td>" . $row['End_Time'] . "</td>";
		}
	echo "</table>";
	
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