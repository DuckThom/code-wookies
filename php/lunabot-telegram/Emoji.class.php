<?php

class Emoji {

	/**
	 * Return OpenWeatherMap icons as emoji
	 *
	 * @var string
	 * @return mixed
	 */
	public function getOWMEmoji($code = '')
	{
		$emojiCodes = [
				"01d" => "\xE2\x98\x80", // Clear sky 
				"02d" => "\xE2\x9B\x85", // Few clouds
				"03d" => "\xE2\x98\x81", // Scattered clouds
				"04d" => "\xE2\x98\x81", // Broken clouds
				"09d" => "\xE2\x98\x94", // Shower rain
				"10d" => "\xE2\x98\x94", // Rain
				"11d" => "\xE2\x9A\xA1", // Thunderstorm
				"13d" => "\xE2\x9B\x84", // Snow
				"50d" => "\xE3\x80\xB0", // Mist
			];

		return (array_key_exists($code, $emojiCodes) ? $emojiCodes[$code] : '');
	}

}