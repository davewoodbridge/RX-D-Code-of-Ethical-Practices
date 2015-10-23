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
	$code_parent_chapter = get_post_meta( $post->ID, 'code_parent_chapter', true );  

	echo '<label style="float:left;line-height:22px;width:260px;" for="code_chapter">';
	   _e("Section: ", 'code_chapter' );
	echo '</label> ';
	
	echo '<input style="width:400px;" type="textbox" id="code_chapter" name="code_chapter" value="' . $code_chapter . '">';
	
	echo '<label style="float:left;line-height:22px;width:260px;" for="code_chapter">';
	   _e("Parent Section: ", 'code_chapter' );
	echo '</label> ';
	
	echo '<input style="width:400px;" type="textbox" id="code_parent_chapter" name="code_parent_chapter" value="' . $code_parent_chapter . '">';
	
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
	
	$code_chapter = $_POST['code_chapter'];
	$code_parent_chapter = $_POST['code_parent_chapter'];
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
	echo '<ul id="' . $tocID . '">';
	$sections = get_terms('code_section');
	foreach ($sections as $section) {
		//echo 'section: ' . $section->name;
		$term_id = $section->term_taxonomy_id;
		//echo '<br><br><br>whole thing: ' . print_r($section);
		
		$section_color = get_tax_meta($term_id,'section_color');
		echo '<li class="single_toc"><span style="background:' . $section_color . '"></span><a href="' . get_term_link( $section ) . '">' . $section->name . ' </a></li>';

		
	}
	echo '</ul>';
	
}
?>