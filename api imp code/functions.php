<?php
   add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
   function my_theme_enqueue_styles() {
       wp_enqueue_style ( 'parent-style', get_template_directory_uri() . '/style.css'     , array());
       wp_enqueue_style ( 'child-style' , get_stylesheet_directory_uri().'/css/style.css' , array());
       wp_enqueue_script( 'jquery-min-js'   , 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js'  , array(),rand(), false );
       wp_enqueue_script( 'custom-js'   , get_stylesheet_directory_uri().'/js/custom.js'  , array(),rand(), true );
       $args = array('url'   => admin_url( 'admin-ajax.php' ),);
      wp_localize_script( 'custom-js', 'custom', $args );
    } 
    if ( ! function_exists('custom_post') ) {

        // Register Custom Post Type Poll
        function custom_post() {
        
            $labels = array(
                'name'                  => _x( 'Polls', 'Post Type General Name', 'twentytwentychild' ),
                'singular_name'         => _x( 'Poll', 'Post Type Singular Name', 'twentytwentychild' ),
                'menu_name'             => __( 'Poll', 'twentytwentychild' ),
                'name_admin_bar'        => __( 'Poll', 'twentytwentychild' ),
                'archives'              => __( 'Item Archives', 'twentytwentychild' ),
                'attributes'            => __( 'Item Attributes', 'twentytwentychild' ),
                'parent_item_colon'     => __( 'Parent Poll:', 'twentytwentychild' ),
                'all_items'             => __( 'All Polls', 'twentytwentychild' ),
                'add_new_item'          => __( 'Add New Poll', 'twentytwentychild' ),
                'add_new'               => __( 'Add Poll', 'twentytwentychild' ),
                'new_item'              => __( 'New Poll', 'twentytwentychild' ),
                'edit_item'             => __( 'Edit Poll', 'twentytwentychild' ),
                'update_item'           => __( 'Update Poll', 'twentytwentychild' ),
                'view_item'             => __( 'View Poll', 'twentytwentychild' ),
                'view_items'            => __( 'View Poll', 'twentytwentychild' ),
                'search_items'          => __( 'Search Poll', 'twentytwentychild' ),
                'not_found'             => __( 'Not found', 'twentytwentychild' ),
                'not_found_in_trash'    => __( 'Not found in Trash', 'twentytwentychild' ),
                'featured_image'        => __( 'Featured Image', 'twentytwentychild' ),
                'set_featured_image'    => __( 'Set featured image', 'twentytwentychild' ),
               
            );
            $args = array(
                'label'                 => __( 'Poll', 'twentytwentychild' ),
                'description'           => __( 'Post Type Description', 'twentytwentychild' ),
                'labels'                => $labels,
                'supports'              => array( 'title', 'thumbnail' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 5,
                'menu_icon'             => 'dashicons-dashboard',
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'show_in_rest'          => true,
            );
            register_post_type( 'Poll', $args );
        
        }
        $labels_poll_type = array(
            'name'                       => _x( 'Poll category', 'Taxonomy General Name', 'twentytwentychild' ),
            'singular_name'              => _x( 'poll Type', 'Taxonomy Singular Name', 'twentytwentychild' ),
            'menu_name'                  => __( 'poll Types', 'twentytwentychild' ),
            'all_items'                  => __( 'All poll Types', 'twentytwentychild' ),
            'parent_item'                => __( 'Parent poll Type', 'twentytwentychild' ),
            'parent_item_colon'          => __( 'Parent poll Type:', 'twentytwentychild' ),
            'new_item_name'              => __( 'poll Type ', 'twentytwentychild' ),
            'add_new_item'               => __( 'Add poll Type', 'twentytwentychild' ),
            'edit_item'                  => __( 'Edit poll Type', 'twentytwentychild' ),
            'update_item'                => __( 'Update poll Type', 'twentytwentychild' ),
            'view_item'                  => __( 'View poll Type', 'twentytwentychild' ),
            'separate_items_with_commas' => __( 'Separate Types with commas', 'twentytwentychild' ),
            'add_or_remove_items'        => __( 'Add or remove Types', 'twentytwentychild' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'twentytwentychild' ),
            'popular_items'              => __( 'Popular Types', 'twentytwentychild' ),
            'search_items'               => __( 'Search Types', 'twentytwentychild' ),
            'not_found'                  => __( 'Not Found', 'twentytwentychild' ),
            'no_terms'                   => __( 'No Types', 'twentytwentychild' ),
            'items_list'                 => __( 'Items list', 'twentytwentychild' ),
            'items_list_navigation'      => __( 'Items list navigation', 'twentytwentychild' ),
        );
        $args_poll_type = array(
            'labels'			  => $labels_poll_type,
            'hierarchical'		  => true,
            'public'		 	  => true,
            'show_ui'			  => true,
            'show_in_rest'		  => true,
            'show_admin_column'	  => true,
            'show_in_nav_menus'	  => true,
            'show_tagcloud'		  => true,
            'hierarchical'        => false,
        );
        register_taxonomy( 'poll_type', array( 'poll' ), $args_poll_type );


        add_action( 'init', 'custom_post', 0 );
        
        }

        /* Code for adding ACF to default rest API */
        
        function create_ACF_meta_in_REST() {
          $postypes_to_exclude = ['acf-field-group','acf-field'];
          $extra_postypes_to_include = ["poll"];
          $post_types = array_diff(get_post_types(["poll" => false], 'post'),$postypes_to_exclude);
      
          array_push($post_types, $extra_postypes_to_include);
      
          foreach ($post_types as $post_type) {
              register_rest_field( $post_type, 'ACF', [
                  'get_callback'    => 'expose_ACF_fields',
                  'schema'          => null,
             ]
           );
          }
      
      }
      
      function expose_ACF_fields( $object ) {
          $ID = $object['id'];
          return get_fields($ID);
      }
      
      add_action( 'rest_api_init', 'create_ACF_meta_in_REST' );
     

    function wc_rest_post_create($request){
        /* if(FSS_DEBUG == true){
          global $log;
          $log->log(print_r($request,true), FileLogger::WARNING);
        } */
        /* echo "<pre>";
        print_r($request);
        echo "</pre>";
        die; */
        $post_title = $request->get_param('post_title');
        $post_type = $request->get_param('post_type');
        $post_status = $request->get_param('post_status');
        $post_author = $request->get_param('post_author');
        $post_category = $request->get_param('post_category');
        $poll_question = $request->get_param('poll_question');
        $answer = $request->get_param('answer');
        
        $error = new WP_Error();
        if (empty($post_title)) {
          $error->add(401, __("title field is required.", 'wp-rest-user'), array('status' => 400));
          return $error;
        }
        if (empty($post_type)) {
          $error->add(401, __("type field is required.", 'wp-rest-user'), array('status' => 400));
          return $error;
        }
          if (empty($post_status)) {
            $error->add(401, __("status field is required.", 'wp-rest-user'), array('status' => 400));
            return $error;
          }
          if (empty($post_author)) {
            $error->add(401, __("author field is required.", 'wp-rest-user'), array('status' => 400));
            return $error;
          }
          if (empty($post_category)) {
            $error->add(401, __("category field is required.", 'wp-rest-user'), array('status' => 400));
            return $error;
          } 
          if (empty($poll_question)) {
            $error->add(401, __("poll_question field is required.", 'wp-rest-user'), array('status' => 400));
            return $error;
          }
        
        if (empty($post_title) == false) {
            $new = array(
                'post_type'    => $post_type,
                'post_title'   => $post_title,
                'post_status'  => $post_status,
                'post_author'  => $post_author,
                'post_category'=> $post_category,
                'meta_input'   => array(
                    'question' => $poll_question,
                    'options' => true,
                      'options_0_text_option' => $answer[0],
                      'options_1_text_option' => $answer[1],
                      'options_2_text_option' => $answer[2],
                ),
            );

            $post_id = wp_insert_post( $new );
            if( $post_id ){
                $response['code'] = 200;
                $response['message'] = __("Post  '" . $post_title . "'Successfully published", "wp-rest-user");
                $response['userdata'] = $post_id;
            } else {
                echo "Something went wrong, try again.";
            }
        } else {
          $error->add(406, __("post not created ", 'wp-rest-user'), array('status' => 400));
          return $error;
        }
        return new WP_REST_Response($response, 123);
    } 
      function wc_rest_post_delete($request){
        $post_id = $request->get_param('post_id');
        $error = new WP_Error();
        if (empty($post_id)) {
          $error->add(401, __("id field is required.", 'wp-rest-user'), array('status' => 400));
          return $error;
        }
        if (empty($post_id) == false) {
            $delete = wp_delete_post($post_id, false );
           
            if( $delete ){
                $response['code'] = 200;
                $response['message'] = __("Post  '" . $post_id . "'Successfully deleted", "wp-rest-user");
                $response['userdata'] = $post_id;
            } else {
                echo "Something went wrong, try again.";
            }
        } else {
          $error->add(406, __("post not deleted ", 'wp-rest-user'), array('status' => 400));
          return $error;
        }
        return new WP_REST_Response($response, 123);
      } 

      function wc_rest_post_update($request){
        $post_title = $request->get_param('post_title');
        $post_type = $request->get_param('post_type');
        $post_status = $request->get_param('post_status');
        $post_author = $request->get_param('post_author');
        $post_category = $request->get_param('post_category');
        $poll_question = $request->get_param('poll_question');
        $answer = $request->get_param('answer');
        
        $error = new WP_Error();
        if (empty($post_title)) {
          $error->add(401, __("title field is required.", 'wp-rest-user'), array('status' => 400));
          return $error;
        }
        if (empty($post_type)) {
          $error->add(401, __("type field is required.", 'wp-rest-user'), array('status' => 400));
          return $error;
        }
          if (empty($post_status)) {
            $error->add(401, __("status field is required.", 'wp-rest-user'), array('status' => 400));
            return $error;
          }
          if (empty($post_author)) {
            $error->add(401, __("author field is required.", 'wp-rest-user'), array('status' => 400));
            return $error;
          }
          if (empty($post_category)) {
            $error->add(401, __("category field is required.", 'wp-rest-user'), array('status' => 400));
            return $error;
          } 
          if (empty($poll_question)) {
            $error->add(401, __("poll_question field is required.", 'wp-rest-user'), array('status' => 400));
            return $error;
          }
        
          $new = array(
            'post_type'    => $post_type,
            'post_title'   => $post_title,
            'post_status'  => $post_status,
            'post_author'  => $post_author,
            'post_category'=> $post_category,
            'meta_input'   => array(
                'question' => $poll_question,
                'options' => true,
                    'text_option' => $answer,
                
            ),
        );
        if (empty($new) == false) {
            $post_id = wp_update_post( $new );
            if( $post_id ){
                $response['code'] = 200;
                $response['message'] = __("Post  '" . $post_title . "'Successfully updated", "wp-rest-user");
                $response['userdata'] = $post_id;
            } else {
                echo "Something went wrong,try again.";
            }
        } else {
          $error->add(406, __("post not created ", 'wp-rest-user'), array('status' => 400));
          return $error;
        }
        return new WP_REST_Response($response, 123);
      }

      add_action( 'rest_api_init',  'register_rest_routes'  );

       function register_rest_routes(){

        register_rest_route('wp/v2', 'polls/create', array(
            'methods' => 'POST',
            'callback' => 'wc_rest_post_create'
          ));
          register_rest_route('wp/v2', 'polls/delete', array(
            'methods' => 'POST',
            'callback' => 'wc_rest_post_delete'
          ));
          register_rest_route('wp/v2', 'polls/update', array(
            'methods' => 'POST',
            'callback' => 'wc_rest_post_update'
          ));
          register_rest_route('wp/v2', '/poll_post', array(
            'methods' => 'GET',
            'callback' => 'wp_create_endpoint'
          ));
          

        }


      function wp_create_endpoint(){
      /*   $query = new WP_Query(
          array(
             'posts_per_page' => 5, 
             'post_type'      => 'poll',
             'post_status'    => 'publish',
             'meta_key'	  => 'question',
                array(
                  'key'		  => 'options',
                )
             ) );

             global $wpdb;
             $results = $wpdb->get_results( 'SELECT * FROM wp_options WHERE option_id = 1', OBJECT );
            $post_last_modify_english = $wpdb->get_results("SELECT ID,post_title  FROM $wpdb->posts  WHERE $wpdb->posts.post_type = 'topic'");
            $new_topics_today = $wpdb->get_results("SELECT ID,post_title, post_ FROM $wpdb->posts  WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'poll'  ");
             */

             $args = array(
              'post_type' => 'poll',
              'numberposts' => -1,
              'meta_key' => 'question', 
            );
            $args_polls = get_posts($args);

            foreach ($args_polls  as $args_poll){
              $all_fields = get_fields($args_poll->ID);
              $title = $args_poll->post_title;
              $image =  get_the_post_thumbnail_url($args_poll->ID);
              $date =  $args_poll->post_date;

              $all_data[] =  array('Title' => $title, 'Meta Fields' => $all_fields , 'Image' =>  $image , 'Date' => $date); 
            }

            $json_encoded = json_encode($all_data);
            print_r($json_encoded);
          
            $ciphering = "BF-CBC";
            $iv_length = openssl_cipher_iv_length($ciphering);
            $options = 0;   
            $encryption_iv = random_bytes($iv_length);
            $encryption_key = openssl_digest(php_uname(), 'MD5', TRUE);
            $encryption = openssl_encrypt($json_encoded, $ciphering, $encryption_key, $options, $encryption_iv);

            /* echo "<pre>";
            print_r($encryption);
            echo "</pre>"; */

            $decryption_iv = random_bytes($iv_length);
            $decryption_key = openssl_digest(php_uname(), 'MD5', TRUE);
            $decryption = openssl_decrypt ($encryption, $ciphering,
            $decryption_key, $options, $encryption_iv);
           /*  echo "<pre>";
            print_r($decryption);
            echo "</pre>"; */
      }

    function create_post(){
        $new = array(
            'post_type'    => 'poll',
            'post_title'   => 'Test New Poll with 2 option',
            'post_status'  => 'publish',
            'tax_input'    => array(
                  'poll_type' => array(5)
          ),
            'meta_input'   => array(
                'question' => 'test_meta_key',
                'options'  => true,
                  'options_0_text_option' => 'yufgadcgh' ,
                  'options_1_text_option' => 'test'
                  ) 
                );
        $post_id = wp_insert_post( $new );
        if( $post_id ){
            echo "Post successfully published!";
        } else {
            echo "Something went wrong, try again.";
        }
    } 
    //add_action('wp','create_post');  

   /*  add_filter( 'acf/rest_api/recursive/types', function( $types ) {
      if ( isset( $types['poll'] ) ) {
        unset( $types['poll'] );
      }
    
      return $types;
    } );
 */



function wpb_cookies_tutorial2() { 
  // Time of user's visit
  $visit_time = date('F j, Y g:i a');
  // Check if cookie is already set
  if(isset($_COOKIE['wpb_visit_time'])) {
   
  // Do this if cookie is set 
  function visitor_greeting() {
    $string = '';
   
    // Use information stored in the cookie 
    $lastvisit = $_COOKIE['wpb_visit_time'];

    $string .= 'You last visited our website '. $lastvisit .'. Check out whats new'; 
    
    return $string;
  }   
   
  } else { 
   
    // Do this if the cookie doesn't exist
    function visitor_greeting() { 
      $string = '';
      $string .= 'New here? Check out these resources...' ;
      return $string;
    }   
      // Set the cookie
      setcookie('wpb_visit_time',  $visit_time, time()+31556926);
    }
   
    // Add a shortcode 
    add_shortcode('greet_me', 'visitor_greeting');
   
  } 
  add_action('init', 'wpb_cookies_tutorial2');

  function radio_cookie_set(){
   echo  $checked_value = $_POST['page']; ?>
     <span id="radiovalue" data-options="<?php echo  $checked_value; ?>"></span>
     
    <?php


   // die;
  }
