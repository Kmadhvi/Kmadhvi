<?php

/**
 * tingl functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tingl
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */

define('ENCRYPTIONMETHOD', 'AES-256-CBC');
define('SECRET_KEY', hash('sha256', 'hh1jukQY77MKtaHUgo6S7J4tXG8qsWQ9'));
define('IV', 'hh1jukQY77MKtaHU');
// define('TOKEN'               , 'hh1jukQY77MKtaHU');
function tingl_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on tingl, use a find and replace
		* to change 'tingl' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('tingl', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');
	add_theme_support('woocommerce');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary'   => esc_html__('Primary', 'tingl'),
			'secondary' => esc_html__('Secondary', 'tingl'),
			'footer_second' => esc_html__('footer_second', 'tingl'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'tingl_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'tingl_setup');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tingl_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'tingl'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'tingl'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'tingl_widgets_init');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/api-function.php';

if (!class_exists('adAPI')) {
	require_once  get_template_directory() . '/api/adAPIClass.php';
}
/**
 * Enqueue scripts and styles.
 */
/**
 * enqueue styles.
 */
function tingl_styles()
{
	wp_enqueue_script('jquery');
	wp_enqueue_style('style-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), _S_VERSION);
	wp_enqueue_style('style-all', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css');
	wp_enqueue_style('style-owl', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), _S_VERSION);
	wp_enqueue_style('style-fonts', get_template_directory_uri() . '/assets/css/fonts.googleapis.css', array(), _S_VERSION);
	wp_enqueue_style('style-swiper', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', array(), _S_VERSION);
	wp_enqueue_style('style-style', get_template_directory_uri() . '/assets/css/style.css', array(), _S_VERSION);
	wp_enqueue_style('style-media', get_template_directory_uri() . '/assets/css/media.css', array(), _S_VERSION);
	wp_enqueue_style('style-daterangepicker', get_template_directory_uri() . '/assets/css/daterangepicker.css', array(), _S_VERSION);
	wp_enqueue_style('style-custom', get_template_directory_uri() . '/assets/css/custom.css', array(), _S_VERSION);
}
add_action('wp_enqueue_scripts', 'tingl_styles');
/**
 * enqueue scripts.
 */
function tingle_scripts()
{


	wp_enqueue_script('script-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('script-owl', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('script-moment', get_template_directory_uri() . '/assets/js/moment.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('script-daterangepicker', get_template_directory_uri() . '/assets/js/daterangepicker.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('script-swiperbundle', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('script-validate.min', get_template_directory_uri() . '/assets/js/jquery.validate.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('script-main', get_template_directory_uri() . '/assets/js/main.js', array(), _S_VERSION, true);
	/* Script localize  */
	wp_enqueue_script('custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', 99, true);
	wp_localize_script('custom', 'templateUrl', array('ajaxurl' => admin_url('admin-ajax.php')));
	/* Script localize  */
}

add_action('wp_enqueue_scripts', 'tingle_scripts');

/*==============================================================*/
/* Start theme option settings */
/*==============================================================*/
if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
		'page_title'    => 'Theme General Settings',
		'menu_title'    => 'Theme Settings',
		'menu_slug'     => 'theme-general-settings',
		'capability'    => 'edit_posts',
		'redirect'      => false
	));
	acf_add_options_page(array(
		'page_title'    => 'Model General Settings',
		'menu_title'    => 'Model Settings',
		'menu_slug'     => 'model-general-settings',
		'capability'    => 'edit_posts',
		'redirect'      => false
	));
}
/*==============================================================*/
/* End theme option settings */
/*==============================================================*/

/* 
==============================================================
Menu custom class added 
===============================================================
*/
add_filter('nav_menu_link_attributes', 'tingl_menu_add_class', 10, 3);

function tingl_menu_add_class($atts, $item, $args)
{
	if ($args->theme_location == 'primary') {
		$class = 'nav-link'; // or something based on $item
		$atts['class'] = $class;
	}
	return $atts;
}

/*==============================================================*/
/* Start SVG Icon */
/*==============================================================*/

function tingl_mime_types($mimes)
{

	// New allowed mime types.
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	$mimes['doc'] = 'application/msword';

	// Optional. Remove a mime type.
	unset($mimes['exe']);

	return $mimes;
}
add_filter('upload_mimes', 'tingl_mime_types');

/*==============================================================*/
/* End SVG Icon */
/*==============================================================*/

remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);



add_filter('woocommerce_account_menu_items', 'tingl_menu_links_reorder');

function tingl_menu_links_reorder($menu_links)
{
	return array(
		'dashboard' => __('Order', 'tingl'),
		'downloads' => __('Subscription', 'tingl'),
		'payment-methods' => __('Gift subscription', 'tingl'),
		'edit-address' => __('Manage Address', 'tingl'),
		'orders' => __('Feedback', 'tingl')
	);
}

function tingl_my_account_profile_callback()
{
	?>
	<div class="sidebar">
		<div class="profile-sidebar">
			<?php
			 if ( is_user_logged_in() ) { 
				$current_user_id = get_current_user_id();
				//echo $current_user_id;
				$user_avatar = get_avatar_url($current_user_id,64);
				//echo $user_avatar;
				$userdata = get_userdata($current_user_id);
				?>
				 <div class="profile-img">
					 <img src="<?php echo $user_avatar;?>">
				 </div>
				 <div class="profile-desc">
					 <h4><?php echo $userdata->data->display_name; ?></h4>
					 <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account">
						 <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-account' ) ) ;?> "><?php echo  __( 'View Profile', 'woocommerce' ) ?></a>
					 </li>
				 </div>
				<?php
			} ?>

		</div>
	
	<?php
}
add_action('woocommerce_before_account_navigation', 'tingl_my_account_profile_callback');

function tingl_my_account_logout_callback()
{
	?>
		<a href="#" data-bs-target="#logoutModal" data-bs-toggle="modal" class="logout"><img src="<?php echo get_template_directory_uri().'/assets/images/fi-rr-power.png';?>"><?php echo esc_html__('logout'); ?> </a>
	<?php
}
add_action('woocommerce_before_account_navigation', 'tingl_my_account_logout_callback');


// add link to the menu
add_filter ( 'woocommerce_account_menu_items', 'tingl_one_more_link' );
function tingl_one_more_link( $menu_links ){
	$new = array( 'contact-us' => 'Contact us' );
	$menu_links = array_slice( $menu_links, 0, 4, true ) 
	+ $new 
	+ array_slice( $menu_links, 1, NULL, true );
	return $menu_links;
}

// hook the external URL
add_filter( 'woocommerce_get_endpoint_url', 'tingl_hook_endpoint', 10, 4 );
function tingl_hook_endpoint( $url, $endpoint, $value, $permalink ){
	if( 'contact-us' === $endpoint ) {	
		$url = '#';
	}
	return $url;
 
}

//add_action( 'template_redirect', 'tingl_my_account_redirect_to_orders' );
 
function tingl_my_account_redirect_to_orders(){
   if ( is_account_page() && empty( WC()->query->get_current_endpoint() ) ) {
      wp_safe_redirect( wc_get_account_endpoint_url( 'orders' ) );
      exit;
   }
}

add_filter( 'woocommerce_login_redirect', 'tingl_customer_login_redirect', 9999, 2 );

function tingl_customer_login_redirect( $redirect, $user ) {
     
    if ( wc_user_has_role( $user, 'Customer' ) ) {
        $redirect = get_home_url(); // homepage
        $redirect = wc_get_page_permalink( 'my-account' ); // shop page
    }
  
    return $redirect;
}





 // Set the old and new category IDs
/* $old_category_id = 25 ; // Replace with the old category ID
$new_category_id = 2; // Replace with the new category ID

// Update the category ID
$updated = wp_update_term($old_category_id, 'product_cat', array(
    'name' => 'category name', // Replace with the updated category name
    'slug' => 'category-name', // Replace with the updated category slug
    'term_group' => $new_category_id // Set the new category ID as the term group
));

// Check if the category was updated successfully
if (!is_wp_error($updated)) {
    // Category updated successfully
    echo 'Category updated successfully!';
} else {
    // Error updating category
    echo 'Error updating category: ' . $updated->get_error_message();
}  */

/* function custom_login_redirect( $redirect_to, $request, $user ) {
    // Get the current user's role
    $user_role = $user->roles[0];
    // Set the URL to redirect users to based on their role
    if ( $user_role == 'customer' ) {
        $redirect_to = '/my-account/';
    }
    return $redirect_to;
}
add_filter( 'login_redirect', 'custom_login_redirect', 10, 3 ); */

