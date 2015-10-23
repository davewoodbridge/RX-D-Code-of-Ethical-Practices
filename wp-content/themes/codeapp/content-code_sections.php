	<?php
	
	$code_sections = get_the_terms($post->ID, 'code_section');
	$code_name = array();
	$code_id = array();
	$code_parent = array();
	$code_term_id = array();
	
	if($code_sections) {
		foreach($code_sections as $code_section) {
			$code_name[] = $code_section->name;
			$code_id[] = $code_section->description;
			$code_parent[] = $code_section->parent;
			$code_term_id[] = $code_section->term_id;
		}
	}
	$code_name = $code_name[0];
	$code_id = $code_id[0];
	$code_parent = $code_parent[0];
	$code_term_id = $code_term_id[0];
	
	

	$dot_count = substr_count( $code_id, '.');
	$level = $dot_count;
	//echo '<br>///$code_id: ' . $code_id . ', dot_count: ' . $dot_count . '///<br>';
	//echo '///name: ' . $code_name . ', section: ' . $code_id. ', code_parent: ' . $code_parent;
	//if($parent_parent) echo '$parent_parent : '. $parent_parent;
	//echo ', level: ' . $level . ' ///';
	//echo '<br>' . print_r($code_sections);
	
	if ( is_search() ) { // Only display Excerpts for Search ?>
        <header class="entry-header">
	        <h2 class="section-title"><a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><span class="section_code_chapter"><?php echo $code_id; ?></span><?php the_title(); ?></a></h2>
        </header><!-- .entry-header -->

    
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    <?php } else {
			$code_title_annotation = get_post_meta( $post->ID, 'code_title_annotation', true );  
			if($code_title_annotation) {
				$code_title_footnote = '<a class="title_footnote" href="#" id="refmark-99"><sup>1</sup></a><div class="title_footnote_content">' . $code_title_annotation . '</div>';
			} else {
				$code_title_footnote = "";
			}
			$code_force_title = get_post_meta( $post->ID, 'code_force_title', true );  
			$code_hide_chapter = get_post_meta( $post->ID, 'code_hide_chapter', true );  
			$code_hide_id = get_post_meta( $post->ID, 'code_hide_id', true ); 
			if($level == 4) { $extra_class = 'extraindent'; }
			?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class($extra_class); ?>>
				<header class="entry-header">
                
				<?php 
				// if it is a top-level major section title
					if($level == 1 || $one_up->ID == 19) { 

						// if a first-level heading, like 3.1 
						
						if($code_hide_chapter == "on") { ?>
							<h2 class="section-title"><span class="section_code_chapter"><?php echo $code_id; ?></span><?php echo $code_title_footnote; ?></h2>
							
						<?php } elseif($code_hide_id == "on") { ?>
							<h2 class="section-title"><?php the_title(); ?><?php if (function_exists('wpfp_link') && !is_single()) { wpfp_link(); } ?><?php echo $code_title_footnote; ?></h2>
							
						<?php } elseif($code_force_title == "on") { ?>
                        	<h2 class="section-title"><span class="section_code_chapter"><?php echo $code_id; ?></span><?php the_title(); ?><?php if (function_exists('wpfp_link') && !is_single()) { wpfp_link(); } ?><?php echo $code_title_footnote; ?></h2>
                        
                        <?php } else { ?>
	                    	<h2 class="section-title"><span class="section_code_chapter"><?php echo $code_id; ?></span><?php the_title(); ?><?php if (function_exists('wpfp_link') && !is_single()) { wpfp_link(); } ?><?php echo $code_title_footnote; ?></h2>
						<?php }
						
					} elseif($level == 2) {
						// if's a a second-level heading (i.e. 3.1.1) 
						
						if($code_force_title == "on") { ?>
                        	<h3 class="subsection-title forcetitle"><span class="section_code_chapter"><?php echo $code_id; ?></span><?php the_title(); ?><?php echo $code_title_footnote; ?></h3>
                        
                        <?php } else { ?>
                        	<h3 class="subsection-title"><span class="section_code_chapter"></span><?php echo $code_id; ?><?php echo $code_title_footnote; ?></h3>
                        
                        <?php } ?> 

				<?php } elseif($level == 3 || $level == 4) {
						// if's a a second-level heading (i.e. 3.1.1) ?> 

                        <h3 class="subsection-title subsub"><span class="section_code_chapter"></span><?php echo $code_id; ?><?php echo $code_title_footnote; ?></h3>
				<?php } ?>
				</header><!-- .entry-header -->
				
				<div class="section-content">
					<?php the_content(); ?>				
				</div><!-- .entry-content -->
                				
				<footer class="entry-meta">
					
				</footer><!-- .entry-meta -->
			</article><!-- #post -->

	<?php } ?>		