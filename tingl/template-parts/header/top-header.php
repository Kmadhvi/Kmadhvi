<?php

/**
 * Template part for displaying page header in whole site
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */

$top_location = get_field('top_location', 'option');
$top_location = ($top_location) ? $top_location : '';

$topbar_marquee_text = get_field('topbar_marquee_text', 'option');
$topbar_marquee_text = ($topbar_marquee_text) ? $topbar_marquee_text : '';

$topbar_email = get_field('topbar_email', 'option');
$topbar_email = ($topbar_email) ? $topbar_email : '';

$topbar_phone = get_field('topbar_phone', 'option');
$topbar_phone = ($topbar_phone) ? $topbar_phone : '';

$topbar_consulting_link = get_field('topbar_consulting_link', 'option');
$topbar_consulting_link = ($topbar_consulting_link) ? $topbar_consulting_link : '';

$add_logo = get_field('add_logo', 'option');
$add_logo = ($add_logo) ? $add_logo : '';

$subscribe_button = get_field('subscribe_button', 'option');
$subscribe_button = ($subscribe_button) ? $subscribe_button : '';

$login_button = get_field('login_button', 'option');
$login_button = ($login_button) ? $login_button : '';

$cart_button = get_field('cart_button', 'option');
$cart_button = ($cart_button) ? $cart_button : '';
?>
<header>
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-5">
                    <div class="location-select">
                        <span><img src="<?php echo get_template_directory_uri() ?>/assets/images/fi-rr-marker.png"></span>
                        <select class="form-select">
                            <?php foreach ($top_location as $value) { ?>
                                <option><?php echo $value['label']; ?></option>
                            <?php } ?>

                        </select>
                        <marquee width="40%" direction="left" height="30%"><?php echo $topbar_marquee_text; ?></marquee>
                    </div>
                </div>
                <div class=" col-lg-5 col-md-7">
                    <div class="topbar-right">
                        <span><img src="<?php echo get_template_directory_uri() ?>/assets/images/fi-rr-envelope.png"> <?php echo $topbar_email; ?> </span>
                        <span><img src="<?php echo get_template_directory_uri() ?>/assets/images/fi-rr-phone-call.png"> <?php echo $topbar_phone; ?> </span>
                        <a href="<?php echo $topbar_consulting_link['url']; ?>" class="free-consultation-btn"><?php echo $topbar_consulting_link['title']; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-md tingl-menu">
        <div class="container">
            <a class="navbar-brand" href="<?php echo site_url(); ?>">
                <?php if ($add_logo) : ?>
                    <img src="<?php echo $add_logo['url']; ?>">
                <?php endif; ?>
            </a>
            <div class="other-btn other-btn-mob">

                <a href="#" class="cart-btn"><img src="<?php echo get_template_directory_uri() ?>/assets/images/fi-rr-shopping-cart.svg"> <span><?php echo absint( WC()->cart->get_cart_contents_count() ) ;?></span></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'navbar-nav',
                        'container'      =>  false,
                        'depth'          => 0,
                    ));
                } ?>
            </div>
            <?php
            if (is_user_logged_in()) {
                $current_user_id = get_current_user_id();
                $user_avatar = get_avatar_url($current_user_id, 64);
                $userdata = get_userdata($current_user_id);
            ?>
                 <?php if ($subscribe_button) : ?>
                        <a href="<?php echo $subscribe_button['url']; ?>" class="btn btn-primary"><?php echo $subscribe_button['title']; ?></a>
                    <?php endif; ?>
                <div class="other-btn pro-menu">
                    <div class="profile-menu">
                        <a href="#"><img src="<?php echo $user_avatar; ?>"> <?php echo $userdata->data->display_name; ?> <img src="<?php echo get_template_directory_uri() . '/assets/images/chevrondown.svg'; ?>" class="down-icon"></a>
                    </div>
                    <a href="#" class="cart-btn"><img src="<?php echo get_template_directory_uri() ?>/assets/images/fi-rr-shopping-cart.svg"> <span><?php echo absint( WC()->cart->get_cart_contents_count() ) ;?></span></a>
                </div>
            <?php
            } else { ?>
                <div class="other-btn">
                    <?php if ($subscribe_button) : ?>
                        <a href="<?php echo $subscribe_button['url']; ?>" class="btn btn-primary"><?php echo $subscribe_button['title']; ?></a>
                    <?php endif; ?>
                    <?php if ($login_button) :
                        $login_url = $login_button['url'];
                        $login_title = $login_button['title'];
                        $login_target = $login_button['target'] ? $login_button['target'] : '_self';
                    ?>
                        <a href="<?php echo $login_url; ?>" class="btn btn-secondary-outline" data-bs-toggle="modal" data-bs-target="#loginModal"><?php echo $login_title; ?></a>

                    <?php endif; ?>
                    <a href="#" class="cart-btn"><img src="<?php echo get_template_directory_uri() ?>/assets/images/fi-rr-shopping-cart.svg"> <span><?php echo absint( WC()->cart->get_cart_contents_count() ) ;?></span></a>
                </div>
            <?php } ?>
        </div>
    </nav>
</header>