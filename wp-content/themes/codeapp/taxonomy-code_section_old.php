<?php
get_header(); 
	if( is_tax() ) {
		global $wp_query;
		$term = $wp_query->get_queried_object();
		$title = $term->name;
		$section_number = get_tax_meta($term->term_id,'section_number');
		$section_color = get_tax_meta($term->term_id,'section_color');
	} ?>

<?php
    $args = array('taxonomy'=>'code_section', 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => false);
    $categories = get_categories($args);
	print_r($categories);
?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
             <header style="background: <?php echo $section_color; ?>" class="section-header">
                <h1 class="section-title"><span class="code_chapter"><?php echo $section_number; ?></span><?php echo $title; ?></h1>
            </header><!-- .archive-header -->
	        <?php
			
			$top_level = $wp_query->queried_object;
			$title = $top_level->name;
			$top_slug = $top_level->slug;
			$section_number = get_tax_meta($top_level->term_id,'section_number');
			$section_color = get_tax_meta($top_level->term_id,'section_color');
			?>
			
			<?php 				
            
            $args = array(
                'taxonomy' => 'code_section',
                'hide_empty' => 0,
                'hierarchical' => false,
                'orderby' => 'name',
				'order'=> 'ASC',				
                'parent' => get_queried_object()->term_id,
                );
            $first_level = get_categories( $args );		
			print_r($first_level);
			function name_compare( $a, $b ) {
//				echo 'number1: ' . str_replace('.', '', $a->description)  . ', number2: ' . str_replace('.', '', $b->description);
			  	return intval(str_replace('.', '', $a->description)) + intval(str_replace('.', '', $b->description));
			}
			usort($first_level, "name_compare");
            // $first_level now has all the top sections (i.e. 3.1, 3.2, 3.3)
    
            
			// are there any sub-cates? yes...
			if (($first_level)) {
						
				// cycle through each, 
				foreach($first_level as $first_cat) {
					
					$first_level_cat_id = $first_cat->term_id;
					$first_level_cat_name = $first_cat->name;
					$first_level_cat_code = $first_cat->description;
					$first_level_cat_slug = $first_cat->slug;
					// first level title (3.1)
					get_articles($first_level_cat_name, $first_level_cat_code, $first_level_cat_slug);
					//echo 'here: <h2><span class="section_code_chapter">' . $first_level_cat_code . '</span>' . $first_level_cat_name . ' - id: ' . $first_level_cat_id . '</h2>';
		
					
					//get the one that have %first_level_cat_id as a parent,		
					
					$args = array(			
						'taxonomy' => 'code_section',
						'hide_empty' => 0,
						'hierarchical' => false,
						'orderby' => 'name',
						'order'=> 'ASC',
						'parent' => $first_level_cat_id
						);
						
					$second_level = get_categories( $args );
				
					usort($second_level, "name_compare");
					print_r($second_level);
					
					foreach($second_level as $second_cat) {
						$second_level_cat_id = $second_cat->term_id;
						$second_level_cat_name = $second_cat->name;
						$code_name = $second_level_cat_name;				
						$second_level_cat_code = $second_cat->description;
						$code_id = $second_level_cat_code;
						$second_level_cat_slug = $second_cat->slug;
						
						// Second Level level title (3.1.1)				
						//get_articles($second_level_cat_name, $second_level_cat_code, $second_level_cat_slug );
						//echo '<h4><span class="section_code_chapter">' . $second_level_cat_code . '</span>' . $second_level_cat_name . ' - id: ' . $second_level_cat_id . '</h4>';
		
					}
						//get the one that have $second_level_cat_id as a parent,		
						$args = array(			
							'taxonomy' => 'code_section',
							'hide_empty' => 0,
							'hierarchical' => false,
							'orderby' => 'name',
							'order'=> 'ASC',
							'parent' => $second_level_cat_id
							);
						$third_level = get_categories( $args );
						usort($third_level, "name_compare");
						//echo '<ul> third_level: ' . print_r($third_level) . '</ul>';
						/*
						foreach($third_level as $third_cat) {
							$third_level_cat_id = $third_cat->term_id;
							$third_level_cat_name = $third_cat->name;
							$code_name = $third_level_cat_name;
							$third_level_cat_code = $third_cat->description;
							$code_id = $third_level_cat_code;
							$third_level_cat_slug = $third_cat->slug;
							// Third Level level title (3.1.1.1)				
							get_articles($third_level_cat_name, $third_level_cat_code, $third_level_cat_slug );
							//echo '<h5><span class="section_code_chapter">' . $third_level_cat_code . '</span>' . $third_level_cat_name . ' - id: ' . $third_level_cat_id . '</h5>';
			
						}  */    
          	}
		} else { // no sub cats on first_level     
			get_articles($title, $section_number, $top_slug );
		}
            
            
            
            function get_articles($code_name, $code_id, $code_term_id) {
                //echo 'getting article: ' . $code_name .', ' . $code_id .', code_term_id: ' . $code_term_id . '...';
                $theargs = array( 'post_type'=>'code', 'code_section'=>$code_term_id, 'order'=>'ASC');
                $codes = new WP_Query( $theargs);
                //prinat_r($codes);
        
                if ( $codes->have_posts() ) {				
                    $current_id = $post->ID;
                    //echo 'current_id: ' . $current_id;	
                    
                    while ( $codes->have_posts() ) : $codes->the_post();
                        echo 'hey this happens';
						get_template_part( 'content-code_sections' );	
                    endwhile;
                }
            } ?>
		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_footer(); ?>