<?php
/**
 * The Sidebar containing the header right widget areas.
 *
 * @package Church
 */

if ( is_active_sidebar( 'header-right' ) ) : ?>	

	<aside class="header-right widget-area sidebar">
		
		<?php dynamic_sidebar( 'header-right' ); ?>

  	</aside><!-- .sidebar -->

<?php endif;  ?>