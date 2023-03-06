<?php 

/**
 * Class to register profile meta fields
 */
class WPProfileMeta
{
	
	function __construct()
	{
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post',      array( $this, 'save' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box( $post_type ) {
		// Limit meta box to certain post types.
		$post_types = array( 'wp-profiles' );

		if ( in_array( $post_type, $post_types ) ) {
			add_meta_box(
				'Profile Data',
				__( 'Profile Data', 'wp-profile' ),
				array( $this, 'render_meta_box_content' ),
				$post_type,
				'advanced',
				'high'
			);
		}
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'wpprofile_meta_data', 'wpprofile_meta_data_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$dob 				 = get_post_meta( $post->ID, 'dob', true );
		$hobbies 			 = get_post_meta( $post->ID, 'hobbies', true );
		$interests 			 = get_post_meta( $post->ID, 'interests', true );
		$years_of_experience = get_post_meta( $post->ID, 'years_of_experience', true );
		$jobs_completed 	 = get_post_meta( $post->ID, 'jobs_completed', true );
		$ratings 			 = get_post_meta( $post->ID, 'ratings', true );

		?>

		<style type="text/css">
			.form-group {
				margin: 15px 0;
			    display: flex;
			    flex-direction: column;
			}
			.form-control {
				width: 50%;
			}
		</style>

		<div class="form-group">
			<label for="dob">
				<?php _e( 'Date of Birth', 'wp-profile' ); ?>
			</label>
			<input type="date" id="dob" name="dob" class="form-control" value="<?php echo esc_attr( $dob ); ?>" />
		</div>

		<div class="form-group">
			<label for="hobbies">
				<?php _e( 'Hobbies', 'wp-profile' ); ?>
			</label>
			<input type="text" id="hobbies" name="hobbies" class="form-control" value="<?php echo esc_attr( $hobbies ); ?>" />
		</div>

		<div class="form-group">
			<label for="interests">
				<?php _e( 'Interests', 'wp-profile' ); ?>
			</label>
			<input type="text" id="interests" name="interests" class="form-control" value="<?php echo esc_attr( $interests ); ?>" />
		</div>

		<div class="form-group">
			<label for="years_of_experience">
				<?php _e( 'Years of experience', 'wp-profile' ); ?>
			</label>
			<input type="number" id="years_of_experience" name="years_of_experience" class="form-control" value="<?php echo esc_attr( $years_of_experience ); ?>" />
		</div>

		<div class="form-group">
			<label for="jobs_completed">
				<?php _e( 'No jobs completed', 'wp-profile' ); ?>
			</label>
			<input type="number" id="jobs_completed" name="jobs_completed" class="form-control" value="<?php echo esc_attr( $jobs_completed ); ?>" />
		</div>

		<div class="form-group">
			<label for="ratings">
				<?php _e( 'Ratings', 'wp-profile' ); ?>
			</label>
			<input type="number" id="ratings" name="ratings" class="form-control" value="<?php echo esc_attr( $ratings ); ?>" />
		</div>


		<?php
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['wpprofile_meta_data_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['wpprofile_meta_data_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'wpprofile_meta_data' ) ) {
			return $post_id;
		}

		/*
		 * If this is an autosave, our form has not been submitted,
		 * so we don't want to do anything.
		 */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		/* OK, it's safe for us to save the data now. */

		// Sanitize the user input.
		$dob 				 = sanitize_text_field( $_POST['dob'] );
		$hobbies 			 = sanitize_text_field( $_POST['hobbies'] );
		$interests 			 = sanitize_text_field( $_POST['interests'] );
		$years_of_experience = absint( $_POST['years_of_experience'] );
		$jobs_completed 	 = absint( $_POST['jobs_completed'] );
		$ratings 			 = absint( $_POST['ratings'] );

		// Update the meta field.
		update_post_meta( $post_id, 'dob', $dob );
		update_post_meta( $post_id, 'hobbies', $hobbies );
		update_post_meta( $post_id, 'interests', $interests );
		update_post_meta( $post_id, 'years_of_experience', $years_of_experience );
		update_post_meta( $post_id, 'jobs_completed', $jobs_completed );
		update_post_meta( $post_id, 'ratings', $ratings );

	}

}