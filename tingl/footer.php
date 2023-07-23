<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tingl
 */

$add_footer_logo = get_field('add_footer_logo', 'option');
$add_footer_logo = ($add_footer_logo) ? $add_footer_logo : '';


$add_footer_description = get_field('add_footer_description', 'option');
$add_footer_description = ($add_footer_description) ? $add_footer_description : '';

$add_menu_label = get_field('add_menu_label', 'option');
$add_menu_label = ($add_menu_label) ? $add_menu_label : '';

$add_footer_contact_lable = get_field('add_footer_contact_lable', 'option');
$add_footer_contact_lable = ($add_footer_contact_lable) ? $add_footer_contact_lable : '';

$contact_settings = get_field('contact_settings', 'option');
$contact_settings = ($contact_settings) ? $contact_settings : '';

$add_more_info_label = get_field('add_more_info_label', 'option');
$add_more_info_label = ($add_more_info_label) ? $add_more_info_label : '';

$add_menu_items = get_field('add_menu_items', 'option');
$add_menu_items = ($add_menu_items) ? $add_menu_items : '';

$add_social_media_label = get_field('add_social_media_label', 'option');
$add_social_media_label = ($add_social_media_label) ? $add_social_media_label : '';

$add_social_media_links = get_field('add_social_media_links', 'option');
$add_social_media_links = ($add_social_media_links) ? $add_social_media_links : '';

$add_copyright_text = get_field('add_copyright_text', 'option');
$add_copyright_text = ($add_copyright_text) ? $add_copyright_text : '';

?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="footer-logo">
                    <?php if ($add_footer_logo) : ?>
                        <img src="<?php echo $add_footer_logo['url']; ?>" class="img-fluid">
                    <?php endif; ?>
                </div>
                <div class="footer-desc">
                    <p><?php echo $add_footer_description; ?></p>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-3">
                        <div class="footer-content">
                            <h3 class="footer-title"><?php echo $add_menu_label; ?></h3>
                            <?php
                            if (has_nav_menu('secondary')) {
                                wp_nav_menu(array(
                                    'theme_location' => 'secondary',
                                    'menu_class'     => '',
                                    'container'      =>  false,
                                    'depth'          => 0,
                                ));
                            } ?>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-3">
                        <div class="footer-content">
                            <h3 class="footer-title">quick links</h3>
                            <?php
                            if (has_nav_menu('footer_second')) {
                                wp_nav_menu(array(
                                    'theme_location' => 'footer_second',
                                    'menu_class'     => '',
                                    'container'      =>  false,
                                    'depth'          => 0,
                                ));
                            } ?>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-3">
                        <div class="footer-content">
                            <h3 class="footer-title"><?php echo $add_footer_contact_lable; ?></h3>
                            <ul>

                                <?php

                                // Check rows existexists.
                                if (have_rows('contact_settings', 'option')) :

                                    // Loop through rows.
                                    while (have_rows('contact_settings', 'option')) : the_row();

                                        // Load sub field value.
                                        $add_lable = get_sub_field('add_lable', 'option');
                                        $add_icon = get_sub_field('add_icon', 'option');
                                        $add_link = get_sub_field('add_link', 'option');
                                ?>
                                        <li>
                                            <p><?php echo $add_lable; ?></p>
                                            <a href="<?php echo $add_link['url']; ?>"><img src="<?php echo $add_icon['url']; ?>"> <?php echo $add_link['title']; ?></a>
                                        </li>
                                <?php
                                    endwhile;
                                endif;
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="footer-content footer-social">
                            <div>
                                <h3 class="footer-title"><?php echo $add_more_info_label; ?></h3>
                                <ul>
                                    <?php

                                    // Check rows existexists.
                                    if (have_rows('add_menu_items', 'option')) :

                                        // Loop through rows.
                                        while (have_rows('add_menu_items', 'option')) : the_row();

                                            // Load sub field value.
                                            $add_more_info_links = get_sub_field('add_more_info_links', 'option');
                                    ?>
                                            <li><a href="<?php echo $add_more_info_links['url']; ?>"><?php echo $add_more_info_links['title']; ?></a></li>

                                    <?php
                                        endwhile;

                                    endif;
                                    ?>
                                </ul>
                            </div>
                            <div>
                                <h3 class="footer-title"><?php echo $add_social_media_label; ?></h3>
                                <div class="follow-link">
                                    <?php
                                    // Check rows existexists.
                                    if (have_rows('add_social_media_links', 'option')) :

                                        // Loop through rows.
                                        while (have_rows('add_social_media_links', 'option')) : the_row();

                                            // Load sub field value.
                                            $add_social_links = get_sub_field('add_social_links', 'option');
                                            $add_social_media_icon = get_sub_field('add_social_media_icon', 'option');
                                    ?>
                                            <?php if ($add_social_links && $add_social_media_icon) : ?>
                                                <a href="<?php echo $add_social_links['url']; ?>">
                                                    <img src="<?php echo $add_social_media_icon['url']; ?>"></a>
                                            <?php endif; ?>
                                    <?php
                                        endwhile;

                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="footer-coyright">
                    <p><?php echo $add_copyright_text; ?></p>
                </div>
            </div>
        </div>
    </div>
</footer>



<!--------------Login-Modal-------------------->
<?php
get_template_part('/template-model/login-model', 'model');
get_template_part('/template-model/logout-model', 'model');
/* --------------contact-us-Modal-------------------->*/
get_template_part('/template-model/contactus-model');
get_template_part('/template-model/product-detail-modal');
get_template_part('/template-model/address-model');
get_template_part('/template-model/giftmealplan-model');

?>

<?php wp_footer(); ?>

</body>

</html>