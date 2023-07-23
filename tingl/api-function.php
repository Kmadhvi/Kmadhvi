<?php
require_once  get_template_directory(). '/api/adAPIClass.php';

        if (!session_id()) {
            session_start();
        } 

    function tingl_all_actions() {


        // Include the WooCommerce session handler class
        if (class_exists('WC_Session_Handler')) {
            $session_handler = new WC_Session_Handler();
            $session_handler->init();
        }
        add_action('wp_ajax_tingl_send_login_otp', 'tingl_send_login_otp');
        add_action('wp_ajax_nopriv_tingl_send_login_otp', 'tingl_send_login_otp');
        
        add_action('wp_ajax_tingl_verify_login_otp', 'tingl_verify_login_otp');
        add_action('wp_ajax_nopriv_tingl_verify_login_otp', 'tingl_verify_login_otp');
        
        add_action('wp_ajax_tingl_complete_profile_callback', 'tingl_complete_profile_callback');
        add_action('wp_ajax_nopriv_tingl_complete_profile_callback', 'tingl_complete_profile_callback'); 
        
        add_action( 'admin_init', 'tingl_get_categorylist_callback' );

        add_action('admin_init','tingl_get_dishlist_callback');

        add_action('wp_ajax_tingl_show_productby_category_callback', 'tingl_show_productby_category_callback');
        add_action('wp_ajax_nopriv_tingl_show_productby_category_callback', 'tingl_show_productby_category_callback');
        
        add_action('wp_ajax_tingle_get_dish_detail_callback', 'tingle_get_dish_detail_callback');
        add_action('wp_ajax_nopriv_tingle_get_dish_detail_callback', 'tingle_get_dish_detail_callback');
        
        
        add_action('wp_ajax_tingle_update_edit_profile_callback', 'tingle_update_edit_profile_callback');
        add_action('wp_ajax_nopriv_tingle_update_edit_profile_callback', 'tingle_update_edit_profile_callback');

        add_action('wp_ajax_tingl_addAddress_callback', 'tingl_addAddress_callback');
        add_action('wp_ajax_nopriv_tingl_addAddress_callback', 'tingl_addAddress_callback');

        
        add_action('wp_ajax_add_product_to_cart', 'custom_add_product_to_cart');
        add_action('wp_ajax_nopriv_add_product_to_cart', 'custom_add_product_to_cart'); // For non-logged-in users


    }
    add_action('init','tingl_all_actions');
    

    /*
    ================================================================
    ================================================================
        **  send login otp api **
    ================================================================
    ================================================================
    */
    function tingl_send_login_otp() {
        /* Class object defined */
        $objapi = new adAPI();
        $mobileNumber =$_POST['mobileNumber'];
        if(isset($_POST['mobileNumber']) && !empty($_POST['mobileNumber']))
        {
            $data = array('mobileNumber' => $_POST['mobileNumber'] );
            $json_encoded = json_encode($data);
            $encryptedData = openssl_encrypt( $json_encoded, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
            $postapiData = $objapi->sendOtp($encryptedData);
            //echo $postapiData;
            $decrypt_value = openssl_decrypt($postapiData, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
		    // echo "Response body: $decrypt_value";
             $json_decoded = json_decode($decrypt_value);
             print_r($json_decoded);
             if (isset($json_decoded)) {
                get_template_part("template-model/login-model", null, $json_decoded);
            }
        }
        die();

    }
    /*
    ================================================================
    ================================================================
     **  verify otp api **
    ================================================================
    ================================================================
    */

    function tingl_verify_login_otp() {
        /* Class object defined */
        $objapi = new adAPI();
        $mobileNumber =$_POST['mobileNumber'];
        $otp          = $_POST['otp'];
        $login_otp  =  implode("",$otp);
        if(isset($_POST['otp']) && !empty($_POST['otp']))
        {
            $data = array('otp' => $login_otp ,'mobileNumber'=> $mobileNumber , 'device_type'=> 'W');
            $json_encoded = json_encode($data);
            $encryptedData = openssl_encrypt( $json_encoded, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
            $postapiData = $objapi->verifyOtp($encryptedData);
            $decrypt_value = openssl_decrypt($postapiData, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
		    // echo "Response body: $decrypt_value";
            $json_decoded = json_decode($decrypt_value);
            /* echo '<pre>';
            print_r($json_decoded);
            echo '</pre>'; */

            
            $token = $json_decoded->details->token;
            $_SESSION['token'] = $token;
            WC()->session->set('token', $token);

          //  echo $token;


            if ($json_decoded->code == 2) {
                $response = array(
                    'alert' => $json_decoded->message
                );
                wp_send_json($response);
                exit();
            }            
            else
            {
                //add_user_meta()
                /* if exiting user  */
                $user = get_user_by('login', $mobileNumber);
                if($user)
                {
                    $login_user = array(
                        'user_login'    => $mobileNumber,  // user_login.
                        'user_password' => $mobileNumber,   // login password.
                    );
                    $users = wp_signon( $login_user);

                    if ( ! is_wp_error($users) ) {
                        $response = array(
                            'login_status' => '1' 
                        );
                        wp_send_json($response);
                        exit(); 
                    }
                }   
            }
        }
       die();
    } 
    /*
    ================================================================
    ================================================================
     **  Complete profile api **
    ================================================================
    ================================================================
    */

    function tingl_complete_profile_callback() {
        /* Class object defined */
        $objapi = new adAPI();
        $formData = $_POST['formData'];
        $step = $formData['step'];
        if (isset($_SESSION['token']) && $_SESSION['token'] !== '') {
            $encryptedtoken = $_SESSION['token'];
        }
    
        switch ($step) {
            case 1:
                $firstName = $formData['firstName'];
                $lastName = $formData['lastName'];
                $data1 = array('step'=> $step,'firstName' => $firstName ,'lastName'=> $lastName);
                $json_encoded = json_encode($data1);
                echo $encryptedData = openssl_encrypt( $json_encoded, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
                $first_last_name = $objapi->completeProfile($encryptedData,$encryptedtoken);
                $decrypt_value = openssl_decrypt($first_last_name, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
                $json_decoded = json_decode($decrypt_value);
                echo "<pre>";
                print_r($json_decoded);
                echo "</pre>";
                break;

            case 2:
                $gender = $formData['gender'];
                $data2 = array('step'=>$step,'gender' => $gender);
                $json_encoded = json_encode($data2);
                $encryptedData = openssl_encrypt( $json_encoded, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
                echo $postapiData = $objapi->completeProfile($encryptedData,$encryptedtoken);
                $decrypt_value = openssl_decrypt($postapiData, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
                $json_decoded = json_decode($decrypt_value);
                echo "<pre>";
                print_r($json_decoded);
                echo "</pre>";
                break;
                
            case 3:
                $age = $formData['age'];
                $data3 = array('step'=>$step,'age' => $age);
                $json_encoded = json_encode($data3);
                $encryptedData = openssl_encrypt( $json_encoded, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
                $postapiData = $objapi->completeProfile($encryptedData,$encryptedtoken);
                $decrypt_value = openssl_decrypt($postapiData, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
                $json_decoded = json_decode($decrypt_value);
                echo "<pre>";
                print_r($json_decoded);
                echo "</pre>";
                break;

            case 4:
                $mobileNumber =$formData['mobileNumber'];
                $firstName    = $formData['firstName'];
                $lastName     = $formData['lastName'];
                $gender       = $formData['gender'];
                $age          = $formData['age'];
                $pincode      = $formData['pincode'];
                $data4 = array('step'=>$step,'pincode' => $pincode);
                $json_encoded = json_encode($data4);
                $encryptedData = openssl_encrypt( $json_encoded, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
                $postapiData = $objapi->completeProfile($encryptedData,$encryptedtoken);
                $decrypt_value = openssl_decrypt($postapiData, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
                $json_decoded = json_decode($decrypt_value);

                //Register New User
                $login_user = wp_create_user($mobileNumber, $mobileNumber);  
                if($login_user){
                    echo 'New User Created !!';
                }  
                
                $user = get_user_by('login', $mobileNumber);
                $user_id=$user->data->ID;

                // Update the user
                $user_data = array(
                    'ID'            => $user_id,
                    'first_name'    => $firstName,
                    'last_name'     => $lastName,
                    'user_nicename' => $firstName.'-'.$lastName,
                    'display_name'  => $firstName.'_'.$lastName,
                    'role'          => 'customer',
                );
                $result = wp_update_user($user_data);
                if (is_wp_error($result)) {
                    $error_message = $result->get_error_message();
                    echo "Error updating user: $error_message";
                } 
                else {
                    echo "User updated successfully";
                }
                update_user_meta( $user_id, 'gender', $gender );       
                update_user_meta( $user_id, 'age', $age );
                update_user_meta( $user_id, 'pincode', $pincode );

                if($login_user)
                {
                    $login_user_data = array(
                        'user_login'    => $mobileNumber,  // user_login.
                        'user_password' => $mobileNumber,   // login password.
                    );
                    $users = wp_signon( $login_user_data);
                    if ( ! is_wp_error($users) ) {
                        echo 'user login Success !!';
                    }
                }
                echo "<pre>";
                print_r($json_decoded);
                echo "</pre>";
                break;
            }

     die();
    }
    
    /*
    ================================================================
    ================================================================
     **  Get category list api **
    ================================================================
    ================================================================
    */
    function tingl_get_categorylist_callback(){
        $objapi = new adAPI();
        $postapiData = $objapi->categoryList();
        $decrypt_value = openssl_decrypt($postapiData, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
        $json_decoded = json_decode($decrypt_value);
        if(is_admin()){
            foreach($json_decoded->details as $cat)
            {
                $cat_name = $cat->category_name;
                $cat_image  = $cat->category_image;
                $cat_id  = $cat->id;
                $image_path = 'https://hlik-deep-bhaumik.s3.amazonaws.com/tingl/dish/64a696d1e24831688639185.jpg'; // Replace with the actual image URL

                // Check if the category already exists
                if (!term_exists($cat_name, 'product_cat')) {
                    // Category doesn't exist, so insert it
                    $term = wp_insert_term($cat_name, 'product_cat', array(
                        'slug' => sanitize_title($cat_name)
                    ));
                    $term_id = $term['term_id'];

                    add_term_meta($term_id ,'_cat_id_api',$cat_id);
                
                    if (!is_wp_error($term) && isset($term['term_id'])) {
                        //$term_id = $term['term_id'];
                        $image_url = media_sideload_image($image_path , $term_id, '', 'id');
                        if (!is_wp_error($image_url)) {
                            update_term_meta($term_id, 'thumbnail_id', $image_url);
                        } else {
                            echo 'Error uploading category image: ' . $image_url->get_error_message();
                        }
                    } else {
                        echo 'Error inserting category: ' . $term->get_error_message();
                    }
                }else{
                    if( $term = get_term_by('name',$cat_name ,'product_cat' ) ){
                        if($cat_name != $term->name){
                            wp_delete_category($term->term_id);
                        }
                        /*  echo "<pre>";
                        print_r($term);
                        $image =  get_term_meta($term->term_id);
                        print_r($image); */ 
                    }
                }
            }
           // die();
        }
    }
    /*
    ================================================================
    ================================================================
     **  Get dish list api **
    ================================================================
    ================================================================
    */
    
    function tingl_get_dishlist_callback()
    {
        $objapi = new adAPI();
        $param = array('categoryId'=> '0','page' => '1');
        $json_encoded = json_encode($param);
        $encryptedData = openssl_encrypt( $json_encoded, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
        $postapiData = $objapi->dishList($encryptedData);
        $decrypt_value = openssl_decrypt($postapiData, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
        $json_decoded = json_decode($decrypt_value);
        foreach($json_decoded->details as $product_api)
        {
            $product_sku = $product_api->id; 
            $product_id = wc_get_product_id_by_sku( $product_sku );
            $product = new WC_Product_Simple();
            if (!$product_id ) {
                $product->set_sku( wc_clean( $product_api->id) );

                $product->set_name( $product_api->dish_name ); // product title

                $product->set_slug (sanitize_title( $product_api->dish_name ));
        
                $product->set_regular_price( $product_api->price ); 
                
                $product->set_sale_price( $product_api->price );

                $product->set_description( $product_api->description );
                
                $term = get_term_by('name', $product_api->category_name ,'product_cat' ) ;

                $product->set_category_ids( array( $term->term_id ) );

                //$product->set_image_id( 90 ); set image 
                $image_path = 'https://hlik-deep-bhaumik.s3.amazonaws.com/tingl/dish/64a696d1e24831688639185.jpg';
                $attachment_id = media_sideload_image($image_path, $product->id, 'Product Image Description','id');
                $product->set_image_id( $attachment_id ); //  update image  

                
                $attributes = array();
                $attribute = new WC_Product_Attribute();
                $attribute->set_name( 'protein' );
                $attribute->set_visible( true );
                $attribute->set_variation( true );
                $attribute->set_position( 0 );
                $attribute->set_options( array($product_api->protein));
                $attributes[] = $attribute;
                $product->set_attributes( $attributes );
                
                $attribute = new WC_Product_Attribute();
                $attribute->set_name( 'fat' );
                $attribute->set_visible( true );
                $attribute->set_variation( true );
                $attribute->set_options( array($product_api->fat ));
                $attributes[] = $attribute; 
                $product->set_attributes( $attributes );
                
                $attribute = new WC_Product_Attribute();
                $attribute->set_name( 'carbohydrate' );
                $attribute->set_visible( true );
                $attribute->set_variation( true );
                $attribute->set_options( array($product_api->carbohydrate ));
                $attributes[] = $attribute; 
                $product->set_attributes( $attributes );
                
                $attribute = new WC_Product_Attribute();
                $attribute->set_name( 'fiber' );
                $attribute->set_visible( true );
                $attribute->set_variation( true );
                $attribute->set_options( array($product_api->fiber));
                $attributes[] = $attribute;
                $product->set_attributes( $attributes );
                
                $attribute = new WC_Product_Attribute();
                $attribute->set_name( 'allergies' );
                $attribute->set_visible( true );
                $attribute->set_variation( true );
                $attribute->set_options( array($product_api->allergies ) );
                $attributes[] = $attribute;
                $product->set_attributes( $attributes ); 
                $product->save(); 

            }else {
                    /* update product */
                    $product = wc_get_product($product_id);
                    // echo $product->id;
                
                    $product->set_name($product_api->dish_name); // Update the product title
                    $product->set_slug(sanitize_title($product_api->dish_name));
                    $product->set_regular_price($product_api->price);
                    $product->set_sale_price($product_api->price);
                    $product->set_description($product_api->description);
                    /*  $image_path = 'https://hlik-deep-bhaumik.s3.amazonaws.com/tingl/dish/64a696d1e24831688639185.jpg';
                    //  $attachment_id = media_sideload_image($product_api->dish_image, 0);
                    //  $attachment_id = media_sideload_image($image_path, 0);
                        $attachment_id = media_sideload_image($image_path, $product->id, 'Product Image Description','id');
                    //   echo $attachment_id;
                    
                    
                    $product->set_image_id( $attachment_id ); //  update image   */

                    $attribute = new WC_Product_Attribute();
                    $attribute->set_name( 'protein' );
                    $attribute->set_visible( true );
                    $attribute->set_variation( true );
                    $attribute->set_position( 0 );
                    $attribute->set_options( array($product_api->protein));
                    $attributes[] = $attribute;
                    $product->set_attributes( $attributes );
                
                    $attribute = new WC_Product_Attribute();
                    $attribute->set_name( 'fat' );
                    $attribute->set_visible( true );
                    $attribute->set_variation( true );
                    $attribute->set_options( array($product_api->fat ));
                    $attributes[] = $attribute; 
                    $product->set_attributes( $attributes );
                    
                    $attribute = new WC_Product_Attribute();
                    $attribute->set_name( 'carbohydrate' );
                    $attribute->set_visible( true );
                    $attribute->set_variation( true );
                    $attribute->set_options( array($product_api->carbohydrate ));
                    $attributes[] = $attribute; 
                    $product->set_attributes( $attributes );
                    
                    $attribute = new WC_Product_Attribute();
                    $attribute->set_name( 'fiber' );
                    $attribute->set_visible( true );
                    $attribute->set_variation( true );
                    $attribute->set_options( array($product_api->fiber));
                    $attributes[] = $attribute;
                    $product->set_attributes( $attributes );
                    
                    $attribute = new WC_Product_Attribute();
                    $attribute->set_name( 'allergies' );
                    $attribute->set_visible( true );
                    $attribute->set_variation( true );
                    $attribute->set_options( array($product_api->allergies ) );
                    $attributes[] = $attribute;
                    
                    $product->set_attributes( $attributes ); 
            
                    // Update other product properties if needed

                    $product->save();
                        /* update product */
                }
                
                // Get the product object.
                $product = wc_get_product($product_id);
                $sku = $product->get_sku();
                if($sku){
                    if($sku != $product_api->id){
                        wp_delete_post($product_id);
                    }
                }
            }
                  
    }
   

    
function tingl_show_productby_category_callback()
{
	$cat_slug = $_POST['cat_slug'];

		$args = array(
			'post_type' => 'product',
            'posts_per_page' => '-1',
			'order'          => 'ASC',
			'orderby'        => 'date',
			'post_status'    => 'publish',
            'tax_query'       => array( 'relation' => 'OR',));  
             if(!empty(isset($_POST['cat_slug']))) {
                $arg =  array(
                'taxonomy' 	  => 'product_cat',
                        'field' 			=> 'term_id',
                        'terms' 			=> $_POST['cat_slug'],
                    );	
                array_push($args['tax_query'],$arg);	
            }
		$postslist = get_posts($args);

        if($postslist){
            foreach ($postslist as $post) {
                setup_postdata($post);
                $product_id = $post->ID;
                $_product = wc_get_product($product_id); 
                $sku = $_product->get_sku();

                ?>

                <div class="col-md-4">
                    <div class="shop-box">
                        <div class="shop-img">
                            <img src="<?php echo ($post->ID); ?>" class="img-fluid">
                        </div>
                        <div class="shop-desc">
                            <h3><?php echo $post->post_title ; ?></h3>
                            <p><?php if($_product->get_sale_price()) : echo  "₹".$_product->get_sale_price(); endif; ?> <label><del><?php echo "₹". $_product->get_regular_price(); ?></del></label></p>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#productdetailModal" data-pro-id = "<?php echo $sku; ?>" class="btn btn-primary w-100 dish_detail_btn"><?php echo esc_html( 'Add to cart' );?></a>
                        </div>
                    </div>
                </div>
              <?php
            }
        }else{ ?>
        <div class="col-md-4">
            <?php echo  "No post found"; ?>
        </div>
       <?php }   
    wp_reset_postdata();
	wp_die();
}

/*
================================================================
================================================================
    **  dish detail api **
================================================================
================================================================
*/

function tingle_get_dish_detail_callback(){

    $dishId = $_POST['dishId'];
    $objapi = new adAPI();
    $param = array('dishId'=> $dishId );
    $json_encoded = json_encode($param);
    $encryptedData = openssl_encrypt( $json_encoded, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
    $postapiData = $objapi->dishDetail($encryptedData);
    $decrypt_value = openssl_decrypt($postapiData, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
    $json_decoded = json_decode($decrypt_value);
    
    if ($json_decoded->code == 1) {
        $response = array(
            'details' => $json_decoded->details
        );
    }  
    wp_send_json($response);
    die();

}


/*
================================================================
================================================================
    **  edit user profile detail api **
================================================================
================================================================
*/

function tingle_update_edit_profile_callback(){

    $objapi = new adAPI();
    if (isset($_SESSION['token']) && $_SESSION['token'] !== '') {
        $encryptedtoken = $_SESSION['token'];
	} 
    $formdata = $_POST['formdata'];

    $firstName = $formdata['firstname'];
    $lastName = $formdata['lastname'];
    $age = $formdata['age'];
    $weight = $formdata['weight'];
    $birthdate = $formdata['birthdate'];
    $email = $formdata['email'];
    $gender = $formdata['gender'];
    $height = $formdata['height'];
    echo $formattedDate = date("d-m-Y", strtotime($birthdate));


    $param = array('firstName'=> $firstName,'lastName'=> $lastName,'age'=> $age ,'email'=>$email,'gender'=>$gender,'weight'=>$weight ,'height' =>$height, 'birthDate' => $formattedDate );
    $json_encoded = json_encode($param);

    echo $encryptedData = openssl_encrypt( $json_encoded, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
    echo $postapiData = $objapi->editProfile($encryptedData,$encryptedtoken);
    $decrypt_value = openssl_decrypt($postapiData, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
    $json_decoded = json_decode($decrypt_value);
    
   $response =  $json_decoded;
   echo "<pre>";  
   print_r($response);
   echo "</pre>";  

    wp_send_json($response);
    die();

}

function tingl_addAddress_callback(){
    $objapi = new adAPI();
    if (isset($_SESSION['token']) && $_SESSION['token'] !== '') {
        $encryptedtoken = $_SESSION['token'];
	} 
    
    echo $encryptedtoken;

    $address_full = $_POST['address'];
    $flatno = $_POST['flatno'];
    $landmark = $_POST['landmark'];

    $param = array('address'=> $address_full,'flatno'=> $flatno,'landmark'=> $landmark ,'addressType'=>'Office','latitude'=>'19.34','longitude'=> '21.45' ,'addressTag' => 'My office');
    $json_encoded = json_encode($param);

    $encryptedData = openssl_encrypt( $json_encoded, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
    $postapiData = $objapi->addAddress($encryptedData,$encryptedtoken);
    $decrypt_value = openssl_decrypt($postapiData, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
    $json_decoded = json_decode($decrypt_value);
    
   $response =  $json_decoded;
   echo "<pre>";  
   print_r($response);
   echo "</pre>";  

    wp_send_json($response);
    die();
}


function custom_add_product_to_cart() {
    if (isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);
        
        defined( 'WC_ABSPATH' ) || exit;

        $quantity = 1; // You can modify this if you want to add more than one quantity
          // Load cart functions which are loaded only on the front-end.
    include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
    include_once WC_ABSPATH . 'includes/class-wc-cart.php';

    if ( is_null( WC()->cart ) ) {
        wc_load_cart();
    }
        // Add the product to the cart
        $added_to_cart = WC()->cart->add_to_cart($product_id,$quantity);

        if ($added_to_cart) {
            echo 'Product added to cart successfully';
        } else {
            echo 'Failed to add the product to cart';
        }

        
        wp_die(); // This is required to terminate the script properly after AJAX request
    }
}
