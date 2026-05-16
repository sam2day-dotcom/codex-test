<?php

declare(strict_types=1);

namespace DynamicPublisherSuite\Services\Updater;

final class GithubUpdater
{
	private string $slug;
	private string $owner;
	private string $repo;
	private string $version;
	private string $pluginFile;

	public function __construct(string $slug, string $owner, string $repo, string $version, string $pluginFile)
	{
		$this->slug       = $slug;
		$this->owner      = $owner;
		$this->repo       = $repo;
		$this->version    = $version;
		$this->pluginFile = $pluginFile;
	}

	public function register(): void
	{
		add_filter('pre_set_site_transient_update_plugins', [$this, 'inject_update']);
		add_filter('plugins_api', [$this, 'plugin_info'], 10, 3);
	}

	public function inject_update(object $transient): object
	{
		if (empty($transient->checked)) {
			return $transient;
		}

		$release = $this->get_release_data();
		if (! $release || version_compare($this->version, $release['version'], '>=')) {
			return $transient;
		}

		$transient->response[$this->pluginFile] = (object) [
			'slug'        => $this->slug,
			'plugin'      => $this->pluginFile,
			'new_version' => $release['version'],
			'url'         => $release['url'],
			'package'     => $release['package'],
		];

		return $transient;
	}

	public function plugin_info($result, string $action, object $args)
	{
		if ($action !== 'plugin_information' || ($args->slug ?? '') !== $this->slug) {
			return $result;
		}

		$release = $this->get_release_data();
		if (! $release) {
			return $result;
		}

		return (object) [
			'name'          => 'Dynamic Publisher Suite',
			'slug'          => $this->slug,
			'version'       => $release['version'],
			'author'        => 'Dynamic Publisher Team',
			'homepage'      => $release['url'],
			'download_link' => $release['package'],
			'sections'      => ['description' => 'Commercial-grade Gutenberg block suite.', 'changelog' => $release['body']],
		];
	}

	private function get_release_data(): ?array
	{
		$cacheKey = 'dps_gh_release_' . md5($this->owner . $this->repo);
		$cached = get_site_transient($cacheKey);
		if (is_array($cached)) {
			return $cached;
		}

		$resp = wp_remote_get(sprintf('https://api.github.com/repos/%s/%s/releases/latest', $this->owner, $this->repo), [
			'timeout' => 15,
			'headers' => ['Accept' => 'application/vnd.github+json'],
		]);
		if (is_wp_error($resp) || wp_remote_retrieve_response_code($resp) !== 200) {
			return null;
		}

		$body = json_decode((string) wp_remote_retrieve_body($resp), true);
		if (! is_array($body) || empty($body['tag_name']) || empty($body['zipball_url'])) {
			return null;
		}

		$data = [
			'version' => ltrim((string) $body['tag_name'], 'v'),
			'package' => (string) $body['zipball_url'],
			'url'     => (string) ($body['html_url'] ?? ''),
			'body'    => (string) ($body['body'] ?? ''),
		];

		set_site_transient($cacheKey, $data, 6 * HOUR_IN_SECONDS);
		return $data;
	}
}
