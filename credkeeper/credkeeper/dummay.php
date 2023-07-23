<?php
/*if (is_admin()) { 

add_action( 'init', 'github_plugin_updater_test_init' );

function github_plugin_updater_test_init() {	
		//require_once 'updater.php';
		define( 'WP_GITHUB_FORCE_UPDATE', true );	
		$token = "YTJkYjg2Mjg4YWE3ODRiYTNkNjIwNWNhNjkwZDdkN2M4YzU3ZjliYQ==";
		$config = array(
			'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
			'proper_folder_name' => 'agent-directory', // this is the name of the folder your plugin lives in
			'api_url' => 'https://api.github.com/repos/bipinrawatbytes/agent-directory', // the GitHub API url of your GitHub repo
			'raw_url' => 'https://raw.github.com/bipinrawatbytes/agent-directory/master', // the GitHub raw url of your GitHub repo
			'github_url' => 'https://github.com/bipinrawatbytes/agent-directory', // the GitHub url of your GitHub repo
			'zip_url' => 'https://github.com/bipinrawatbytes/agent-directory/zipball/master', // the zip url of the GitHub repo
			'sslverify' => true, // whether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
			'requires' => '1', // which version of WordPress does your plugin require?
			'tested' => '6', // which version of WordPress is your plugin tested up to?
			'readme' => 'README.md', // which file to use as the readme for the version number
			'access_token' => base64_decode($token), // Access private repositories by authorizing under Appearance > GitHub Updates when this example plugin is installed
		);
		new WP_GitHub_Updater($config);
	}
}*/
	/*********** ABOVE CODE IN CLASS EXTENDS  **********/
		 
		 function my_save_post_function() {

			global $post;
			
			$thePostID = $post->ID;

			$posttype=get_post_type();
			

			$postdatapass=array();

			if($posttype=='post')
			{

				$postdata = get_post( $thePostID); 
				
				$postdatapass['ID']=$postdata->ID;
				$postdatapass['post_title']=$postdata->post_title;
				$postdatapass['post_content']=$postdata->post_content;
				$postdatapass['post_image']=get_the_post_thumbnail_url($thePostID);
				$postdatapass['meta_title']=get_post_meta($thePostID,'_yoast_wpseo_title',true);
				$postdatapass['meta_description']=get_post_meta($thePostID,'_yoast_wpseo_metadesc',true);
				$postdatapass['meta_keyword']=get_post_meta($thePostID,'_yoast_wpseo_focuskw',true);
                $postdatapass['website_url']=site_url();
				$this->putPostEditContent($postdatapass);
			}
			
		}

		function add_author_filed_post()
		{
			function auther_field_article() {
			    add_meta_box( 'auther-name', __( 'Article Auther Name', 'auther' ), 'add_author_field', 'post' );
			}
			add_action( 'add_meta_boxes', 'auther_field_article' );

			function add_author_field( $post ) {
			    ?>
			    <p class="meta-options hcf_field">
			        <label for="article_author">Author Name</label>
			        <input id="article_author" type="text" name="article_author"  value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'article_author', true ) ); ?>" disabled>
			    </p>
			    <?php
			}

			function save_author_field( $post_id ) {
			    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
			        $post_id = $parent_id;
			    }
			    $fields = [
			        'article_author',
			    ];
			    foreach ( $fields as $field ) {
			        if ( array_key_exists( $field, $_POST ) ) {
			            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
			        }
			    }
			}
			add_action( 'save_post', 'save_author_field' );
		}