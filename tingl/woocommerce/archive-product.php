<?php

/**
 * Template Name: Product Archive
 *
 * This template overrides the default product archive template.
 *
 * @package tingl
 */

get_header();
?>
<div class="main-content">
    <section>
        <div class="social-links">
            <a href="#" class="facebook">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/facebook.png"> Facebook
            </a>
            <a href="#" class="instagram">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/instagram.png"> Instagram
            </a>
            <a href="#" class="linkedin">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/linkedin.png">Linkedin
            </a>
            <a href="#" class="whatsapp">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/whatsapp.png"> Whatsapp
            </a>
        </div>
        <div class="container-fluid">
            <div class="swiper mySwiper banner-swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="slider-detail">
                                        <h1>tingl your senses with healthy & tasty meals</h1>
                                        <p>perfectly portioned for your body type and activity levels. Eating right is not just related to weight loss but your overall lifestyle. When you eat right, you glow from inside out, you feel stronger, and it does wonders for your immune system. Tingl is a subscription-based meal delivery service that brings food to your doorstep daily. </p>
                                        <a href="#" class="btn btn-primary">call to action</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="banner-img">
                                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/slider-img.png" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="slider-detail">
                                        <h1>tingl your senses with healthy & tasty meals</h1>
                                        <p>perfectly portioned for your body type and activity levels. Eating right is not just related to weight loss but your overall lifestyle. When you eat right, you glow from inside out, you feel stronger, and it does wonders for your immune system. Tingl is a subscription-based meal delivery service that brings food to your doorstep daily. </p>
                                        <a href="#" class="btn btn-primary">call to action</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="banner-img">
                                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/slider-img.png" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="slider-detail">
                                        <h1>tingl your senses with healthy & tasty meals</h1>
                                        <p>perfectly portioned for your body type and activity levels. Eating right is not just related to weight loss but your overall lifestyle. When you eat right, you glow from inside out, you feel stronger, and it does wonders for your immune system. Tingl is a subscription-based meal delivery service that brings food to your doorstep daily. </p>
                                        <a href="#" class="btn btn-primary">call to action</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="banner-img">
                                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/slider-img.png" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="slider-detail">
                                        <h1>tingl your senses with healthy & tasty meals</h1>
                                        <p>perfectly portioned for your body type and activity levels. Eating right is not just related to weight loss but your overall lifestyle. When you eat right, you glow from inside out, you feel stronger, and it does wonders for your immune system. Tingl is a subscription-based meal delivery service that brings food to your doorstep daily. </p>
                                        <a href="#" class="btn btn-primary">call to action</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="banner-img">
                                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/slider-img.png" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="day-trial">
                        <a href="#" class="btn btn-secondary-outline">breakfast</a>
                        <a href="#" class="btn btn-secondary-outline">lunch</a>
                        <a href="#" class="btn btn-secondary-outline">snacks</a>
                        <a href="#" class="btn btn-secondary-outline">dinner</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="plans">
        <div class="container">
            <div class="row justify-content-md-end">
                <div class="col-lg-3 col-md-4">
                    <div class="form-group mb-3">
                        <?php
                        $args =  array(
                            'hide_empty'       => 0,
                            'hierarchical'     => true,
                            'orderby'          => 'name',
                            'order'            => 'ASC',
                            'name'             => 'form-select',
                            'id'               => 'form_select',
                            'class'            => 'form-select',
                            'show_option_none' => 'All category',
                            'value_field'      => 'id',
                            'taxonomy'         => 'product_cat'
                        );
                        $product_cat = wp_dropdown_categories($args);
                        ?>
                    </div>
                </div>
            </div>
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'taxonomy'        => 'product_cat',
                'hide_empty' => false,
            );
            $terms = get_terms($args); ?>

            <div id="category-carousel" class="owl-carousel owl-theme plan-carousel mt-5">
                <?php
                if (!empty($terms) && !is_wp_error($terms)) {
                    foreach ($terms as $term) { ?>
                        <div class="item">
                            <div class="category-box">
                                <?php $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                                $image  = wp_get_attachment_url($thumbnail_id); ?>
                                <img src="<?php echo $image; ?>" class="img-fluid">
                                <a href="#" ><?php echo $term->name; ?></a>
                            </div>
                        </div>
                <?php }
                }
                ?>
            </div>

        </div>
    </section>
    <section class="shop-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="category-title">
                        <span></span>
                        <p id="my_cat">All Category</p>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="row mt-3" id="cayegory_list">

                <?php
                if (woocommerce_product_loop()) {
                    do_action('woocommerce_before_shop_loop');

                    woocommerce_product_loop_start();

                    while (have_posts()) {
                        the_post();

                        /**
                         * Include the template for displaying the product
                         */

                        wc_get_template_part('content', 'product');
                    }

                    woocommerce_product_loop_end();

                    do_action('woocommerce_after_shop_loop');
                } else {
                    do_action('woocommerce_no_products_found');
                }
                ?>
            </div>
        </div>
    </section>
</div>
<?php
get_footer();
