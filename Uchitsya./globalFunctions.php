<?php
#gets the position of the data required in the file
#it does this by searching for the primary key in the file to find the data
function findDataPosition($word, $text_file)
{
	
	$dataPosition = 0;
	$taken = false;
	$f = file($text_file);
	for ($i = 0; $i <= count($f) - 1; $i++)
	{
		$wordCompare = explode(', ', $f[$i], 3);
		
		#compares to see if the primary key matches
		if ($word == $wordCompare[0])
		{
			$taken = true;
			$dataPosition = $i;
		}
	}
	
	if ($taken == true)
	{
		#this is done because false registers as 0 and so if 0 is registered then it later gets registered as false
		$dataPosition = $dataPosition + 1;
		return $dataPosition;
	}
	
	else
	{
		return $taken;
	}
}	

#this function reads the user file, stores the data in to an array and changes the line where the classroom is added 
function changeLine($usernamePosition, $encryptedCode)
{
	$f = fopen("users.txt", "r");
	$fileLine = array();
	$x = 0;
	#reads the file line by line until the end of the file
	while(!feof($f))
	{
		#checks if the line is the line that needs to be changed
		if ($x == $usernamePosition)
		{
			$line = fgets($f);
			$newLine = (substr($line, 0, -1) . ", " . $encryptedCode . "\n");
			array_push($fileLine, $newLine);
		}
		
		else
		{
			$line = fgets($f);
			array_push($fileLine, $line);
		}
		
		$x = $x + 1;
	}
	return $fileLine;
}

#this function adds the new edited data into the txt file
function appendUser($fileLine)
{
	#opens the file to be written to
	$f = fopen("users.txt", "w");
	#writes each line to the text file
	for ($i = 0; $i < count($fileLine); $i++)
	{
		fwrite($f, $fileLine[$i]);
	}
	fclose($f);
}

//this procedure stores data to text file
function store($word, $file, $appendOrWrite)
	{
		$f = fopen($file, $appendOrWrite);
		fwrite($f, $word);
		fclose($f);
	}


//this function reads data from text file
function read($file)
{
	$f = fopen($file, "r");
	$data = fgets($f);
	return $data;
	
}	


?>