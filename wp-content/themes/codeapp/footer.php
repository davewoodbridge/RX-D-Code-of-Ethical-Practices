<?php

?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		<div class="site-info">
		
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php 



wp_footer(); ?>
</body>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.jscrollpane.min.js"></script>


<script>
function add_this_fav(post_id) {
	jQuery('#tab_fav').load(document.URL +  ' .wpfp-span');	
}
function showMenu() {
	toc = jQuery('#navigation');
	console.log('left: ' + parseInt(toc.css('left')));
	if(parseInt(toc.css('left')) < 0 ) {		
		toc.animate( {left: "0"},500);
	} else {
		toc.animate( {left: "-100%"},500);
	}
}

function showTab(section) {
	
	if(section == "toc") margin = "0";
	if(section == "fav") margin = "-100%";
	if(section == "news") margin = "-200%";
	if(section == "conf") margin = "-300%";
	
	jQuery('#nav_tabs').animate( { marginLeft: margin }, 500);
}

jQuery(document).ready( function() {
	jQuery('.title_footnote').hover( 
		function() {
			jQuery(this).next('.title_footnote_content').fadeIn(100);
		}, 
		function() {
			jQuery(this).next('.title_footnote_content').fadeOut(700);
		} 
	);
	
});
</script>
    
<script>
jQuery(window).load( function() {
	//$('.single_tab').show().jScrollPane({ autoReinitialise: true 	});
	
	/*var pane = jQuery('.single_tab');

	var settings = { 
		autoReinitialize: true 
	}
	pane.jScrollPane(settings);*/
});
</script>
</html>