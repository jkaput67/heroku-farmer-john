<?php
/**
 * The Social page template
 */
get_header();
get_template_part( 'parts/social', 'hero' );
?>
<div class="page-social">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<script src="<?php echo get_template_directory_uri(); ?>/js/custom/social.js"></script>
	<div class="social_archive_filter_nav show-for-large-up light-yellow-bg">
		<div class="row text-center">
			<div style="display:inline-block;margin:0 auto;">
				<div class="column social_archive_filter_item">
					<a class="filter-all active" onclick="jQuery('.all').click();">ALL</a>
				</div>

				<div class="column social_archive_filter_item">
					<a class="filter-hashtag-thebaconparty" onclick="trigger_juicer('28620');">#TheBaconParty</a>
				</div>
				<div class="column social_archive_filter_item">
					<a class="filter-instagram" onclick="trigger_juicer('21333');"><i class="fa fa-instagram"></i> INSTAGRAM</a>
				</div>
				<div class="column social_archive_filter_item">
					<a class="filter-facebook" onclick="trigger_juicer('21331');"><i class="fa fa-facebook"></i> FACEBOOK</a>
				</div>
				<div class="column social_archive_filter_item">
					<a class="filter-pinterest" onclick="trigger_juicer('21337');"><i class="fa fa-pinterest"></i> PINTEREST</a>
				</div>
				<div class="column social_archive_filter_item">
					<a class="filter-twitter" onclick="trigger_juicer('21332');"><i class="fa fa-twitter"></i> TWITTER</a>
				</div>
				<div class="column social_archive_filter_item">
					<a class="filter-tumblr" onclick="trigger_juicer('28619');"><i class="fa fa-tumblr"></i> TUMBLR</a>
				</div>
				<div class="column social_archive_filter_item">
					<a class="filter-youtube" onclick="trigger_juicer('21334');"><i class="fa fa-youtube"></i> YOUTUBE</a>
				</div>
			</div>
		</div>
	</div>
	<div class="social_archive_filter_nav hide-for-large-up light-yellow-bg">
		<a class="social_archive_filter_dropdown_toggle text-center">
			<h2 class="filter-all active">ALL</h2>
			<h2 class="filter-hashtag-thebaconparty">#TheBaconParty</h2>
			<h2 class="filter-instagram">INSTAGRAM</h2>
			<h2 class="filter-facebook">FACEBOOK</h2>
			<h2 class="filter-pinterest">PINTEREST</h2>
			<h2 class="filter-twitter">TWITTER</h2>
			<h2 class="filter-tumblr">TUMBLR</h2>
			<h2 class="filter-youtube">YOUTUBE</h2>
			<div class="right dropdown-toggle collapsed"></div>
		</a>
		<div class="social_archive_filter_dropdown row">
			<div class="vertical-divider"></div>
			<div class="column small-12 social_archive_filter_item text-center">
				<a class="filter-all active">ALL</a>
			</div>
			<div class="column small-12 social_archive_filter_item text-center">
				<a class="filter-hashtag-thebaconparty" onclick="trigger_juicer('28620');">#TheBaconParty</a>
			</div>
			<div class="column small-12 social_archive_filter_item text-center">
				<a class="filter-instagram" onclick="trigger_juicer('21333');"><i class="fa fa-instagram"></i> INSTAGRAM</a>
			</div>
			<div class="column small-12 social_archive_filter_item text-center">
				<a class="filter-facebook" onclick="trigger_juicer('21331');"><i class="fa fa-facebook"></i> FACEBOOK</a>
			</div>
			<div class="column small-12 social_archive_filter_item text-center">
				<a class="filter-pinterest" onclick="trigger_juicer('21337');"><i class="fa fa-pinterest"></i> PINTEREST</a>
			</div>
			<div class="column small-12 social_archive_filter_item text-center">
				<a class="filter-twitter" onclick="trigger_juicer('21332');"><i class="fa fa-twitter"></i> TWITTER</a>
			</div>
			<div class="column small-12 social_archive_filter_item text-center">
				<a class="filter-tumblr" onclick="trigger_juicer('28619');"><i class="fa fa-tumblr"></i> TUMBLR</a>
			</div>
			<div class="column small-12 social_archive_filter_item text-center">
				<a class="filter-youtube" onclick="trigger_juicer('21334');"><i class="fa fa-youtube"></i> YOUTUBE</a>
			</div>
		</div>
	</div>
	<div class="social_feed_container row" style="max-width:1000px; margin-left:auto; margin-right:auto">
		<?php juicer_feed('name=social-34ac215d-8c29-4c01-88dc-7f8647b225e3'); ?>
	</div>
</div>
<?php get_footer(); ?>
