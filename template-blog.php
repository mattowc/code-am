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

// First show the featured category
$args = array(
		'type'=>'post', 
		'category_name'=>'featured', 
		'posts_per_page'=>'3');
query_posts($args);

$count = 0;
$featured = get_category( 58 );

// Prepare a separate for this div
echo'<div style="clear: both;">';
echo'<h3 class="jm-cat"><a href="' . get_category_link($featured->term_id) . '">Featured</a></h3>';

// Loop through the posts, display properly
while(have_posts()): the_post(); ?>
	<div class="one_third <?php if($count == 0): echo 'first'; elseif($count==2): echo 'last'; endif;?>">
		<a href="<?php the_permalink(); ?>">
			<?php if(has_post_thumbnail()): ?>
				<?php the_post_thumbnail(array(300, 168), array('class'=>'jm-thumb')); ?>
			<?php else: ?>
				<img class="wp-post-image jm-thumb" src="<?php bloginfo('url') ?>/wp-content/uploads/2012/10/AmberMay.jpg" />
			<?php endif; ?>
		</a>
		<h4>
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h4>
		<div class="the_story">
				<?php the_excerpt(); ?>
		</div>
	</div>
<?php $count++; endwhile; // End post loop, and increment the counter 
wp_reset_query();
echo'<div class="news-feed-divider"><a href="' . 
get_category_link($featured->term_id) . '" class="button small accent1   alignright">More from ' . 
$featured->name . '</a></div>';
echo'</div>';

// Loop through the categories, and extract the three most recent posts
foreach($categories as $category)
{
	if( $category->slug == 'featured' )
		continue;

	// Prepare a separate for this div
	echo'<div style="clear: both;">';
	echo'<h3 class="jm-cat"><a href="' . get_category_link($category->term_id) . '">' . 
	$category->name . '</a></h3>';

	// Get the three most recent posts from this category
	$args = array(
		'type'=>'post', 
		'category_name'=>$category->slug, 
		'posts_per_page'=>'3');
	query_posts($args);

	// Counter, used to properly show the three grids in a row
	$count = 0;

	// Loop through the posts, display properly
	while(have_posts()): the_post(); ?>
		<div class="one_third <?php if($count == 0): echo 'first'; elseif($count==2): echo 'last'; endif;?>">
			<a href="<?php the_permalink(); ?>">
				<?php if(has_post_thumbnail()): ?>
					<?php the_post_thumbnail(array(300, 168), array('class'=>'jm-thumb')); ?>
				<?php else: ?>
					<img class="wp-post-image jm-thumb" src="<?php bloginfo('url') ?>/wp-content/uploads/2012/10/AmberMay.jpg" />
				<?php endif; ?>
			</a>
			<h4>
				<a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
				</a>
			</h4>
			<div class="the_story">
				<?php the_excerpt(); ?>
			</div>
		</div>
	<?php $count++; endwhile; // End post loop, and increment the counter ?>

	<?php // Reset the query before continuing through the foreach 
	wp_reset_query();
	echo'<div class="news-feed-divider"><a href="' . 
	get_category_link($category->term_id) . '" class="button small accent1   alignright">More from ' . 
	$category->name . '</a></div>';
	echo'</div>';
}

get_footer('blog');
?>