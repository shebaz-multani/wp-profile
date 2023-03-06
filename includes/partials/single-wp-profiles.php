<?php

/**
 * Template File to show wp profile single page 
 * 
 */

get_header('single');

global $post;

$post_id = $post->ID;

$dob = get_post_meta($post_id, 'dob', true);
$hobbies = get_post_meta($post_id, 'hobbies', true);
$interests = get_post_meta($post_id, 'interests', true);
$years_of_experience = get_post_meta($post_id, 'years_of_experience', true);
$jobs_completed = get_post_meta($post_id, 'jobs_completed', true);
$ratings = get_post_meta($post_id, 'ratings', true);

$skills = '';
$all_skills = get_the_terms($post, 'skills');
if ( ! empty ( $all_skills ) ) {
	$skill_names = wp_list_pluck($all_skills, 'name');
	$skills = implode(', ', $skill_names);
}

$education = '';
$all_education = get_the_terms($post, 'education');
if ( ! empty( $all_education ) ) {
	$education_names = wp_list_pluck($all_education, 'name');
	$education = implode(', ', $education_names);
}

?>

<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>

	<header>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<div class="metadata" >
		<div class="meta">
			<p><?php _e( 'Skills', 'wp-profile' ); ?>: <?php echo $skills; ?></p>
			<p><?php _e( 'Education', 'wp-profile' ); ?>: <?php echo $education; ?></p>
			<p><?php _e( 'Date of Birth', 'wp-profile' ); ?>: <?php echo $dob; ?></p>
			<p><?php _e( 'Hobbies', 'wp-profile' ); ?>: <?php echo $hobbies; ?></p>
			<p><?php _e( 'Interests', 'wp-profile' ); ?>: <?php echo $interests; ?></p>
			<p><?php _e( 'Years of experience', 'wp-profile' ); ?>: <?php echo $years_of_experience; ?></p>
			<p><?php _e( 'No jobs completed', 'wp-profile' ); ?>: <?php echo $jobs_completed; ?></p>
			<p><?php _e( 'Rating', 'wp-profile' ); ?>: <?php echo $ratings; ?></p>
		</div>
	</div>

</article>

<?php
get_footer('single');
