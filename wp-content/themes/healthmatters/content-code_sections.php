	<?php

	$code_chapter = get_post_meta( $post->ID, 'code_chapter', true );  
	$code_parent_chapter = get_post_meta( $post->ID, 'code_parent_chapter', true );  
	//echo 'code chapter: ' . $code_chapter . ', code chapter parent: ' . $code_parent_chapter;
	if($post->post_parent) {		
		$one_up = get_post($post->post_parent);
		//echo '<br>one_up: ' . $one_up->ID;
		$up = 0;
		if($one_up->post_parent) {
			$two_up = get_post($one_up->post_parent);
			//echo '<br>two_up: ' . $two_up->ID;
			
			if($two_up->post_parent) {
				$three_up = get_post($two_up->post_parent);
				//echo '<br>three_up: ' . $three_up->ID;
				$up = 3;
			} else {
				$up = 2;
			}
		} else {
			$up = 1;
		}
	}
	echo 'up: ' . $up;
	
	if ( is_search() ) { // Only display Excerpts for Search ?>
        <header class="entry-header">
	        <h2 class="section-title"><a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><span class="section_code_chapter"><?php echo $code_chapter; ?></span><?php the_title(); ?></a></h2>
        </header><!-- .entry-header -->

    
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    <?php } else {
		if($one_up->ID != $current_id) {
			?>
			<?php $extraclass=""; if(!$code_chapter) $extraclass = " no_chapter_number"; ?>
	
			<article id="post-<?php the_ID(); ?>" <?php post_class($extraclass); ?>>
				<header class="entry-header">
                
				<?php 
					// if it's not a major section header 
					if($up == 1 || $one_up->ID == 19) { ?>                                                     
						<?php if(!$code_parent_chapter) { ?>
							<h2 class="section-title"><span class="section_code_chapter"><?php echo $code_chapter; ?></span><?php the_title(); ?></h2>
						<?php } else { 
							// if the code_chapter ends in a 1, add the code_chapter_parent
							if(substr($code_chapter,strlen($code_chapter)-1) == "1") { ?>
                                <h2 class="section-title"><span class="section_code_chapter"><?php echo $code_parent_chapter; ?></span><?php the_title(); ?></h2>
                                <h3 class="subsection-title"><?php echo $code_chapter; ?></h3>
						<?php } else {
							// otherwise just the heading... ?>
								<h3 class="subsection-title"><?php echo $code_chapter; ?></h3>
                        <?php }
						 } ?>                    
				<?php } else {  ?>
							<h2 class="section-title"><span class="section_code_chapter"><?php echo $code_chapter; ?></span><?php the_title(); ?></h2>
				<?php } ?>
				</header><!-- .entry-header -->
				
				
				<div class="section-content">
					<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'dwbasic' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'dwbasic' ), 'after' => '</div>' ) ); ?>
				</div><!-- .entry-content -->
				
		
				<footer class="entry-meta">
					
				</footer><!-- .entry-meta -->
			</article><!-- #post -->

		<?php } ?>
	<?php } ?>		