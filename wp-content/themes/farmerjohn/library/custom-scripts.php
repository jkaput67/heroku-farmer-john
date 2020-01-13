<?php /* Custom Scripts */

function formatHoursAndMinutes($minutes){
	$minutes = intval( preg_replace('/\D/', '',$minutes) );
	return $minutes;
	//return $formattedString;
}

function writeHoursAndMinutes($minutes){
	$minutes = formatHoursAndMinutes($minutes);
	// If there are less than 60 minutes
	if( $minutes < 60 ){ ?>
	<div class="meta_value"><?php echo $minutes; ?></div>
	<div class="meta_label_bottom">MIN</div>
<?php	// If there are more than 60 minutes
	} else if( $minutes > 60 ) {
		// If the amount of minutes can be represented only using hours
		if( $minutes % 60 === 0 ){ ?>
	<div class="meta_value"><?php echo $minutes / 60; ?></div>
	<div class="meta_label_bottom">HRS</div>
<?php 	// If the amount of minutes cannot be represented only using hours
		} else { ?>
	<div class="recipe_time_left">
		<div class="meta_value"><?php echo floor($minutes / 60); ?></div>
		<div class="meta_label_bottom"><?php if( floor($minutes / 60) == 1 ){ echo 'HR'; } else { echo 'HRS'; }?></div>
	</div>
	<div class="recipe_time_right">
		<div class="meta_value"><?php echo $minutes % 60; ?></div>
		<div class="meta_label_bottom">MIN</div>
	</div>
<?php	}

	// Else (exactly 60 minutes)
	} else { ?>
	<div class="meta_value">1</div>
	<div class="meta_label_bottom">HR</div>
<?php }

}

function getJobOpeningsCount($department){
	$args = array(
		'post_type' => 'job_openings',
		'tax_query' => array(
			array(
				'taxonomy' => 'departments',
				'field'    => 'slug',
				'terms'    => $department,
			),
		),
	);
	// The Query
	$the_query = new WP_Query( $args );
	$thing_to_return = $the_query->found_posts;
	wp_reset_postdata();
	return $thing_to_return;
}

function getTaxQuery($department){

	$parent_department = get_term_by( 'slug', $department, 'departments' );
	$parent_department_id = $parent_department->term_id;

	// no default values. using these as examples
	$taxonomies = array( 
	    'departments',
	);

	$args = array(
	    'orderby'           => 'menu_order', 
	    'order'             => 'ASC',
	    'slug'              => '',
	    'child_of'          => $parent_department_id
	); 

	$terms = get_terms($taxonomies, $args);
	return $terms;
}

function printJobOpeningsByDepartment($department){
	$args = array(
		'post_type' => 'job_openings',
		'tax_query' => array(
			array(
				'taxonomy' => 'departments',
				'field'    => 'slug',
				'terms'    => $department,
			),
		),
	);
	// The Query
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
		echo '<h3 class="careers_job_openings_department_category_title">'.strtoupper($department).'</h3>';
		echo '<ul>';
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			echo '<li><a data-reveal-id="job-'.get_the_id().'">' . get_the_title() . '</a></li>';
		}
		echo '</ul>';
	}
	wp_reset_postdata();
}

?>