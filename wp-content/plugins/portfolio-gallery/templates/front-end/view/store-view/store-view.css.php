<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<style>
.play-icon.youtube-icon  {
    background: url(<?php echo  PORTFOLIO_GALLERY_IMAGES_URL.'/admin_images/play.youtube.png';?>) center center no-repeat;
    background-size: 30% 30%;
}
.play-icon.vimeo-icon  {
    background: url(<?php echo  PORTFOLIO_GALLERY_IMAGES_URL.'/admin_images/play.vimeo.png';?>) center center no-repeat;
    background-size: 30% 30%;
}
.play-icon {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
.play-icon:hover{
    cursor:pointer;
}
/***</add>***/
.portelement_<?php echo $portfolioID; ?> {
    max-width:<?php echo $portfolio_gallery_get_options['portfolio_gallery_ht_view8_width']+2*$portfolio_gallery_get_options['portfolio_gallery_ht_view8_border_width']; ?>px;
    width: 100%;
    margin:0 0 10px 0;
    border:<?php echo $portfolio_gallery_get_options['portfolio_gallery_ht_view8_border_width']; ?>px solid #<?php echo $portfolio_gallery_get_options['portfolio_gallery_ht_view8_border_color']; ?>;
    border-radius:<?php echo $portfolio_gallery_get_options['portfolio_gallery_ht_view8_border_radius']; ?>px;
    outline:none;
    overflow:hidden;
}

.portelement_<?php echo $portfolioID; ?> .image-block_<?php echo $portfolioID; ?> {
    position:relative;
    width:100%;
    height:auto;
}
.portelement_<?php echo $portfolioID; ?> .image-block_<?php echo $portfolioID; ?> a {
    border:none;
    display: block;
    cursor: -webkit-zoom-in; cursor: -moz-zoom-in;
}
.portelement_<?php echo $portfolioID; ?> .image-block_<?php echo $portfolioID; ?> img {
    margin:0 !important;
    padding:0 !important;
    max-width: none !important;
    width: 100%;
    display:block;
    border-radius: 0 !important;
    box-shadow: 0 0 0 rgba(0, 0, 0, 0) !important;
    height:auto;
}

.portelement_<?php echo $portfolioID; ?> .image-block_<?php echo $portfolioID; ?> img:hover {
    cursor: pointer;
}


.portelement_<?php echo $portfolioID; ?> .title-block_<?php echo $portfolioID; ?> a, .portelement_<?php echo $portfolioID; ?> .title-block_<?php echo $portfolioID; ?> a:link, .portelement_<?php echo $portfolioID; ?> .title-block_<?php echo $portfolioID; ?> a:visited,
.portelement_<?php echo $portfolioID; ?> .title-block_<?php echo $portfolioID; ?> {

    margin:0;
    padding:0 1% 0 2%;
    text-decoration:none;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space:nowrap;
    z-index:20;
    font-size: <?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_title_font_size"];?>px;
    color:#<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_title_font_color"];?>;
    font-weight:normal;
    text-align:center;
    background: <?php
			list($r,$g,$b) = array_map('hexdec',str_split($portfolio_gallery_get_options['portfolio_gallery_ht_view8_title_background_color'],2));
				$titleopacity=$portfolio_gallery_get_options["portfolio_gallery_ht_view8_title_background_transparency"]/100;
				echo 'rgba('.$r.','.$g.','.$b.','.$titleopacity.')  !important';
	?>;
    <?php


    if ($portfolio_gallery_get_options['portfolio_gallery_ht_view8_hide_title']=="on")
        echo "display:none !important;"
    ?>
}



.portelement_<?php echo $portfolioID; ?> .title-block_<?php echo $portfolioID; ?> a:hover, .portelement_<?php echo $portfolioID; ?> .title-block_<?php echo $portfolioID; ?> a:focus, .portelement_<?php echo $portfolioID; ?> .title-block_<?php echo $portfolioID; ?> a:active,
.portelement_<?php echo $portfolioID; ?> .title-block_<?php echo $portfolioID; ?> :hover {
    color:#<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_title_font_hover_color"];?>;
    text-decoration:none;
}


.huge_it_container-title {
    width: 45%;
    float: right;
    padding-bottom: 0;
    box-sizing: border-box;
    font-size: <?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_image_title_font_size"];?>px;
    color:#<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_image_title_font_color"];?>;
    font-weight:normal;
    text-align:center;
}


.portelement_<?php echo $portfolioID; ?> .title-block_<?php echo $portfolioID; ?> :hover {
    color:#<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_title_font_hover_color"];?>;
    text-decoration:none;
}



#huge_it_main-product {
    margin-bottom: 40px !important;
    max-width: 1080px;
    margin: 0 auto;
    overflow: auto;
    width:100% !important;
}

