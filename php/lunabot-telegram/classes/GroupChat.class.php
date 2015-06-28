<?php

class GroupChat {

	private $id;
	private $title;

	public function __construct($input)
	{
		$this->id 		= $input["id"];
		$this->title 	= $input["title"];
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return (int) $this->id;
	}

	/**
	 * @return string
	 */
	public function getGroupChatId()
	{
		return (string) $this->title;
	}

}