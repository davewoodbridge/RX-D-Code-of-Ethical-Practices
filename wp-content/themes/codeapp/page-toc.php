<?php
/** Template Name: TOC */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<div id="nav_tabs">
                <div class="single_tab" id="tab_toc">
                	<h3>Table of Contents</h3>
                    <?php showTOC('toc'); ?>
                </div>   
                <div class="single_tab" id="tab_fav">
                	<h3>My Faves</h3>
                    <?php
                    wpfp_list_favorite_posts();
                    ?>
                    
                </div>   
                <div class="single_tab" id="tab_news">
        			<h3>Pharma News</h3>
        
                </div>   
                <div class="single_tab" id="tab_conferences">
        			<h3>Pharma Conferences</h3>        
        
                </div>        
            </div>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>