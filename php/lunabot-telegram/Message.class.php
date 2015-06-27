<?php

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

	public function getUpdateId()
	{
		return $this->update_id;
	}

	public function getMessageId()
	{
		return $this->message_id;
	}

	public function getFromId()
	{
		return $this->from_id;
	}

	public function getChatId()
	{
		return $this->chat_id;
	}

	public function getFirstName()
	{
		return $this->from_first_name;
	}

	public function getLastName()
	{
		return $this->from_last_name;
	}

	public function getCommand()
	{
		$array = preg_replace("/\//", "", explode(" ", $this->chat_message));
		
		return (isset($array[0]) ? $array[0] : false);
	}

	public function getArgument()
	{
		$array = explode(" ", $this->chat_message);

		return (isset($array[1]) ? $array[1] : '');
	}
}