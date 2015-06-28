<?php

/*************************************
 * Class Command
 *
 * All functions, except isValid, should return a string (the message)
 *************************************/

class Command {

	/**
	 * Check if the command is valid
	 *
	 * @var string
	 * @return boolean
	 */
	public function isValid($command, $target)
	{
		$commandList = ["help", "fortune", "boe", "weather", "laugh"];
		$command 	 = preg_replace("/\//", "", $command);
		$validTarget = false;

		// Is this bot the target?
		if ($target === "LunaBot" || $target === false)
			$validTarget = true;
		
		// Is the command in the known command list and is this bot the target?
		if (in_array($command, $commandList) && $validTarget === true)
			return true;
		else
			return false;
	}

	/**
	 * Dispense some help to a damsel in distress
	 *
	 * @return string
	 */
	public function help()
	{
		$text = "Possible commands: \r\n" .
				"/help  -  Display this message \r\n" .
				"/weather <location>  -  Get the weather for that location\r\n" .
				"/boe  -  Scare me \r\n" . 
				"/fortune  -  Get a fortune cookie";
		
		return $text;
	}

	/**
	 * Give a person a (fortune) cookie
	 *
	 * @return string
	 */
	public function fortune()
	{
		$output = '';

		exec("fortune", $out, $code);

		// Needed for multi-line fortunes
		foreach($out as $line)
			$output .= $line . "\r\n";

		// If the return code is 0 (successful) return the fortune
		if ($code === 0)
			return $output;
		else
			return 'No fortunes found :(';
	}

	/**
	 * I'm scjert
	 *
	 * @return string
	 */
	public function boe()
	{
		return "Schrik!";
	}

	/**
	 * Display the weather for the queried location
	 *
	 * @var string
	 * @return string
	 */
	public function weather($location = '')
	{
		if ($location === '')
			return "Usage: /weather [location]";
		else
		{
			$location = preg_replace("/\s/", "%20", $location);

			// Create the url
			$url 	= "http://api.openweathermap.org/data/2.5/weather?q=" . $location . "&APPID=" . OWM_KEY;
			
			// Initialize curl
			$ch 	= curl_init();

			// Set the curl options
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// Run the query
			$input 	= curl_exec($ch);

			// Close the connection
			curl_close($ch);

			// Parse the json returned by the Telegram API
			$input 	= json_decode($input, true);

			// Has the location been found by the OpenWeatherMap API
			if (isset($input["cod"]))
			{
				if ($input["cod"] !== 200)
				{
					return "No weather data found for this location: " . ucfirst($location);
				} else
				{
					return "City: " . ucfirst($location) . "\r\n" .
						   "Temperature: " . round($input["main"]["temp"] - 272.15, 1) . " °C \r\n" .
						   "Weather: " . $input["weather"][0]["main"] . " " . Emoji::getOWMEmoji($input["weather"][0]["icon"]);
				}
			} else
				return "Error retrieving weather data, please try again later";
		}
	}

	/**
	 * Return a random laugh
	 *
	 * @return string
	 */
	public function laugh()
	{
		$laughList = [
				"HAHAHAHAHAHAHAHAHAHAHAHAHAHA",
				"mwaahaAHAHAAHHAHAAHHAHAHA",
				"hehe",
				"hahahahaha",
				"hahahaAHAHAHA",
				"TeeHee",
				"kek",
				"topkek",
				"lol",
				"lawl",
				"haha",
				"huehuehue",
				"lololololol",
				"trolololol",
				"hihihihihi",
				"lmao",
				"rofl"
			];

		return $laughList[array_rand($laughList)];
	}

}

?>