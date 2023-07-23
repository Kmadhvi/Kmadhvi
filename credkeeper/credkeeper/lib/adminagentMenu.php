<?php
ob_start();
function agentdir_settings_init() { 
	register_setting( 'agentdir', 'agentdir_options' ); 
 	 
 	add_settings_section('agentdir_section_developers', __( 'Agent API.', 'agentdir' ), '', 'agentdir');
 	  
 	add_settings_field( 'agentdir_field_pill', __( 'Token ID', 'agentdir' ),'agentdir_field_pill_cb','agentdir','agentdir_section_developers', [ 'label_for' => 'agentdirtokan', 'class' => 'agentdir_row', 'agentdir_custom_data' => 'custom']);  
 	
 	add_settings_field( 'agentdirlimit',  __( 'Record Per Page', 'agentdir' ), 'agentdir_field_pill_cb2', 'agentdir', 'agentdir_section_developers', [ 'label_for' => 'agentdirlimit', 'class' => 'agentdir_row', 'agentdir_custom_data' => 'custom']);   
 	add_settings_field( 'apiurl',  __( 'API Url', ' ' ), 'agentdir_field_pill_cb4', 'agentdir', 'agentdir_section_developers', [ 'label_for' => 'apiurl', 'class' => 'agentdir_row apiurl', 'agentdir_custom_data' => 'custom']);  
} 
add_action( 'admin_init', 'agentdir_settings_init' );

function agentdir_field_pill_cb( $args ) { 
	$options = get_option( 'agentdir_options' ); ?>
	<input type="text" style="width: 50%;" name="agentdir_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo isset( $options[ $args['label_for'] ] )?$options[ $args['label_for'] ]:$options[ $args['label_for'] ]?>"> 
<?php  
} 

 function agentdir_field_pill_cb2( $args ) {	 
	$options = get_option( 'agentdir_options' ); ?>
	 <input type="text" style="width: 50%;" name="agentdir_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo isset( $options[ $args['label_for'] ] )?$options[ $args['label_for'] ]:$options[ $args['label_for'] ]?>"> <p class="description">Show All Agent List used this do_shortcode('[list_agentDr]');</p>  
<?php 
} 

function agentdir_field_pill_cb4( $args ) {	 
	$options = get_option( 'agentdir_options' ); ?>
	<input type="text" style="width: 50%;" name="agentdir_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo isset( $options[ $args['label_for'] ] )?$options[ $args['label_for'] ]:$options[ $args['label_for'] ]?>"> <p class="description">Add Api Url</p>  
<?php 
}  

function agentdir_options_page() { 
	add_menu_page( 'Credkeeper Settings', 'Credkeeper Settings', 'manage_options', 'agentdir', 'agentdir_options_page_html' );
} 
add_action( 'admin_menu', 'agentdir_options_page'); 

function agentdir_options_page_html() {
	if ( ! current_user_can( 'manage_options' ) ) { 
		return; 
	} 
	
	if ( isset( $_GET['settings-updated'] ) ) { 
	 	add_settings_error( 'agentdir_messages', 'agentdir_message', __( 'Settings Saved', 'agentdir' ), 'updated' ); 
	}

		settings_errors( 'agentdir_messages' ); ?> 
		
		<div class="wrap"> <h1><?php echo esc_html( get_admin_page_title() ); ?></h1> 
	 		<form action="options.php" method="post"> 
	 			<?php settings_fields( 'agentdir' ); do_settings_sections( 'agentdir' );submit_button( 'Save Settings' ); ?> 
	 		</form> 
	 	</div>
	 	 
	 <?php
	}
?>