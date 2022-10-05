<html>
<head>

<!create classes for the program>
<style>
.button
{
  border: none;
  color: black;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  background-color: #ffff00;
}

.button:hover
{
	background-color: #9b870c;	
}
.button1
{  
  margin: 0;
  position: absolute;
  top: 30%;
  -ms-transform: translateX(150%);
  transform: translateX(150%);
}

.button2
{  
  margin: 0;
  position: absolute;
  top: 30%;
  -ms-transform: translateX(450%);
  transform: translateX(450%);
}




</style>

</head>
<body>

<!creates buttons and redirects to pages on click> 
<button onclick="join()" class="button button1" > Join Classroom</button>
<button onclick="make()" class="button button2">Make Classroom</button>

<script>
function join()
{
  location.href = "/Uchitsya/joinClassroom.php";
}
</script>

<script>
function make()
{
  location.href = "/Uchitsya/makeClassroom.php";
}

function classroom(classroom)
{
	location.href = classroom;
}

</script>

<?php

#gets the global functions
include("globalFunctions.php");

#this function gets the classroom codes for the user
function getCodes($usernamePosition)
{
	#gets the line with the users information
	$lines = file("users.txt");
	$userLine = $lines[$usernamePosition];
	
	#removes the username, password and email leaving only the classroom codes remaining
	$codes = substr($userLine, 102);
	
	return $codes;
}

#converts string to array
function convertToArray($word)
{
	$word = substr($word, 0, -1);
	$wordCalculator = strlen($word);
	
	
	#calculates how much classroom codes there are
	$amountToExplode = 0;
	
	while ($wordCalculator > 0)
	{
		$wordCalculator = $wordCalculator - 32;
		$amountToExplode = $amountToExplode + 1;
		$wordCalculator = $wordCalculator - 2;
	}
	
	$classroomArray = explode(', ', $word, $amountToExplode);
	
	return $classroomArray;
}

#this function gets the classroom name for the associated classroom code 
function getClassroom($codePosition)
{
	$text_file = "classroom.txt";
	$f = file($text_file);
	$classroomLine = explode(', ', $f[$codePosition], 2);
	
	#removes the classroom codes leaving only the password remaining
	$classroomName = $classroomLine[1];
	
	return $classroomName;
}

#gets the username position
$usernamePosition = read("C:\Users\User\AppData\Local\Microsoft\Windows\INetCookies\uchitsya.cookie");


#this is to stop people gaining unauthorised access
if ($usernamePosition == "")
{
	echo("<script> alert('You are not logged in please log in'); window.location.href='/Uchitsya/login.php'; </script>");
}

$codes = getCodes($usernamePosition);


$codeArray = convertToArray($codes);

#checks if there are any classrooms added
if ($codeArray[0] != "")
{
	#displays the classroom codes;
	for ($i = 0; $i < count($codeArray); $i++)
	{
		$stringI = (string) $i;
		$display = "classroom" . $stringI;
		#gets the name of the classroom and the file for the classroom
		$codePosition = findDataPosition($codeArray[$i], "classroom.txt");
		$codePosition = $codePosition - 1;
		$classroomName = getClassroom($codePosition);
		$classroomServer = ("/Uchitsya/" . $codeArray[$i] . ".php");
		
		#calculates the amount needed to translate the button by
		$translate = $i * 200;
		$translateString = (string)$translate;
		$displayTranslateString = $translateString . "%";
		
		#creates the class for the button
		echo(" <style> .$display
			{
			  border: none;
			  color: black;
			  padding: 30px 30px;
			  border-radius: 200%;
			  text-align: center;
			  text-decoration: none;
			  display: inline-block;
			  font-size: 16px;
			  margin: 4px 2px;
			  cursor: pointer;
			  background-color: #008CBA;
			  margin: 0;
			  position: absolute;
			  top: 50%;
			  -ms-transform: translateX($displayTranslateString);
			  transform: translateX($displayTranslateString);
			}
			
			.$display:hover
			{
				background-color: #45a049;	
			}
			</style> ");
		
		#displays the button
		echo ("<button onclick=classroom('$classroomServer') class='$display'>$classroomName</button>");
	}
}
?>
</body>
</html>