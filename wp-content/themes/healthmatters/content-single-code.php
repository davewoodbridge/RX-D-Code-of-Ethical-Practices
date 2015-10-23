
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<?php
			global $wp_query;
			$terms = get_the_terms($post->ID, 'code_section');
			
			foreach($terms as $term) {		
				$sectionname[] = $term->name;
				$sectionid[] = $term->term_id;
				$sectionurl[] = get_term_link($term->slug,'code_section');
			}
			
			$title = $sectionname[0];
			$section_number = get_tax_meta($sectionid[0],'section_number');
			$section_color = get_tax_meta($sectionid[0],'section_color');
			//echo 'title: ' . $title . ', number: ' . $section_number . ', color: ' . $section_color; 
			 
			$code_chapter = get_post_meta( $post->ID, 'code_chapter', true );  
			$code_parent_chapter = get_post_meta( $post->ID, 'code_parent_chapter', true );  
			
			?>
		<header style="background: <?php echo $section_color; ?>" class="section-header">
			<h1 class="section-title"><a href="<?php echo $sectionurl[0]; ?>" title="<?php echo $title; ?>"><span class="code_chapter"><?php echo $section_number; ?></span><?php echo $title; ?></a></h1>
		</header><!-- .archive-header -->
		
        <header class="entry-header">
			
			<?php if(!$code_parent_chapter) { ?>
                <h2 class="section-title"><span class="section_code_chapter"><?php echo $code_chapter; ?></span><?php the_title(); ?></h2>
            <?php } else { ?>
                <h2 class="section-title"><span class="section_code_chapter"><?php echo $code_parent_chapter; ?></span><?php the_title(); ?></h2>
                <h3 class="subsection-title"><?php echo $code_chapter; ?></h3>
            <?php } ?>                    
    
        </header><!-- .entry-header -->
            
		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="section-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'dwbasic' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'dwbasic' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">
			
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
