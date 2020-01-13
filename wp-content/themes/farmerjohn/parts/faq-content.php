<div class="faq_title text-center">
	<h1>FREQUENTLY ASKED QUESTIONS</h1>
</div>
<div class="faq_content">
	<div class="row" data-equalizer>
		<div class="column small-12 large-4 large-offset-2 faq_section green-bg" data-equalizer-watch>
			<div class="faq_section_heading">
				<h2>Food Safety and Animal Welfare</h2>
			</div>
<?php

$args = array(
	'post_type' => 'faq_entries',
	'tax_query' => array(
		array(
			'taxonomy' => 'faq_category',
			'field'    => 'slug',
			'terms'    => 'food-safety',
		),
	),
);

// The Query
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
	echo '<ul>';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		echo '<li>' . get_field('question') . '<div class="answer">'.get_field('answer').'</div></li>';
	}
	echo '</ul>';
} else {
	// no posts found
}
/* Restore original Post Data */
wp_reset_postdata();

?>
		</div>
		<div class="column small-12 large-4 end faq_section orange-bg" data-equalizer-watch>
			<div class="faq_section_heading">
				<h2>Nutrition</h2>
			</div>
<?php

$args = array(
	'post_type' => 'faq_entries',
	'tax_query' => array(
		array(
			'taxonomy' => 'faq_category',
			'field'    => 'slug',
			'terms'    => 'nutrition',
		),
	),
);

// The Query
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
	echo '<ul>';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		echo '<li>' . get_field('question') . '<div class="answer">'.get_field('answer').'</div></li>';
	}
	echo '</ul>';
} else {
	// no posts found
}
/* Restore original Post Data */
wp_reset_postdata();

?>
		</div>
	</div>

	<div class="row" data-equalizer>
		<div class="column small-12 large-4 large-offset-2 faq_section light-blue-bg" data-equalizer-watch>
			<div class="faq_section_heading">
				<h2>Products</h2>
			</div>
<?php

$args = array(
	'post_type' => 'faq_entries',
	'tax_query' => array(
		array(
			'taxonomy' => 'faq_category',
			'field'    => 'slug',
			'terms'    => 'products',
		),
	),
);

// The Query
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
	echo '<ul>';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		echo '<li>' . get_field('question') . '<div class="answer">'.get_field('answer').'</div></li>';
	}
	echo '</ul>';
} else {
	// no posts found
}
/* Restore original Post Data */
wp_reset_postdata();

?>
		</div>
		<div class="column small-12 large-4 end faq_section light-yellow-bg" data-equalizer-watch>
			<div class="faq_section_heading">
				<h2>Charitable Giving</h2>
			</div>
<?php

$args = array(
	'post_type' => 'faq_entries',
	'tax_query' => array(
		array(
			'taxonomy' => 'faq_category',
			'field'    => 'slug',
			'terms'    => 'charitable-giving',
		),
	),
);

// The Query
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
	echo '<ul>';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		echo '<li>' . get_field('question') . '<div class="answer">'.get_field('answer').'</div></li>';
	}
	echo '</ul>';
} else {
	// no posts found
}
/* Restore original Post Data */
wp_reset_postdata();

?>
		</div>
	</div>
	<div class="faq_divider show-for-large-up"></div>
</div>
