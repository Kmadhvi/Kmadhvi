<?php
/**
 * The template for adding custom post types to site
 *
 * 
 *
 * @link https://developer.wordpress.org/themes/inc/
 *
 * @package tingl
 */

 // Register Custom Post Type
function tingl_custom_post_types() {

	$labels = array(
		'name'                  => _x( 'Testimonials', 'Post Type General Name', 'tingl' ),
		'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'tingl' ),
		'menu_name'             => __( 'Testimonials', 'tingl' ),
		'name_admin_bar'        => __( 'Testimonial', 'tingl' ),
		'archives'              => __( 'Testimonial archives', 'tingl' ),
		'attributes'            => __( 'Testimonial Attributes', 'tingl' ),
		'parent_item_colon'     => __( 'Parent testimonial:', 'tingl' ),
		'all_items'             => __( 'All Testimonials', 'tingl' ),
		'add_new_item'          => __( 'Add New Testimonial', 'tingl' ),
		'add_new'               => __( 'Add Testimonial', 'tingl' ),
		'new_item'              => __( 'New Testimonial', 'tingl' ),
		'edit_item'             => __( 'Edit Testimonial', 'tingl' ),
		'update_item'           => __( 'Update Testimonial', 'tingl' ),
		'view_item'             => __( 'View testimonial', 'tingl' ),
		'view_items'            => __( 'View testimonial', 'tingl' ),
		'search_items'          => __( 'Search testimonial', 'tingl' ),
		'not_found'             => __( 'Not found', 'tingl' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'tingl' ),
		'featured_image'        => __( 'Testimonial Image', 'tingl' ),
		'set_featured_image'    => __( 'Set testimonial image', 'tingl' ),
		'remove_featured_image' => __( 'Remove image', 'tingl' ),
		'use_featured_image'    => __( 'Use as testimonial image', 'tingl' ),
		'insert_into_item'      => __( 'Insert into item', 'tingl' ),
		'uploaded_to_this_item' => __( 'Uploaded to this testimonial', 'tingl' ),
		'items_list'            => __( 'Testimonial list', 'tingl' ),
		'items_list_navigation' => __( 'Testimonial list navigation', 'tingl' ),
		'filter_items_list'     => __( 'Filter Testimonial list', 'tingl' ),
	);
	$args = array(
		'label'                 => __( 'Testimonial', 'tingl' ),
		'description'           => __( 'This post type will store details of testimonials', 'tingl' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'post-formats' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'testimonial', $args );

}
add_action( 'init', 'tingl_custom_post_types', 0 );

?>

