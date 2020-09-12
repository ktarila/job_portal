<?php

namespace App\Utils;

/**
 * This class creates a random token that can be used as reset
 * password token --- or random password
 */
class RandomToken {

	public function __construct() {

	}

	/**
	 * Create a random token of minimum length 32 bytes
	 * @param int $length
	 * @return string
	 */
	public function generateToken($length = 32) {
		if (function_exists('random_bytes')) {
			return bin2hex(random_bytes($length));
		}
		if (function_exists('mcrypt_create_iv')) {
			return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
		}
		if (function_exists('openssl_random_pseudo_bytes')) {
			return bin2hex(openssl_random_pseudo_bytes($length));
		}
	}

	public function generateUniqueRandomNumbersWithinRange($min, $max, $quantity) {
		$numbers = range($min, $max);
		shuffle($numbers);
		return array_slice($numbers, 0, $quantity);
	}
}
