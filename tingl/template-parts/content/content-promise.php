<?php

/**
 * Template part for displaying testimonial section in whole site
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */

 if (have_rows('home_page_flexible_settings')) :
    while (have_rows('home_page_flexible_settings')) : the_row();
	  /* Banner section starts  */
      if (get_row_layout() == 'we_promise') : ?>

    <section class="we-promise">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <?php
                        $add_section_heading = get_sub_field('add_section_heading');
                    ?>
                    <h2><?php echo $add_section_heading; ?></h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center promise-list">
        <?php
            // Loop through rows.
            while (have_rows('add_promise_box_details')) : the_row();
			$add_promise_img = get_sub_field('add_promise_img');
			$add_promise_heading = get_sub_field('add_promise_heading');
			$add_promise_description = get_sub_field('add_promise_description');
        ?>
            <div class="col-lg-5 col-md-6">
                <div class="promise-box">
                    <div class="promise-img">
                        <?php if($add_promise_img): ?>
                        <img src="<?php echo $add_promise_img['url']; ?>" class="img-fluid">
                        <?php endif;?>
                    </div>
                    <div class="promise-info">
                        <h3><?php if ($add_promise_heading) : echo $add_promise_heading; endif; ?></h3>
                        <p><?php echo $add_promise_description; ?></p>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endwhile; ?>
<?php endif; ?>