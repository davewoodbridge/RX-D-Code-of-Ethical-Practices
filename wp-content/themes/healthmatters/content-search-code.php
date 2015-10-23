

	<?php 
	$code_chapter = get_post_meta( $post->ID, 'code_chapter', true );  
	$code_parent_chapter = get_post_meta( $post->ID, 'code_parent_chapter', true );  
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class($extraclass); ?>>
		<header class="entry-header">
	        <h2 class="search_title"><a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><span class="section_code_chapter"><?php echo $code_chapter; ?></span><?php the_title(); ?></a></h2>
        </header><!-- .entry-header -->

    
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div>
	</article>