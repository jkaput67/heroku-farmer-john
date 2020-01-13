<?php

$departments = array('professional','production','internships');

?>
<style>
.careers_job_openings_department_category_title {font-size:20px!important}
.careers_job_openings_department ul {line-height:2.2rem}
</style>
<div class="careers_job_openings light-yellow-bg text-center">
	<div class="row">
		<div class="column small-8 large-4 small-offset-2 large-offset-4">
			<h2>JOB OPENINGS</h2>
		</div>
		<div class="column large-4 show-for-large-up">
			<a target="_blank" href="https://www.linkedin.com/vsearch/j?page_num=1&locationType=Y&f_C=307634&trk=careers_promo_module_see_jobs" class="linkedin">View jobs on LinkedIn <i class="fa fa-linkedin-square"></i></a>
		</div>
	</div>
	<div class="row">
		<div class="column small-12 large-4 text-center">
			<h3>PROFESSIONAL</h3>
			<p class="text-left">Advance your career by working behind-the-scenes at Farmer John in areas like management, marketing, sales and accounting. Oversee the day-to-day workflow of our operations in a nurturing office environment.</p>
			<div class="row">
				<div class="column small-12 large-4 text-center hide-for-large-up">
					<a class="green-button green-bg" data-open-positions="<?php echo getJobOpeningsCount('professional'); ?>" data-target-department="professional">OPENINGS (<?php echo getJobOpeningsCount('professional'); ?>)</a>
					<div class="green-triangle"></div>
				</div>
			</div>
<?php if( getJobOpeningsCount('professional') > 0 ){ ?>
			<div class="row hide-for-large-up">
				<div class="column small-12 careers_job_openings_department department-professional">
					<a class="close-reveal-modal" aria-label="Close">×</a>
					<div class="row">
						<div class="column-small-12">
							<div class="row">
								<h2><?php echo strtoupper('professional'); ?> JOB OPENINGS</h2>
							</div>
							<div class="row">

<?php
		$terms = getTaxQuery('professional');
		foreach ($terms as $term) {
			echo '<div class="column small-12">';
			printJobOpeningsByDepartment($term->slug);
			echo '</div>';
		}
?>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php } ?>
		</div>
		<div class="column small-12 large-4 text-center">
			<h3>PRODUCTION</h3>
			<p class="text-left">For those who wish to be directly involved in our process, put your skills to use on the ground floor of production in fields like product lab testing, quality control, distribution and mechanical engineering.</p>
			<div class="row">
				<div class="column small-12 large-4 text-center hide-for-large-up">
					<a class="green-button green-bg" data-open-positions="<?php echo getJobOpeningsCount('production'); ?>" data-target-department="production">OPENINGS (<?php echo getJobOpeningsCount('production'); ?>)</a>
					<div class="green-triangle"></div>
				</div>
			</div>
<?php if( getJobOpeningsCount('production') > 0 ){ ?>
			<div class="row hide-for-large-up">
				<div class="column small-12 careers_job_openings_department department-production">
					<a class="close-reveal-modal" aria-label="Close">×</a>
					<div class="row">
						<div class="column-small-12">
							<div class="row">
								<h2><?php echo strtoupper('production'); ?> JOB OPENINGS</h2>
							</div>
							<div class="row">

<?php
		$terms = getTaxQuery('production');
		foreach ($terms as $term) {
			echo '<div class="column small-12">';
			printJobOpeningsByDepartment($term->slug);
			echo '</div>';
		}
?>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php } ?>
		</div>
		<div class="column small-12 large-4 text-center">
			<h3>INTERNSHIPS</h3>
			<p class="text-left">Internships are a great way to discover what it's like to work in your field of study. We offer opportunities for hands-on experience in fields such as sales and marketing, human resources, quality assurance and engineering.</p>
			<div class="row">
				<div class="column small-12 large-4 text-center hide-for-large-up">
					<a class="green-button green-bg" data-open-positions="<?php echo getJobOpeningsCount('internships'); ?>" data-target-department="internships">OPENINGS (<?php echo getJobOpeningsCount('internships'); ?>)</a>
					<div class="green-triangle"></div>
				</div>
			</div>
