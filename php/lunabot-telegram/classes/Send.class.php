<?php

class Send {

	/**
	 * Send the message to telegram
	 *
	 * @var $message - string
	 * @var $chatID  - int
	 * @var $key 	 - string
	 * @return boolean
	 */
	public function message($data, $chatID)
	{
		$url 	= "https://api.telegram.org/bot" . BOT_KEY . "/sendMessage";	  
		
 		// POST data to send
		$fields = array(
						"chat_id" 	=> urlencode($chatID),
				  		"text" 		=> urlencode($data["text"])
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

	/**
	 * Send the sticker to telegram
	 *
	 * @var $message - string
	 * @var $chatID  - int
	 * @var $key 	 - string
	 * @return boolean
	 */
	public function sticker($data, $chatID)
	{
		$url 	= "https://api.telegram.org/bot" . BOT_KEY . "/sendSticker";	  
		
 		// POST data to send
		$fields = array(
						"chat_id" 	=> urlencode($chatID),
				  		"sticker" 	=> urlencode($data["sticker"])
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