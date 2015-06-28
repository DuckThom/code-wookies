<?php

/**
 * Auto load the classes when needed
 */
function _autoloader($class) {
    include $class . ".class.php";
}
spl_autoload_register('_autoloader');

/**
 * Set some variables
 */
$running 	= true;
$config 	= parse_ini_file('bot-config.ini');
$key 		= $config["key"];
$offset 	= 0;

// OpenWeatherMap API Key
define('OWM_KEY', $config["owm_key"]);

// Put the Command class in a var to suppress a PHP Notice
$classCommand = new Command();

/**
 * Notify that the bot is running
 */
echo "Bot is running\r\n";

/**
 * Main bot loop
 */
while($running)
{
	// Create the url
	$url 	= "https://api.telegram.org/bot" . $key . "/getUpdates?offset=" . $offset . "&limit=1&timeout=60";
	
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

	/**
	 * Check if the long polling timeout was reached.
	 * If so, don't parse it any further.
	 */
	if (Chat::notTimeout($input))
	{
		// Create an object out of the returned json
		$message 	  = new Message($input["result"][0]);

		// Get the command from the input
		$command 	  = $message->getCommand();

		// Check if the command is valid, does it do anything?
		if (Command::isValid($command, $message->getTarget()) && $message->getFirstName() !== "Luna Bot")
		{
			// If it does, does the method for the command exist?
			if (method_exists($classCommand, $command))
			{
				// Put the message text in a variable
				$text = Command::$command($message->getArgument());

				// If the command doesn't return any text, ignore it
				if ($text !== false)
					Chat::sendMessage($text, $message->getChatId(), $key);

				// Echo the command to the console for debugging
				echo "Command '" . $command . "' with arguments '" . $message->getArgument() . "' issued by '" . $message->getFirstName() . "'\r\n";
			} else
			{
				// Log command for debugging
				echo "Command '" . $command . "' not found!\r\n";
			}
		}

		// Increase the offset for the update_id by one
		$offset = $message->getUpdateId() + 1;
	}

	// Clear some stuff for the next loop
	unset($message);
	unset($command);
	unset($input);
}

// Should the loop stop for some reason, end it gracefully
exit();

?>