.huge_it_thumbnail-wrapper
{   margin-right: 10px;
    width: 20%;
    margin-left: 0;
    display: block;
    float: left;
    margin-top: 18px;
}
.huge_it_thumbnail-prev-button,.huge_it_thumbnail-next-button
{   width: 100%;
    padding: 8px 0 8px 0 ;
    cursor: pointer;
    margin:0 !important;
    text-align: center;
}
span.huge_it_icon-arrow_up
{   display: block;
    margin: 0 auto;
    background: url(<?php echo  PORTFOLIO_GALLERY_IMAGES_URL.'/admin_images/store-prev.png';?>) center center no-repeat;
    width: 25px;
    height: 25px;

}
span.huge_it_icon-arrow_down
{    display: block;
    margin: 0 auto;
    background: url(<?php echo  PORTFOLIO_GALLERY_IMAGES_URL.'/admin_images/store-next.png';?>) center center no-repeat;
    width: 25px;
    height: 25px;

}
.huge_it_thumbnail-carousel
{ margin:0 !important;

    height: 400px;
    position: relative;
    overflow: hidden;
    z-index: 1;
}
ul.huge_it_thumbnails
{
    width: 100%;
    z-index: 1;
    height: 100%;
    position: relative;
    margin: 0 !important;
    transition-duration: 0ms;
    transform: translate3d(0px, 0px, 0px);
    text-align: center;
    padding:0 !important;
}
li.huge_it_thumbnail
{   margin: 4px 0 4px 0 !important;
    height: 77px;
    margin-bottom: 6px;
    width: 100%;
    position: relative;
    list-style:none;
    display: inline-block;
    text-align: center;
}
img.huge_it_thumbnail-image
{
/*    width: 100%;*/
    height: 67px;
    cursor: pointer;
    padding: 4px;
    border: 1px solid #fff;
    display: block;
    overflow:hidden;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    max-width: 100%;
    max-height: 100%;

}
.huge_it_container-title {
    font-size: <?php echo $portfolio_gallery_get_options['portfolio_gallery_ht_view8_image_title_font_size']; ?>px;
    color:#<?php echo $portfolio_gallery_get_options['portfolio_gallery_ht_view8_image_title_font_color']; ?>;
}

.huge_it_container-details
{   width: 45%;
    float: right;
    display: block;
    font-size: <?php echo $portfolio_gallery_get_options['portfolio_gallery_ht_view8_desc_font_size']; ?>px;
    color:#<?php echo $portfolio_gallery_get_options['portfolio_gallery_ht_view8_desc_font_color']; ?>;
}
.huge_it_container-imagery
{
    width: 54%;
    clear: left;
    margin-top: 8px;
    position: relative;
}
.huge_it_main-carousel-wrapper
{
    width: 73%;
    float: left;
    position: relative;
}

.huge_it_main-carousel-wrapper  img:hover {
    cursor: -webkit-zoom-in;
    cursor: -moz-zoom-in;
}


