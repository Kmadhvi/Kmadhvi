<?php
/*
 Template Name: Poll page
 */
get_header();?>

<main id="site-content">

<?php

if ( have_posts() ) {

    while ( have_posts() ) {
        the_post();

        get_template_part( 'template-parts/content-poll');
    }
}

?>

</main>

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>
<?php get_footer(); ?>