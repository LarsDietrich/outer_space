<?php
	// assume nothing is suspect
	$suspect = false;
	// Create a pattern to locate suspect phrases
	$pattern = '/Content-Type:|Bcc:|Cc:/i';
	
	// Function to check for suspect phrases
	function isSuspect($val, $pattern, &$suspect) {
		// if the variable is an array, loop through each element
		// and pass is recursively back to the same function
		if (is_array($val)) {
			foreach ($val as $item) {
				isSuspect($item, $pattern, $suspect);
			}
		} else {
			// if one of the suspect phrases are found, set boolean to true
			if (preg_match($pattern, $val)) {
				$suspect = true;
			}
		}
	}
	
	if (!$suspect) {
		foreach ($_POST as $key => $value) {
			// Assign to temporary variable and strip white-space if not an array
			$temp = is_array($value) ? $value : trim($value);
			// If empty and required, add to $missing array
			if (empty($temp) && in_array($key, $required)) {
				$missing[] = $key;
			} elseif (in_array($key, $expected)) {
				// otherwise, assign assign to a variable of the same name as $key
				${$key} = $temp;
			}
		}
	}
	
	// Validate the users email
	if (!$suspect && !empty($email)) {
		$validemail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
			if ($validemail) {
				$headers .= "\r\nReply-to: $validemail";
			} else {
				$errors['email'] = true;
			}
	}
	
	$mailSent = false;
	
	// Go ahead only if not suspect and all required fields OK
	if (!$suspect && !$missing && !$errors) {
		// initialize the $message variable
		$message = '';
		// loop through the $expected array
		foreach ($expected as $item) {
			// assign the value of the current item to $val
			if (isset(${$item}) && !empty(${$item})) {
				$val = ${$item};
			} else {
				// If it has no value, assign 'Not selected'
				$val = 'Not selected';
			}
			// if an array, expand as comma separated string
			if (is_array($val)) {
				$val = implode(', ', $val);
			}
			//replace underscores and hyphens in the label with spaces
			$item = str_replace(array('_', '-'), ' ', $item);
			// add label and value to the message body
			$message .= ucfirst($item).": $val\r\n\r\n";
		}
		
		// Limit line length to 70 characters
		$message = wordwrap($message, 70);
		
		$mailSent = mail($to, $subject, $message, $headers);
		if (!$mailSent) {
			$errors['mailfail'] = true;
		}
	}
