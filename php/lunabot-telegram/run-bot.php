<?php

function _autoloader($class) {
    include $class . ".class.php";
}

spl_autoload_register('_autoloader');

$running 	= true;

$config 	= parse_ini_file('bot-config.ini');
$key 		= $config["key"];
$offset 	= 0;

echo "Bot is running\r\n";

while($running)
{
	$url 	= "https://api.telegram.org/bot" . $key . "/getUpdates?offset=" . $offset . "&limit=1&timeout=60";
	$ch 	= curl_init($url);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$input 	= curl_exec($ch);
	curl_close($ch);

	$input 	= json_decode($input, true);

	if (Chat::notTimeout($input))
	{
		$message 	  = new Message($input["result"][0]);
		$classCommand = new Command();
		$command 	  = $message->getCommand();

		if (Command::isValid($command) && $message->getFirstName() !== "Luna Bot")
		{
			if (method_exists($classCommand, $command))
			{
				$text = Command::$command($message->getArgument());

				if ($text !== false)
					Chat::sendMessage($text, $message->getChatId(), $key);

			} else
			{
				echo "[ERROR] Command " . $command . " failed!\r\n";
			}
		}

		$offset = $message->getUpdateId() + 1;
	}

	unset($message);
	unset($command);
	unset($input);
}

exit();

?>
