<?php

declare(strict_types=1);

namespace DynamicPublisherSuite\Core;

use DynamicPublisherSuite\Blocks\SliderBlock;
use DynamicPublisherSuite\Services\Assets\AssetManager;
use DynamicPublisherSuite\Services\Updater\GithubUpdater;

final class Plugin
{
	/** @var array<object> */
	private array $modules = [];

	public function boot(): void
	{
		$this->modules = [
			new AssetManager(),
			new SliderBlock(),
			new GithubUpdater(
				'dynamic-publisher-suite',
				'CHANGE-ME-OWNER',
				'CHANGE-ME-REPO',
				DPS_VERSION,
				DPS_BASENAME
			),
		];

		foreach ($this->modules as $module) {
			if (method_exists($module, 'register')) {
				$module->register();
			}
		}
	}
}
