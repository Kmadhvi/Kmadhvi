<?php

add_action( 'admin_init', 'remove_callback', 999);

function remove_callback(){
	remove_action( 'show_user_profile', 'tm_additional_profile_fields');
	remove_action( 'edit_user_profile', 'tm_additional_profile_fields');
	remove_action( 'personal_options_update', 'save_tm_additional_profile_fields');
	remove_action( 'edit_user_profile_update', 'save_tm_additional_profile_fields');
}

/*add_action( 'init','callbacl_user_meta_update_fun', 99);
function callbacl_user_meta_update_fun(){
	require_once AD_PLUGIN_DIR . '/include/usermeta_update.php';
}
*/

/*TGM PLugin configuration*/
/*require_once AD_PLUGIN_DIR.'/include/class-tgm-plugin-activation.php';
require_once AD_PLUGIN_DIR.'/include/require-plugin.php';*/

//show_user_profile
//edit_user_profile
//personal_options_update
//edit_user_profile_update

/*********** ABOVE CODE IN CLASS EXTENDS  **********/

public function schedule_post_notification_callback($postID){
    $postdatapass = array();
	$postdata = get_post( $postID);
	if($postdata){
		$postdatapass['ID']= $postdata->ID;
		$postdatapass['post_title']=$postdata->post_title;
		$this->scheduleToPublishPost($postdatapass);
	}
}



