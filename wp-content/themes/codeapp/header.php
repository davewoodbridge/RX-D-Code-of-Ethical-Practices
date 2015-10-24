<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<?php wp_enqueue_script("jquery"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, target-densitydpi=medium-dpi, user-scalable=0" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800,700' rel='stylesheet' type='text/css'>
<link type="text/css" href="<?php echo get_template_directory_uri(); ?>/js/jquery.jscrollpane.css">
	<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		
        <div id="header_logo">
        	<img src="<?php echo get_template_directory_uri(); ?>/images/logo_rxd.jpg" alt="RX&D Logo">
        </div>
        <hgroup>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php _e('<!--:en-->RX&D Code of Ethical Practices<!--:--><!--:fr-->RX&D Code de pratiques éthiques<!--:-->'); ?></a></h1>
		</hgroup>

      	<a class="menu" href="javascript:showMenu()">Menu</a>

		<nav id="navigation" class="main-navigation" role="navigation">
        	<div id="buttons">
            	<a href="javascript:showTab('toc');" class="button_toc btn_small"><?php _e('<!--:en-->Table of Contents<!--:--><!--:fr-->Table des matières<!--:-->') ?></a>
                <a href="javascript:showTab('fav');" class="button_fav btn_small"><?php _e('<!--:en-->Favourites<!--:--><!--:fr-->Favoris<!--:-->') ?></a>
                <a href="javascript:showTab('news');" class="button_news btn_small"><?php _e('<!--:en-->News<!--:--><!--:fr-->Nouvelles<!--:-->') ?></a>
                <a href="javascript:showTab('conf');" class="button_conferences btn_small"><?php _e('<!--:en-->Events<!--:--><!--:fr-->Événements<!--:-->') ?></a>
                <div class="lang_toggle">
					<?php 
                    /*$currentLang = qtrans_getLanguage();
                    if($currentLang == "fr") {
                        echo '<a class="change_lang" href="' . get_home_url() . '/en/">EN</a>';
                    } else {
                        echo '<a class="change_lang" href="' . get_home_url() . '/fr/">FR</a>';
                    }*/
					wp_nav_menu( array('menu'=>'language'));

                    ?>
                </div>
            </div>
            
			
			<?php //wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
            <div id="nav_tab_wrapper">
                <div id="nav_tabs">
                    <div class="single_tab" id="tab_toc">
                        <h3><?php _e('<!--:en-->Table of Contents<!--:--><!--:fr-->Table des matières<!--:-->') ?></h3>
                        <?php showTOC('toc'); ?>
                    </div>   
                    <div class="single_tab" id="tab_fav">
                        <h3><?php _e('<!--:en-->My Favourites<!--:--><!--:fr-->Mes Favoris<!--:-->') ?></h3>
                        <?php
                        wpfp_list_favorite_posts();
                        ?>
                    </div>   
                    <div class="single_tab" id="tab_news">
                        <h3><?php _e('<!--:en-->News<!--:--><!--:fr-->Nouvelles<!--:-->') ?></h3>   
                        <?php show_news(); ?>
                    </div>   
                    <div class="single_tab" id="tab_conferences">
                        <h3><?php  _e('<!--:en-->Events<!--:--><!--:fr-->Événements<!--:-->') ?></h3>        
                        <?php show_events(); ?>

                    </div>        
                </div>
			</div>
		</nav><!-- #site-navigation -->
		
        
	</header><!-- #masthead -->

	<div id="main" class="wrapper">
   