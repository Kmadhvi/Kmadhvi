<?php

/**
 * 
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 * *
 * @link              https://https://madhvikoshti.wordpress.com/
 * @since             1.0.0
 * @package           Wp_auth_manage
 *
 * @wordpress-plugin
 * Plugin Name:       Wp Author management
 * Plugin URI:        https://https://madhvikoshti.wordpress.com/
 * Description:       This is a plugin for creating contributors for a post.
 * Version:           1.0.0
 * Author:            Madhvi Koshti
 * Author URI:        https://https://madhvikoshti.wordpress.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp_auth_manage
 * Domain Path:       /languages
 * 
 **/

require_once plugin_dir_path(__FILE__) . 'admin/wp_auth_manage-admin.php';

define("AD_PLUGIN_URL", plugin_dir_url(__FILE__));
function wpadd_scripts()
{
    if (is_single()) {
        wp_enqueue_style('style-css', AD_PLUGIN_URL . 'style.css');
    }
}

add_action('wp_enqueue_scripts', 'wpadd_scripts');
add_filter('the_content', 'wp_auth_manage_add_before_page_content', -1);
function wp_auth_manage_add_before_page_content($content)
{
    global $post;
    if (is_single()) {
        $author_ids = get_post_meta($post->ID, 'author', true);

        if (!empty($author_ids)) {
            $contributors_html = '<h2>Contributors</h2>';
            foreach ($author_ids as $id) {
                $author_name = get_the_author_meta('display_name', $id);
                $author_meta = get_the_author_meta('user_nicename', $id);
                $author_posts_url = get_author_posts_url($id, $author_meta);
                $author_avatar_url = get_avatar_url($id);

                $contributors_html .= '<a href="' . esc_url($author_posts_url) . '">';

                if ($author_avatar_url) {
                    $contributors_html .= '<img src="' . esc_url($author_avatar_url) . '" title="' . esc_attr($author_name) . '" class="auth_imag">';
                }
                $contributors_html .= $author_name;

                $contributors_html .= '</a><br>';
            }

            // Remove the trailing comma and space from the last author.
            $contributors_html = rtrim($contributors_html, '<br>');

            $content =  $content . $contributors_html;
        }
    }

    return $content;
}
