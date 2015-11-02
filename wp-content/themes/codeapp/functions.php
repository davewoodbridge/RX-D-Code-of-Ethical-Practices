<?php
// add stylesheet
function fluxworx_scripts() {
	wp_enqueue_style( 'fluxworx', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'fluxworx_scripts' );

// add menu support 
add_theme_support( 'menus' );
// add thumbnail support
add_theme_support( 'post-thumbnails' ); 


// get next and prev cat functions
class wpse_99513_adjacent_category {

    public $sorted_taxonomies;

    /**
     * @param string Taxonomy name. Defaults to 'category'.
     * @param string Sort key. Defaults to 'id'.
     * @param boolean Whether to show empty (no posts) taxonomies.
     */
    public function __construct( $taxonomy = 'code_section', $skip_empty = true ) {

        $this->sorted_taxonomies = get_terms(
            $taxonomy,
            array(
                'get'          => $skip_empty ? '' : 'all',
                'fields'       => 'ids',
                'hierarchical' => false,
            )
        );
//		print_r($this->sorted_taxonomies);
    }

    /**
     * @param int Taxonomy ID.
     * @return int|bool Next taxonomy ID or false if this ID is last one. False if this ID is not in the list.
     */
    public function next( $taxonomy_id ) {

        $current_index = array_search( $taxonomy_id, $this->sorted_taxonomies );

        if ( false !== $current_index && isset( $this->sorted_taxonomies[ $current_index + 1 ] ) )
            return $this->sorted_taxonomies[ $current_index + 1 ];

        return false;
    }

    /**
     * @param int Taxonomy ID.
     * @return int|bool Previous taxonomy ID or false if this ID is last one. False if this ID is not in the list.
     */
    public function previous( $taxonomy_id ) {

        $current_index = array_search( $taxonomy_id, $this->sorted_taxonomies );

        if ( false !== $current_index && isset( $this->sorted_taxonomies[ $current_index - 1 ] ) )
            return $this->sorted_taxonomies[ $current_index - 1 ];

        return false;
    }
}


function basic_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'dwbasic' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'dwbasic' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'dwbasic' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'dwbasic' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'dwbasic' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'dwbasic' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
function basic_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'dwbasic' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'dwbasic' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'dwbasic' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
function dwbasic_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'dwbasic' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'dwbasic' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'dwbasic' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'dwbasic' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'dwbasic' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'dwbasic' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'dwbasic' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}

//
// Add Code custom post type
//

add_action( 'init', 'create_code_type' );
add_action( 'init', 'create_code_types' );
function create_code_type() {
	register_post_type( 'code',
		array(
			'labels' => array(
				'name' => __( 'Code' ),
				'singular_name' => __( 'Code' )
			),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'code'),		
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'hierarchical'        => true,
		'supports'            => array( 'title', 'editor', 'page-attributes' ),
		'taxonomies'          => array( 'code_section' ),
		'query_var'           => true,
		'can_export'          => true,
		'show_in_nav_menus'   => true
		)
	);
}

