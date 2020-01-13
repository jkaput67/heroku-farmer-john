<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>
<?php get_template_part( 'parts/where','to-buy-hero' ); ?>
<div class="row page-where-to-buy">
	<?php do_action( 'foundationpress_before_content' ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,600,300,700' rel='stylesheet' type='text/css'>
	<link href="/product-locator/locator.css" rel="stylesheet" type="text/css">
 	<div class="column large-12 medium-12" style="text-align:center">
		<h1 class="title">Craving that <br class="hide-for-large-up hide-for-medium-up" />Farmer John<sup style="font-size:60%;">&reg;</sup> Flavor?</h1>
		<p>Find your favorite products at a retailer near you. First tell us where you are, then tell us what you want to eat.</p>
	</div>
		<div xmlns:ng="http://angularjs.org" id="ng-app" ng-app="fjLocator" ng-cloak>
			<div class="common-text" >
				<div class="main-text">
				</div>
				 <div class="container-fluid " ng-controller="MainCtrl" >
				  <div class="row-fluid selecting-product-params" ng-show="selectingProduct">
					<div class="where_to_buy_step_label">1. Enter your location</div>
				    <div class="row selectingproduct" ng-show="selectingProduct">
                <div class="column large-3 medium-3">&nbsp;</div>
				        <div class="column large-3 medium-3 textinputfield">
				          <form name="searchForm" class="zip-code-form">
				            <input
				            	ng-model="searchParams.zip"
				            	ng-pattern="/^[0-9]+$/"
				            	ng-minlength="5"
				            	class="map-view-zip"
				            	name="zip"
				            	required
				            	ng-change="zipCodeChanged()"
				            	placeholder="Enter Zip"
				            	>
				            <span class="error" ng-show="selectedItem && (searchForm.zip.$error.required || !searchForm.zip.$valid )">
				            	Required
				            </span>
				          </form>
				        </div>
				        <div class="column large-3 medium-3 selectfield">
				            <span class="travel-distance-label ">Within</span>
				            <span class="radius-container" on-outside-element-click="hideAllOpenDropDowns()">
					            <div class="radius-button "
					            	ng-init = "showRadiusOption = false"
												ng-click="showRadiusOption = !showRadiusOption">
												{{searchRadius}} mi</div>

					            <div class="radius-dropdown-option radius-dropdown-option-page-1" ng-show="showRadiusOption" >
					            	<div ng-show="searchRadius != 5"ng-click="setRadius(5)">
													5 mi
					            	</div>
					            	<div ng-show="searchRadius != 10" ng-click="setRadius(10)">
													10 mi
					            	</div>
					            	<div ng-show="searchRadius != 20" ng-click="setRadius(20)">
													20 mi
					            	</div>
					            	<div ng-show="searchRadius != 50" ng-click="setRadius(50)">
													50 mi
					            	</div>
					            </div>
				            </span>
				        </div>
				        <div class="column large-3 medium-3">&nbsp;</div>
				    </div>
					<div class="where_to_buy_step_label">2. Select a product</div>
				    <div class="row-fluid food-options">
				        <div class="food-type" ng-repeat="category in categoryListModel.list"
				         ng-click="category.toggleShowFood()">
				          <div>
				            <img ng-src='{{category.imgSrc}}'/></div>
				          <div>
				            <div class="selected-item text-center" ng-show="!category.selectedItem">
				              <div class="name">{{category.name}}</div>
				            </div>
				            <div class="selected-item text-center" ng-show="category.selectedItem">
				              <div class="name">{{category.selectedItem.name.slice(12)}}</div>
				            </div>
				          </div>
				          <div class="individual-food-list" ng-show="category.showOptions">
				           <b>{{category.name}}</b></br>
				            <div class="food-options" ng-repeat="food in category.list">
				              <div  class="food-name"
				                    ng-class="{blue: hover}"
				                    ng-mouseenter="hover = true"
				                    ng-mouseleave="hover = false"
				                    ng-click="onFoodItemClicked(food, category)">
				                {{food.name}}
				              </div>
				            </div>
				          </div>
				        </div>
				    </div>
				    <hr>
				    <div class="find-product" ng-show="showFindMyProduct()"
				        ng-click="launchMap()">
				       <a href="">
					      <div class="find-my-product">
					      FIND MY PRODUCT
					       </div>
				      </a>
				    </div>
				    <div class="find-product-alt">
					      <div class="find-my-product" title="Please select a product to search for">
					      FIND MY PRODUCT
					       </div>
				    </div>
				  </div><!-- end selecting product -->
				  <div class="row-fluid results-container large-10 medium-10" ng-show="!selectingProduct">
				    <div class="row-fluid map-options">
				      <div class="pane pull-left span12 large-12 medium-12">
				        <div class="dropdownfield row-fluid large-4 medium-4 small-10" style="float:left">
				          <div class="dropdown">
				            <div class="current-item " ng-init="showDropDown = false"
				            	ng-click="showDropDown = !showDropDown">
				              {{selectedItem.name}}
				              <span class="caret"></span>
				            </div>
				            <div class="dropdown-menu entire-food-list-drop-down span12 large-12 medium-12" ng-show="showDropDown">
				              <div class="dropdown-food-items " ng-repeat="category in categoryListModel.list">
				                <div class="dropdown-food-list span6 large-6 medium-6">
				                  <b>{{category.name}}</b><br />
				                  <div class="food-options" ng-repeat="food in category.list">
				                    <div  class="food-name"
				                          ng-class="{blue: hover}"
				                          ng-mouseenter="hover = true"
				                          ng-mouseleave="hover = false"
				                          ng-click="onNewFoodItemClicked(food, category)">
				                      {{food.name}}
				                    </div>
				                  </div>
				                </div>
				            </div>
				          </div>
				        </div>
				      </div>
				        <div class="location-zone pull-left span12 large-8 medium-8">
				            <div class="zip-code">
								<form name="searchForm" class="zip-code-form">
									<input
									ng-model="searchParams.zip"
									ng-minlength="5"
									ng-pastter="/^[0-9]+$/"
									class="map-view-zip onlyDigits"
									name="zip"
									required
									ng-change="zipCodeChanged()"
									>
									<span class="error" ng-show="selectedItem && (searchForm.zip.$error.required || !searchForm.zip.$valid )">
										Invalid!
									</span>
								</form>
				            </div>
				            <div class="radius-div pull-left" style="float:left">
				            <span class="travel-distance-label ">Within</span>
				            	<span on-outside-element-click="hideAllOpenDropDowns()">
						            <div class="radius-button-page2"
								             ng-init = "showRadiusOption = false"
														 ng-click="showRadiusOption = !showRadiusOption">
														 {{searchRadius}} mi<!-- <div class="caret white-caret"></div> --></div>

						            <div class="radius-dropdown-option" ng-show="showRadiusOption" >
						            	<div ng-show="searchRadius != 5"ng-click="setRadius(5)">
														5 mi
						            	</div>
						            	<div ng-show="searchRadius != 10" ng-click="setRadius(10)">
														10 mi
						            	</div>
						            	<div ng-show="searchRadius != 20" ng-click="setRadius(20)">
														20 mi
						            	</div>
						            	<div ng-show="searchRadius != 50" ng-click="setRadius(50)">
														50 mi
						            	</div>
					            	</div>
					            </span>
				        	</div>
				          <div class="new-search">
							      <div class="find-my-product"  ng-click="launchMap()" ng-show="newFoodItemClicked && showFindMyProduct()"> FIND  </div>
				          </div>
				        </div>
				      </div>
				    </div>
				    <div class="row-fluid store-results span12" style="clear:both">
				          <div class="span10 map-column" style="float:right; width:70%">
				            <div class="google-map"
				                 center="map.center"
				                 zoom="map.zoom"
				                 draggable="true"
				                 dragging="map.dragging"
				                 bounds="map.bounds"
				                 refresh="map.refreshMap"
				                 events ="map.events"
				                 >
				                  <markers  models="map.storeMarkers"
				                            coords="'self'"
				                            icon="'icon'"
				                            click="'onClicked'">
				                    <windows show="'showWindow'" closeClick="'closeClick'">
								                <p ng-non-bindable>

								                	<a href="http://maps.google.com/?q={{ latitude | number:4 }},{{ longitude | number:4 }}" target="_blank">
								                		{{name}}</a>
								                </p>
								                <p class="muted"></p>
								            </windows>
				                  </markers>
				            </div>
				            <div  class="loading-stores"
				                  ng-show="loadingStores"
				              >
				              {{loadingMessage}} <br><br>
				              <div ng-show="showLoadingGif">
				              	<img src="/product-locator/img/loading2.gif" >
				              </div>
				            </div>
				            <div  class="loading-stores"
				                  ng-show="noStoresFound"
				              >
				               No stores found.  Try increasing the radius or a different product. <br><br>
				            </div>
				          </div>
				          <div class="span2 store-list-column">
				          	<div class="store-list-addresses">
				              <div class="store-item"
				                ng-repeat="store in storeListModel.list | startFrom:currentStoresPage*pageSize | limitTo:pageSize"
				                ng-class="{storeitemmiddle:$index  == 1 }"
				                >
				                <div class="row-fluid">
				                <!--   <div class="store-name-title span2">{{$index + currentStoresPage*pageSize + 1}})</div> -->

				                  <div class="store-name span10">{{store.NAME.__cdata}}</div>
				                </div>
				                <div class="store-address row-fluid" style="clear:both">
				                  <div class="span10">
				                    <div>
				                      {{store.ADDRESS.__cdata}}
				                    </div>
				                    <div>
				                      {{store.CITY.__cdata}}, {{store.STATE.__cdata}}
				                    </div>
				                    <div>
				                      {{store.ZIP.__cdata}}
				                    </div>
				                  </div>
				                </div>
				                <div class="row-fluid">
				                  <div class="span10">
				                    {{store.PHONE.__cdata}}
				                  </div>
				                </div>
				              </div>
				            </div>
				              <div class="row-fluid pagination-buttons">
