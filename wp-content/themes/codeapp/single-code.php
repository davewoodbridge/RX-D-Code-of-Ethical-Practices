<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

function get_articles($code_name, $code_id, $code_term_id) {
	//echo 'getting article: ' . $code_name .', ' . $code_id .', code_term_id: ' . $code_term_id . '...';
	$theargs = array( 'post_type'=>'code', 'code_section'=>$code_term_id, 'order'=>'ASC');
	$codes = new WP_Query( $theargs);
	//prinat_r($codes);

	if ( $codes->have_posts() ) {				
		$current_id = $post->ID;
		//echo 'current_id: ' . $current_id;	
		
		while ( $codes->have_posts() ) : $codes->the_post();
			get_template_part( 'content-code_sections' );	
		endwhile;
	}
}

get_header(); ?>

	<section id="primary" class="site-content">
		<section id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				
                <?php	
				$this_cat = get_the_terms($post->ID, 'code_section');		
				$i = get_top_level_info($this_cat);
		/*
				$first_level = $i[first_level];
				$second_level = $i[second_level];
				$third_level = $i[third_level];
		
				if($first_level) {
					foreach($first_level as $first_cat) {
						$firstname[] = $first_cat->name;					
						$firsttermid[] = $first_cat->term_id;
						$firstparent[] = $first_cat->parent;
					}
					$first_name = $firstname[0];
					$topname = $first_name;
					$first_parent = $firstparent[0];
					$first_term_id = $firsttermid[0];
				}
				if($second_level) {
					foreach($second_level as $second_cat) {
						$secondname[] = $second_cat->name;					
						$secondtermid[] = $second_cat->term_id;
						$secondparent[] = $second_cat->parent;
					}
					$second_name = $secondname[0];
					$topname = $second_name;
					$second_parent = $secondparent[0];
					$second_term_id = $secondtermid[0];										
				}
				if($third_level) {
					foreach($third_level as $third_cat) {
						$thirdname[] = $third_cat->name;					
						$thirdtermid[] = $third_cat->term_id;
						$thirdparent[] = $third_cat->parent;
					}
					$third_name = $thirdname[0];
					$topname = $third_name;							
					$third_parent = $thirdparent[0];
					$third_term_id = $thirdtermid[0];	
				}
				
				//echo 'i: ' . print_r($i);
				*/
				?>
				
				<?php  
				// this 

				$this_cat = get_the_terms($post->ID, 'code_section');		
				$this_info = get_this_info($this_cat);
				//echo ' this-info: ' . $this_info[this_name];

				$args = array('post_type'=>'code', 'code_section'=>$this_info[this_slug], 'posts_per_page'=>1);
				
				$thearticles = get_posts($args);
				//echo 'articles: ' . print_r($thearticles);
				foreach($thearticles as $thearticle) { ?>
					
					<header class="entry-header">
			
                       <h2 class="section-title"><span class="section_code_chapter"><?php echo $this_info[this_code]; ?></span><?php echo $thearticle->post_title; ?><?php if (function_exists('wpfp_link')) { wpfp_link(); } ?></h2>    
                
                    </header><!-- .entry-header -->
                    <div class="section-content">
						<?php echo apply_filters('the_content',$thearticle->post_content); ?>
                    </div><!-- .entry-content -->
                    <footer class="entry-meta">
			
					</footer><!-- .entry-meta -->
				
				<?php 
				}
				/*
				if($this_fourth) {
					echo 'fourth';
					echo '<h3>' . $this_second_name . '</h3><br>';
					echo '<h4>' . $this_third_name . '</h4><br>';					
					echo '<h5>' . $this_fourth_name . '</h5><br>////';										
				} elseif($this_third) {
					echo 'third';					
					echo '<h3>' . $this_second_name . '</h3><br>';
					echo '<h4>' . $this_third_name . '</h4><br>///';					
				} elseif($this_second) {
					echo 'second';					
					echo '<h3>aa' . $second_name . '</h3><br>//';
				} else {
					echo 'first';					
				}
				*/
				?>
				<?php
				$this_term_id = $this_info[this_term_id];
				
				?>
				<?php $args = array(
					'taxonomy' => 'code_section',
					'hide_empty' => 0,
					'hierarchical' => true,
					'orderby' => 'term_order',
					'order'=> 'ASC',				
					'parent' => $this_term_id,
					);
				$first_level = get_categories( $args );		
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
							'hierarchical' => true,
							'orderby' => 'term_order',
							'order'=> 'ASC',
							'parent' => $first_level_cat_id
							);
						$second_level = get_categories( $args );
						
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
								'hierarchical' => true,
								'orderby' => 'term_order',
								'order'=> 'ASC',
								'parent' => $second_level_cat_id
								);
							$third_level = get_categories( $args );
			
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
				
				
				
			 ?>

			<?php endwhile; // end of the loop. ?>

		</section><!-- #content -->
	</section><!-- #primary -->

<?php get_footer(); ?>