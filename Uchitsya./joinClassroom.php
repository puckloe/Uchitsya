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
	
		<label for="classroomCode">classroom code</label>
		<input type="text" class = "classroomCode" id="classroomCode" name="classroomCode" placeholder="Classroom Code..." <br> </br>
		

	

  
	<input type="submit" name="Submit">
  </form>
</div>

<?php
#gets the global functions
include("globalFunctions.php");

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
	$classroomCode = $_POST["classroomCode"];
	
	#encrypts the classrooom code
	$word = $classroomCode;
	$encryptedCode = include("encrypt.php");
	

	
	$classroomPosition = findDataPosition($encryptedCode, "classroom.txt");
	
	if ($classroomPosition == false)
	{
		echo('<script>alert("this classroom does not exist");</script>');
	}
	
	else
	{

		$fileLine = changeLine($usernamePosition, $encryptedCode);
		appendUser($fileLine);
		echo('<script>alert("classroom has successfully been added"); window.location.href="/Uchitsya/menu.php";</script>');
	}
}
?>

</body>
</html>