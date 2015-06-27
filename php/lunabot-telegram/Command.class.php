<?php

class Command {

	public function isValid($command)
	{
		$commandList = ["help", "fortune", "boe"];

		$command = preg_replace("/\//", "", $command);

		if (in_array($command, $commandList))
			return true;
		else
			return false;
	}

	public function help()
	{
		return "Help has been dispensed!";
	}

	public function fortune()
	{
		$output = '';

		exec("fortune", $out, $code);

		foreach($out as $line)
			$output .= $line . "\r\n";

		if ($code === 0)
			return $output;
		else
			return 'No fortunes found :(';
	}

	public function boe()
	{
		return "Schrik!";
	}

}

?>