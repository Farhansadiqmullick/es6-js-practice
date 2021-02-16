<?php
/**
 * Displays the searchform of the theme.
 *
 * @package    WordPress
 * @subpackage Jannah Lite
 * @since      Jannah Lite 1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<form action="<?php echo esc_url( home_url( '/' ) ); ?>"
      class="search-form searchform clearfix"
      method="get"
      role="search"
>

	<div class="search-wrap">
		<input type="search"
		       class="s field"
		       name="s"
		       value="<?php echo get_search_query(); ?>"
		       placeholder="<?php esc_attr_e( 'Search for', 'jannah-lite' ); ?>"
		/>

		<button type="submit"><i class="fas fa-search"></i></button>
	</div>

</form><!-- .searchform -->