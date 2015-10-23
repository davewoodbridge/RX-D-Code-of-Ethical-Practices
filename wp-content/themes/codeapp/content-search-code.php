

	<?php 
	$thecontent = get_the_content();

	if($thecontent) {
		global $wp_query;
		$terms = get_the_terms($post->ID, 'code_section');
		
		foreach($terms as $term) {		
			$sectionname[] = $term->name;
			$sectionid[] = $term->term_id;
			$sectionurl[] = get_term_link($term->slug,'code_section');
			$sectionparent[] = $term->parent;
		}
		
		$title = $sectionname[0];
		$term_id = $sectionid[0];
		$section_parent = $sectionparent[0];
//		echo 'the parent: ' . $sectionparent[0];		
		$section_number = get_tax_meta($sectionid[0],'section_number');
		
		if($section_parent) {
			$args = array(			
				'taxonomy' => 'code_section',
				'hide_empty' => 0,
				'hierarchical' => true,
				'orderby' => 'term_order',
				'order'=> 'ASC',
				'include'=> $section_parent
				);
			$next_up = get_categories( $args );
			//print_r($next_up);
			foreach($next_up as $leveltwo) {
				//print_r($level_two);		
				$parentname[] = $leveltwo->name;
				$parentid[] = $leveltwo->term_id;
				$parenturl[] = get_term_link($leveltwo->slug,'code_section');
				$parentparent[] = $leveltwo->parent;
			}
			$parent_name = $parentname[0];
			//echo 'parent_name: ' . $parent_name;
			$parent_id = $parentid[0];
			$parent_parent = $parentparent[0];
			$parent_section_number = get_tax_meta($parent_id,'section_number');
			
			
			if($parent_parent) {
				$args = array(
					'taxonomy' => 'code_section',
					'hide_empty' => 0,
					'heirarchical' => true,
					'orderby' => 'term_order',
					'order' => 'ASC',
					'include' => $parent_parent
					);
				$two_up = get_categories($args);
				foreach($two_up as $levelthree) {
					$parent_parentname[] = $levelthree->name;
					$parent_parentid[] = $levelthree->term_id;
					$parent_parenturl[] = get_term_link($levelthree->slug,'code_section');
					$parent_parentparent[] = $levelthree->parent;
				}
				$parent_parent_name = $parent_parentname[0];
				//echo 'parent_name: ' . $parent_name;
				$parent_parent_id = $parent_parentid[0];
				$parent_parent_parent = $parent_parentparent[0];
				$parent_parent_section_number = get_tax_meta($parent_parent_id,'section_number');				
				
			}
		}
		
		
		
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class($extraclass); ?>>
			<header class="entry-header">
				<h2 class="search_title"><a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php if($parent_parentname) echo $parent_parent_section_number . ' > ' . $parent_parent_name . ' > '; if($parentname) echo $parent_section_number . ' > '; if($parent_section_number != $parent_name) echo $parent_name . ' > '; echo $section_number; if($section_number != $title) echo $title; ?></a></h2>
			</header><!-- .entry-header -->
	
		
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div>
		</article>
   	<?php } ?>