@media screen and (max-width: 375px){
    .huge_it_container-imagery{
        width:100% !important;}
    .huge_it_container-details{  font-size: 3vw !important;width: 100%!important; }
    .huge_it_container-title {  font-size: 3vw !important;width: 100% !important;}
    .huge_it_container-title { width: 100% !important;}
    .huge_it_main-carousel-wrapper{width: 75%!important;position: absolute !important;margin-top: 50% !important;margin-left:25% !important;}
    .huge_it_thumbnail-wrapper{ width: 20%;margin-top: 0 !important;}
}
@media screen and (min-width: 376px) and (max-width: 410px){
    .huge_it_container-imagery{
        width:100% !important;}
    .huge_it_container-details{  font-size: 3vw !important;width: 100%!important; }
    .huge_it_container-title {  font-size: 3vw !important;width: 100% !important;}
    .huge_it_container-title { width: 100% !important;}
    .huge_it_main-carousel-wrapper{width: 75%!important;position: absolute !important;margin-top: 30% !important;margin-left:25% !important;}
    .huge_it_thumbnail-wrapper{ width: 20%;margin-top: 0 !important;}
}
@media screen and (min-width: 411px) and (max-width: 485px){
    .huge_it_container-imagery{
        width:100% !important;}
    .huge_it_container-details{  font-size: 3vw !important;width: 100%!important; }
    .huge_it_container-title {  font-size: 3vw !important;width: 100% !important;}
    .huge_it_container-title { width: 100% !important;}
    .huge_it_main-carousel-wrapper{width: 75%!important;position: absolute !important;margin-top: 10% !important;margin-left:25% !important;}
    .huge_it_thumbnail-wrapper{ width: 20%;margin-top: 0 !important;}
}
@media screen and (min-width: 486px) and (max-width: 523px){
    .huge_it_container-imagery{
        width:100% !important;}
    .huge_it_container-details{  font-size: 3vw !important;width: 100%!important; }
    .huge_it_container-title {  font-size: 3vw !important;width: 100% !important;}
    .huge_it_container-title { width: 100% !important;}
    .huge_it_main-carousel-wrapper{width: 65%!important;position: absolute !important;margin-top: 10% !important;margin-left:25% !important;}
    .huge_it_thumbnail-wrapper{ width: 20%;margin-top: 0 !important;}
}

@media screen and (min-width: 524px) and (max-width: 562px){
    .huge_it_container-imagery{
        width:100% !important;}
    .huge_it_container-details{  font-size: 3vw !important;width: 100%!important; }
    .huge_it_container-title {  font-size: 3vw !important;width: 100% !important;}
    .huge_it_container-title { width: 100% !important;}
    .huge_it_main-carousel-wrapper{width: 50%!important;position: absolute !important;margin-top: 10% !important;margin-left:25% !important;}
    .huge_it_thumbnail-wrapper{ width: 20%;margin-top: 0 !important;}
}

@media screen and (min-width: 563px) and (max-width: 725px){
    .huge_it_main-carousel-wrapper{width: 70%!important;margin-top: 5%;}
}

@media screen and (min-width: 768px) and (max-width: 894px){
    .huge_it_main-carousel-wrapper{width: 70%!important;margin-top: 50% !important;}
}
    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_options_<?php echo $portfolioID; ?> {
    position: relative;
    overflow: hidden;
<?php

if($sortingFloatLgal != 'top'){
           echo 'float:'.$sortingFloatLgal.' ;' ;
           echo  "max-width:180px;width:20%;display:inline-block;";
           if($filteringFloatLgal == 'top') echo 'margin-top:40px;';
           if($sortingFloatLgal == 'left') echo 'margin-right: 1%;';
           else echo 'margin-left:1%;';
       }
       else {
           if($portfolioposition == 'on' && ($filteringFloatLgal == 'top' || $filteringFloatLgal == '')) echo 'left:50%; transform:translateX(-50%);';
           if($filteringFloatLgal == 'left') echo 'margin-left:calc( 185px + 1%);';
           echo 'width: auto; margin-bottom: 5px;display:table;';
       }
       if(($sortingFloatLgal == 'left' && $filteringFloatLgal == 'left') || ($sortingFloatLgal == 'right' && $filteringFloatLgal == 'right')){
           echo 'width: 100%;';
       }
?>


    margin-bottom: 10px;
}

