<style type="text/css">
.select2-results {
	background-color: #f4f4f4 !important;
}
.select2-container {
	margin-bottom:1rem;
}

@media only screen and (max-width: 64em) {
	.contact_form_container .select2-chosen {
		font-size:1.25rem;
	}
}

@media only screen and (min-width: 64.0625em) {
	.select2-container .select2-choice {
	    padding: 0.5rem 0 0.5rem 1rem;
	    font-size: 1.25rem;
	    background-color: #fff;
	}
	.select2-results .select2-result-label {
	    padding: 0.25rem 5%;
	    text-transform:none;
	}
}
</style>

<div class="page-contact">
	<div class="row text-center">
		<h1 class="title">CONTACT INFORMATION</h1>
	</div>
	<div class="row">
		<div class="column small-12 large-6 text-center">
			<div class="floating-centered-inline-block text-left">
				<h4>Mailing Address</h4>
				<p class="contact_address">
					Farmer John<br>
					Consumer Response<br>
					3049 East Vernon Avenue<br>
					Los Angeles, CA 90058
				</p>
				<p>Phone: 800-846-7635<br>
					<small>Monday-Friday, 8:00 a.m. to 4:00 p.m. CST,<br>
					excluding holidays. Summer hours may vary.</small><br><br>
				</p>
				<div class="contact_social">
					<h4>KEEP IN TOUCH!</h4>
			        <div class="footer-social">
				        <a target="_blank" href="http://facebook.com/farmerjohn">
				            <i class="fa fa-facebook"></i>
				        </a>
				        <a target="_blank" href="http://pinterest.com/farmerjohnLA">
				            <i class="fa fa-pinterest-p"></i>
				        </a>
				        <a target="_blank" href="http://instagram.com/farmerjohnla">
				            <i class="fa fa-instagram"></i>
				        </a>
				        <a target="_blank" href="https://www.linkedin.com/company/clougherty-packing-llc">
				            <i class="fa fa-linkedin"></i>
				        </a>
				        <a target="_blank" href="http://twitter.com/farmerjohnla">
				            <i class="fa fa-twitter"></i>
				        </a>
						<a target="_blank" href="https://www.youtube.com/user/FarmerJohnLA">
							<i class="fa fa-youtube"></i>
						</a>
<!-- 						<a target="_blank" href="https://www.tumblr.com/FarmerJohnLA">
							<i class="fa fa-tumblr"></i>
						</a> -->
			        </div>
				</div>
			</div>
		</div>
		<div class="column small-12 large-6">
			<div class="contact_form_container light-blue-bg">
	<?php 
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post(); 
			the_content();
		} // end while
	} // end if
	?>
				<div class="hidden-form-text">
					<div class="hidden-form-text-item first-hidden-form-text">
						<h3>How may we contact you?</h3>
						<p>In order to receive correspondence back from Clougherty Packing, LLC, you must complete at least one of the following options. Lease note - if you are requesting information on where to purchase a specific product, please include your address and phone number. Our "where to purchase" requests are handled by the sales force located near your city.</p>
					</div>
					<div class="hidden-form-text-item second-hidden-form-text">
						<p>If you are inquiring about a specific product, please indicate the product information below.</p>
					</div>
					<div class="hidden-form-text-item third-hidden-form-text">
						<h3>Suggestion & Idea Submission Policy:</h3>
						<p>You understand and agree that Clougherty Packing, LLC has many resources both internal and external, which may have developed or may develop information identical or similar to that disclosed to us here. Information here is not submitted in confidence and Clougherty Packing, LLC assumes no obligation by considering it. All comments, offers, suggestions, ideas, recipes, concepts, artwork, or other information ("Submissions") disclosed to us using this site or in response to solicitations on this site are the property of Clougherty Packing, LLC, including its business units, divisions and wholly-owned subsidiaries. Without limitation, Cloughterty PAcking, LLC shall exclusively own all rights, known or hereafter existing, to the Submissions and shall be entitled to unrestricted use of the same for any purpose whatsoever, commercial or otherwise, without compensation to the submitter. Clougherty Packing, LLS will consier Submissions only on these terms.<br><br>Please click the submit button below to indicate your agreement with these terms and submit your information.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	

<div class="black-horizontal-divider"></div>