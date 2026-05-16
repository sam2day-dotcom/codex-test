<?php

declare(strict_types=1);

namespace DynamicPublisherSuite\Support;

use WP_Query;

final class QueryEngine
{
	public static function build_args(array $attributes): array
	{
		$args = [
			'post_type'           => $attributes['postType'] ?? 'post',
			'posts_per_page'      => (int) ($attributes['postsPerPage'] ?? 5),
			'ignore_sticky_posts' => true,
			'orderby'             => $attributes['orderBy'] ?? 'date',
			'order'               => $attributes['order'] ?? 'DESC',
		];

		if (! empty($attributes['categoryIds'])) {
			$args['category__in'] = array_map('intval', $attributes['categoryIds']);
		}

		if (! empty($attributes['tagIds'])) {
			$args['tag__in'] = array_map('intval', $attributes['tagIds']);
		}

		if (! empty($attributes['manualPostIds'])) {
			$args['post__in'] = array_map('intval', $attributes['manualPostIds']);
			$args['orderby']  = 'post__in';
		}

		return $args;
	}

	public static function get_posts(array $attributes): WP_Query
	{
		$key = 'dps_slider_' . md5(wp_json_encode($attributes));
		$data = get_transient($key);

		if ($data instanceof WP_Query) {
			return $data;
		}

		$query = new WP_Query(self::build_args($attributes));
		set_transient($key, $query, 2 * MINUTE_IN_SECONDS);

		return $query;
	}
}
