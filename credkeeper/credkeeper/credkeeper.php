<?php 
/*
Plugin Name: CredKEEPER - Increase Your Website Traffic.  Enhance your and your site's Credibility.
Plugin URI: http://bytestechnolab.com/
Description: Magnify Content - Increase Traffic - CredKeeper Manages the Creation, Publication, Optimization, and Distribution of your site's content, significantly improving your overall visibility and Credibility.
Author: Bytesteam
Version: 1.1.6
Author URI: http://bytestechnolab.com/
Text Domain: agentdirectory
*/
define("IS_DUMMY_WEBSTIE",true);

if ( ! defined( 'ABSPATH' ) ) {
	die( '<h3>Direct access to this file do not allow!</h3>' );
}

if ( ! function_exists( 'get_plugin_data' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

$plugin = get_plugin_data(__FILE__ );

define( 'AGET_VERSION', $plugin['Version'] );

define("AD_PLUGIN_URL",plugin_dir_url( __FILE__ ));
define( 'AD_FILE', __FILE__ );
define( 'AD_FILENAME', basename( __FILE__ ) );
define( 'AD_PLUGIN_NAME', plugin_basename( dirname( __FILE__ ) ) );
define( 'AD_PLUGIN_DIR', untrailingslashit( plugin_dir_path( AD_FILE ) ) );
define( 'AD_BASE_URL_PLUGIN', untrailingslashit( plugins_url( '', AD_FILE ) ) );


define('SECRET_KEYS', '6LfpQBEbAAAAAACiEEKK_pAMe3MePJEky_Omb7A8');
define('SITE_KEY', '6LfpQBEbAAAAAFsjqe7Sytfs1fx3Zym-1TS5esAX');
define('RECAPTACH_MESSAGE', 'Please verify you are not a robot.');

require_once AD_PLUGIN_DIR . '/bytes-technolab-basic-auth-master.php';


if(IS_DUMMY_WEBSTIE){
	require_once AD_PLUGIN_DIR . '/dummay.php';
}else{
	require_once AD_PLUGIN_DIR . '/production.php';
}

require_once AD_PLUGIN_DIR . '/lib/set_post_tag_categories_via_rest.php';

add_action( 'activated_plugin', 'agent_activation_redirect' );

function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
} 

function agent_activation_redirect( $plugin ) 
{
    if( $plugin == plugin_basename( __FILE__ ) ) 
    {
        exit( wp_redirect( admin_url( '/admin.php?page=agentdir' ) ) );
    }
} 

register_activation_hook( __FILE__, 'insert_page_new_pages' );

function wpad_scripts()
{
	if ( is_page(299)){
	
	wp_enqueue_script( 'jquery-min-js', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js' );
	 //wp_deregister_script( 'google-recaptcha' );
     //wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js?hl=en_US&onload=recaptchaCallback&render=explicit&ver=2.0', array(), 2.0);
      
    }

	/* New Add css And Js New Design 31-01-2019*/
	
	wp_enqueue_style( 'font-awesome', AD_PLUGIN_URL . 'css/font-awesome.min.css' );
	//wp_enqueue_script( 'jquery', AD_PLUGIN_URL . '/js/jquery.min.js', 'jQuery', AGET_VERSION, true );

	//wp_enqueue_style( 'bootstrap-min-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' );

	/* End Add css And Js New Design 31-01-2019*/	

	//wp_enqueue_style( 'our-agent-css', AD_PLUGIN_URL . 'css/our-agent.css' );
	//wp_enqueue_style( 'bootstrap-min', AD_PLUGIN_URL . 'css/bootstrap.min.css' );
	
	wp_enqueue_style( 'magnific-popup-css', AD_PLUGIN_URL . 'css/magnific-popup.css' );
	//wp_enqueue_style( 'ad-style', AD_PLUGIN_URL . 'css/ad-style.css' );
	if(!is_front_page()){
		wp_enqueue_style( 'style', AD_PLUGIN_URL . 'css/style.css',null,rand());
	}
	
    wp_enqueue_script( 'magnific-popup-js', AD_PLUGIN_URL . '/js/jquery.magnific-popup.min.js', 'jQuery', AGET_VERSION, true );

   //wp_enqueue_script( 'reCaptcha-script','https://www.google.com/recaptcha/api.js',array( ),false, false );

	wp_enqueue_script( 'custom-script-ad', AD_PLUGIN_URL . '/js/custom-script.js', 'jQuery', rand(), true );
	wp_localize_script( 'custom-script-ad', 'script_adurl', array( 'ajax_url' => admin_url('admin-ajax.php'),'plugin_url' => AD_PLUGIN_URL,'site_key'=> SITE_KEY) );
	
	wp_deregister_script( 'twenty-twenty-one-primary-navigation-script');

}

add_action( 'wp_enqueue_scripts', 'wpad_scripts' );

/*Add For Admin Side Css And Script*/

//add_action( 'admin_enqueue_scripts', 'wpad_scripts' );

function insert_page_new_pages()
{
	// Create post object
    $agent_search_page = array(
      'post_title'    => 'Agent Search',
      'post_content'  => '[list_agentDr]',
      'post_status'   => 'publish',
      'post_author'   => get_current_user_id(),
      'post_type'     => 'page',
    );
	
	/*$agent_details_page = array(
      'post_title'    => 'Agent Details',
      'post_content'  => '[get_agent_by_id]',
      'post_status'   => 'publish',
      'post_author'   => get_current_user_id(),
      'post_type'     => 'page',
    );
	*/
    // Insert the post into the database
    wp_insert_post( $agent_search_page, '' );
	$DetialspageID = wp_insert_post( $agent_details_page, '' );
	isset($DetialspageID)? add_option( 'agent_details_page_id', $DetialspageID): '';
	flush_rewrite_rules();	
}


/* 
	added new serach as per new XD 
*/

add_filter( 'query_vars', function( $query_vars ) {
    $query_vars[] = 'wpusername';
    $query_vars[] = 'agentid';
    return $query_vars;
} );

/*add_action( 'template_include', function( $template ) {
    if ( get_query_var( 'agnetusername' ) == false || get_query_var( 'agnetusername' ) == '' ) {
        return $template;
    }
 	//var_dump(AD_PLUGIN_DIR . 'templates/agent-details.php');die();
    return  AD_PLUGIN_DIR . '/templates/agent-details.php';
} );*/

add_action( 'init', 'init_custom_rewrite' );
function init_custom_rewrite() 
{
	//$DetialspageID = get_option('agent_details_page_id');
	
	add_rewrite_rule(        
		'^agent-detail/([^/]*)/([\w+]*)?',        
		'index.php?page_name=agent-detail&wpusername=$matches[1]&agentid=$matches[2]',        
		'top' );
}

/* 
	added new serach as per new XD END
*/

require_once AD_PLUGIN_DIR . '/lib/adminagentMenu.php';
	
function get_Token()
{
	 $options = get_option( 'agentdir_options' );
	 return $options['agentdirtokan'];
}

function get_Limit()
{
	 $options = get_option( 'agentdir_options' );
	 return $options['agentdirlimit'];
}

if ( ! class_exists( 'adAPI' ) ) 
{
	require_once AD_PLUGIN_DIR . '/api/adAPIClass.php';
}

/*
function get_adbyzipcode()
{

	$objapi = new adAPI();
	if (! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'searchbyzipcode' ) ) 
	{
		echo errorMessage('Sorry, your nonce did not verify.');
		exit;

	}
	elseif(isset($_REQUEST['zipcode']) && !empty($_REQUEST['zipcode']))
	{
		echo $_REQUEST['zipcode'];
		$post = ['page'  => 1,'postcode'   => $_REQUEST['zipcode']];
		$data = $objapi->getAgentList($post);
		if(count($data) > 0 )
		{
			if($data->error == 1)
			{
				echo errorMessage($data->message);
			}
			else
			{
				echo print_agent($data);
			}
		}
		
	}
	elseif(empty($_REQUEST['zipcode']))
	{
		
		$post = ['page'  => 1];
		$data = $objapi->getAgentList($post);
		if(count($data) > 0 )
		{
			if($data->error == 1)
			{
				echo errorMessage($data->message);
			}
			else
			{
				echo print_agent($data);
			}
		}
	}	
	else 
	{
		echo errorMessage("Please Enter ZipCode");
	}	
}
function errorMessage($errorText){
	return '<p class="error error-agnet-not-fond">'.$errorText.'</p>';
}
*/

function print_agent($data){
	//$output	= '';
	//echo "<pre>";print_r($data);
	return $data;
}

## Single Agent Details Call By USER NAME in URL #####
/*
function print_AgentDetail($data)
{
	// echo "<pre>";
	// print_r($data);
	// echo "</pre>";
	?>
	<table class="table table-striped table-dark agentdetail">
		<tbody>
			<tr>
				<td>First Name</td>
				<td><?php echo $data->data->first_name; ?></td>
			</tr>
			<tr>
				<td>Last Name</td>
				<td><?php echo $data->data->last_name; ?></td>
			</tr>
			<tr>
				<td>Firm</td>
				<td><?php echo $data->data->firm; ?></td>
			</tr>
			<tr>
				<td>Title</td>
				<td><?php echo $data->data->title; ?></td>
			</tr>
			<tr>
				<td>City</td>
				<td><?php echo $data->data->city; ?></td>
			</tr>
			<tr>
				<td>State</td>
				<td><?php echo $data->data->gujrat; ?></td>
			</tr>
			<tr>
				<td>Zipcode</td>
				<td><?php echo $data->data->zipcode; ?></td>
			</tr>
			<tr>
				<td>Phone</td>
				<td><?php echo $data->data->phone; ?></td>
			</tr>
			<tr>
				<td>Website</td>
				<td><?php echo $data->data->website; ?></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><?php echo $data->data->address; ?></td>
			</tr>
			<tr>
				<td>Subscription</td>
				<td><?php echo $data->data->subscription; ?></td>
			</tr>
			 <tr>
				<td>Contact</td>
				<td>
					<div id="popup-with-form">
                        <button class="btn agent-lead-btn agent-listing" data-id="<?php echo $membership_id; ?>" type="button">
                        	Contact
                    	</button>
                     </div>
				</td>
			</tr> 

		</tbody>
	</table>

	<div class="agent-form-style modal-content mfp-hide white-popup-block">
                        <form id="agentleadadd" class=" ">
                            <div class="modal-header">
                                <h4 class="modal-title ng-binding">Lead Agent From</h4>
                            </div>
                            <div class="form-horizontal">
                                <ul>
                                    <li class="form-group">
                                        <div class="col-sm-3 text-right">
                                            <label class="control-label" for="name">First Name :</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="name" name="first_name" type="text" placeholder="Name" required>
                                        </div>
                                    </li>
                                     <li class="form-group">
                                        <div class="col-sm-3 text-right">
                                            <label class="control-label" for="name">Last Name :</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="name" name="last_name" type="text" placeholder="Name" required>
                                        </div>
                                    </li>
                                    <li class="form-group">
                                        <div class="col-sm-3 text-right">
                                            <label class="control-label" for="email">Email :</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="email" name="email" type="email" placeholder="Email" required>
                                        </div>
                                    </li>
									<li class="form-group">
                                        <div class="col-sm-3 text-right">
                                            <label class="control-label" for="phone">Phone :</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="phone" name="phone" type="tel" placeholder="Mobile Number" required>
                                        </div>
                                    </li>
                                    <li class="form-group">
                                        <div class="col-sm-3 text-right">
                                            <label class="control-label" for="city">City :</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="city" name="city" type="text" placeholder="City" required>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="modal-footer">
                                <input type="submit" class="submit btn btn-primary" name="savepostlead" value="Save Lead">
                                <input type="hidden" name="action" value="savepostlead">
                                <?php echo wp_nonce_field('savepostlead' ); ?>
                                    <input type="hidden" id="popupagentida" name="agentid" value="<?php echo $_REQUEST['id'];?>">
                            </div>
                           
                        </form>
                        <div id="agent-lead-response-msg"></div>
                    </div>
	<?php
}

function list_agentDr()
{
	$objapi = new adAPI();
	//$post = ['page'  => 1];
	
	$data = $objapi->getAgentList($post);
	
	$output =''; 
	// $outputf	.= '<form id="user-search" method="post">';
	// $outputf	.= '<input type="text" name="zipcode" >';
	// $outputf	.= '<input class="searchbyzipcode" required="required" type="submit" name="Search" >';
	// $outputf	.= '<input value="searchbyzipcode" type="hidden" name="action" >';
	// $outputf	.=  wp_nonce_field('searchbyzipcode' );
	// $outputf	.= '</form>';
	$outputf .= '<div class="form-horizontal searchbg">
				    <div class="form-group">
				        <div class="searchform form-horizontal">
				            <form id="user-search" method="post">
								<input type="text" class="form-control" name="zipcode">
								<input class="searchbyzipcode btn sitebtn search-agent-btn" required="required" type="submit" name="Search" value="Search">
								<input value="searchbyzipcode" type="hidden" name="action" >'.
								wp_nonce_field('searchbyzipcode' ).'
							</form>
				        </div>
				    </div>
				</div>';
	
	echo $outputf;
	echo '<div class="ad-list-main">';
		
	if(!empty($data))
	{
		if($data->error == 1){
			echo $data->message;
		} else {
			echo print_agent($data);				
		}
	}
	echo '</div>'; 
	
}
*/
## All Shotcode ADD shortCode ####

add_shortcode( "list_agentDr" ,'list_agentDr');
add_shortcode( "get_agent_by_id" ,'get_agent_by_id_shortcode');

## Plugin Deactiveation Hook ##############

register_deactivation_hook( __FILE__, 'ad_myplugin_deactivate' );

function ad_myplugin_deactivate()
{
	
	delete_option( 'agentdir_options');
	delete_option( 'agent_details_page_id' );
}

/*
function print_array($arraybuity)
{
	echo "<pre>";
	print_r($arraybuity);
	echo "</pre>";
	die();
}*/


function more_post_ajax(){
    $response = array('success' => true , 'html' => '', 'all_load' => false );

    $post_per_page = 3;
    $paged = (isset($_POST['paged'])) ? $_POST['paged'] : 1;
    $authorID = (isset($_POST['authorID'])) ? $_POST['authorID'] : 1;
    
    $args = array(
        'suppress_filters' => true,
        'post_type' => 'post',
        'author'        =>  $authorID,
        'posts_per_page' => $post_per_page,
        'paged'    => $paged,
    );

    $total_args = array(
        'suppress_filters' => true,
        'post_type' => 'post',
        'author'        =>  $authorID,
        'posts_per_page' => -1,        
    );

    $loadedArticle = $paged * $post_per_page;
    $totalArticle = count(get_posts($total_args));
    $allloaded = false;
    if($totalArticle <= $loadedArticle ){
        $allloaded = true;
    }

    $loop = new WP_Query($args);
    global $post;

    $out = '';
    $counter = 0;
    if ($loop -> have_posts()) :  
        ob_start(); 
        while ($loop -> have_posts()) : $loop -> the_post();
	        $counter ++;
	        $article_image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'recent-post-image' );
	        $trimmed_content = wp_trim_words( $post->post_content, 20, '...' );
	         $articleURL = urlencode(get_permalink());
	        $articleTitle = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
	        $twitterURL = 'https://twitter.com/intent/tweet?text='.$articleTitle.'&amp;url='.$articleURL.'&amp;via=Crunchify';
	        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$articleURL;
	        $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$articleURL.'&amp;title='.$articleTitle;
        if($article_image){
            $article_image = 'https://cdn.shortpixel.ai/client/q_glossy,ret_img,w_632,h_334/'.$article_image[0];
        }else{
            $article_image = 'https://cdn.shortpixel.ai/client/q_glossy,ret_img,w_632,h_334/http://csm.demo1.bytestechnolab.com/wp-content/uploads/2020/12/safe-money.png';
        }       
        ?>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="published_content">
                <div class="published_main">
                <div class="published-img">
                    <figure>
                    <img alt="<?php echo get_the_title(); ?>" title="<?php echo get_the_title(); ?>" width="400px" height="400px" data-src="<?php echo $article_image; ?>"  src="<?php echo $article_image; ?>">
                    </figure>
                </div>
                <ul class="published-social-icon">
                    <li><a href="<?php echo $twitterURL;?>"><span class="icon-twitter"></span></a></li>
                    <li><a href="<?php echo $linkedInURL;?>"><span class="icon-linkedin"></span></a></li>
                    <li><a href="<?php echo $facebookURL;?>"><span class="icon-facebook"></span></a></li>
                </ul>
            </div>
                <div class="published-text">
                    <h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                     <p>
                        <?php 
                            if(!empty($trimmed_content)){
                                 echo $trimmed_content;  
                            }
                       ?>    
                    </p>
                </div>
            </div>
        </div>
        <?php
        endwhile;
        $AgentListHtml = ob_get_clean();
    endif;
    wp_reset_postdata();

    $response['html'] = $AgentListHtml;
    $response['all_load'] = $allloaded;

    wp_send_json( $response );
    die();
}

add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax');
add_action('wp_ajax_more_post_ajax', 'more_post_ajax');

class Agent_Call extends adAPI
{
		private static $instance;
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Agent_Call ) ) {
				self::$instance = new Agent_Call;
			}
			return self::$instance;
	 	}

		public function __construct() {

			parent::__construct();

			add_action("wp_ajax_searchbyzipcode", array($this,"get_adbyzipcode"));
			add_action("wp_ajax_nopriv_searchbyzipcode",array($this,"get_adbyzipcode"));


			/* 
				added new serach as per new XD 
			*/
			add_action("wp_ajax_find_agent_by_zipcode", array($this,"find_agent_by_zipcode_callback"));
			add_action("wp_ajax_nopriv_find_agent_by_zipcode",array($this,"find_agent_by_zipcode_callback"));

			add_action( 'template_include',array($this,"template_include_callback"),99,1);
			

			add_action("wp_ajax_credkeeper_request_information", array($this,"credkeeper_request_information_callback"));
			add_action("wp_ajax_nopriv_credkeeper_request_information",array($this,"credkeeper_request_information_callback"));

			add_action("wp_ajax_credkeeper_request_add_review", array($this,"credkeeper_request_add_review_callback"));
			add_action("wp_ajax_nopriv_credkeeper_request_add_review",array($this,"credkeeper_request_add_review_callback"));

			add_action( 'wpcf7_before_send_mail', array($this,'action_wpcf7_mail_registrationLink'), 10, 3); 


			## All Shotcode ADD shortCode ####
			
			//register_activation_hook( __FILE__, 'insert_page_new_pages' );

			add_shortcode( "list_agentDr" ,array($this,'list_agentDr'));
			add_shortcode( "get_agent_by_id" ,array($this,'get_agent_by_id_shortcode'));

			add_action("wp_ajax_savepostlead",  array($this,"agent_postLeadadd"));
			add_action("wp_ajax_nopriv_savepostlead",  array($this,"agent_postLeadadd"));

			add_action("wp_ajax_get_adbyajax", "get_adbyajax");
			add_action("wp_ajax_nopriv_get_adbyajax", "get_adbyajax");

			add_action("wp_ajax_get_agentbyid", array($this,"ajax_callBack_agentbyid"));
			add_action("wp_ajax_nopriv_get_agentbyid", array($this,"ajax_callBack_agentbyid"));
			if(IS_DUMMY_WEBSTIE){
				add_action( 'post_updated', array($this,'my_save_post_function'), 10,3);
				//add_action( 'post_updated''post_dave', 'my_save_post_function', 10, 3 );

				 add_author_filed_post();	
			}else{
			 add_action('future_to_publish',array($this,'schedule_post_notification_callback'), 10,1);	
			}
		
			add_action( 'rest_api_init', array($this,'register_user_meta_field'));
			add_action( 'wp_head', array($this,'check_user_as_agent'));
			add_action( 'filter_widget_box', array($this,'filter_widget_box_callback'));
		}

		public function filter_widget_box_callback(){
			$primarytopicResonse = $this->getPrimarytopic();
			echo $this->get_template_html("primarytopic",$primarytopicResonse);
		}


		public function check_user_as_agent(){
			if(is_author()){
				$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
				$agentid = get_the_author_meta( 'agentid', $author->ID);
				if($agentid){
					wp_redirect(home_url('/agent-detail/'.get_query_var( 'author_name' ) . '/'.$agentid));
					die();
				}
			}
		}
		public function register_user_meta_field() {   
		  register_meta('user', 'agentid', array(
			    "type" => "integer",
			    "show_in_rest" => true,
			    "single" => true,
			));
		}

		public function recaptchaVarify($recaptcharesponse){
			$url = 'https://www.google.com/recaptcha/api/siteverify';
			$data = array(
				'secret' => SECRET_KEYS,
				'response' => $recaptcharesponse
			);

			$options = array(
				'http' => array (
					'method' => 'POST',
					'content' => http_build_query($data)
				)
			);
			$context  = stream_context_create($options);
			$verify = file_get_contents($url, false, $context);
			$captcha_success=json_decode($verify);

			if ($captcha_success->success==false) {
				$isError = true;
			} else if ($captcha_success->success==true) {
				$isError = false;
			}
			return $isError;
		}

		public function action_wpcf7_mail_registrationLink( $form, &$abort, $object) {
		    $wpcf7      = WPCF7_ContactForm::get_current();
		    $submission = WPCF7_Submission::get_instance();
		    if ($wpcf7->id == 887):
	           $formdata = $submission->get_posted_data();
		       $post['first_name'] = $formdata['your-name'];
		       $post['email'] = $formdata['your-email'];
		       $post['last_name'] = $formdata['your-lastname'];
		       $post['zipcode'] = $formdata['your-zipcode'];
		       $postLeadAddResonse = $this->registrationLink($post);
		       $errorMEssage = '';
		       if(isset($postLeadAddResonse) && $postLeadAddResonse->status == 'failed'){
		      	$error = 1;
				foreach ($postLeadAddResonse->data as $key => $errormessage) {
					$errorMEssage .= $errormessage[0] . PHP_EOL;
				}
		       }

			  if($error != 0) {
			      $abort = true;
			      $object->set_response($errorMEssage);
			  }
		    endif;  
        }

        public function sucessMessage($sucessText){
			return '<p class="sucess">'.$sucessText.'</p>';
		}
		public function credkeeper_request_information_callback(){
			$response = array('sucess'=>false,'message'=> '');
			if (isset($_REQUEST['g-recaptcha-response']) && !empty($_REQUEST['g-recaptcha-response'])){
				if(!$this->recaptchaVarify($_REQUEST['g-recaptcha-response'])){
					if (isset($_REQUEST['agent_id']) && !empty($_REQUEST['agent_id'])){
					//print_r($_REQUEST);die();
						$post = array("first_name" => $_REQUEST['username'],
								  "email" => $_REQUEST['useremail'],
								  "agent_id" => base64_decode($_REQUEST['agent_id']));
						if(isset($_REQUEST['phone']) && !empty($_REQUEST['phone'])){
							$post['phone'] = $_REQUEST['phone'];
		 				}

						$postLeadAddResonse = $this->postLeadAdd($post);

						if($postLeadAddResonse->status == 'failed'){
							$response['message'] =  $this->errorMessage($postLeadAddResonse->msg);
						}else{
							$response['sucess'] = true;
							$response['message'] =  $this->sucessMessage('Thank you, your request has been received.');
						}
					}else{
						$response['message'] =  $this->errorMessage('Agent Not Found please try again.');
					}
				}else{
					$response['message'] =  $this->errorMessage(RECAPTACH_MESSAGE);
				}
			}else{
				$response['message'] =  $this->errorMessage(RECAPTACH_MESSAGE);
			}

			echo wp_send_json($response);
			die();
		}

		public function credkeeper_request_add_review_callback(){

			$response = array('sucess'=>false,'message'=> '');

			if (isset($_REQUEST['g-recaptcha-response']) && !empty($_REQUEST['g-recaptcha-response'])){
				if(!$this->recaptchaVarify($_REQUEST['g-recaptcha-response'])){
					if (isset($_REQUEST['agent_id']) && !empty($_REQUEST['agent_id']))
					{
						$post = array("reviewer_name" => $_REQUEST['reviewer_name'],
						  "reviewer_email" => $_REQUEST['reviewer_email'],
						  "review_description" => $_REQUEST['review_description'],
						  "reviewer_star" => $_REQUEST['reviewer_star'],
						  "agent_id" => base64_decode($_REQUEST['agent_id']));
						$postLeadAddResonse = $this->postLeadAddReview($post); // API 			

						if($postLeadAddResonse->status == 'failed'){
							$response['message'] =  $this->errorMessage($postLeadAddResonse->msg);
						}else{
							$response['sucess'] = true;
							$response['message'] =  '<p class="sucess">'.$postLeadAddResonse->msg.'</p>';
						
						}
					}else{
						$response['message'] =  errorMessage('Agent Not Found please try again.');
					}
				}else{
					$response['message'] =  $this->errorMessage(RECAPTACH_MESSAGE);
				}
			}else{
				$response['message'] =  $this->errorMessage(RECAPTACH_MESSAGE);
			}

			echo wp_send_json($response);
			die();

		}

		public function  template_include_callback( $template ) {
			if(get_query_var('pagename') && get_query_var('pagename') == 'agent-detail'){
		    	if (get_query_var( 'wpusername' ) == '' ) {
		    		wp_redirect( home_url('/agent-search'));
		    	}
		    }

		    if ( get_query_var( 'wpusername' ) == false || get_query_var( 'wpusername' ) == '' ) {
		        return $template;
		    }

		    //var_dump(get_query_var( 'wpusername' ));
		    //var_dump(get_query_var( 'agentid' ));
		 	/*if(get_query_var('agentid')){
		 		$post = ['id'  => get_query_var('agentid')];
			
				$data = $this->getAgentByID($post);	
		 	}*/
		 	/*$post = ['id'  => 10170];
			
			$data = $this->getAgentByID($post);*/
			/*echo "<pre>";
			print_r($data);
			die();*/
			//echo $this->get_template_html("agent-details",$data);
		    return  AD_PLUGIN_DIR . '/templates/agent-details.php';
		}

		public function find_agent_by_zipcode_callback(){
			$response = array('sucess'=>false,'message'=> '');
			if(isset($_REQUEST['page']) && !empty($_REQUEST['page'])){
				$post['page'] = $_REQUEST['page'];
			}else{
				$post['page'] = 1;					
			}

			if(isset($_REQUEST['primary_topic']) && !empty($_REQUEST['primary_topic'])){
				$post['primary_topic_id'] = implode(',', $_REQUEST['primary_topic']);
			}
		
			if(isset($_REQUEST['zipcode']) && !empty($_REQUEST['zipcode'])){
				$post['zipcode'] = $_REQUEST['zipcode'];
				$response_agt = $this->searchAgentList($post);
				if(count($response_agt->data->data) > 0 )
				{
					if($response_agt->error == 1){
						$response['message'] = $this->errorMessage('Sorry, your nonce did not verify.');
					}
					else{
						$response['data'] =  $this->get_template_html("agent_list_serarch_v1",$response_agt);
						$response['sucess'] = true;
					}
				}else{
					$response['message'] = $this->errorMessage('No agent found on this '. $_REQUEST['zipcode'].' zip code.');

				}
			}else{
				//var_dump($post);
				$aget_list = $this->getAgentList($post);
				if(count($aget_list->data->total > 0 ))
				{
					if($aget_list->error == 1)
					{
						$response['message'] = $this->errorMessage($aget_list->message);
					}
					else
					{
						$response['sucess'] = true;
						$response['data'] = $this->get_template_html("agent_list_serarch_v1",$aget_list);
					}
				}else{
					$response['message'] = $this->errorMessage('No agent found on this  '. get_bloginfo( 'name' ) .' website.');

				}
			}
			echo wp_send_json($response);
			
			die();
		}

		public function ajax_callBack_agentbyid()
		{
			if(isset($_POST['agent_id']) && !empty($_POST['agent_id']))
			{
				$post = ['id'  => $_POST['agent_id'],'token' => $this->token];
				$responsedata = $this->getAgentByID($post);
				//echo "<pre>";print_r($responsedata);
				echo $this->get_template_html("agent_details",$responsedata);
			}
			die();
			
		}		
	
		function getUserIP()
		{
			// Get real visitor IP behind CloudFlare network
			if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
					  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
					  $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
			}
			$client  = @$_SERVER['HTTP_CLIENT_IP'];
			$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
			$remote  = $_SERVER['REMOTE_ADDR'];

			if(filter_var($client, FILTER_VALIDATE_IP))
			{
				$ip = $client;
			}
			elseif(filter_var($forward, FILTER_VALIDATE_IP))
			{
				$ip = $forward;
			}
			else
			{
				$ip = $remote;
			}

			return $ip;
		}

		public function errorMessage($errorText){
			return '<p class="error error-agnet-not-fond">'.$errorText.'</p>';
		}


		public function get_adbyajax($params)
		{
			//$objapi = new adAPI();
			echo $_POST['page_id'];
			echo $_POST['zipcode'];

			if(isset($_POST['page_id']) && !empty($_POST['page_id']))
			{
				$post = ['page'  => $_POST['page_id']];
				$data = $this->getAgentList($post);
				if(count($data) > 0 )
				{
					if($data->error == 1)
					{
						echo $this->errorMessage($data->message);
						//echo print_agent
					}
					else
					{
						echo print_agent($data);
						echo $this->get_template_html("agent_list_serarch",$data);
					}
				}
			}
			else
			{
				echo $this->errorMessage("Page ID Not SET... ");
			}
			die();
		}

		public function get_adbyzipcode()
		{

			$objapi = new adAPI();
			if (! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'searchbyzipcode' ) ) 
			{
				echo  $this->errorMessage('Sorry, your nonce did not verify.');
				exit;

			}
			elseif(isset($_REQUEST['zipcode']) && !empty($_REQUEST['zipcode']))
			{	
				
				$post = ['zipcode'   => $_REQUEST['zipcode']];
				$data = $this->searchAgentList($post);
				if(count($data) > 0 )
				{
					if($data->error == 1)
					{
						echo $this->errorMessage('Sorry, your nonce did not verify.');
					}
					else
					{
						echo $this->get_template_html("agent_list_serarch",$data);
					}
				}
				
			}
			elseif(empty($_REQUEST['zipcode']))
			{
				
				$post = ['page'  => 1];
				$data = $this->getAgentList($post);
				if(count($data) > 0 )
				{
					if($data->error == 1)
					{
						echo $this->errorMessage($data->message);
					}
					else
					{
						echo print_agent($data);
						echo  $this->errorMessage('Sorry, your nonce did not verify.');
						exit;
						echo $this->get_template_html("agent_list_serarch",$data);
					}
				}
			}	
			else 
			{
				//echo  $this->errorMessage('Sorry, your nonce did not verify.');
				//exit;
				echo $this->errorMessage("Please Enter ZipCode");
			}
			die();
		}

		public function get_agent_by_id_shortcode()
		{	
			echo $_GET['agentidmain'];
			//$objapi = new adAPI();
			$matches = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$	[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$tokens = explode('/', $matches);

			if(isset($tokens[sizeof($tokens)-2]))
			{
				//$post = ['agentid'  => $_REQUEST['agentid']];
				//$post = ['agentusername'  => $tokens[sizeof($tokens)-2]];
				$post = ['id'  => $_REQUEST['id']];
				
				$data = $this->getAgentByID($post);
				// echo "<pre>";
				// print_r($data);
				// die();
				
				if(count((array) $data) > 0 )
				{
					if($data->error == 1)
					{
						echo $data->message;
					}
					else
					{
						echo print_AgentDetail($data);
					}
				}
			}
			die();
		}

		public function list_agentDr()
		{
			//$objapi = new adAPI();
			$post = ['page'  => 1];
			//die('call me');
			$aget_list = $this->getAgentList($post);
			//echo "<pre>";
			//print_r($aget_list);
			//die();
			return $this->get_template_html("agent_list",$aget_list);

			$output =''; 
			
			/*$outputf .= '<div class="form-horizontal searchbg">
						    <div class="form-group">
						        <div class="searchform form-horizontal">
						            <form id="user-search" method="post">
										<input type="text" class="form-control" name="zipcode">
										<input class="searchbyzipcode btn sitebtn search-agent-btn" required="required" type="submit" name="Search" value="Search">
										<input value="searchbyzipcode" type="hidden" name="action" >'.
										wp_nonce_field('searchbyzipcode' ).'
									</form>
						        </div>
						    </div>
						</div>';*/
			
			echo $outputf;
			echo '<div class="ad-list-main">';
				
			if(!empty($data))
			{
				if($data->error == 1)
				{
					echo $data->message;
				} 
				else 
				{
					echo print_agent($data);				
				}
			}
			echo '</div>'; 
			die();
		}
		
		//return $this->get_template_html("finaleinventorypanelinfo",$data);


		public function get_template_html( $template_name, $attributes = null ) {
		if ( ! $attributes ) {
			$attributes = array();
		}
			ob_start();
			//do_action( 'finale_inventory_before_' . $template_name );
			require( AD_PLUGIN_DIR . '/templates/' . $template_name . '.php');
			//do_action( 'finale_inventory_after_' . $template_name );
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
		}

		## AJAX CALL API DATA FUNCTION END #######
		public function agent_postLeadadd()
		{
			if (isset($_REQUEST['agentid']) && !empty($_REQUEST['agentid']))
			{
				//print_r($_REQUEST);die();
				$post = array("first_name" => $_REQUEST['first_name'],
						  "last_name" => $_REQUEST['last_name'],
						  "email" => $_REQUEST['email'],
						  "phone" => $_REQUEST['phone'],
						  "prefer_to_contact" => $_REQUEST['prefer_to_contact'],
						  "agent_id" => $_REQUEST['agentid']);

				//$objapi = new adAPI();
				
				$postLeadAddResonse = $this->postLeadAdd($post);
				

				if(count($postLeadAddResonse) > 0 )
				{
					if($postLeadAddResonse->error == 1)
					{
							echo $this->errorMessage($postLeadAddResonse->message);
					}
					else
					{
							echo $postLeadAddResonse->message;
							echo "<h3><b>Agent Lead  Successfully</b></h3>";
					}
				}
			}
			else
			{
				echo errorMessage('Agent Not Found please try again.');
			}
			exit;
			die();
		}

}


function Agent_Call() {
	return Agent_Call::instance();
}

Agent_Call();
