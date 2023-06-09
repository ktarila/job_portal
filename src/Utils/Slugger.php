<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Utils;

/**
 * This class is used to provide an example of integrating simple classes as
 * services into a Symfony application.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class Slugger {
	/**
	 * @param string $string
	 *
	 * @return string
	 */
	public function slugify($string) {
		return preg_replace('/\s+/', '-', mb_strtolower(trim(strip_tags($string)), 'UTF-8'));
	}
}
