<?php

/*Add*/

/*Add User Data Using REst api wordpress*/ 

//echo "test";

function getUserValue($userID,$field){
	return   get_user_meta($userID,$field,true);
}
function tm_additional_profile_fields_new( $user ) {
	/*echo "<pre>";
	print_r($user);
	die();*/
	?>
    <table class="form-table">
		<tbody>
			<?php
				$jsonData = get_user_meta($user->ID,'user_profile_dynamic_field',true);
				if(!empty($jsonData))
				{
					$dynamicfielddata= json_decode(stripslashes(html_entity_decode($jsonData)),true); 
					foreach($dynamicfielddata as $fielddata)
					{
						$fieldtype=$fielddata['field_type'];
						switch ($fieldtype) {
							case 'text':
								?>
									<tr class="user-<?php echo $fielddata['field_lable']; ?>-wrap">
									 	<th><label for="<?php echo $fielddata['field_lable']; ?>"><?php echo $fielddata['field_lable']; ?></label></th>
									 	<td>
								   		 	<input type="<?php echo getUserValue($user->ID,$fielddata['field_name']);//echo $fielddata['field_type']; ?>" name="<?php echo $fielddata['field_name']; ?>" style="width:60%" value="<?php echo $fielddata['field_value']; ?>">
								   		</td>
									</tr>
								<?php
								break;
							case 'textarea':
								?>
									<tr class="user-<?php echo $fielddata['field_lable']; ?>-wrap">
								   		 <th><label for="<?php echo $fielddata['field_lable']; ?>"><?php echo $fielddata['field_lable']; ?></label></th>
								   		 <td>
								   		 	<textarea name="<?php echo $fielddata['field_name']; ?>" rows="5" cols="30"><?php echo getUserValue($user->ID,$fielddata['field_name']); //echo $fielddata['field_value']; ?></textarea>
								   		 </td>
								   	</tr>
								<?php
								break;
							case 'editor':	
								?>
									<tr class="user-<?php echo $fielddata['field_lable']; ?>-wrap">
							   		 <th><label for="<?php echo $fielddata['field_lable']; ?>"><?php echo $fielddata['field_lable']; ?></label></th>
							   		 <td>
										<?php
										$content = getUserValue($user->ID,$fielddata['field_name']);
										$editor_id = $fielddata['field_name'];
										$settings = array(
												'tinymce' => true,
												'quicktags' => true
												// array( 
												// 	'buttons' => 'strong,em,del,ul,ol,li,close' 
												// ),
											);
										wp_editor( $content, $editor_id, $settings);
										?>
										
							   		 </td>
							   	</tr>
								<?php
								break;
							default:
								# code...
								break;
						}
					}
				}
			?>
			
		</tbody>
    </table>
    <?php

}

add_action( 'show_user_profile', 'tm_additional_profile_fields_new' );
add_action( 'edit_user_profile', 'tm_additional_profile_fields_new' );

add_action( 'personal_options_update', 'save_tm_additional_profile_fields_new' );
add_action( 'edit_user_profile_update', 'save_tm_additional_profile_fields_new' );

