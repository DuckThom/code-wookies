<?php

/*************************************
 * Class Message
 *
 * This class will be used to parse the result array
 *
 * @var Telegram bot API User object
 *************************************/
class User {

	private $user_id;
	private $user_first_name;
	private $user_last_name;
	private $user_username;

	public function __construct($input)
	{
		$this->user_id			= $input["id"];
		$this->user_first_name	= $input["first_name"];
		$this->user_last_name	= (isset($input["last_name"]) ? $input["last_name"] : false);
		$this->user_username	= (isset($input["username"])  ? $input["username"]  : false);
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return (int) $this->user_id;
	}

	/**
	 * @return string
	 */
	public function getFirstName()
	{
		return (string) $this->user_first_name;
	}

	/**
	 * @return mixed
	 */
	public function getLastName()
	{
		return $this->user_last_name;
	}

	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->user_username;
	}
}