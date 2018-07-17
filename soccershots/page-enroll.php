<?php
/**
 * @package SOCCERSHOTS
 */
?>
<h2>Locations</h2>

<div class="locations-map-list-wrapper">
	<div class="locations-wrapper">
		<div class="locations-canvas-wrapper">
			<div class="locations-canvas"></div>
			<div class="locations-loader-wrapper">
				<div class="locations-loader"></div>
				<div class="locations-loader-txt">Plotting locations for this region, please wait...</div>
			</div>
		</div>
	</div>

	<div id="location-wrapper" class="list">
		<p>
			<label for="location_name">Filter Locations By Search Phrase: </label>
			<input id="location_name" name="location_name" type="text" class="search">
		</p>
		<?php echo do_shortcode('[locations id="' . get_post_top_ancestor_slug() . '"]'); ?>
	</div>
</div>
