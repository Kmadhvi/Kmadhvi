<?php 

function cdk_explode_values( $value, $separator = ',' ) {
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
