<?php

/*************************************
 * Class Message
 *
 * This class will be used to parse the result array
 *
 * @var Telegram bot API array
 *************************************/
class Message {

	private $update_id;
	private $message_id;
	private $from_id;
	private $from_first_name;
	private $from_last_name;
	private $from_username;
	private $chat_id;
	private $chat_message;

	public function __construct($input)
	{
		$this->update_id		= $input["update_id"];
		$this->message_id		= $input["message"]["message_id"];
		$this->from_id			= $input["message"]["from"]["id"];
		$this->from_first_name	= $input["message"]["from"]["first_name"];
		$this->from_last_name	= $input["message"]["from"]["last_name"];
		$this->chat_id			= $input["message"]["chat"]["id"];
		$this->chat_message		= $input["message"]["text"];
	}

	/**
	 * @return string
	 */
	public function getUpdateId()
	{
		return $this->update_id;
	}
	
	/**
	 * @return string
	 */
	public function getMessageId()
	{
		return $this->message_id;
	}
	
	/**
	 * @return string
	 */
	public function getFromId()
	{
		return $this->from_id;
	}

	/**
	 * @return string
	 */
	public function getChatId()
	{
		return $this->chat_id;
	}

	/**
	 * @return string
	 */
	public function getFirstName()
	{
		return $this->from_first_name;
	}

	/**
	 * @return string
	 */
	public function getLastName()
	{
		return $this->from_last_name;
	}

	/**
	 * @return string
	 */
	public function getCommand()
	{
		// Split the message in to [command] - [arguments]
		$array = preg_replace("/\//", "", explode(" ", $this->chat_message));
		
		// Return the command or false
		return (isset($array[0]) ? $array[0] : false);
	}

	/**
	 * @return string
	 */
	public function getArgument()
	{
		// Split the message in to [command] - [arguments]
		$array = explode(" ", $this->chat_message);

		// Return the arguments or an empty string
		return (isset($array[1]) ? $array[1] : '');
	}
}