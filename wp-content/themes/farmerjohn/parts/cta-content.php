<div class="page-ca-transparency-act row">
	<div class="column small-12">
<?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		the_content();
	} // end while
} // end if
?>
	</div>
</div>
<div class="black-horizontal-divider"></div>