<?php
/**
* @package WordPress
* @subpackage zenden
*/
?><!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6 large-screen"> <![endif]-->
<!--[if IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie7 large-screen"> <![endif]-->
<!--[if IE 8 ]> <html <?php language_attributes(); ?> class="no-js ie8 large-screen"> <![endif]-->
<!--[if IE 9 ]> <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-ie no-js"> <!--<![endif]-->
	
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php wpv_title() ?></title> 
		
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php wpvge('favicon_url')?>"/>
	
	<script>
		WPV_THEME_URI = '<?php echo WPV_THEME_URI ?>';  
	</script>
	
	<?php wp_head(); ?>
	<?php
		global $post;

		if(is_object($post) && get_post_meta($post->ID, 'use-global-options', true) === 'false') {
			$bgcolor = get_post_meta($post->ID, 'background-color', true);
			$bgimage = get_post_meta($post->ID, 'background-image', true);
			$bgrepeat = get_post_meta($post->ID, 'background-repeat', true);
			$bgsize = get_post_meta($post->ID, 'background-size', true);
			$bgattachment = get_post_meta($post->ID, 'background-attachment', true);
			
			$page_style = '';
			if(!empty($bgcolor))
				$page_style .= "background-color:$bgcolor;";
			if(!empty($bgimage))
				$page_style .= "background-image:url('$bgimage');";
			if(!empty($bgrepeat))
				$page_style .= "background-repeat:$bgrepeat;";
			if(!empty($bgsize))
				$page_style .= "background-size:$bgsize;";
			if(!empty($bgattachment))
				$page_style .= "background-attachment:$bgattachment;";
			
			if(!empty($page_style) && (is_single() || is_page())) {
				echo "<style>body{ $page_style }</style>";
			} 
		}
	?>
</head>
	<?php
		global $wpv_has_header_sidebars;
	
		$has_header_slider = theme_has_header_slider();
		$wpv_has_header_sidebars = wpv_post_default('show_header_sidebars', 'has-header-sidebars');
		$has_page_header = is_singular(array('post', 'portfolio')) || (is_page() && wpv_post_default('show_page_header', 'has-page-header') || is_category() || is_archive() || is_search() || is_home());

		$fancy_portfolio_cats = is_page() ? unserialize(get_post_meta($post->ID, 'fancy-portfolio-categories', true)) : array();
		$fancy_portfolio_type = is_page() ? get_post_meta($post->ID, 'fancy-portfolio-type', true) : 'background';
			
		$body_class = array();

		$body_class[] = wpv_get_option('site-layout-type');
		
		$body_class_conditions = array(
			'no-page-header' => !$has_page_header,
			'has-page-header' => $has_page_header, 
			'cbox-share-twitter' => wpv_get_option('share-lightbox-twitter'),
			'cbox-share-facebook' => wpv_get_option('share-lightbox-facebook'),
			'cbox-share-gplus' => wpv_get_option('share-lightbox-gplus'),
			'cbox-share-pinterest' => wpv_get_option('share-lightbox-pinterest'),
			'fixed-header' => wpv_get_option('fixed-header'),
			'has-header-slider' => $has_header_slider,
			'has-header-sidebars' => $wpv_has_header_sidebars,
			'no-header-slider' => !$has_header_slider,
			'no-header-sidebars' => !$wpv_has_header_sidebars,
			'no-footer-sidebars' => !wpv_get_option('has-footer-sidebars'),
			'responsive-layout' => WPV_RESPONSIVE,
			'full-bg-slider' => !empty($fancy_portfolio_cats) && $fancy_portfolio_type == 'background',
			'fast-slider' => !empty($fancy_portfolio_cats) && $fancy_portfolio_type == 'background',
			'ajax-portfolio' => !empty($fancy_portfolio_cats) && $fancy_portfolio_type == 'page',
			'force-menu-background' => wpv_get_option('force-menu-background'),
			'no-header-search' => !empty($fancy_portfolio_cats) && $fancy_portfolio_type == 'page',
			'moving-main-menu' => true,
			'auto-force-menu-background' => true,
			'force-menu-background' => true,
		);
		
		foreach($body_class_conditions as $class=>$cond) {
			if($cond) {
				$body_class[] = $class;
			}
		}

		if(is_archive() || is_search() || get_query_var('format_filter'))
			define('WPV_ARCHIVE_TEMPLATE', true);
		
		$slider_style = '';
		$slider_effect = '';
	?>
<body <?php body_class(implode(' ', $body_class)); ?>>
	<?php do_action('wpv_body') ?>
	<div id="container" class="main-container">
		<div class="boxed-layout">
			<div class="page-dash-wrapper">
				
					<div class="fixed-header-box">
						<header class="main-header">
							<div class="limit-wrapper">
								<div id="header-search"><?php get_search_form() ?></div>
								<div class="header-inner">
									<div class="logo-wrapper">
									<?php $logo = wpv_get_option('custom-header-logo') ?>
										<a href="<?php echo home_url() ?>/" title="<?php bloginfo( 'name' ) ?>" class="logo a-reset"><?php 
											if($logo):
											?>
												<img src="<?php echo $logo;?>" alt="<?php bloginfo('name')?>"/>
											<?php
											else:
												bloginfo( 'name' );
											endif;
											?>
										</a>
									</div>
									<a href="#" id="show-menu-toggle" title="<?php _e('Menu', 'wpv')?>"><span class="icon"><?php wpv_icon('list') ?></span></a>
									<div id="menus">
										<nav id="main-menu">
											<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
											<a href="#content" title="<?php esc_attr_e( 'Skip to content', 'wpv' ); ?>" class="visuallyhidden"><?php _e( 'Skip to content', 'wpv' ); ?></a>
											<?php
												if(has_nav_menu('menu-header')) {
													wp_nav_menu(array('theme_location' => 'menu-header', 'walker' => new description_walker() ));
												} else {
													wp_page_menu();
												}
											?>
										</nav>
										<nav id="top-nav">
											<?php wp_nav_menu(array('fallback_cb' => '', 'theme_location' => 'menu-top' )); ?>
										</nav>
									</div>
									<?php if(!$has_header_slider && wpv_get_option('phone-num-top') != ''): ?>
										<div id="phone-num"><?php echo do_shortcode(wpv_get_option('phone-num-top'))?></div>
									<?php endif ?>
								</div>
							</div>
						</header>

						<?php
							if(!empty($fancy_portfolio_cats) && $fancy_portfolio_type == 'background'):
								$data = wpv_get_fancy_portfolio_items();
								wp_enqueue_script('front-wpvbgslider');
						?>
									<script>wpvBgSlides = <?php echo json_encode($data)?>;</script>
								</div> <!-- fixed-header-box -->
								</div> <!-- page-dash-wrapper -->
								</div> <!-- boxed-layout -->
								</div> <!-- #container -->
								
								<!-- Fullscreen slider controls -->
								<h4 class="fast-slider-caption"></h4>
								<div class="fast-slider-navbar">
									<div class="fast-slider-next icon"><b><?php wpv_icon('angle-right')?></b></div>
									<?php
										$view_all = wpv_get_option('portfolio-all-items');
										if(!empty($view_all)):
									?>
										<a href="<?php echo $view_all?>" class="fast-slider-view-all icon"><b><?php wpv_icon('grid-3')?></b></a>
									<?php endif ?>
									<div class="fast-slider-prev icon"><b><?php wpv_icon('angle-left')?></b></div>
									<div class="fast-slider-gall-prev icon"><b><?php wpv_icon('angle-top')?></b></div>
									<div class="fast-slider-gall-next icon"><b><?php wpv_icon('angle-bottom')?></b></div>
								</div>
								
								<?php wp_footer() ?>
								</body>
								</html>

								<?php
								exit;
							endif;
						?>

						<div id="sub-header">
							<?php
							/*
							 * some pages may not have a slider enabled, check for that
							 */
							if( $has_header_slider ):
								$slider_effect = wpv_post_default('slider-effect', 'header-slider-effect');
								
								$slider_engine = 'vamtam';

								$slider_size = wpv_get_option('full-width-slider') ? 'fullwidth' : 'limited';
							?>
								<div class="clearfix">
									<div id="header-slider-container" class="push-logo <?php echo $slider_engine?> <?php echo $slider_size?>">
										<div class="header-slider-wrapper animation-<?php echo $slider_effect?>">
											<?php
												get_template_part('slider', $slider_engine);
											?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div><!-- / .fixed-header-box -->
					<div id="header-slider-thumbs"><span class="fl"><?php echo ($slider_effect == 'thumbNav' ? wpv_get_option('slider-title') : '')?></span></div>
					
					
					<div class="pane-wrapper clearfix">
						<!-- #main (do not remove this comment) -->
						<div id="main" role="main">
							<div class="limit-wrapper">
								<?php if($has_header_slider && wpv_get_option('phone-num-top') != ''): ?>
									<div id="phone-num"><?php echo do_shortcode(wpv_get_option('phone-num-top'))?></div>
								<?php endif ?>
