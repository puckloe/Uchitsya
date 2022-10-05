<html>
<style>
input[type=text], input[type=password] {
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
  top: 60%;
  -ms-transform: translateX(80%);
  transform: translateX(80%);
}

.user
{
  -ms-transform: translateX(41%);
  transform: translateX(41%);
}


.pass

{
  -ms-transform: translateX(43%);
  transform: translateX(43%);
}


input[type=submit]:hover 
{
  background-color: #45a049;
}

.backround {

  width: 360px;
  height: 210px; 
  background-color: #f2f2f2;
  padding: 20px;
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
	
		<label for="username">Username</label>
		<input type="text" class = "user" id="username" name="username" placeholder="Username..." <br> </br>
		
		<label for="password">Password</label>
		<input type="password" class = "pass"  id="password" name="password" placeholder="Password..." <br> </br>

	

  
	<input type="submit" name="Submit">
  </form>
</div>

<?php
#gets the global functions
include("globalFunctions.php");


#this functions gets the password stored in the text file
function getPassword($usernamePosition)
{
	$text_file = "users.txt";
	$f = file($text_file);
	$passwordCompare = explode(', ', $f[$usernamePosition], 3);
	
	#removes the classroom codes leaving only the password remaining
	$passwordSend = $passwordCompare[2];
	$dataToRemove = strlen($passwordSend) - 32;
	$passwordSend = substr($passwordSend, 0, -$dataToRemove);
	
	return $passwordSend;
}	

#checks if the submit button has been pressed and when it has it activates the code inside
if(isset($_POST['Submit']))
{
	#gets data from input fields
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	#encrypts the username and checks to see if it is the same username as in the text file
	$word = $username;
	$encryptedUsername = include("encrypt.php");
	
	$usernamePosition = findDataPosition($encryptedUsername, "users.txt");
	if ($usernamePosition == false)
	{
		echo('<script>alert("this username does not exist");</script>');
	}
	
	else
	{
		#if password exists then it does the same for the password to check it is correct as well
		$word = $password;
		$encryptedPassword = include("encrypt.php");
		
		$userPassword = getPassword(($usernamePosition - 1));
		
		if ($encryptedPassword == $userPassword)
		{
			$usernamePositionStored = $usernamePosition - 1;
			store($usernamePositionStored, "C:\Users\User\AppData\Local\Microsoft\Windows\INetCookies\uchitsya.cookie", "w");
			store($username, "C:\Users\User\AppData\Local\Microsoft\Windows\INetCookies\uchitsyaTwo.cookie", "w");
			header("Location: /Uchitsya/menu.php");
		}
		
		else
		{
			echo('<script>alert("incorrect password");</script>');
		}
	}	
}
?>

</body>
</html>


