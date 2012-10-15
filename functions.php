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
?>