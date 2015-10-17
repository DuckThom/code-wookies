<?php
declare(strict_types=1);

class Hoi {
	public static function foo(): string {
		return "bar";
	}

	public static function bar(): int {
		return 1;
	}

	public static function foobar(): float {
		return true;
	}
}

echo "Hoi::foo() - ";
var_dump(Hoi::foo());

echo "Hoi::bar() - ";
var_dump(Hoi::bar());

echo "Hoi::foobar() - ";
try { 
	var_dump(Hoi::foobar()); 
} catch (TypeError $e) { 
	var_dump($e->getMessage()); 
}
