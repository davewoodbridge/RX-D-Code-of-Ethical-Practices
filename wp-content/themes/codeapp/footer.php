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



<script>
jQuery(window).resize( function() {
		console.log('moving');
	if(jQuery(window).width() < 480) {
		console.log('yep');
		jQuery('#buttons .button_toc').text('TOC');
		jQuery('#buttons .button_fav').text('FAV');
	} else {
		jQuery('#buttons .button_toc').text('Table of Contents');
		jQuery('#buttons .button_fav').text('Favourites');
	}			
});
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
	if(jQuery(window).width() < 480) {
		console.log('yep');
		jQuery('#buttons .button_toc').text('TOC');
		jQuery('#buttons .button_fav').text('FAV');
	} else {
		jQuery('#buttons .button_toc').text('Table of Contents');
		jQuery('#buttons .button_fav').text('Favourites');
	}	
});
</script>

</html>