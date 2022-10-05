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

  width: 400px;
  height: 300px; 
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
		
		<label for="email">Email address</label>
		<input type="text" class = "mail"  id="email" name="email" placeholder="Email address..." <br> </br>

		<label for="password">Password</label>
		<input type="password" class = "pass"  id="password" name="password" placeholder="Password..." <br> </br>

		<label for="repPassword">Repeat Password</label>
		<input type="password" class = "repass"  id="repPassword" name="repPassword" placeholder="Repeat password..." <br> </br>
	

  
	<input type="submit" name="Submit">
  </form>
</div>



<?php
#gets the global functions
include("globalFunctions.php");

#this function validates the password
function validatePassword($password)
{
	$lowerCase = false;
	$upperCase = false;
	$number = false;
	$special = false;
		
	for ($i = 0; $i < strlen($password); $i++)
	{
		if (ctype_lower($password[$i]))
		{
			$lowerCase = true;
		}
		
		else if (ctype_upper($password[$i]))
		{
			$upperCase = true;
		}	
		
		else if (ctype_digit($password[$i]))
		{
			$number = true;
		}
		
		else if ($password[$i] == "!" or $password[$i] == "£" or $password[$i] == "$" or $password[$i] == "%" or $password[$i] == "^" or $password[$i] == "&" or $password[$i] == "*" or $password[$i] == "(" or $password[$i] == ")" or $password[$i] == "{" or $password[$i] == "}" or $password[$i] == "[" or $password[$i] == "]" or $password[$i] == "#" or $password[$i] == "~" or $password[$i] == ":" or $password[$i] == ";" or $password[$i] == "@" or $password[$i] == "<" or $password[$i] == "," or $password[$i] == ">" or $password[$i] == "." or $password[$i] == "?" or $password[$i] == "|" or $password[$i] == chr(34) or $password[$i] == chr(92) or $password[$i] == chr(39) or $password[$i] == chr(47) or $password[$i] == "=" or $password[$i] == "+" or $password[$i] == "_" or $password[$i] == "-" or $password[$i] == "+")
		{
			$special = true;	
		}
	}
	
	
	if($lowerCase == true and $upperCase == true and $number == true and $special == true)
	{
		$valid = true;
	}
		
	else
	{
		$valid = false;
	}
	
	return $valid;
}


#this function validates the email
function validateEmail($email)
{
	#at is an integeger while . is a boolean because a valid email can contain more then one . but has to have at least . but can only have one @
	$at = 0;
	$dot = false;
	$atPos = 0;
	$dotpos = 0;
	$space = false;
	
	
	
	#check if the email contains @ and . and gets there position
	for ($i = 0; $i < strlen($email); $i++)
	{
		if ($email[$i] == "@")
		{
			$at = $at + 1;
			$atPos = $i;
		}
		
		else if ($email[$i] == ".")
		{
			$dot = true;
			$dotPos = $i;
		}
		
		else if ($email[$i] == " ")
		{
			$space = true;
		}
	}	
	
	if ($at == 1 and $dot == true and $space == false)
	{
		#compares the position of the @ and . because for example bobgmail.@com is not a valid email as the final dot must be after the @
		if ($atPos < $dotPos)
		{
			$valid = true;
		}
		
		else
		{
			$valid = false;
		}
	}
	
	else
	{
		$valid = false;
	}
	
	return $valid;
}


#checks if the submit button has been pressed and when it has it activates the code inside
if(isset($_POST['Submit']))
{
	#gets data from input fields
	$username = $_POST["username"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$repPassword = $_POST["repPassword"];
	
	#validate data
	if($password != $repPassword)
	{
		echo('<script>alert("password does not equal repeated password");</script>');
	}
		
	else if (strlen($password) < 8)
	{
		echo('<script>alert("password is not long enough");</script>');
	}
	
	else
	{
		$validPassword = validatePassword($password);
		
		if ($validPassword == false)
		{
			echo('<script>alert("invalid password");</script>');
		}
		
		else
		{
			$validEmail = validateEmail($email);
			
			if ($validEmail == false)
			{
				echo('<script>alert("invalid email");</script>');
			}
			
			else
			{
				#the encrypting data is done in a different file to make it more secure as this way you can't reverse engineer by looking at the encryption program 
				$word = $username;
				$encryptedUsername = include("encrypt.php");
				
				$taken = findDataPosition($encryptedUsername, "users.txt");
				if ($taken == false)
				{
					$word = $email;
					$encryptedEmail = include("encrypt.php");
					$word = $password;
					$encryptedPassword = include("encrypt.php");
					
					$wordToSave = ($encryptedUsername . ", " . $encryptedEmail . ", " . $encryptedPassword . "\n");
					store($wordToSave, "users.txt", "a");
				
					echo("<script> alert('You have succesfully been registered'); window.location.href='/Uchitsya/index.php'; </script>");
				}
				
				else
				{
					echo('<script>alert("that username has been taken");</script>');
				}
			}
		}
	}	
}
?>

</body>
</html>


