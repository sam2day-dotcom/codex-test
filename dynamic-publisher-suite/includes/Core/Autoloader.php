<?php

declare(strict_types=1);

namespace DynamicPublisherSuite\Core;

final class Autoloader
{
	public static function init(): void
	{
		spl_autoload_register([self::class, 'autoload']);
	}

	private static function autoload(string $class): void
	{
		$prefix = 'DynamicPublisherSuite\\';

		if (strpos($class, $prefix) !== 0) {
			return;
		}

		$relative = str_replace('\\', '/', substr($class, strlen($prefix)));
		$file     = DPS_DIR . 'includes/' . $relative . '.php';

		if (file_exists($file)) {
			require_once $file;
		}
	}
}