function save_tm_additional_profile_fields_new( $user_id ) {
	
	if ( ! current_user_can( 'edit_user', $user_id ) )
        return false;
	if($_POST):
		$post = $_POST;
	endif;	
	
	$dynamicfielddataList = get_user_meta($user_id,'user_profile_dynamic_field',true);
	if($dynamicfielddataList){
		$dynamicfielddataList = stripslashes(html_entity_decode($dynamicfielddataList));
		$dynamicfieldArray = json_decode($dynamicfielddataList,true);
		if(is_array($dynamicfieldArray) && !empty($dynamicfieldArray)){
			foreach ($dynamicfieldArray as $idx => $fields) {
			if(array_key_exists($fields['field_name'],$post)){
				if($fields['field_name'] == 'ldesc' && !empty($fields['field_value'])){
					$fields['field_value'] = htmlentities($fields['field_value']);
					//$fields['field_value'] = str_replace('u003E', '>', $fields['field_value']);
				}
				//if(!empty($post['field_name'])){
					/*echo "<pre>";
					print_r($fields['field_name']);
					print_r($post[$fields['field_name']]);
					die();*/
				if(!empty($post[$fields['field_name']])){
					update_user_meta( $user_id,$fields['field_name'],$post[$fields['field_name']]);
				}
				//}
				$dynamicfieldArray[$idx]['field_value'] =  $post[$fields['field_name']];
			}
			}	
		}
		
	}
	
	array_walk_recursive($dynamicfieldArray, function(&$item, $key) {
	    if(is_string($item)) {
	        $item = htmlentities($item);
	    }
	});
	/*echo "<pre>";
	print_r($post);
	print_r($dynamicfieldArray);
	echo "<pre>";
	die();*/
	update_user_meta($user_id,'user_profile_dynamic_field',json_encode($dynamicfieldArray,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
}

add_action( 'rest_api_init', 'adding_user_meta_rest' ,999);

function adding_user_meta_rest() {
     register_rest_field( 'user',
            'meta',
             array(
               'get_callback'      => 'user_meta_callback',
               'update_callback'   => 'user_meta_update_callback',
               'schema'            => null,
                )
          );
}

function user_meta_callback( $object, $field_name, $request ) {

	  $userid=$object['id'];

	  $requestbody=json_decode($request->get_body(),true);
	  
	  $userTableArray = array('user_url'=>'');

	  $staticFieldArray = array('first_name'=>'','last_name'=>'','nickname'=>'','facebook'=>'','instagram'=>'','linkedin'=>'','myspace'=>'','pinterest'=>'','soundcloud'=>'','tumblr'=>'','twitter'=>'','youtube'=>'','wikipedia'=>'','description'=>'','wpseo_title'=>'','wpseo_metadesc'=>'');

	  $staticFieldKeyImage = 'wp_user_avatar';
	  
	  if(isset($requestbody) && !empty($requestbody))	
	  {	
	  	  $newFieldArray = array();
		  foreach ($requestbody as $key => $meta) {
		  		foreach ($meta as $keyfield=>$metadata) 
		  		{
		  			foreach ($metadata as $keyfield=>$dynamic_field) 
		  			{
		  				    if(array_key_exists($dynamic_field['field_name'], $userTableArray)){
								$userTableArray[$dynamic_field['field_name']] = $dynamic_field['field_value'];
								updateUserTableFiled($userTableArray,$userid);	
							}
							else if(array_key_exists($dynamic_field['field_name'], $staticFieldArray))
							{
								$staticFieldArray[$dynamic_field['field_name']] = $dynamic_field['field_value'];
							}else if($dynamic_field['field_name']==$staticFieldKeyImage){
				  				$image_url=$dynamic_field['field_value'];
				  				if(isset($image_url) && !empty($image_url))
								{
								  	  $upload_dir = wp_upload_dir();
									  $image_data = file_get_contents( $image_url );
									  $filename = basename( $image_url );

									  if ( wp_mkdir_p( $upload_dir['path'] ) ) {
										  $file = $upload_dir['path'] . '/' . $filename;
									  }
									  else {
										  $file = $upload_dir['basedir'] . '/' . $filename;
									  }

									  file_put_contents( $file, $image_data );

									  $wp_filetype = wp_check_filetype( $filename, null );

									  $attachment = array(
										  'post_mime_type' => $wp_filetype['type'],
										  'post_title' => sanitize_file_name( $filename ),
										  'post_content' => '',
										  'post_status' => 'inherit'
									  );

									  $attach_id = wp_insert_attachment( $attachment, $file );
									  require_once( ABSPATH . 'wp-admin/includes/image.php' );
									  $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
									  wp_update_attachment_metadata( $attach_id, $attach_data );
									  global $wpdb;
        							  update_user_meta($userid,str_replace('wp_',$wpdb->prefix,$staticFieldKeyImage),$attach_id);
								}
				  			}
				  			else
							{
								$newFieldArray[] = $dynamic_field;
								update_user_meta($object['id'],$dynamic_field['field_name'],$dynamic_field['field_value']);
							}
							
					}
				}
		  	}
		    if(!empty($newFieldArray))
	  		{
	  			updateStaticArray($newFieldArray,true,$userid);
	  		}

	  		if(!function_exists('updateUserTableFiled'))
	  		{
	  			updateUserTableFiled($userTableArray,$userid);	
	  		}
	  		if(!function_exists('updateStaticArray'))
	  		{
	  			updateStaticArray($staticFieldArray);	
	  		}
		}

	  //return $postdata;
}
function updateUserTableFiled($userTableArray,$userid){
	$website=!empty($userTableArray['user_url']) ? 	$userTableArray['user_url'] : '';
	wp_update_user(array('ID'=>$userid,"user_url" => $website));
}

function updateStaticArray($staticFieldArray,$isNewFieldArray,$userid)
{
	foreach ($staticFieldArray as $key => $staticvalue) {
		update_user_meta($userid,$key,$staticvalue);	
	}
	if($isNewFieldArray){
		$isMetaExist = get_user_meta($userid,'user_profile_dynamic_field',true);
			array_walk_recursive($staticFieldArray, function(&$item, $key) {
		    if(is_string($item)) {
		        $item = htmlentities($item);
		    }
		});
		if($isMetaExist) {
			update_user_meta($userid,'user_profile_dynamic_field',json_encode($staticFieldArray,JSON_HEX_QUOT | JSON_HEX_TAG));	
		}else
		{		//add_user_meta( $user_id, $meta_key, $meta_value, $unique = false )
		add_user_meta($userid,'user_profile_dynamic_field',json_encode($staticFieldArray,JSON_HEX_QUOT | JSON_HEX_TAG));	
		
		}	
	}
}

function user_meta_update_callback( $object, $field_name, $request )
{	

	// echo "test"	;die();
	 $userid=$field_name->data->ID;

	 $userTableArray = array('user_url'=>'');
	 
	 $staticFieldArray = array('first_name'=>'','last_name'=>'','nickname'=>'','facebook'=>'','instagram'=>'','linkedin'=>'','myspace'=>'','pinterest'=>'','soundcloud'=>'','tumblr'=>'','twitter'=>'','youtube'=>'','wikipedia'=>'','description'=>'','wpseo_title'=>'','wpseo_metadesc'=>'');

	 $staticFieldKeyImage = 'wp_user_avatar';
	
	 foreach ($object as $key => $meta) {
	  		foreach ($meta as $keyfield=>$dynamic_field) {
	  			
				if(array_key_exists($dynamic_field['field_name'], $userTableArray)){
					$userTableArray[$dynamic_field['field_name']] = $dynamic_field['field_value'];
				}
				else if(array_key_exists($dynamic_field['field_name'], $staticFieldArray))
				{
					$staticFieldArray[$dynamic_field['field_name']] = $dynamic_field['field_value'];
				}else if($dynamic_field['field_name']==$staticFieldKeyImage){
	  				$image_url=$dynamic_field['field_value'];
	  				if(isset($image_url) && !empty($image_url))
					{
					  	  $upload_dir = wp_upload_dir();
						  $image_data = file_get_contents( $image_url );
						  $filename = basename( $image_url );

						  if ( wp_mkdir_p( $upload_dir['path'] ) ) {
							  $file = $upload_dir['path'] . '/' . $filename;
						  }
						  else {
							  $file = $upload_dir['basedir'] . '/' . $filename;
						  }

						  file_put_contents( $file, $image_data );

						  $wp_filetype = wp_check_filetype( $filename, null );

						  $attachment = array(
							  'post_mime_type' => $wp_filetype['type'],
							  'post_title' => sanitize_file_name( $filename ),
							  'post_content' => '',
							  'post_status' => 'inherit'
						  );

						  $attach_id = wp_insert_attachment( $attachment, $file );
						  require_once( ABSPATH . 'wp-admin/includes/image.php' );
						  $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
						  wp_update_attachment_metadata( $attach_id, $attach_data );
						  
						  global $wpdb;
        				 update_user_meta($userid,str_replace('wp_',$wpdb->prefix,$staticFieldKeyImage),$attach_id);
					}
	  			}else
				{
					$newFieldArray[] = $dynamic_field;
				}
				update_user_meta($userid,$dynamic_field['field_name'],$dynamic_field['field_value']);
			}

	  		if(!empty($newFieldArray))
	  		{
	  			updateStaticArray($newFieldArray,true,$userid);
	  		}

	  		if(!function_exists('updateUserTableFiled'))
	  		{
	  			updateUserTableFiled($userTableArray,$userid);	
	  		}
	  		if(!function_exists('updateStaticArray'))
	  		{
	  			updateStaticArray($staticFieldArray);	
	  		}
	}
}


?>