<?php
/** Template Name: Landing Page
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<div id="homepage_info">
            	<div class="homepage_left">
                 2015
                </div>
            	<div class="homepage_right">
                    <div class="homepage_right_top">
                    	<a href="/fr/home/" title="Code d'ethique en Francais">Code d'éthique<span>Appuyez ici pour Francais</span></a>
                    </div>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/bg_rainbox.jpg" class="separator" alt="Rainbow">
                    <div class="homepage_right_bottom">
                    	<a href="/en/home/" title="Code of Ethics in English">Code of Ethics<span>Click Here for English</span></a>
                    </div>                
                </div>
                

                
            </div>


		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>