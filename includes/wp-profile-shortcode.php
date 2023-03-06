<?php
/**
 * Register public shortcode for search/filter and listing functionality 
 */
class WPProfileShortcode
{	

	/**
	 * The unique identifier of shortcode name.
	 *
	 * @access   protected
	 * @var      string    $shortcode_name    The string used to uniquely identify shortcode name.
	 */
	protected $shortcode_name;

	function __construct()
	{
		//Set Shortcode name
		$this->shortcode_name = 'wp_profiles';

		//Register shortcode
		add_shortcode( $this->shortcode_name , array( $this, 'wp_profiles_callable') );

		//Regsiter shortcode stylesheets file
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles') );
		
		//Regsiter shortcode JavaScript file
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts') );

		//Regsiter ajax filter action
		add_action('wp_ajax_wpprofile_ajax_filter', array( $this, 'wpprofile_ajax_filter' ) );
		add_action('wp_ajax_nopriv_wpprofile_ajax_filter', array( $this, 'wpprofile_ajax_filter' ) );

		//override wp profile single template 
		add_filter('template_include', array( $this, 'single_template_override'));
	}

	/**
	 * Register the stylesheets for the shortcode.
	 *
	 */
	public function enqueue_styles() {

		wp_register_style( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array(), '4.1.0', 'all' );
		wp_register_style( $this->shortcode_name, plugin_dir_url( __FILE__ ) . 'css/general.css', array(), WP_PROFILE_VERSION, 'all' );

	}

	/**
	 * Register the JavaScript for the shortcode.
	 *
	 */
	public function enqueue_scripts() {

		wp_register_script( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array( 'jquery' ), '4.1.0', true );
		wp_register_script( $this->shortcode_name, plugin_dir_url( __FILE__ ) . 'js/script.js', array( 'jquery' ), WP_PROFILE_VERSION, true );
		wp_localize_script( $this->shortcode_name, 'wpprofile_js',
	        [ 'ajaxurl' => admin_url( 'admin-ajax.php' ) ]
	    );

	}

	/**
	 * Render wp profile shortcode content 
	 */
	public function wp_profiles_callable()
	{	
		ob_start();

		include( plugin_dir_path( __FILE__ ) . 'partials/wp-profile-shortcode-content.php' );
			
		$content = ob_get_clean();

		return $content;
	}


	public function wpprofile_ajax_filter()
	{	
		$response = ['status' => 'failed', 'message' => 'Something went wrong!'];

		//Verify security nonce
		if ( isset( $_POST['wpprofile_ajax_filter_nonce'] ) && wp_verify_nonce( $_POST['wpprofile_ajax_filter_nonce'], 'wpprofile_ajax_filter' ) ) {

			$posts_per_page = 5;
			$paged = ( isset( $_POST['paged'] ) && absint( $_POST['paged'] ) ) ? absint( $_POST['paged'] ) : 1;
			$order = ( isset( $_POST['order'] ) && $_POST['order'] === 'ASC' ) ? 'ASC' : 'DESC';
			
			$args = [
				'post_type' 	   => 'wp-profiles',
				'paged' 		   => $paged,
				'posts_per_page'   => $posts_per_page,
				'order' 		   => $order,
				'orderby' 		   => 'title',
				'suppress_filters' => true,
			];

			if ( isset( $_POST[ 'keyword' ] ) && ! empty( $_POST['keyword'] ) ) {
				$keyword = $_POST[ 'keyword' ];
				$args['s'] = $keyword;
			}

			$tax_query = [];
			if ( isset( $_POST[ 'skills' ] ) && ! empty( $_POST['skills'] ) ) {
				$skills = $_POST[ 'skills' ];
				$tax_query[] = [
					'taxonomy' => 'skills',
					'field'	   => 'term_id',
					'terms'	   => $skills,
				];
			}

			if ( isset( $_POST[ 'education' ] ) && ! empty( $_POST['education'] ) ) {
				$education = $_POST[ 'education' ];
				$tax_query[] = [
					'taxonomy' => 'education',
					'field'	   => 'term_id',
					'terms'	   => $education,
				];
			}

			if ( ! empty( $tax_query ) ) {
				$args['tax_query'] = [
					$tax_query,
				];
			}

			$meta_query = [];
			if ( isset( $_POST[ 'jobs_completed' ] ) && ! empty( $_POST['jobs_completed'] ) ) {
				$jobs_completed = $_POST[ 'jobs_completed' ];
				$meta_query[] = [
					'key' 	=> 'jobs_completed',
					'value'	=> $jobs_completed,
				];
			}

			if ( isset( $_POST[ 'years_of_experience' ] ) && ! empty( $_POST['years_of_experience'] ) ) {
				$years_of_experience = $_POST[ 'years_of_experience' ];
				$meta_query[] = [
					'key' 	=> 'years_of_experience',
					'value'	=> $years_of_experience,
				];
			}

			if ( isset( $_POST[ 'ratings' ] ) && ! empty( $_POST['ratings'] ) ) {
				$ratings = $_POST[ 'ratings' ];
				$meta_query[] = [
					'key' 	=> 'ratings',
					'value'	=> $ratings,
				];
			}

			if ( isset( $_POST[ 'age' ] ) && ! empty( $_POST['age'] ) ) {
				$age = $_POST[ 'age' ];
				$currentYear = date('Y');
				$dateofyear = ($currentYear - $age) - 1;
				$dob_age_query = [
					[
						'key' => 'dob',
						'type' => 'DATE',
						'compare' => 'BETWEEN',
						'value' => [$dateofyear.'-01-01', $dateofyear.'-12-12'],
					]
				];
				
				$meta_query[] = $dob_age_query;
			}

			if ( ! empty( $meta_query ) ) {
				$args['meta_query'] = [
					$meta_query,
				];
			}

			$profiles = new WP_Query( $args );

			ob_start();

				include( plugin_dir_path( __FILE__ ) . '/partials/template-parts/wp-profile-listing.php' );

			$html = ob_get_clean();

			$response['status'] = 'success';			
			$response['html'] = $html;			
			$response['message'] = 'Profile Found!';			

		} else {
			$response['message'] = 'Security error!';			
		}

		// Encode and return responce 
		echo json_encode( $response );
		wp_die();
	}

	/**
	 * Override wp profile single template 
	 *
	 * @param string $template path to template
	 */
	public function single_template_override( $template )
	{
		if (is_singular('wp-profiles')) {
	        $template = plugin_dir_path( __FILE__ ) . 'partials/single-wp-profiles.php';
	    }

	    return $template;
	}

}