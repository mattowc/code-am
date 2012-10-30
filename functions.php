<?php

require_once('wpv_common/wpv_framework.php');

new Wpv_Framework(array(
	'name' => 'adeptstyle',
	'slug' => 'adeptstyle'
));

/**
 * Styles the excerpt link
 */
function jm_excerpt_link( $more )
{
	global $post;
	return ' [...]<br /><a href="' . get_permalink($post->ID)
	 . '" style="float: right;">Read on ' . $more . '</a>';
}
add_filter('excerpt_more', 'jm_excerpt_link');

/**
 * Adds a featured meta box to posts
 */
function jm_add_featured_meta()
{
	add_meta_box(
		'jm-featured', 
		'Featured', 
		'jm_show_featured_box', 
		'post', 
		'side',
		'high');
}
add_action('add_meta_boxes', 'jm_add_featured_meta');

/**
 * Shows a simple form for whether it is featured
 */
function jm_show_featured_box( $post )
{
	// Check if it should be checked
	// Defaults to no
	$featured = get_post_meta($post->ID, 'jm_featured', true);
	if($featured == 'true')
		$checked = 'checked';
	else
		$checked = '';

	echo'<input name="featured_post" type="checkbox" value="true" ' . $checked
	 . '/>  <label for="featured_post">Feature This  </label>';
}

/**
 * Handles featuring and un-featuring a blog post
 */
function jm_store_featured( $post_id )
{
	// Check to ensure this is not an auto save
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	// Check permissions first
	if(isset($_POST['post_type']) && ('post' != $_POST['post_type'] || !current_user_can('edit_post', $post_id)))
		return;

	// TO-DO:  ADD NONCE CHECK!
	$data = "";
	if(isset($_POST['featured_post']))
		$data = $_POST['featured_post'];

	// Update if this is featured
	update_post_meta( $post_id, 'jm_featured', $data);
}
add_action('save_post', 'jm_store_featured');

/*
 * Changes cart text
 */
function jm_change_cart_text(  )
{
	return 'Register';
}
add_filter('single_add_to_cart_text', 'jm_change_cart_text' );

function jm_change_cart_country()
{
	return 'US';
}
add_filter( 'default_checkout_country', 'jm_change_cart_country' );

function jm_change_cart_state()
{
	return 'UT';
}
add_filter( 'default_checkout_state', 'jm_change_cart_state' );

function jm_change_free_text( $price )
{
	return '$0.00';
}
add_filter( 'woocommerce_free_price_html', 'jm_change_free_text');

function jm_add_email_text()
{
	echo '<p>If this is for an event, be sure to print your receipt and bring it with you to the event. </p>';
}
add_action( 'woocommerce_email_before_order_table', 'jm_add_email_text' );

register_sidebar(array(
					'id' => 'jm_sidebar',
					'name' => 'jm_sidebar',
					'description' => 'For Testimonials',
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget' => '</section>',
					'before_title' => apply_filters('wpv_before_widget_title', '<h4 class="widget-title">', 'body'),
					'after_title' => apply_filters('wpv_after_widget_title', '</h4>', 'body'),
				));

?>