<?php if( getJobOpeningsCount('internships') > 0 ){ ?>
			<div class="row hide-for-large-up">
				<div class="column small-12 careers_job_openings_department department-internships">
					<a class="close-reveal-modal" aria-label="Close">×</a>
					<div class="row">
						<div class="column-small-12">
							<div class="row">
								<h2><?php echo strtoupper('internships'); ?> JOB OPENINGS</h2>
							</div>
							<div class="row">

<?php
		$terms = getTaxQuery('internships');
		foreach ($terms as $term) {
			echo '<div class="column small-12">';
			printJobOpeningsByDepartment($term->slug);
			echo '</div>';
		}
?>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php } ?>
		</div>
	</div>
	<div class="row show-for-large-up">
		<div class="column small-12 large-4 text-center">
			<a class="green-button green-bg" data-open-positions="<?php echo getJobOpeningsCount('professional'); ?>" data-target-department="professional">OPENINGS (<?php echo getJobOpeningsCount('professional'); ?>)</a>
			<div class="green-triangle"></div>
		</div>
		<div class="column small-12 large-4 text-center">
			<a class="green-button green-bg" data-open-positions="<?php echo getJobOpeningsCount('production'); ?>" data-target-department="production">OPENINGS (<?php echo getJobOpeningsCount('production'); ?>)</a>
			<div class="green-triangle"></div>
		</div>
		<div class="column small-12 large-4 text-center">
			<a class="green-button green-bg" data-open-positions="<?php echo getJobOpeningsCount('internships'); ?>" data-target-department="internships">OPENINGS (<?php echo getJobOpeningsCount('internships'); ?>)</a>
			<div class="green-triangle"></div>
		</div>
	</div>
<?php foreach ($departments as $department):
	if( getJobOpeningsCount($department) > 0 ){ ?>
	<div class="show-for-large-up">
		<div class="careers_job_openings_department department-<?php echo $department; ?>">
			<a class="close-reveal-modal" aria-label="Close">×</a>
			<div class="row">
				<div class="column-small-12">
					<div class="row">
						<h2><?php echo strtoupper($department); ?> JOB OPENINGS</h2>
					</div>
					<div class="row text-center">
<?php
		$terms = getTaxQuery($department);
		$terms_incrementor = 0;
		$terms_count = count($terms);
		foreach ($terms as $term) {
			$end = "";
			if( $terms_incrementor == ($terms_count-1) ){
				$end = " end";
			}
			$offset = "";
			if( $terms_incrementor === 0 ){
				$offset = " large-offset-".(int)((12-(3*$terms_count))/2);
			}
			echo '<div class="column small-12 large-3'.$offset.$end.' text-left">';
			printJobOpeningsByDepartment($term->slug);
			echo '</div>';
			$terms_incrementor++;
		}
?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php	} else { ?>
	<div class="show-for-large-up">
		<div class="careers_job_openings_department department-<?php echo $department; ?>">
			<a class="close-reveal-modal" aria-label="Close">×</a>
			<div class="row">
				<div class="column-small-12">
					<div class="row">
						<h2>NO POSITIONS AVAILABLE</h2>
					</div>
					<div class="row text-center">
						<p>No positions are currently available. Please check back soon.</p>
						<p>You can send your resume to <a class="careers-email-link" href="mailto:careers@farmerjohn.com">careers@farmerjohn.com</a> and we will keep it on file for future consideration.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php	}
endforeach; ?>
</div>
<div class="careers_job_openings_modal_container">
<?php
	$args = array(
		'post_type' => 'job_openings',
	);
	// The Query
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post(); ?>
	<div id="job-<?php echo get_the_id(); ?>" class="reveal-modal careers_job_openings_modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
	  <h2 id="modalTitle" class="careers_job_openings_modal_job_title"><?php the_title(); ?></h2>
	  <div class="careers_job_openings_modal_job_department"><?php the_field('job_subtitle_or_category'); ?></div>
	  <p class="careers_job_openings_modal_job_description"><?php the_field('job_description'); ?></p>
	  <div class="row">
	  	<div class="column small-12 text-center">
	  		<a href="mailto:careers@farmerjohn.com?subject=<?php echo rawurlencode(get_the_title()); ?>" class="apply-button"></a>
	  	</div>
	  </div>
	  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div>
<?php
		}
	}
	wp_reset_postdata();
?>
</div>