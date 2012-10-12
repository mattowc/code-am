<?php /* Template Name: JM Blog */ ?>

<?php
/**
 * Displays the three most recent posts per category
 *
 * @author Jonathon McDonald <jon@onewebcentric.com>
 */

// Load in the header
get_header('blog');

// Get all the categories
$args       = array('type'=>'post');
$categories = get_categories( $args );

global $more;
$more = 0;

// Loop through the categories, and extract the three most recent posts
foreach($categories as $category)
{
	// Prepare a separate for this div
	echo'<div style="clear: both;">';
	echo'<h3><a href="' . get_category_link($category->term_id) . '">' . 
	$category->name . '</a></h3>';

	// Get the three most recent posts from this category
	$args = array(
		'type'=>'post', 
		'category'=>$category->slug, 
		'posts_per_page'=>'3');
	query_posts($args);

	// Counter, used to properly show the three grids in a row
	$count = 0;

	// Loop through the posts, display properly
	while(have_posts()): the_post(); ?>
		<div class="one_third <?php if($count == 0): echo 'first'; elseif($count==2): echo 'last'; endif;?>">
			<h4>
				<a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
				</a>
			</h4>
			<div class="the_story">
				<?php the_excerpt(); ?>
			</div>
		</div>
	<?php 
		$count++; // Increments the counter
	endwhile;

	// Reset the query before continuing through the foreach
	wp_reset_query();
	echo'</div>';
}

get_footer('blog');
?>