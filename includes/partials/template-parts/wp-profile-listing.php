<?php 

/**
 * Template File to wp profile table 
 * 
 */

$order = ( isset( $_POST['order'] ) && $_POST['order'] === 'ASC' ) ? 'ASC' : 'DESC';
$paged = ( isset( $_POST['paged'] ) && absint( $_POST['paged'] ) ) ? absint( $_POST['paged'] ) : 1;
$posts_per_page = 5;
$offset = ( $paged - 1 ) * $posts_per_page;

?>

<div class="wp-profile-listing" >
	<table class="wp-profile-tbl" >
		<thead>
			<tr>
				<th>No.</th>
				<th class="sort <?php echo $order ?>" >Profile Name</th>
				<th>Age</th>
				<th>Years of expriance</th>
				<th>No of jobs completed</th>
				<th>Ratings</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			if ( $profiles->have_posts() ) :
				$row = $offset;
				while ( $profiles->have_posts() ) :
					$profiles->the_post();
					
					/**
					 * Include wp profile table row contentn
					 * 
					 */
					include( plugin_dir_path( __FILE__ ) . 'wp-profile-table-content.php' );
				
				endwhile;
				//reset post data to default
				wp_reset_postdata();
				?>
			<?php else : ?>
				<tr class="no-records-found" >
					<td colspan="6" >
						<p><?php _e( 'No profile found!', 'wp-profile' ); ?></p>
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>

	<?php
		/**
		 * Include wp profile pagination contentn
		 * 
		 */
		include( plugin_dir_path( __FILE__ ) . 'wp-profile-pagination.php' );
	?>
</div>