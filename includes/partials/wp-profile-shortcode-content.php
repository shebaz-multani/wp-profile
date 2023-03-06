<?php

//Enqueue shortcode stylesheets file
wp_enqueue_style('select2');
wp_enqueue_style($this->shortcode_name);

//Enqueue shortcode JavaScript file
wp_enqueue_script('select2');
wp_enqueue_script($this->shortcode_name);

//Query for getting profiles
if ( ! isset($profiles) ) {
	$posts_per_page = 5;
	$profiles = new WP_Query([
		'post_type' 	 => 'wp-profiles',
		'paged' 		 => 1,
		'posts_per_page' => $posts_per_page,
	]);
}


?>

<div class="wp-profile-main">
	
	<?php 

		/**
		 * Include WP Profile filter content
		 * 
		 */
		include( plugin_dir_path( __FILE__ ) . 'template-parts/wp-profile-filter.php' );
	?>

	<div class="wp-profile-listing-main">

		<?php
			/**
			 * Include wp Profile lisitng table conent
			 * 
			 */
			include( plugin_dir_path( __FILE__ ) . 'template-parts/wp-profile-listing.php' );
		?>
	</div>

	
</div>
	