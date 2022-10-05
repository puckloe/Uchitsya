<html>

<style>
input[type=text]{
  width: 50%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 30%;
  background-color: #008CBA;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin: 0;
  position: absolute;
  top: 80%;
  -ms-transform: translateX(80%);
  transform: translateX(80%);
}

.user
{
  -ms-transform: translateX(41%);
  transform: translateX(41%);
}

.mail
{
  -ms-transform: translateX(29%);
  transform: translateX(29%);
  
}

.pass

{
  -ms-transform: translateX(43%);
  transform: translateX(43%);
}

.repass
{
  -ms-transform: translateX(20%);
  transform: translateX(20%);
}

input[type=submit]:hover 
{
  background-color: #45a049;
}

.backround {

  width: 300px;
  height: 200px; 
  background-color: #f2f2f2;
  padding: 54px;
}

.centre
{
  margin: 0;
  position: absolute;
  top: 20%;
  -ms-transform: translateX(102%);
  transform: translateX(102%);
}
</style>
<body>

<div>
  <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
  
	<div class="centre backround">
	
		<label for="classroomName">classroom name</label>
		<input type="text" class = "classroomName" id="classroomName" name="classroomName" placeholder="Classroom Name..." <br> </br>
		

	

  
	<input type="submit" name="Submit">
  </form>
</div>


<?php
#gets the global functions
include("globalFunctions.php");

#this function generates a random code for the classroom
#this is done slightly different to the psudecode as there is no random character generate function in php 
function codeGenerate()
{
    $classroomCode = "";
	$characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    for ($i = 0; $i < 6; $i++)
    {
		$index = rand(0, strlen($characters) - 1);
		$classroomCode[$i] = $characters[$index];
    }	 
	
	return $classroomCode;
}

#gets the username position
$usernamePositionString = read("C:\Users\User\AppData\Local\Microsoft\Windows\INetCookies\uchitsya.cookie");
$usernamePosition = (int)$usernamePositionString;

#this is to stop people gaining unauthorised access
if ($usernamePositionString == "")
{
	echo("<script> alert('You are not logged in please log in'); window.location.href='/Uchitsya/login.php'; </script>");
}

if(isset($_POST['Submit']))
{
	
	#gets data from input fields
	$classroomName = $_POST["classroomName"];
	
	
	
	#validates the data
	if (strlen($classroomName) < 2)
	{
		echo('<script>alert("Not valid classroom name, classrooms should be at least two characters long");</script>');
	}
	
	else
	{
		$classroomCode = codeGenerate();
		$word = $classroomCode;
		$encryptedCode = include ("encrypt.php");
		$fileLine = changeLine($usernamePosition, $encryptedCode);
		appendUser($fileLine);
		$wordToSave = ($encryptedCode . ", " . $classroomName . "\n");
		store($wordToSave, "classroom.txt", "a");
		
		#generates the classroom server page and files
		$serverToCopy = file_get_contents("classroomTemplate.php");
		$classroomFile = ($encryptedCode . ".php");
		store($serverToCopy, $classroomFile, "w");
		mkdir($encryptedCode);
		
		#all 3 files are written two decipte two been blank
		#this is so when the classroom is exccecuted it does not give errors
		#as you can't read a file that does not exist
		$uploadNumberFile = $encryptedCode . "/file upload number.txt";
		$classroomLogFile = $encryptedCode . "/classroom log.txt";
		$fileUploadsFile = $encryptedCode . "/file uploads.txt";
		store("0", $uploadNumberFile, "w");
		store("", $classroomLogFile, "a");
		store("", $fileUploadsFile, "a");
		
		#move the file image to the new folder made
		$targetFilePath = $encryptedCode . "/file.png"; 
		copy("classroomTemplate/file.png", $targetFilePath);
		
		echo("<script>alert('classroom has been successfully added. This classroom\'s code is: ' + '$classroomCode'); window.location.href='/Uchitsya/menu.php';</script>");
	}
}
?>
</body>
</html>