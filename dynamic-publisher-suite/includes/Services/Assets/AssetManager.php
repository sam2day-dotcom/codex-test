<?php

declare(strict_types=1);

namespace DynamicPublisherSuite\Services\Assets;

final class AssetManager
{
	public function register(): void
	{
		add_action('init', [$this, 'register_assets']);
	}

	public function register_assets(): void
	{
		wp_register_style(
			'dps-shared-style',
			DPS_URL . 'build/style-index.css',
			[],
			DPS_VERSION
		);

		wp_register_script(
			'dps-view-slider',
			DPS_URL . 'build/slider-view.js',
			[],
			DPS_VERSION,
			true
		);
	}
}
