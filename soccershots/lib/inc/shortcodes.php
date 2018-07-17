<?php

require 'geo.php';

/* add locations short code */
add_shortcode('locations', 'soccershots_locations');
function soccershots_locations($atts) {
	$id = $atts['id'];
	$feedLocations = '';

	if ($id != '') {
		$cacheTimeInMinutes = 60;

		/* set cache name for a given location */
		$cacheKeyLocations = 'soccershots_locations_' . $id;

		/* get feeds from transient cache */
		$feedLocations = get_transient($cacheKeyLocations);

		/* refetch feed, add to cache */
		if (!$feedLocations) {
			/*
			 * *************************************************************************************************************************** BEGIN CURL
			*/

			// CREATE CURL RESOURCE
			$ch = curl_init();

			// SET URL
			curl_setopt($ch, CURLOPT_URL, "https://" . $id . ".ssreg.org/location_feed.php");

			// RETURN TRANSFER AS A STRING
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			// SET SSL VERSION TO USE (OTHERWISE WE HAVE AN SSL CONNECT ERROR DUE TO OUTDATED CURL LIBRARIES IN OUR LINUX ENVRIONMENTS)
			// USING DIRECT CURL APPROACH OVER wp_remote_get() DUE TO SSL HANDSHAKE ISSUE
			curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);

			// $output contains the output string
			$output = curl_exec($ch);

			/*
			if ($errno = curl_errno($ch)) {
				$error_message = curl_strerror($errno);
				echo "<p>cURL error ({$errno}):\n {$error_message}";
			}
			*/

			// CLOSE CURL RESOURCE
			curl_close($ch);

			/*
			 * *************************************************************************************************************************** END CURL
			*/

			$feedLocations = $output;

			if($feedLocations != '') {
				$arrLocations = json_decode( $output );
				$bounds = new \geo\LatLngBounds();

				$cacheResult = '';

				function cleanvalue($str) {
					$str = str_replace("\u0027", "'", $str);
					$str = str_replace("\u0022", '"', $str);
					$str = str_replace("\u0026", "&", $str);
					$str = str_replace("\u003C", "<", $str);
					$str = str_replace("\u003E", "=", $str);
					return $str;
				}

				$cacheResult .= '<ul class="clist cf list" data-center="">';
				foreach($arrLocations as $location) {
					/*
					"siteID":"146",
					"sitename":"CHUM -- Camp Hill UM Church Preschool",
					"territory":"0",
					"siteaddress":"417 S. 22nd Street",
					"siteaddress2":"",
					"sitecity":"Camp Hill",
					"sitestate":"PA",
					"sitezip":"17011",
					"sitelat":"40.235476300000000",
					"sitelng":"-76.921468700000000",
					"website":"http:\/\/www.chumpreschool.com\/",
					"franID":"1",
					"contactemail":"kjrgsr@aol.com",
					"contactname":"Georgia Reisinger\/Susan",
					"contactphone":"717-737-0262, ext. 246 \/737-5631",
					"regOnline":"1",
					"programs":[
					 "Childcare\/Preschool"
					],
					"url":"https:\/\/harrisburg.ssreg.org\/index.php?site_id=146",
					"mobile_url":"https:\/\/harrisburg.ssreg.org\/m\/index.php?site_id=146",
					"type":"private"
					*/
					$cacheResult .= '<li class="location">';
					$cacheResult .= '<a href="' . cleanvalue($location->url) . '" data-mobile-url="' . cleanvalue($location->mobile_url) . '" data-lat="' . cleanvalue($location->sitelat) . '" data-lng="' . cleanvalue($location->sitelng) . '">';
					$cacheResult .= '<p class="name">' . cleanvalue($location->sitename) . '</p>';
					$cacheResult .= '<div class="location-content">';
					$cacheResult .= '<p class="address">' . cleanvalue($location->siteaddress);
					$cacheResult .= '<br>' . cleanvalue($location->sitecity) . ', ' . cleanvalue($location->sitestate) . ' ' . cleanvalue($location->sitezip);
					$cacheResult .= '</p>';
					$cacheResult .= '<p class="programs">Programs:</p>';
					$cacheResult .= '<ul class="programs-list">';
					foreach($location->programs as $program) {
						$cacheResult .= '<li>' . $program . '</li>';
					}
					$cacheResult .= "</ul>";
					$cacheResult .= "</div>";
					$cacheResult .= '<p class="cta cta-dark">Enroll</p>';
					$cacheResult .= '</a>';
					$cacheResult .= '</li>';

					$bounds->extend(new \geo\LatLng($location->sitelat, $location->sitelng));
				}
				$cacheResult .= '</ul>';

				$center = $bounds->getCenter();
				/* update advanced custom fields of franchise page, delete regions transient so it pulls latest custom fields */
				$franchiseId = get_post_top_ancestor_id();
				update_field('lat', $center->lat, $franchiseId);
				update_field('lng', $center->lng, $franchiseId);
				update_field('bounds_sw_lat', $bounds->southWest->lat, $franchiseId);
				update_field('bounds_sw_lng', $bounds->southWest->lng, $franchiseId);
				update_field('bounds_ne_lat', $bounds->northEast->lat, $franchiseId);
				update_field('bounds_ne_lng', $bounds->northEast->lng, $franchiseId);
				delete_transient('soccershots_regions');

				set_transient($cacheKeyLocations, $cacheResult, 60 * $cacheTimeInMinutes);
				$feedLocations = $cacheResult;
			}
		}
	}
	return $feedLocations;
}

/* add button short code */
add_shortcode('button', 'soccershots_button');
function soccershots_button($atts) {
	$text = ($atts['text'] == '') ? "Read More" : $atts['text'];
	$newwindow = ($atts['newwindow'] == '') ? "" : ' target="_blank"';
	$href = $atts['href'];
	$content = '';

	if ($href != '') {
		$content .= '<p class="cta cta-dark">';
		$content .= '<a href="' . $href . '"' . $newwindow . '>';
		$content .= '<span>' . $text . '</span>';
		$content .= '</a>';
		$content .= '</p>';
	}
	return $content;
}

/* add career plug short code */
add_shortcode('careerplug', 'soccershots_careerplug');
function soccershots_careerplug($atts) {
	$text                     = ($atts['text'] == '') ? "Career Opportunities" : $atts['text'];
	$topMostFranchisePageId   = get_post_top_ancestor_id();
	$topMostFranchisePageSlug = get_post($topMostFranchisePageId)->post_name;
	$settingsID               = get_franchise_settings_id($topMostFranchisePageSlug);
	$franchise_id             = get_field('franchise_id', $topMostFranchisePageId);
	$career_plug              = get_field('career_plug', $topMostFranchisePageId);
	$career_plug_email        = get_field('career_plug_email', $settingsID);
	$content                  = '';

	if ($franchise_id != '') {
		if ($career_plug) {
			// FRANCHISE USES CAREER PLUG
			$content .= '<p class="cta cta-dark">';
			$content .= '<a href="http://soccershotscareers.careerplug.com/jobs?loc=' . $franchise_id .'" target="_blank">';
			$content .= '<span>' . $text . '</span>';
			$content .= '</a>';
			$content .= '</p>';
		} else if ($career_plug_email != '') {
			// FRANCHISE DOES NOT USE CAREER PLUG
			$content .= '<p>';
			$content .= '<a href="mailto:' . $career_plug_email . '">Email Us About Our Career Opportunities</a>';
			$content .= '</p>';
		}
	}
	return $content;
}
?>