function create_code_types() {
	$labels = array(
		'name'              => _x( 'Sections', 'taxonomy general name' ),
		'singular_name'     => _x( 'Section', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Sections' ),
		'all_items'         => __( 'All Sections' ),
		'parent_item'       => __( 'Parent Section' ),
		'parent_item_colon' => __( 'Parent Section:' ),
		'edit_item'         => __( 'Edit Section' ),
		'update_item'       => __( 'Update Section' ),
		'add_new_item'      => __( 'Add New Section' ),
		'new_item_name'     => __( 'New Section Name' ),
		'menu_name'         => __( 'Sections' ),
	);
	$args = array(
		'labels' 			=> $labels,
		'public'            => true,
		'show_in_nav_menus' => true,
        'show_admin_column' => true,

		'show_ui'           => true,
		'show_tagcloud'     => false,
		'hierarchical'      => true,
		'rewrite'           => array( 'slug' => 'code-section' ),
	);

	register_taxonomy( 'code_section', 'code', $args );
	
}


add_action( 'add_meta_boxes', 'code_add_custom_box' );
add_action( 'save_post', 'code_save_postdata' );

function code_add_custom_box() {
    $screens = array( 'code');
    foreach ($screens as $screen) {
        add_meta_box(
            'code_details',
            __( 'Code Details', 'dw' ),
            'code_details_content',
            $screen
        );
		
    }
}


function code_details_content( $post ) {
	$code_chapter = get_post_meta( $post->ID, 'code_chapter', true );  
	$code_title_annotation = get_post_meta( $post->ID, 'code_title_annotation_fr', true );  
	$code_title_annotation_fr = get_post_meta( $post->ID, 'code_title_annotation', true );  
	$code_parent_chapter = get_post_meta( $post->ID, 'code_parent_chapter', true );  
	$code_hide_chapter = get_post_meta( $post->ID, 'code_hide_chapter', true );  
	$code_hide_id = get_post_meta( $post->ID, 'code_hide_id', true );  
	$code_force_title = get_post_meta( $post->ID, 'code_force_title', true );  
	
	/*
	echo '<label style="float:left;line-height:22px;width:260px;" for="code_chapter">';
	   _e("Section (i.e. 5.2.1.1): ", 'code_chapter' );
	echo '</label> ';
	
	echo '<input style="width:400px;" type="textbox" id="code_chapter" name="code_chapter" value="' . $code_chapter . '"><br>';
	
	echo '<label style="float:left;line-height:22px;width:260px;" for="code_chapter">';
	   _e("Parent Section: (i.e 5)", 'code_chapter' );
	echo '</label> ';
	*/
	echo '<input style="width:400px;" type="textbox" id="code_parent_chapter" name="code_parent_chapter" value="' . $code_parent_chapter . '">';
	
	echo "<span style='width: 100%;display:inline-block;'>";
	echo '<label style="float:left;line-height:22px;width:260px;" for="code_chapter">';
	   _e("Hide Title?: (i.e. 2.1)", 'code_chapter' );
	echo '</label> ';
	if($code_hide_chapter == "on") {
		echo '<input type="checkbox" id="code_hide_chapter" name="code_hide_chapter" checked="' . $code_hide_chapter . '">';
	} else {
		echo '<input type="checkbox" id="code_hide_chapter" name="code_hide_chapter" >';		
	}
	echo '</span>';
	
	echo "<span style='width: 100%;display:inline-block;'>";
	echo '<label style="float:left;line-height:22px;width:260px;" for="code_chapter">';
	   _e("Hide Chapter?: (i.e. 2.1)", 'code_chapter' );
	echo '</label> ';
	if($code_hide_id == "on") {
		echo '<input type="checkbox" id="code_hide_id" name="code_hide_id" checked="' . $code_hide_id . '">';
	} else {
		echo '<input type="checkbox" id="code_hide_id" name="code_hide_id" >';		
	}
	echo '</span>';	
	
	echo "<span style='width: 100%;display:inline-block;'>";
	echo '<label style="float:left;line-height:22px;width:260px;" for="code_chapter">';
	   _e("Force Full Title?: ", 'code_chapter' );
	echo '</label> ';
	if($code_force_title == "on") {
		echo '<input type="checkbox" id="code_force_title" name="code_force_title" checked="' . $code_force_title . '">';
	} else {
		echo '<input type="checkbox" id="code_force_title" name="code_force_title" >';		
	}
	echo '</span>';	
	
	echo '<label style="float:left;line-height:22px;width:260px;" for="code_chapter">';
	   _e("Title Annotation:", 'code_chapter' );
	echo '</label> ';
	echo '<textarea style="width:600px;display:block;height: 100px;margin-bottom: 15px;" id="code_title_annotation" name="code_title_annotation">' . $code_title_annotation . '</textarea>';

	echo '<label style="float:left;line-height:22px;width:260px;" for="code_chapter">';
	   _e("Title Annotation (French):", 'code_chapter' );
	echo '</label> ';
	echo '<textarea style="width:600px;display:block;height: 100px;margin-bottom: 15px;" id="code_title_annotation_fr" name="code_title_annotation_fr">' . $code_title_annotation_fr . '</textarea>';


}

function code_save_postdata( $post_id ) {
	// Do nothing during a bulk edit
    if (isset($_REQUEST['bulk_edit']))
        return;

	if ( ! current_user_can( 'edit_page', $post_id ) )
		return;

	if ( ! current_user_can( 'edit_post', $post_id ) )
		return;

	$post_ID = $_POST['post_ID'];
	$code_force_title = $_POST['code_force_title'];
	$code_hide_id = $_POST['code_hide_id'];
	$code_hide_chapter = $_POST['code_hide_chapter'];
	$code_chapter = $_POST['code_chapter'];
	$code_parent_chapter = $_POST['code_parent_chapter'];
	$code_title_annotation = $_POST['code_title_annotation'];
	$code_title_annotation_fr = $_POST['code_title_annotation_fr'];

	update_post_meta($post_ID, 'code_title_annotation_fr', $code_title_annotation_fr);
	update_post_meta($post_ID, 'code_title_annotation', $code_title_annotation);
	update_post_meta($post_ID, 'code_force_title', $code_force_title);
	update_post_meta($post_ID, 'code_hide_id', $code_hide_id);	
	update_post_meta($post_ID, 'code_hide_chapter', $code_hide_chapter);
	update_post_meta($post_ID, 'code_chapter', $code_chapter);	
	update_post_meta($post_ID, 'code_parent_chapter', $code_parent_chapter);
	
}

//include the main class file
require_once("Tax-meta-class/Tax-meta-class.php");
 
/*
* configure taxonomy custom fields
*/
$config = array(
   'id' => 'demo_meta_box',                         // meta box id, unique per meta box
   'title' => 'Demo Meta Box',                      // meta box title
   'pages' => array('code_section'),                    // taxonomy name, accept categories, post_tag and custom taxonomies
   'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
   'fields' => array(),                             // list of meta fields (can be added by field arrays)
   'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
   'use_with_theme' => false                        //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
);
 
/*
* Initiate your taxonomy custom fields
*/
 
$custom_meta = new Tax_Meta_Class($config);
//Color field
$custom_meta->addColor('section_color',array('name'=> 'Section Color '));
$custom_meta->addText('section_number',array('name'=> 'Chapter'));
$custom_meta->Finish();


function showTOC($tocID) {
	
	echo '<div class="searchbar">';
	get_search_form();
	echo '</div>';
	echo '<ul id="' . $tocID . '">';
	$sections = get_terms('code_section');
	foreach ($sections as $section) {
		//echo 'section: ' . $section->name;
		$term_id = $section->term_taxonomy_id;
		//echo '<br><br><br>whole thing: ' . print_r($section);
		if($section->parent == 0) {
			$section_color = get_tax_meta($term_id,'section_color');
			$tocnumber = $section->description;
			if($tocnumber) {
				$tocnumber = $tocnumber . ' - ';
			} else {
				$tocnumber = '';
			}
			echo '<li class="single_toc"><span style="background:' . $section_color . '"></span><span class="tocnumber">' . $tocnumber . '</span><a href="' . get_term_link( $section ) . '">' . $section->name . ' </a></li>';
		}
		
	}
	echo '</ul>';
	
}

function get_this_info($this_cat) {

	$this_info = array();	

	foreach ($this_cat as $cat) {
		$thisname[] = $cat->name;					
		$thistermid[] = $cat->term_id;
		$thisparent[] = $cat->parent;
		$thisslug[] = $cat->slug;
	}
	$this_name = $thisname[0];			
	$this_parent = $thisparent[0];
	$this_term_id = $thistermid[0];
	$this_slug = $thisslug[0];
	//echo  'id: ' . $this_term_id;
	$this_code = get_tax_meta($this_term_id,'section_number');
	//echo  'code: ' . $this_code;
	$this_info = array('this_name'=>$this_name, 'this_parent'=>$this_parent, 'this_term_id'=>$this_term_id, 'this_code' => $this_code, 'this_slug' => $this_slug);
	return $this_info;

}
function get_top_level_info($this_cat) {
	//echo ' this_cat: ' . print_r($this_cat);
	foreach ($this_cat as $cat) {
		$thisname[] = $cat->name;					
		$thistermid[] = $cat->term_id;
		$thisparent[] = $cat->parent;
	}
	$this_name = $thisname[0];			
	$this_parent = $thisparent[0];
	$this_term_id = $thistermid[0];


	$this_info = array($this_name, $this_parent, $this_term_id, $this_code);
	
	
	if($this_parent > 0) {
		$args = array(
			'taxonomy' => 'code_section',
			'hide_empty' => 0,
			'hierarchical' => true,
			'orderby' => 'term_order',
			'order'=> 'ASC',				
			'include' => $this_parent,
			);
		$first_level = get_categories( $args );		
		//echo 'first_level id: ' . $first_level[0]->term_id;
		foreach($first_level as $first_cat) {
			$firstname[] = $first_cat->name;					
			$firsttermid[] = $first_cat->term_id;
			$firstparent[] = $first_cat->parent;
			$firstslug[] = $first_cat->slug;
		}
		$first_name = $firstname[0];
		$topname = $first_name;
		$first_parent = $firstparent[0];
		$first_term_id = $firsttermid[0];
		$first_slug = $firstslug[0];
		$topslug = $first_slug;
		
		
		if($first_parent>0) {
			
			$args = array(
				'taxonomy' => 'code_section',
				'hide_empty' => 0,
				'hierarchical' => true,
				'orderby' => 'term_order',
				'order'=> 'ASC',				
				'include' => $first_parent,
				);
			$second_level = get_categories( $args );		
			//echo 'second_level id: ' . $second_level[0]->term_id;
			foreach($second_level as $second_cat) {
				$secondname[] = $second_cat->name;					
				$secondtermid[] = $second_cat->term_id;
				$secondparent[] = $second_cat->parent;
				$secondslug[] = $second_cat->slug;
			}
			$second_name = $secondname[0];
			$topname = $second_name;
			$second_parent = $secondparent[0];
			$second_term_id = $secondtermid[0];	
			$second_slug = $secondslug[0];
			$topslug = $second_slug;									
			
			if($second_parent>0) {
				
				$args = array(
					'taxonomy' => 'code_section',
					'hide_empty' => 0,
					'hierarchical' => true,
					'orderby' => 'term_order',
					'order'=> 'ASC',				
					'include' => $second_parent,
					);
				$third_level = get_categories( $args );		
				//echo 'third_level id: ' . $third_level[0]->term_id;
				foreach($third_level as $third_cat) {
					$thirdname[] = $third_cat->name;					
					$thirdtermid[] = $third_cat->term_id;
					$thirdparent[] = $third_cat->parent;
					$thirdslug[] = $third_cat->slug;
				}
				$third_name = $thirdname[0];
				$topname = $third_name;							
				$third_parent = $thirdparent[0];
				$third_term_id = $thirdtermid[0];										
				$third_slug = $thirdslug[0];
				$topslug = $third_slug;
				
				$this_top = $third_term_id; $this_top_name = $third_name;
				$this_second = $second_term_id; $this_second_name = $second_name;
				$this_third = $first_term_id; $this_third_name = $third_name;
				$this_fourth = $this_term_id; $this_fourth_name = $fourth_name;
				
				
			} else {
				$this_top = $second_term_id; $this_top_name = $third_name;
				$this_second = $first_term_id; $this_second_name = $second_name;
				$this_third = $this_term_id; $this_third_name = $third_name;
			}
		} else {
			$this_top = $first_term_id; $this_top_name = $third_name;
			$this_second = $this_term_id; $this_second_name = $second_name;
		}
	} else {
		$this_top = $this_term_id; $this_top_name = $third_name;
	}
	
	/* Top section info */
	$section_name = $topname;
	$section_number = get_tax_meta($this_top,'section_number');
	$section_color = get_tax_meta($this_top,'section_color');							
	$top_level = array($section_name, $section_number, $section_color);
	?>
    <header style="background: <?php echo $section_color; ?>" class="section-header">
            <h1 class="section-title"><span class="code_chapter"><?php echo $section_number; ?></span><a href="/code-section/<?php echo $topslug; ?>"><?php echo $section_name; ?><?php echo $this_top_name; ?></a></h1>
    </header><!-- .archive-header -->
    <?php 
	$i = array('first_level' => $first_level, 'second_level' => $second_level, 'third_level' => $third_level);
	return $i;
}

function show_news() {
	// Get RSS Feed(s)
	include_once( ABSPATH . WPINC . '/feed.php' );
	
	// Get a SimplePie feed object from the specified feed source.
	$rss = fetch_feed( 'http://healthmatters.davesdev.ca/news/feed/' );

	if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
	
		// Figure out how many total items there are, but limit it to 5. 
		$maxitems = $rss->get_item_quantity( 5 ); 
	
		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items( 0, $maxitems );
	
	else: 
		echo '<br>Sorry, can not connect to news feed.';
	endif;
	?>
	<?php // print_r($rss_items); ?>
	<ul>
		<?php if ( $maxitems == 0 ) : ?>
			<li><?php _e( 'No items', 'my-text-domain' ); ?></li>
		<?php else : ?>
			<?php // Loop through each feed item and display each item as a hyperlink. ?>
			<?php foreach ( $rss_items as $item ) : ?>
				<li>
					<a href="<?php echo esc_url( $item->get_permalink() ); ?>"
						title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('j F Y | g:i a') ); ?>">
						<?php echo esc_html( $item->get_title() ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
	<?php 

}

function show_events() {
	// Get RSS Feed(s)
	include_once( ABSPATH . WPINC . '/feed.php' );
	
	// Get a SimplePie feed object from the specified feed source.
	$rss = fetch_feed( 'http://healthmatters.davesdev.ca/events/feed/' );

	if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
	
		// Figure out how many total items there are, but limit it to 5. 
		$maxitems = $rss->get_item_quantity( 5 ); 
	
		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items( 0, $maxitems );
	
	else: 
		echo '<br>Sorry, can not connect to the events feed.';
	endif;
	?>
	<?php // print_r($rss_items); ?>
	<ul>
		<?php if ( $maxitems == 0 ) : ?>
			<li><?php _e( 'No items', 'my-text-domain' ); ?></li>
		<?php else : ?>
			<?php // Loop through each feed item and display each item as a hyperlink. ?>
			<?php foreach ( $rss_items as $item ) : ?>
				<li>
					<a href="<?php echo esc_url( $item->get_permalink() ); ?>"
						title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('j F Y | g:i a') ); ?>">
						<?php echo esc_html( $item->get_title() ); ?>
					</a>
                    <div class="event_info"><?php echo $item->get_description(); ?></div>
                    <?php //print_r($item); ?>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
	<?php 

}

