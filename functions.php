<?php

require_once('wpv_common/wpv_framework.php');

new Wpv_Framework(array(
	'name' => 'adeptstyle',
	'slug' => 'adeptstyle'
));

function jm_excerpt_link( $more )
{
	global $post;
	return ' [...]<br /><a href="' . get_permalink($post->ID) . '" style="float: right;">Read on ' . $more . '</a>';
}
add_filter('excerpt_more', 'jm_excerpt_link');


?>