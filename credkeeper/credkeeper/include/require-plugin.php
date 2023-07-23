<?php
add_action( 'tgmpa_register', 'twentyseventeen_require_plugin' );

function twentyseventeen_require_plugin() {

	$plugins = array(
 		
 		array(
			'name'        => 'Yoast SEO',
			'slug'        => 'wordpress-seo',
			'source'      => 'https://downloads.wordpress.org/plugin/wordpress-seo.12.9.1.zip' ,
			'required'           => true, 
			'force_activation'   => true, 
			'force_deactivation' => false,
			'external_url'       => ''
		),

		array(
			'name'        => 'WP User Avatar',
			'slug'        => 'wp-user-avatar',
			'source'      => 'https://downloads.wordpress.org/plugin/wp-user-avatar.zip' ,
			'required'           => true, 
			'force_activation'   => true,
			'force_deactivation' => false, 
			'external_url'       => ''
		),

	);

	$config = array(
		'id'           => 'agentdirectory',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'plugins.php',            // Parent menu slug.
		'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
