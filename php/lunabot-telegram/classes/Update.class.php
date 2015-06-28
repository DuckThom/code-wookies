<?php 

class Update {

	private $update_id;
	public  $message;
	
	public function __construct($input)
	{
		$this->update_id  = $input['update_id'];
		$this->message	  = new Message($input['message']);
	}

	public function getUpdateId()
	{
		return $this->update_id;
	}

}