<?php
/**
* @package WordPress
* @subpackage zenden
*/

/**
 * Header for the shop template
 *
 * @author Jonathon McDonald <jon@onewebcentric.com>
 */


if(!wpv_is_reduced_response()):
	get_header();
	$page_header_placed = wpv_get_header_sidebars($title);
endif;
?>
<?php if(!wpv_is_reduced_response()): ?>
<div class="pane main-pane">
	<div class="row">
		<?php if(is_archive()): $category = get_the_category( $post->ID ); ?>
		<?php wpv_page_header($page_header_placed); ?> 
		<?php else: wpv_page_header($page_header_placed); endif; ?>
		<div class="page-outer-wrapper">
			<?php do_action('wpv_start_page'); ?>
			<div class="clearfix page-wrapper">
				<?php endif; ?>
