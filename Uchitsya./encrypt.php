<?php

#creates a hash for the word
#declare Hash as variable instead of hash to distinguish between the function hash in php
#this hash algorithm  should be uncrackable as  when trying to reverse engineer a hash there are multiple solutions 
$Hash = "ri8YkqlsXfIm7IWg92PTBY8oWynSpl7p"; 
for ($i=0; $i < strlen($word) - 3; $i = $i+4)
{	
	$t = 0;
	for ($i=0; $i < strlen($Hash); $i = $i+4)
	{
		$Hash[$i] = chr(ord($word[$t]) + ord($Hash[$i]) - 106);	

		$t ++;
		if ($t >= strlen($word))
		{
			$t = 0;
		}
	}
}

$encryptedWord = "";
		
		
$t = 0;

#creates a salt for the hashed password
#this makes it more secure by preventing hackers using something like a rainbow table
#this also separates hashes so no to hashes can be the same
for ($i = 0; $i < strlen($Hash); $i++)
{
	
	
	$encryptedValue = ord($Hash[$i]) + ord($word[$t]);
	
	#the loop keeps going until the character becomes either a number or letter
	while(($encryptedValue > 123) or ($encryptedValue < 33) or ((($encryptedValue > 57) and ($encryptedValue < 65))) or (($encryptedValue > 90) and ($encryptedValue <97)))
	{
		
		if (($encryptedValue > 57) and ($encryptedValue < 65))
		{
			$encryptedValue = $encryptedValue - 10;
		}
		
		else if (($encryptedValue > 90) and ($encryptedValue <97))
		{
			$encryptedValue = $encryptedValue + 6;
		}
		
		else if ($encryptedValue > 123)
		{
			#this is set to 75 so that it only outputs numbers and letters
			$encryptedValue = $encryptedValue - 75;	
			
		}
		else if ($encryptedValue < 33)
		{
			#the value 89 is used so that it only outputs numbers and letters
			$encryptedValue = $encryptedValue + 89;
		}
		
	}
	
	$encryptedWord[$i] = chr($encryptedValue);	
	$t ++;
	if ($t >= strlen($word))
	{
		$t = 0;
	}

}

return $encryptedWord;
	


?>