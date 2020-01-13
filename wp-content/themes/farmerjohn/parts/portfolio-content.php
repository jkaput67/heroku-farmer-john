<?php
/**
 * The portfolio content template
 */
?>

<style>
.embed-container {
    position: relative;
    padding-bottom: 45%;
    height: 0;
    overflow: hidden;
    max-width: 80%;
    margin: 0 auto;
}
.embed-container iframe,.embed-container object,.embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%;}
.martop40{
	margin-top:40px;
}
.baconpartysingleheader {
	padding: 3rem 8% 2rem;
}
.baconpartysingleheader h2{
  font-family: "DIN OT Bold";
}
</style>
	
	<div class="baconpartysingleheader text-center">
		<h2>CHECK OUT OUR PAST BACON PARTIES!</h2>
	</div>
	
	<div class="row">
		<div class='embed-container'><iframe src='https://player.vimeo.com/video/243382593' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>
	</div>
	
	<div class="row martop40">
		<div class="column small-12 text-center">
			<?php echo do_shortcode("[huge_it_portfolio id='2']"); ?>
		</div>
	</div>
	
	<div class="clearfix"></div>