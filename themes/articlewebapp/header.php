<!DOCTYPE html>
<html <?php language_attributes();?>>
	<head>		
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">		
		<title><?php echo is_front_page() ? get_bloginfo( 'name' ) : get_the_title(); ?></title> 
		<meta name="description" content="<?php bloginfo('description');?>">
		<?php wp_head();?> <!-- It calls all header included files -->
	</head>
	<body <?php body_class(implode('', get_body_class() )); ?> >
            <header class="site-header container">
				<div class="site-header__items-left">
					<div class="site-header__image">
						<?php if ( function_exists( 'the_custom_logo' ) ) : ?>
							<?php the_custom_logo(); ?>
						<?php endif ?>
					</div>
				</div>
				<div class="site-header__items-right">
				<form role="search" method="get" id="searchform" class="searchform" action="<?php echo site_url() ?>">
					<div>
					<label class="screen-reader-text" for="s">Search for:</label>
					<input type="text" value="" name="s" id="s" class="site-header__search" />
					<button type="submit" class="site-header__search-button"><i class="dashicons dashicons-search"></i></button>
					</div>
					</form>
				</div>
				<div class="site-header__profile">
					<?php $current_url = home_url( add_query_arg( [], $GLOBALS['wp']->request ) ); ?>
					<?php $current_user = wp_get_current_user(); ?>
					<?php if ( is_user_logged_in() ): ?>
						<a href="<?php echo esc_url( wp_login_url( $current_url )  ); ?>"><?php echo get_avatar( $current_user->ID, 32 ); ?></a>
					<?php else: ?>
						<a href="<?php echo esc_url( wp_login_url( $current_url )  ); ?>"><?php echo get_avatar( $current_user->ID, 32 ); ?></a>
					<?php endif; ?>
						
				</div>
			</header>
			<section id="menu" class="wp-menu">
				<div class="container">
					<div class="wp-menu__content">
						<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
					</div>
				</div>
			</section>