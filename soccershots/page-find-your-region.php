<?php
/**
 * @package SOCCERSHOTS
 */?>
<div class="geolocation-geocode-options">
	<div class="geolocation-wrapper">
		<div class="geolocation-banner"></div>
		<div class="geolocation-canvas-wrapper">
			<div class="geolocation-canvas"></div>
			<div class="geolocation-loader-wrapper">
				<div class="geolocation-loader"></div>
				<div class="geolocation-loader-txt">Determining your region via geolocation, please wait...</div>
			</div>
		</div>
	</div>

	<div id="postal-code" class="geocode-option">
		<h2>Find Region By Postal Code</h2>
		<form id="postal-code-search" method="get" action="<?php echo get_permalink(); ?>">
			<p>
				<label for="postal_code">Postal Code</label>
				<input id="postal_code" name="postal_code" type="number" maxlength="10">
				<button type="submit" class="btn">Find</button>
			</p>
		</form>
	</div>
</div>

<div class="state-option">
	<h2>Find Region By State/Province</h2>
	<p>Use the menu below to filter regions by State/Province.</p>
	<?php
	/* get all pages that have a meta_key of 'lat' (i.e the franchise home pages) */
	$args = array(
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'exclude'        => '2052', // exclude FRANCHISEE TEMPLATE (this is used by Soccer Shots to build new templates)
		'meta_key'       => 'lat',
		'post_type'      => 'page',
		'post_status'    => 'publish'
	);
	$posts_array = get_posts($args);
	$arrLocations = array();
	$list = '';
	$locObject = get_field_object('field_55c0c0964990b');

	if ($posts_array) {
		foreach ($posts_array as $post) {
			setup_postdata($post);
			$loc = get_field('stateprovinceterritory', $post->ID);
			$list .= '<div class="' . $loc . '"><a href="' . get_the_permalink() . '"><span class="icon icon-angle-right"></span>' . get_the_title() . '</a></div>' . "\n";
			array_push($arrLocations, get_field('stateprovinceterritory', $post->ID));
		}
		array_unique($arrLocations);
	}
	?>
	<?php if ($locObject): ?>
	<p>
		<select id="location-select">
			<option value="" selected="selected">All Regions</option>
			<?php foreach( $locObject['choices'] as $k => $v ): ?>
				<?php if (in_array($k, $arrLocations)): ?>
					<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
	</p>
	<?php endif; ?>

	<?php if ($list != ''): ?>
	<div class="location-list-wrapper">
		<?php echo $list; ?>
	</div>
	<?php endif; ?>
</div>
