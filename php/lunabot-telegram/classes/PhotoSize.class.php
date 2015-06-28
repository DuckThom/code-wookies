<?php

class PhotoSize {

	private $file_id;
	private $width;
	private $height;
	private $file_size;

	public function __construct($input)
	{
		$this->file_id 	 = $input["file_id"];
		$this->width 	 = $input["width"];
		$this->height 	 = $input["height"];
		$this->file_size = (isset($input["file_size"]) ? $input["file_size"] : false);
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return (string) $this->file_id;
	}

	/**
	 * @return int
	 */
	public function getWidth()
	{
		return (int) $this->width;
	}

	/**
	 * @return int
	 */
	public function getHeight()
	{
		return (int) $this->height;
	}

	/**
	 * @return mixed
	 */
	public function getFileSize()
	{
		return $this->file_size;
	}

}