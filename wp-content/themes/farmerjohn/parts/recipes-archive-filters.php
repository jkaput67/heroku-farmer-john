<div class="recipes_archive_filters hide-for-large-up">
	<div class="row">
		<div class="column small-8">
			<span class="sort_by"><?php _e('SORT BY','foundationpress')?>:</span>
		</div>
		<div class="column small-4 relative-block">
			<input type="text" class="recipes_archive_search search light-grey-bg" placeholder="SEARCH">
			<i class="fa fa-search"></i>
		</div>
	</div>
	<div class="row">
		<div class="column small-4">
			<select class="filter-dropdown light-grey-bg filter-product" data-placeholder="PRODUCT" placeholder="PRODUCT" data-filter-target="category-">
<?php
$args = array(
    'orderby'           => 'name',
    'order'             => 'ASC',
    'taxonomy'          => 'recipe_categories',
);
$terms = get_categories($args); ?>
				<option value="all" selected="selected"><?php _e('PRODUCT','foundationpress')?></option>
				<option value="all"><?php _e('ALL PRODUCTS','foundationpress')?></option>
<?php foreach ($terms as $term) {
	if( $term->slug != "featured-on-homepage" ){ ?>
				<option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
<?php }
} ?>
			</select>
		</div>
		<div class="column small-4">
			<select class="filter-dropdown light-grey-bg filter-meal" data-placeholder="MEAL">
				<option value="all" selected="selected"><?php _e('MEAL','foundationpress')?></option>
				<option value="all"><?php _e('ALL MEALS','foundationpress')?></option>
				<option value="meals-breakfast"><?php _e('Breakfast','foundationpress')?></option>
				<option value="meals-brunch"><?php _e('Brunch','foundationpress')?></option>
				<option value="meals-lunch"><?php _e('Lunch','foundationpress')?></option>
				<option value="meals-appetizer"><?php _e('Appetizer','foundationpress')?></option>
				<option value="meals-dinner"><?php _e('Dinner','foundationpress')?></option>
			</select>
		</div>
		<div class="column small-4">
			<!-- <select class="filter-dropdown light-grey-bg filter-occasion" data-placeholder="OCCASION">
				<option value="all" selected="selected">OCCASION</option>
				<option value="all">ALL OCCASIONS</option>
				<option value="occasions-holidays">Holidays</option>
				<option value="occasions-grilling">Grilling</option>
				<option value="occasions-entertaining">Entertaining</option>
				<option value="occasions-tailgating">Tailgating</option>
			</select> -->
		</div>
	</div>
</div>

<div class="recipes_archive_filters show-for-large-up">
	<div class="row">
		<div class="column small-12">
			<span class="sort_by"><?php _e('SORT BY','foundationpress')?>:</span>
			<select class="filter-dropdown light-grey-bg filter-product" data-placeholder="PRODUCT" placeholder="PRODUCT" data-filter-target="category-">
<?php
$args = array(
    'orderby'           => 'name',
    'order'             => 'ASC',
    'taxonomy'          => 'recipe_categories',
);
$terms = get_categories($args); ?>
				<option value="all" selected="selected"><?php _e('PRODUCT','foundationpress')?></option>
				<option value="all"><?php _e('ALL PRODUCTS','foundationpress')?></option>
<?php foreach ($terms as $term) {
	if( $term->slug != "featured-on-homepage" ){ ?>
				<option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
<?php }
} ?>
			</select>
			<select class="filter-dropdown light-grey-bg filter-meal" data-placeholder="MEAL" placeholder="MEAL">
				<option value="all" selected="selected"><?php _e('MEAL','foundationpress')?></option>
				<option value="all"><?php _e('ALL MEALS','foundationpress')?></option>
				<option value="meals-breakfast"><?php _e('Breakfast','foundationpress')?></option>
				<option value="meals-brunch"><?php _e('Brunch','foundationpress')?></option>
				<option value="meals-lunch"><?php _e('Lunch','foundationpress')?></option>
				<option value="meals-appetizer"><?php _e('Appetizer','foundationpress')?></option>
				<option value="meals-dinner"><?php _e('Dinner','foundationpress')?></option>
			</select>

			<div class="relative-block right">
				<input type="text" class="recipes_archive_search search light-grey-bg" placeholder="SEARCH">
				<i class="fa fa-search"></i>
			</div>
		</div>
	</div>
</div>
