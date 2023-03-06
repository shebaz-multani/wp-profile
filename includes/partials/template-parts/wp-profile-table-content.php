<?php

$row++;
$profile_id 		 = get_the_ID();
$profile_name 		 = get_the_title();
$profile_url		 = get_permalink($profile_id);
$years_of_experience = get_post_meta($profile_id, 'years_of_experience', true);
$jobs_completed 	 = get_post_meta($profile_id, 'jobs_completed', true);
$ratings 			 = get_post_meta($profile_id, 'ratings', true);

$dob  = get_post_meta($profile_id, 'dob', true);
$from = new DateTime($dob);
$to   = new DateTime('today');
$age  = $from->diff($to)->y;
// $currentYear = date('Y');
// $dateofyear = $currentYear - $age;

?>
<tr>
	<td><?php echo $row; ?></td>
	<td><a href="<?php echo $profile_url; ?>"><?php echo $profile_name; ?></a></td>
	<td><?php echo $age; ?></td>
	<td><?php echo $years_of_experience; ?></td>
	<td><?php echo $jobs_completed; ?></td>
	<td>
		<div class="rating-show">
			<?php for ($i = 5; $i >= 1; $i--) : ?>
	            <label for="rating<?php echo $i ?>" class="<?php echo $ratings == $i ? 'checked' : ''; ?>" >☆</label>
			<?php endfor; ?>
	        <div class="clear"></div>
        </div>
	</td>
</tr>