<div class="span6 pull-right paging-button align-right-no-padding page-button-next"
					                  ng-click="incrementPager();"
					                  ng-class="{disabled: currentStoresPage >= storeListModel.list.length/pageSize - 1}"
					                >
					                  Next
					                </div>
					                <div class="span6 paging-button page-button-prev"
					                  ng-click="decrementPager();"
					                  ng-class="{disabled: currentStoresPage == 0}"
					                >
					                  Prev
					                </div>

				              </div>
				          </div>
				    </div><!--End Span 12 -->
				  </div><!-- end row fluid -->
				 </div><!-- end container fluid -->
			</div>
		<!-- </div> -->
	</div><!-- end #ng-app -->
	<?php endwhile;?>
</div>

    <div class="row-fluid secondary-action span12">
    <p>Can't find the product<br class="hide-for-large-up hide-for-medium-up" /> you're looking for?</p>
	<a href="http://www.amazon.com/s/ref=bl_sr_grocery?ie=UTF8&field-brandtextbin=Farmer+John&node=16310101" target="
	_blank">
		 <div class="exit btn-visit-amazon">
	VISIT AMAZON.COM
	</div>
	</a>
	</div>

	<div class="row-fluid retail-section span12">
		<h1 class="title">Retailers</h1>
		<div class="retail-lists column small-10 small-offset-1 large-8 large-offset-2 medium-8 medium-offset-2 text-center">
			<div class="txtcol text-left column columns large-3 medium-3 small-6"><?php echo get_field('wtb_retailers_column_1','options'); ?></div>
			<div class="txtcol text-left column columns large-3 medium-3 small-6"><?php echo get_field('wtb_retailers_column_2','options'); ?></div>
			<div class="txtcol text-left column columns large-3 medium-3 small-6"><?php echo get_field('wtb_retailers_column_3','options'); ?></div>
			<div class="txtcol text-left column columns large-3 medium-3 small-6"><?php echo get_field('wtb_retailers_column_4','options'); ?></div>
		</div>
		<hr class="small-10 small-offset-1 large-6 large-offset-3 medium-6 medium-offset-3" />
		<p class="text-center subnote">Also enjoy your favorite Farmer John<br class="hide-for-large-up hide-for-medium-up" /> products at select West Coast restaurants!</p>
	</div>

	<?php do_action( 'foundationpress_after_content' ); ?>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCFQnjtxE5GOWEOFKKd6iuGl2XYIihT9uM&v=3.13&sensor=false&language=en"></script>
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.js"></script>
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/product-locator/js/lib/ui.bootstrap.js"></script>
<script type="text/javascript" src="/product-locator/js/lib/xml2json.js"></script>
<script src="/product-locator/js/angular-google-maps.js"></script>
<script type="text/javascript" src="/product-locator/js/services.js"></script>
<script src="/product-locator/js/main.js"></script>
<script type="text/javascript" src="/product-locator/js/categoryListModel.js"></script>
<script type="text/javascript" src="/product-locator/js/storeListModel.js"></script>
<?php get_footer(); ?>
