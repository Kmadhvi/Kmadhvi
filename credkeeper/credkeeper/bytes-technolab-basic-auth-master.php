<?php
/*function cdk_explode_values( $value, $separator = ',' ) {
	$value  = str_replace( '\\,', '::separator::', $value );
	$values = explode( $separator, $value );
	//$values = array_map( array( $this, 'explode_values_formatter' ), $values );
	return $values;
}

function parse_categories_field( $value,$taxonomy ) {
	if ( empty( $value ) ) {
		return array();
	}
	$row_terms  = cdk_explode_values( $value );
	$categories = array();

	foreach ( $row_terms as $row_term ) {
		$parent = null;
		$_terms = array_map( 'trim', explode( '>', $row_term ) );
		$total  = count( $_terms );

		foreach ( $_terms as $index => $_term ) {
			$term = wp_insert_term( $_term, $taxonomy, array( 'parent' => intval( $parent ) ) );

			if ( is_wp_error( $term ) ) {
				if ( $term->get_error_code() === 'term_exists' ) {
					// When term exists, error data should contain existing term id.
					$term_id = $term->get_error_data();
				} else {
					break; // We cannot continue on any other error.
				}
			} else {
				// New term.
				$term_id = $term['term_id'];
			}

			// Only requires assign the last category.
			if ( ( 1 + $index ) === $total ) {
				$categories[] = $term_id;
			} else {
				// Store parent to be able to insert or query categories based in parent ID.
				$parent = $term_id;
			}
		}
	}
	return $categories;
}

add_action('rest_insert_post','rest_insert_post_callback',99,3);
function rest_insert_post_callback($post,$request,$isCreate){
	if(isset($request) && !empty($request['cdk_post_categories'])){
		$categories = parse_categories_field($request['cdk_post_categories'],'category');
		if($categories){
			wp_set_post_categories($post->ID,$categories);
		}	
	}

	if(isset($request) && !empty($request['cdk_post_tags'])){
		$tags = parse_categories_field($request['cdk_post_tags'],'post_tag');
		if($tags){
			wp_set_post_tags($post->ID,$tags);
		}	
	}
}
*/
function json_basic_auth_handler( $user ) {
	global $wp_json_basic_auth_error;
	$wp_json_basic_auth_error = null;

	// Don't authenticate twice
	if ( ! empty( $user ) ) {
		return $user;
	}

        
	// Check that we're trying to authenticate
//	if ( !isset( $_SERVER['PHP_AUTH_USER'] ) ) {
//		return $user;
//	}
//        $json_string = json_encode($_POST,true);
//        $file_post=file_get_contents('php://input');
//        $getdata=json_decode($file_post,true);
//        file_put_contents('log/'.time().'test.txt',$getdata);
//        $file_post=file_get_contents('php://input');
//        $json_string = json_encode($_POST,true);
//        $str = implode("\n", $_POST); 
//        file_put_contents('log/'.time().'test.txt', print_r(($_POST),true));

//$json_string = json_encode($_SERVER);
//$headers = apache_request_headers();
$headers = getallheaders();
$h_data='';
//foreach ($headers['Idpassword'] as $header => $value) {
//    $h_data .= "$header: $value <br />\n";
//    
//}
   $h_data= base64_decode($headers['Credential']);
   $datauser=explode(":",$h_data );
//
//$file_handle = fopen('log/'.time().'my_filename.txt', 'w');
//fwrite($file_handle, print_r($datauser,true));
//fclose($file_handle);       
       
        
	//$username = 'admin';
	//$password = 'admin@23061990';
	$username = $datauser['0'];
	$password = $datauser['1'];
	/**
	 * In multi-site, wp_authenticate_spam_check filter is run on authentication. This filter calls
	 * get_currentuserinfo which in turn calls the determine_current_user filter. This leads to infinite
	 * recursion and a stack overflow unless the current function is removed from the determine_current_user
	 * filter during authentication.
	 */
	remove_filter( 'determine_current_user', 'json_basic_auth_handler', 20 );
//	$user = wp_authenticate( $username, $password );
	$user = wp_authenticate_username_password( NULL, $username, $password );

	add_filter( 'determine_current_user', 'json_basic_auth_handler', 20 );

	if ( is_wp_error( $user ) ) {
		$wp_json_basic_auth_error = $user;
		return null;
	}

	$wp_json_basic_auth_error = true;

	return $user->ID;
}
add_filter( 'determine_current_user', 'json_basic_auth_handler', 20 );

function json_basic_auth_error( $error ) {
	// Passthrough other errors
	if ( ! empty( $error ) ) {
		return $error;
	}
	global $wp_json_basic_auth_error;

	return $wp_json_basic_auth_error;
}
add_filter( 'rest_authentication_errors', 'json_basic_auth_error' );


// added new  mata for yost keyword and title /

function slug_add_post_data() {
    register_rest_field('post',
        'yoast_meta',
        array(
            'get_callback' => 'yoast_meta_get_field',
            'update_callback' => 'yoast_meta_update_field',
            'schema' => array(
                                'description' => 'My special field',
                                'type' => 'string',
                                'context' => array('view', 'edit')
                            )
        )
    );
}
 
add_action('rest_api_init', 'slug_add_post_data',99);
 
// added for keywords fetch update 28-11-19 //
function post_get_yost_meta_json( $data, $post, $context ) {

 
 $_yoast_wpseo_focuskw =  get_post_meta($post->ID,'_yoast_wpseo_focuskw',true);
 $_yoast_wpseo_metadesc =  get_post_meta($post->ID,'_yoast_wpseo_metadesc',true);

 if(!empty($_yoast_wpseo_focuskw)) {
     $data->data['_yoast_wpseo_metakeywords'] = $_yoast_wpseo_focuskw;
 }
 
 if(!empty($_yoast_wpseo_metadesc)) {
     $data->data['_yoast_wpseo_metadesc'] = $_yoast_wpseo_metadesc;
 }
 
 return $data;
}
add_filter( 'rest_prepare_post', 'post_get_yost_meta_json', 10, 3 );
 
 
function yoast_meta_get_field($post, $field_name, $request) {
  return get_post_meta($post->id, $field_name);
}
 
function yoast_meta_update_field($value, $post, $field_name) {
  if (!$value || !is_string($value)) {
    return;
  }
	$keydata = json_decode($value);
	foreach($keydata as $key=>$valueinner){
		update_post_meta($post->ID, $key, strip_tags($valueinner));
	}
  return update_post_meta($post->ID, $field_name, strip_tags($value));
  
}

/*start add meta keyword yoast seo 25-04-2019*/

add_action( 'wpseo_head', 'yoast_seo_add_keyword' , 7 );

function yoast_seo_add_keyword() {
    
    global $post;
	
	if(is_single())
	{
		$meta_keyword =get_post_meta($post->ID,'_yoast_wpseo_focuskw',true );
	}
	
	if ( is_string( $meta_keyword ) && $meta_keyword !== '' ) {
		echo '<meta name="keyword" content="', esc_attr( wp_strip_all_tags( stripslashes( $meta_keyword ) ) ), '"/>', "\n";
		return '';
	} 
}
/*end add meta keyword yoast seo 25-04-2019*/

if (!function_exists('getallheaders')) {
    function getallheaders() {
    $headers = [];
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    return $headers;
    }
}