#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_options_<?php echo $portfolioID; ?> ul {
    margin: 0 !important;
    padding: 0 !important;
    list-style: none;
<?php if($sortingFloatLgal == 'top') {
    echo "float:left;margin-left:1%;";
} ?>
}

#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul {
    margin: 0 !important;
    padding: 0 !important;
    overflow: hidden;
<?php if($filteringFloatLgal == 'top') {
  echo "float:left;margin-left:1%;";
} ?>
    width: 100%;
}

#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_options_<?php echo $portfolioID; ?> ul li {
    list-style-type: none;
    margin: 0 !important;
    padding: 0;
<?php
    if($sortingFloatLgal == "top")
    { echo "float:left !important;margin: 0 8px 4px 0 !important;"; }
    if($sortingFloatLgal == "left" || $sortingFloatLgal == "right")
    { echo 'border-bottom: 1px solid #ccc;'; }
    else
    { echo 'border: 1px solid #ccc;'; }
?>
}

#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_options_<?php echo $portfolioID; ?> ul li a {
    background-color: #<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_sortbutton_background_color"];?> !important;
    font-size:<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_sortbutton_font_size"];?>px !important;
    color:#<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_sortbutton_font_color"];?> !important;
    text-decoration: none;
    cursor: pointer;
    margin: 0 !important;
    display: block;
    padding:<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_sortbutton_border_padding"];?>px;
}


#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_options_<?php echo $portfolioID; ?> ul li a:hover {
    background-color: #<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_sortbutton_hover_background_color"];?> !important;
    color:#<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_sortbutton_hover_font_color"];?> !important;
    cursor: pointer;
}

#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> {
    float: <?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_filtering_float"]; ?> ;
    position: relative ;
<?php   if($filteringFloatLgal != 'top'){
            echo 'float:'.$filteringFloatLgal.';';
            echo  "max-width:180px;width:20%;display:inline-block;";
            if($filteringFloatLgal == 'left') echo 'margin-right: 1%;';
            else echo 'margin-left:1%;';
        }
        else {
            if($portfolioposition == 'on' && ($sortingFloatLgal == 'top' || $sortingFloatLgal == '')) echo 'left:50%; transform:translateX(-50%);';
            echo 'width: auto; margin-bottom: 5px;display:table;';
        }
        if(($sortingFloatLgal == 'left' && $filteringFloatLgal == 'left') || ($sortingFloatLgal == 'right' && $filteringFloatLgal == 'right')){
            echo 'width: 100%;';
        }
?>


}

#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul li {
    list-style-type: none;
    border-radius: <?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_filterbutton_border_radius"];?>px;
<?php
   if($filteringFloatLgal == "top") { echo "float:left !important;margin: 0 8px 4px 0 !important;"; }
   if($filteringFloatLgal == "left" || $filteringFloatLgal == "right")
   { echo 'border-bottom: 1px solid #ccc;'; }
   else echo "border: 1px solid #ccc;";
?>
}

#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul li a {
    font-size:<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_filterbutton_font_size"];?>px !important;
    color:#<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_filterbutton_font_color"];?> !important;
    background-color: #<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_filterbutton_background_color"];?> !important;
    border-radius: <?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_filterbutton_border_radius"];?>px;
    padding:<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_sortbutton_border_padding"];?>px;
    display: block;
    text-decoration: none;
}

#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?>  ul li a:hover {
    color:#<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_filterbutton_hover_font_color"];?> !important;
    background-color: #<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_filterbutton_hover_background_color"];?> !important;
    cursor: pointer
}
#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul li.active a,
#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul li.active a:link,
#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul li.active a:visited,
#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?>  ul li.active a:hover,
#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?>  ul li.active a:focus,
#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?>  ul li.active a:active {
    color:#<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_filterbutton_hover_font_color"];?> !important;
    background-color: #<?php echo $portfolio_gallery_get_options["portfolio_gallery_ht_view8_filterbutton_hover_background_color"];?> !important;
    cursor: pointer;
}
#huge_it_portfolio_content_<?php echo $portfolioID; ?> section {
    position:relative;
    display:block;
}

#huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_container_<?php echo $portfolioID; ?> {
    width: 79%;
    max-width: 100%;

<?php if(($sortingFloatLgal == "left" && $filteringFloatLgal == "right") || ($sortingFloatLgal == "right" && $filteringFloatLgal == "left"))
    {echo "margin: 0 auto;width:58%;"; }
    if(($filteringFloatLgal == "left" || $filteringFloatLgal == "right" && $sortingFloatLgal == "top") || ($sortingFloatLgal == "left" || $sortingFloatLgal == "right" && $filteringFloatLgal == "top"))
    {echo 'float:left;';}
    if(($portfolioShowSorting == 'off' && $portfolioShowFiltering == 'off') || ($sortingFloatLgal == 'top' && $filteringFloatLgal == 'top') ||
        ($sortingFloatLgal == 'top' && $filteringFloatLgal == '') || ($sortingFloatLgal == '' && $filteringFloatLgal == 'top'))
    {echo 'width:100%;';}

?>
}

#port-sort-direction {
<?php if($portfolio_gallery_get_options["portfolio_gallery_ht_view8_sorting_float"] == "top")
   { echo "float: left !important;"; }
?>
}
@media screen and (max-width: 768px) {

    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul li a,
    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul li a:link,
    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul li a:visited {
        font-size: 2vw !important;
    }
    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_options_<?php echo $portfolioID; ?> ul li a {
        font-size:2vw !important;
    }

}
@media screen and (max-width: 480px) {
    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_options_<?php echo $portfolioID; ?> {
        float: left;
    }
    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_options_<?php echo $portfolioID; ?> #sort-by{
        float: left;
        width: 100% !important;
    }
    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_options_<?php echo $portfolioID; ?> #port-sort-direction{
        float: left;
        width: 100% !important;
        position: relative;
        padding-left: 31% !important;
        right: 31%;
    }
    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul li a,
    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul li a:link,
    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul li a:visited {
        font-size: 3vw !important;
    }
    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_options_<?php echo $portfolioID; ?> ul li a {
        line-height: 3vw;
        font-size:3vw !important;
    }
}
@media screen and (max-width: 420px) {

    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul li a,
    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul li a:link,
    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_filters_<?php echo $portfolioID; ?> ul li a:visited {
        font-size: 4vw !important;
    }
    #huge_it_portfolio_content_<?php echo $portfolioID; ?> #huge_it_portfolio_options_<?php echo $portfolioID; ?> ul li a {
        font-size:4vw !important;
    }
}
@media screen and (max-width: <?php echo $portfolio_gallery_get_options['portfolio_gallery_ht_view8_width']+2*$portfolio_gallery_get_options['portfolio_gallery_ht_view8_border_width']+40; ?>px) {
    .portelement_<?php echo $portfolioID; ?>  {
        width:98%;
        margin: 1% !important;
        float: left;
        overflow: hidden;
        outline:none;
        border:<?php echo $portfolio_gallery_get_options['portfolio_gallery_ht_view8_border_color']; ?>px solid #<?php echo $portfolio_gallery_get_options['portfolio_gallery_ht_view8_border_color']; ?>;
    }
    .wd-portfolio-panel_<?php echo $portfolioID; ?> {
        width: 100% !important;
    }
}

#huge_it_portfolio_options_and_filters_<?php echo $portfolioID; ?> {
    position: relative;
    float: left;
    width: 20%;
    max-width: 180px;
    float:<?php echo $sortingFloatLgal; ?>;
<?php if($sortingFloatLgal == 'left') echo 'margin-right: 1%;';
    else echo 'margin-left:1%;';
?>
}




</style>