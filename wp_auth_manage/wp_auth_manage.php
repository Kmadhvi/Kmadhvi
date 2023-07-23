<?php

/**
 * Plugin Name: Wp author management
 * Plugin URI: https://madhvikoshti.wordpress.com/
 * Description: Creating contributors name on post.
 * Version: 0.1
 * Author: Madhvi Koshti
 * Author URI: https://madhvikoshti.wordpress.com/
 **/

require_once plugin_dir_path(__FILE__) . 'admin/wp_auth_manage-admin.php';

define("AD_PLUGIN_URL", plugin_dir_url(__FILE__));
function wpad_scripts()
{
	if (is_single()) {
		wp_enqueue_style('wp_auth_manage', AD_PLUGIN_URL . 'style.css');
	}
}

add_action('wp_enqueue_scripts', 'wpad_scripts');

add_filter('the_content', 'myfunc_add_before_page_content', -1);
function myfunc_add_before_page_content($content)
{
	global $post;
	if (is_single()) {
		if (is_single()) {


			$author_id = get_post_meta($post->ID, 'author', true);
			foreach ($author_id as $id) {
				//	echo $id;
				$author_name = get_the_author_meta('display_name', $id);
				$author_meta = get_the_author_meta('user_nicename', $id);

				$author_posts_url = get_author_posts_url($id, $author_meta);
				$author_avatar_url = get_avatar_url($id);

				$contributors_html = '<h2>Contributors</h2>';
				$contributors_html = 'By ';
				$contributors_html .= '<a href="' . esc_url($author_posts_url) . '">';
				$contributors_html .=  $author_name;

				if ($author_avatar_url) {
					$contributors_html .= '<img src="' . esc_url($author_avatar_url) . '" title="' . esc_attr($author_name) . '" class="auth_imag">';
				}

				$contributors_html .= '</a>';
			}

			$content = $contributors_html . $content;
		}

		return $content;
	} else {
		return ($content);
	}
}
