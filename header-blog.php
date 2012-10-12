<?php
/**
 * Header for the blog template
 *
 * @author Jonathon McDonald <jon@onewebcentric.com>
 */
if(!wpv_is_reduced_response()):
	get_header();
endif;
?>
<?php if(!wpv_is_reduced_response()): ?>
<div class="pane main-pane">
	<div class="row">
		<?php wpv_page_header($page_header_placed); ?>
		<div class="page-outer-wrapper">
			<?php do_action('wpv_start_page'); ?>
			<div class="clearfix page-wrapper">
				<?php endif; ?>