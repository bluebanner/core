<?php namespace Bluebanner\Core;

/**
 * core module
 * basic operations including version.
 */
class Core
{
	
	const VERSION = '1.0-alpha-1-SNAPSHOT';
	
	/**
	 * @return $version of this module
	 */
	public function version()
	{
		return self::VERSION;
	}
}
