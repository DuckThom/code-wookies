<?php

/**
 * Auto load the classes when needed
 */
function _autoloader($class) {
    include "classes/" . $class . ".class.php";
}
spl_autoload_register('_autoloader');

/**
 * Set some variables
 */
$running    = true;
$config     = parse_ini_file('config/bot-config.ini');
$offset     = 0;

// Telegram Bot API key
define('BOT_KEY', $config["key"]);
// OpenWeatherMap API Key
define('OWM_KEY', $config["owm_key"]);
// Debugging mode
define( 'DEBUG' , $config["debug"]);

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
    $url    = "https://api.telegram.org/bot" . BOT_KEY . "/getUpdates?offset=" . $offset . "&limit=1&timeout=60";
    
    // Initialize curl
    $ch     = curl_init();

    // Set the curl options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Run the query
    $input  = curl_exec($ch);

    // Close the connection
    curl_close($ch);

    // Parse the json returned by the Telegram API
    $input  = json_decode($input, true);

    /**
     * Check if the long polling timeout was reached.
     * If so, don't parse it any further.
     */
    if (!empty($input['result']))
    {
        if (DEBUG)
            var_dump($input);

        // Create an object out of the returned json
        $update       = new Update($input["result"][0]);

        // Get the command from the input
        $command      = $update->message->getCommand();

        // Check if the command is valid, does it do anything?
        if (Command::isValid($command, $update->message->getTarget()) && $update->message->from->getFirstName() !== "Luna Bot")
        {
            // If it does, does the method for the command exist?
            if (method_exists($classCommand, $command))
            {
                // Put the message text in a variable
                $output = Command::$command($update->message->getArgument());

                // If the command doesn't return anything, ignore it
                if ($output !== false)
                    Send::$output['type']($output, $update->message->chat->getId());

                // Echo the command to the console for debugging
                echo "Command '" . $command . "' with arguments '" . $update->message->getArgument() . "' issued by '" . $update->message->from->getFirstName() . "'\r\n";
            } else
            {
                // Log command for debugging
                echo "Command '" . $command . "' not found!\r\n";
            }
        }

        // Increase the offset for the update_id by one
        $offset = $update->getUpdateId() + 1;
    }

    // Clear some stuff for the next loop
    unset($update);
    unset($command);
    unset($input);
}

// Should the loop stop for some reason, end it gracefully
exit();

?>
