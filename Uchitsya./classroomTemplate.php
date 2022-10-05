<html>
<style>
input[type=text] {
  width: 50%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  position: absolute;
  top: 90%;
}

input[type=file] {
	position: absolute;
    top: 93%;
	-ms-transform: translateX(255%);
    transform: translateX(255%);
}

input[type=submit] {
	position: absolute;
    top: 93%;
	-ms-transform: translateX(1800%);
    transform: translateX(1800%);
}
</style>

<body>

<div>
    <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
	  <input type="text" id="Text" name="Text" placeholder="Send a message..." >
      <input type="file" id="myFile" name="filename" value="Upload file">
      <input type="submit" name="Submit" value ="Send">
    </form>
</div>


<?php

#gets the global functions
include("globalFunctions.php");

#this is to stop people gaining unauthorised access
$username = read("C:\Users\User\AppData\Local\Microsoft\Windows\INetCookies\uchitsyaTwo.cookie");

#this is to stop people gaining unauthorised access
if ($username == "")
{
	echo("<script> alert('You are not logged in please log in'); window.location.href='/Uchitsya/login.php'; </script>");
}

#get the name of the classroom server
$fileDirectory = $_SERVER['PHP_SELF'];
$classroomFileName = substr($fileDirectory, 10);
$classroomName = substr($classroomFileName, 0, -4);

$classroomLog = $classroomName . "/classroom log.txt";
$fileUploadNumber = $classroomName . "/file upload number.txt";
$fileUploads = $classroomName . "/file uploads.txt";
$imageFile = $classroomName . "/file.png";
	
#this function displays the classroom log line by line
function display($file, $fileUploads, $classroomName, $imageFile)
{
	$f = fopen($file, "r");
	#keeps looping until it has read each line in the file
	while(!feof($f))
	{
		$fileLine = fgets($f); 
		$fileCheck = substr($fileLine, -96);
		
		#if the message was a file
		if ($fileCheck == "747rhf87ncrncu13r7838u830b10ubvurbn18u3ehnv8neuf1uhnq813hvnuu0nuunenufhunhncununnunduenudnuenwc\n")
		{
			$user = substr($fileLine, 0, -100);
			
			$removedUser = substr($fileLine, -100);
			$stringFileKey = substr($removedUser, 0, 2);
			$fileKey = (int) $stringFileKey;
			
			$uploadFileLog = file($fileUploads);
			$fileUploaded = $uploadFileLog[$fileKey];
			#echo($fileUploaded);
			$fileUploadedWithDirectory = $classroomName ."/" . $uploadFileLog[$fileKey];
			
			echo("<Br>");
			echo("<Br>");
			echo($user);
			
			echo("<a href='$fileUploadedWithDirectory' download>
					<img src='$imageFile' alt='fileDownload' width='50' height='30'>
				</a>");
		}
		
		#if the message was text
		else
		{
			echo("<Br>");
			echo("<Br>");
			echo($fileLine);
		}
	}
}	
	
	
#start of main program	
display($classroomLog, $fileUploads, $classroomName, $imageFile);

#checks if the submit button has been pressed and when it has it activates the code inside
if(isset($_POST['Submit']))
{
	#gets the data
	$file = $_FILES["filename"];
	$message = $_POST["Text"];	

	
	if (($file["name"] == "") and ($message == ""))
	{
		echo('<script>alert("you have not sent a message or uploaded a file");</script>');
	}
	
	#these are both if statments as both of them can be true at the same time
	if ($message != "")
	{
		$messageSend = $username . ": " . $message . "\n";
		store($messageSend, $classroomLog, "a");
	
		#displays the sent message
		echo($messageSend);
		echo("<Br>");
		echo("<Br>");
	}
	
	if ($file["name"] != "")
	{
		#use a random string for file sotring making it extremly unlikley that anyone will be able to type this by accident
		$fileString = "747rhf87ncrncu13r7838u830b10ubvurbn18u3ehnv8neuf1uhnq813hvnuu0nuunenufhunhncununnunduenudnuenwc";
		
		#it is necessary to get the number of files on the server so it can be used in the database as an ID for each file uploaded
		#this is done because for example if someone uploads a file the same name as the other then it will confuse the program
		$filesOnServer = read($fileUploadNumber);
		
		#stores the file on the server
		$targetFilePath = $classroomName . "/" . $file["name"]; 
		move_uploaded_file($file["tmp_name"], $targetFilePath);
		
		#makes sure the log knows a file has been uploaded
		$messageSend =  $username . ": " . $filesOnServer . ": " . $fileString . "\n";
		store($messageSend, $classroomLog, "a");
		
		#stores the list of all the files that have been uploaded
		$fileStore = ($file["name"] . "\n");
		store($fileStore, $fileUploads, "a");
		
		#gets the new number of files on the server
		$intFilesOnServer = (int) $filesOnServer;
		$intNewFilesOnServer = $intFilesOnServer + 1;
		$newFilesOnServer = (string) $intNewFilesOnServer;
		store($newFilesOnServer, $fileUploadNumber, "w");
		
		#displays the sent message
		
		echo($username . ": ");
		echo("<a href='$targetFilePath' download>
					<img src='$imageFile' alt='fileDownload' width='50' height='30'>
				</a>");
		echo("<Br");
		echo("<Br");
	}
}
?>
</body>
</html>