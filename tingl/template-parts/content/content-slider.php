<?php

/**
 * Template part for displaying a page slider section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */
?>
<!-- Social media and banner section starts -->
<section>
	<?php
	if (have_rows('common_page_settings')) :
		while (have_rows('common_page_settings')) : the_row(); ?>
			<?php
			/* Social media section starts  */
			if (get_row_layout() == 'social_media_links') : ?>
				<div class="social-links">
					<?php
					if (have_rows('add_social_media_links')) :
						while (have_rows('add_social_media_links')) : the_row();
							$add_link = get_sub_field('add_link');
							$link_url    = $add_link['url'];
							$link_title  = $add_link['title'];
							$link_target = $add_link['target'] ? $add_link['target'] : '_self';
							$add_image = get_sub_field('add_image');
							$add_class = get_sub_field('add_class'); ?>
							<a href="<?php echo esc_url($link_url); ?>" class="<?php echo $add_class; ?>">
								<?php if ($add_image) : ?>
									<span>
										<img src="<?php echo esc_url($add_image['url']); ?>" alt="<?php echo esc_attr($add_image['alt']); ?>"></span> <?php echo $link_title; ?>
								<?php endif; ?>
							</a>
					<?php
						endwhile;
					endif; ?>
				</div>
			<?php endif;
			/* Social media section ends */

			/*  Banner section starts */
			if (get_row_layout() == 'slider_settings') :
				$slider_repeater_settings = get_sub_field('slider_repeater_settings'); ?>
				<div class="container-fluid">
					<div class="swiper mySwiper banner-swiper">
						<div class="swiper-wrapper">
							<?php if (have_rows('slider_repeater_settings')) : ?>
								<?php
								// Loop through rows.
								while (have_rows('slider_repeater_settings')) : the_row();
									$add_slider_title = get_sub_field('add_slider_title');
									$add_slider_description = get_sub_field('add_slider_description');
									$add_slider_link = get_sub_field('add_slider_link');
									if ($add_slider_link) :
										$link_url = $add_slider_link['url'];
										$link_title = $add_slider_link['title'];
										$link_target = $add_slider_link['target'] ? $add_slider_link['target'] : '_self';
									endif;
									$add_slider_image = get_sub_field('add_slider_image');
								?>
									<div class="swiper-slide">
										<div class="container">
											<div class="row align-items-center">
												<div class="col-md-6">
													<div class="slider-detail">
														<h1><?php if ($add_slider_title) : echo $add_slider_title;
															endif; ?></h1>
														<p><?php if ($add_slider_description) : echo $add_slider_description;
															endif; ?></p>
														<a href="<?php echo esc_url($link_url); ?>" class="btn btn-primary" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
													</div>
												</div>
												<div class="col-md-6">
													<div class="banner-img">
														<img src="<?php if ($add_slider_image) : echo $add_slider_image['url'] ?>" class="img-fluid">
													<?php endif; ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php
								endwhile; ?>
							<?php endif; ?>
						</div>
						<div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
						<div class="swiper-pagination"></div>
					</div>
				</div>
			<?php endif; ?>
		<?php endwhile; ?>
	<?php endif; ?>
</section>
<!-- Social media and banner section ends   -->