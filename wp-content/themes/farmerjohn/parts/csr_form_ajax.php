<?php
require_once("../../../../wp-config.php");
$wp->init(); $wp->parse_request(); $wp->query_posts();
$wp->register_globals(); $wp->send_headers();
$contact_page = get_page_by_title( 'Corporate Social Responsibility' );
echo $contact_page->post_title;
setup_postdata($contact_page);
the_content();
wp_reset_postdata();
?>