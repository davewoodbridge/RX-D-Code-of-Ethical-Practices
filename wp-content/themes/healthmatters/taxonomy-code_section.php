<?php


get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
		
		<?php 
		$codes = new WP_Query( $query_string . "&orderby=menu_order");
		
		
		if ( $codes->have_posts() ) : 
		if( is_tax() ) {
			global $wp_query;
			$term = $wp_query->get_queried_object();
			$title = $term->name;
			$section_number = get_tax_meta($term->term_id,'section_number');
			$section_color = get_tax_meta($term->term_id,'section_color');
		} ?>
			<header style="background: <?php echo $section_color; ?>" class="section-header">
				<h1 class="section-title"><span class="code_chapter"><?php echo $section_number; ?></span><?php echo $title; ?></h1>
			</header><!-- .archive-header -->

			<?php
			$current_id = $post->ID;
			//echo 'current_id: ' . $current_id;
	
			/* Start the Loop */
			while ( $codes->have_posts() ) : $codes->the_post();

				
				get_template_part( 'content-code_sections' );

			endwhile;

			basic_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>