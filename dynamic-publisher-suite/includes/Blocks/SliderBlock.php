<?php

declare(strict_types=1);

namespace DynamicPublisherSuite\Blocks;

use DynamicPublisherSuite\Support\QueryEngine;

final class SliderBlock
{
	public function register(): void
	{
		add_action('init', [$this, 'register_block']);
	}

	public function register_block(): void
	{
		register_block_type(DPS_DIR . 'build/blocks/slider', [
			'render_callback' => [$this, 'render'],
		]);
	}

	public function render(array $attributes): string
	{
		$query = QueryEngine::get_posts($attributes);

		if (! $query->have_posts()) {
			return '';
		}

		wp_enqueue_style('dps-shared-style');
		wp_enqueue_script('dps-view-slider');

		ob_start();
		?>
		<section class="dps-slider" data-autoplay="<?php echo esc_attr((string) ($attributes['autoplay'] ?? false)); ?>" data-speed="<?php echo esc_attr((string) ($attributes['speed'] ?? 4000)); ?>">
			<div class="dps-slider__track" tabindex="0" aria-label="<?php esc_attr_e('Content slider', 'dynamic-publisher-suite'); ?>">
				<?php while ($query->have_posts()) : $query->the_post(); ?>
					<article class="dps-slide">
						<?php if (has_post_thumbnail()) : ?>
							<div class="dps-slide__image"><?php the_post_thumbnail('large', ['loading' => 'lazy']); ?></div>
						<?php endif; ?>
						<div class="dps-slide__content">
							<h3 class="dps-slide__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php if (! empty($attributes['showExcerpt'])) : ?>
								<div class="dps-slide__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), (int) ($attributes['excerptLength'] ?? 20))); ?></div>
							<?php endif; ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<button class="dps-slider__arrow dps-slider__arrow--prev" aria-label="<?php esc_attr_e('Previous slide', 'dynamic-publisher-suite'); ?>">&#8592;</button>
			<button class="dps-slider__arrow dps-slider__arrow--next" aria-label="<?php esc_attr_e('Next slide', 'dynamic-publisher-suite'); ?>">&#8594;</button>
		</section>
		<?php
		wp_reset_postdata();

		return (string) ob_get_clean();
	}
}
