<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		<div class="site-info">
		
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
<script>

function showMenu() {
	toc = jQuery('#navigation');
	console.log('left: ' + parseInt(toc.css('left')));
	if(parseInt(toc.css('left')) < 0 ) {		
		toc.animate( {left: "0"},500);
	} else {
		toc.animate( {left: "-100%"},500);
	}
}
</script>
</html>