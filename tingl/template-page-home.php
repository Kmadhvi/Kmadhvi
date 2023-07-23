<?php
/* Template Name: Home page */
get_header();

    get_template_part('template-parts/content/content-slider','page');
    get_template_part('template-parts/content/content-plans','page');
    get_template_part('template-parts/content/content-meal-menu','page');
    get_template_part('template-parts/content/content-subscribe','page');
    get_template_part('template-parts/content/content-promise','page');
    get_template_part('template-parts/content/content-testimonial','page');
    get_template_part('template-parts/content/content-instagram','page');
    get_template_part('template-parts/content/content-faq','page');

get_footer();
?>