<?php
/**
 * @package WordPress
 * @subpackage zenden
 */

if(!wpv_is_reduced_response()):
	get_header();
endif;
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<?php 
if(!wpv_is_reduced_response()):
	$page_header_placed = wpv_get_header_sidebars();
?>

<div class="pane main-pane">
	<div class="row">
		<?php wpv_page_header($page_header_placed) ?>
		<div class="page-outer-wrapper">
			<?php do_action('wpv_start_page'); ?>
			<div class="clearfix page-wrapper">
<?php endif; //reduced ?>
				<?php wpv_has_left_sidebar() ?>
				
				<div <?php post_class('single-post-wrapper '.wpv_get_layout())?>>
					<div class="loop-wrapper clearfix full">
						<div class="page-content post-head clearfix">
							<?php theme_breadcrumbs() ?>
							<?php get_template_part('single', 'inner'); ?>
						</div>
						<div class="clearboth">
							<?php comments_template(); ?>
						</div>
					</div>
				</div>

				<?php wpv_has_right_sidebar() ?>
<?php if(!wpv_is_reduced_response()): ?>
			</div>
		</div>
	</div>
</div>

<?php endif;
endwhile;

if(!wpv_is_reduced_response()) {
	get_footer();
} else {
	wpv_reduced_footer();
}
