<?php
namespace Froxlor\System;

/**
 * If you use RecursiveDirectoryIterator with RecursiveIteratorIterator and run
 * into UnexpectedValueException you may use this little hack to ignore those
 * directories, such as lost+found on linux.
 * (User "antennen" @ http://php.net/manual/en/class.recursivedirectoryiterator.php#101654)
 */
class IgnorantRecursiveDirectoryIterator extends \RecursiveDirectoryIterator
{

	public function getChildren()
	{
		try {
			return new IgnorantRecursiveDirectoryIterator($this->getPathname());
		} catch (\UnexpectedValueException $e) {
			return new \RecursiveArrayIterator(array());
		}
	}
}
