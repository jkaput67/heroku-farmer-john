<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

?>
<!doctype html>
<!--[if IE 9]><html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icons/favicon.ico" type="image/x-icon">
		<?php wp_head(); ?>

		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-M3C3XH');</script>
		<!-- End Google Tag Manager -->

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-33831844-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());
		 
		  gtag('config', 'UA-33831844-1');
		</script>

		<!--[if IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
		<![endif]-->
		<script>
		var $buoop = {c:2};
		function $buo_f(){
		 var e = document.createElement("script");
		 e.src = "//browser-update.org/update.min.js";
		 document.body.appendChild(e);
		};
		try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
		catch(e){window.attachEvent("onload", $buo_f)}
		</script>


		<script type="text/javascript">
		    adroll_adv_id = "SOZHTPQU35CCXIXFHUV6QY";
		    adroll_pix_id = "QMWSVD6BDBCKXEIYUXLFZU";
		    /* OPTIONAL: provide email to improve user identification */
		    /* adroll_email = "username@example.com"; */
		    (function () {
		        var _onload = function(){
		            if (document.readyState && !/loaded|complete/.test(document.readyState)){setTimeout(_onload, 10);return}
		            if (!window.__adroll_loaded){__adroll_loaded=true;setTimeout(_onload, 50);return}
		            var scr = document.createElement("script");
		            var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
		            scr.setAttribute('async', 'true');
		            scr.type = "text/javascript";
		            scr.src = host + "/j/roundtrip.js";
		            ((document.getElementsByTagName('head') || [null])[0] ||
		                document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
		        };
		        if (window.addEventListener) {window.addEventListener('load', _onload, false);}
		        else {window.attachEvent('onload', _onload)}
		    }());
		</script>

	</head>
	<body <?php body_class(); ?>>

		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M3C3XH"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->

		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5625499e2e7afeca" async="async"></script>
	<?php do_action( 'foundationpress_after_body' ); ?>

	<div class="off-canvas-wrap" data-offcanvas>
		<div class="inner-wrap">

	<?php do_action( 'foundationpress_layout_start' ); ?>
	<div class="hide-for-large-up">
	<?php get_template_part( 'parts/off-canvas-menu' ); ?>
	</div>

	<?php get_template_part( 'parts/top-bar' ); ?>

<section class="container" role="document">
	<?php do_action( 'foundationpress_after_header' ); ?>
