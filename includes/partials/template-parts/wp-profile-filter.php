<?php

/**
 * Template File to show wp profile filter form
 * 
 */

$skills = get_terms([
	'taxonomy' => 'skills',
	'hide_empty' => true,
]);

$education = get_terms([
	'taxonomy' => 'education',
	'hide_empty' => true,
]);

?>
<div class="wp-profile-filter" >
	<form class="wp-profile-filter-frm" method="post" >
		<div class="form-group">
			<label for="keyword">
				<?php _e( 'Keyword', 'wp-profile' ); ?>
			</label>
			<input type="text" id="keyword" name="keyword" class="form-control" />
		</div>
		<div class="form-row">
			<div class="form-group">
				<label for="skills">
					<?php _e( 'Skills', 'wp-profile' ); ?>
				</label>
				<select id="skills" name="skills[]" multiple class="form-control" >
					<?php 
					if ( ! empty($skills) ) :
						foreach ($skills as $skill) :
							?>
							<option value="<?php echo $skill->term_id; ?>"><?php echo $skill->name; ?></option>
							<?php
						endforeach;
					endif;
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="education">
					<?php _e( 'Education', 'wp-profile' ); ?>
				</label>

				<select id="education" name="education[]" multiple class="form-control" >
					<?php 
					if ( ! empty($education) ) :
						foreach ($education as $degree) :
							?>
							<option value="<?php echo $degree->term_id; ?>"><?php echo $degree->name; ?></option>
							<?php
						endforeach;
					endif;
					?>
				</select>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group">
				<label for="age">
					<?php _e( 'Age', 'wp-profile' ); ?>
				</label>
				<input type="range" id="age" name="age" min="0" max="100" step="1" class="form-control" value="0" />
				<label id="ageLabel" >0</label>
			</div>
			<div class="form-group">
				<label for="ratings">
					<?php _e( 'Ratings', 'wp-profile' ); ?>
				</label>
				<div class="rating">
		            <input id="rating5" name="ratings" type="radio" value="5" class="radio-btn hide" />
		            <label for="rating5" >☆</label>
		            <input id="rating4" name="ratings" type="radio" value="4" class="radio-btn hide" />
		            <label for="rating4" >☆</label>
		            <input id="rating3" name="ratings" type="radio" value="3" class="radio-btn hide" />
		            <label for="rating3" >☆</label>
		            <input id="rating2" name="ratings" type="radio" value="2" class="radio-btn hide" />
		            <label for="rating2" >☆</label>
		            <input id="rating1" name="ratings" type="radio" value="1" class="radio-btn hide" />
		            <label for="rating1" >☆</label>
		            <div class="clear"></div>
		        </div>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group">
				<label for="jobs_completed">
					<?php _e( 'No of jobs completed', 'wp-profile' ); ?>
				</label>
				<input type="number" id="jobs_completed" name="jobs_completed" class="form-control" />
			</div>
			<div class="form-group">
				<label for="years_of_experience">
					<?php _e( 'Years of experience', 'wp-profile' ); ?>
				</label>
				<input type="number" id="years_of_experience" name="years_of_experience" class="form-control" />
			</div>
		</div>
		<div class="submit-button">
			<?php wp_nonce_field( 'wpprofile_ajax_filter', 'wpprofile_ajax_filter_nonce' ); ?>
			<input type="hidden" name="action" value="wpprofile_ajax_filter">
			<input type="hidden" name="order" value="DESC">
			<input type="hidden" name="paged" value="1">
			<button type="submit" ><?php _e( 'Search', 'wp-profile' ); ?></button>
		</div>
	</form>
</div>