<?php

/**
 * Template part for displaying testimonial section in whole site
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */


?>

<section class="instagram-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <?php
                if( !is_page('about-us') )
                {
                    echo '<div class="section-title">';
                        echo '<h2>join us on instagram</h2>';
                    echo '</div>';
                }
            ?>
            </div>
            <div class="col-md-12">
            <div id="insta-slider" class="owl-carousel owl-theme plan-carousel mt-5">
                <div class="item">
                    <div class="insta-box">
                        <img src="<?php echo get_template_directory_uri()?>/assets/images/insta1.png" class="img-fluid">
                    </div>
                </div>
                <div class="item">
                    <div class="insta-box">
                        <img src="<?php echo get_template_directory_uri()?>/assets/images/insta2.png" class="img-fluid">
                    </div>
                </div>
                <div class="item">
                    <div class="insta-box">
                        <img src="<?php echo get_template_directory_uri()?>/assets/images/insta3.png" class="img-fluid">
                    </div>
                </div>
                <div class="item">
                    <div class="insta-box">
                        <img src="<?php echo get_template_directory_uri()?>/assets/images/insta4.png" class="img-fluid">
                    </div>
                </div>
                <div class="item">
                    <div class="insta-box">
                        <img src="<?php echo get_template_directory_uri()?>/assets/images/insta1.png" class="img-fluid">
                    </div>
                </div>
                <div class="item">
                    <div class="insta-box">
                        <img src="<?php echo get_template_directory_uri()?>/assets/images/insta2.png" class="img-fluid">
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
