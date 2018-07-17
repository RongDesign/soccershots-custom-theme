<?php
require('../../../../../wp-blog-header.php' );
header('Content-Type: application/json');
?>
<?php
$cacheTimeInMinutes = 240;

/* set cache name for a given location */
$cacheKeyRegions = 'soccershots_regions';

/* get feeds from transient cache */
$feedRegions = get_transient($cacheKeyRegions);

function buildLatLng ($prefix, $id) {
	$latlng = new StdClass;
	$latlng->lat = floatval(get_field($prefix . 'lat', $id));
	$latlng->lng = floatval(get_field($prefix . 'lng', $id));
	return $latlng;
}

function getRegions () {
	/* get all pages that have a meta_key of 'lat' (i.e the franchise home pages) */
	$args = array(
		'posts_per_page'   => -1,
		'orderby'          => 'title',
		'order'            => 'ASC',
		'exclude'          => '2052', // exclude FRANCHISEE TEMPLATE (this is used by Soccer Shots to build new templates)
		'meta_key'         => 'lat',
		'post_type'        => 'page',
		'post_status'      => 'publish'
	);
	$posts_array = get_posts($args);
	$arrLocations = array();

	if ($posts_array) {
		foreach ($posts_array as $post) {
			$id = $post->ID;
			$name = get_the_title($id);
			$url = get_the_permalink($id);

			$geo = new StdClass;
			$geo->bounds = new StdClass;
			$geo->bounds->center = buildLatLng('', $id);
			$geo->bounds->sw = buildLatLng('bounds_sw_', $id);
			$geo->bounds->ne = buildLatLng('bounds_ne_', $id);

			$location = array(
				"name" => $name,
				"url" => $url,
				"geo" => $geo
			);
			array_push($arrLocations,$location);
		}
	}

	return $arrLocations;
}

/* refetch feed, add to cache */
if (!$feedRegions) {
	$feedRegions = getRegions();
	set_transient($cacheKeyRegions, $feedRegions, 60 * $cacheTimeInMinutes);
}
echo json_encode($feedRegions);
?>