/* Fav posts bilingual stuff */

function get_add_text() {
	global $q_config;
	$current_language = $q_config[language];
	if($current_language == "en") {
		return "Add to Favourites";
	} else {
		return "Ajoutez aux favoris";
	}
}
function get_added_text() {
	global $q_config;
	$current_language = $q_config[language];
	if($current_language == "en") {
		return "Added";
	} else {
		return "Ajouté";
	}
}
function get_remove_text() {
	global $q_config;
	$current_language = $q_config[language];
	if($current_language == "en") {
		return "Remove";
	} else {
		return "Supprimer";
	}
}
function get_clear_text() {
	global $q_config;
	$current_language = $q_config[language];
	if($current_language == "en") {
		return "Clear Favourites";
	} else {
		return "Effacez mes favoris";
	}
}

// init process for registering our button
 add_action('init', 'wpse72394_shortcode_button_init');
 function wpse72394_shortcode_button_init() {

      //Abort early if the user will never see TinyMCE
      if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
           return;

      //Add a callback to regiser our tinymce plugin   
      add_filter("mce_external_plugins", "wpse72394_register_tinymce_plugin"); 

      // Add a callback to add our button to the TinyMCE toolbar
      add_filter('mce_buttons', 'wpse72394_add_tinymce_button');
}


//This callback registers our plug-in
function wpse72394_register_tinymce_plugin($plugin_array) {
    $plugin_array['wpse72394_button'] = '/wp-content/themes/codeapp/shortcode.js';
    return $plugin_array;
}

//This callback adds our button to the toolbar
function wpse72394_add_tinymce_button($buttons) {
            //Add the button ID to the $button array
    $buttons[] = "wpse72394_button";
    return $buttons;
}


?>