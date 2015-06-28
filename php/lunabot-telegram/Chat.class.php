<?php

class Chat {

	/**
	 * Return the command (UNUSED)
	 * 
	 * @var string
	 * @return string
	 */
	public function getCommand($text)
	{
		$array = explode(" ", $text);

		return preg_replace("/\//", "", $array[0]);
	}

	/**
	 * Return the arguments (UNUSED)
	 *
	 * @var string
	 * @return string
	 */
	public function getArgs($text)
	{
		$array = explode(" ", $text);

		if (isset($array[1]))
			return $array[1];
		else
			return '';
	}

	/**
	 * Check if the response came from a timeout
	 * if the "result" array is empty, then it was a timeout
	 *
	 * @return boolean
	 */
	public function notTimeout($response)
	{
		// If the result array is empty, it was a timeout
		if (empty($response['result']))
			return false;
		else
			return true;
	}

	/**
	 * Send the message to telegram
	 *
	 * @var $message - string
	 * @var $chatID  - int
	 * @var $key 	 - string
	 * @return boolean
	 */
	public function sendMessage($message, $chatID, $key)
	{
		$url 	= "https://api.telegram.org/bot" . $key . "/sendMessage";	  
		
 		// POST data to send
		$fields = array(
						"chat_id" 	=> urlencode($chatID),
				  		"text" 		=> urlencode($message)
				  	);
		$fields_string = '';

		foreach($fields as $key => $value) { 
			$fields_string .= $key . '=' . $value . '&'; 
		}

		rtrim($fields_string, '&');

		$ch 	= curl_init();

		// Set curl options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Cast the return value to boolean
		$done  	= (bool) curl_exec($ch);

		curl_close($ch);

		unset($ch);

		return $done;
	}
}

?>