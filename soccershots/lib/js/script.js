/*
 * *************************
 * SITE JS
 * REQUIRES: lib/js/jquery-1.11.3.min.js
 *           lib/js/jquery.easing.1.3.min.js
 * *************************
*/

jQuery(document).ready(function($) {
	/*
	 * *************************
	 * VARIABLES / COMMON FUNCTIONS
	 * *************************
	*/

	// VARS FOR GOOGLE MAPS
	var $maps = $('.gmaps');
	var maps = [];

	// YOUTUBE VIDEO PLAYER
	var $ytplayers = $('.ytplayer');

	// CREATE GLOBAL SOCSH (SOCCER SHOTS) OBJECT
	window.SOCSH = {};

	/*
	 * *************************
	 * SET COOKIE
	 * *************************
	*/

	function setCookie(name,value,expiredays) {
		var exdate = new Date();
		exdate.setDate(exdate.getDate() + expiredays);
		document.cookie = name + " = " + escape(value) + "; path=/" + ((expiredays==null) ? "" : "; expires = " + exdate.toGMTString());
	}

	/*
	 * *************************
	 * GET COOKIE
	 * *************************
	*/

	function getCookie(check_name) {
		var cookies = document.cookie.split( ';' );
		var tmpcookie = cookie_name = cookie_value = '';
		var cookie_found = false;

		for (var i = 0; i < cookies.length; i++ ) {
			tmpcookie = cookies[i].split( '=' );
			cookie_name = tmpcookie[0].replace(" ", "");

			if (cookie_name == check_name) {
				cookie_found = true;
				if (tmpcookie.length > 1) cookie_value = unescape(tmpcookie[1].replace(" ", ""));
			}
		}
		if (!cookie_found) {
			return '';
		} else {
			return cookie_value;
		}
	}

	/*
	 * *************************
	 * MAIN NAV - FIND A REGION/ENROLL AT A SITE DROPDOWN MENUS
	 * *************************
	*/

	$('#main-nav li:last-child > a').click(function (e) {
		var $t = $(this);

		// LOAD REGION/LOCATIONS MAP ONLY IF NAVICON IS NOT DISPLAYED
		if ($('#navicon').css('display') == 'none' && !$('#body-franchise').length) {
			if ($t.hasClass('enroll')) {
				if (!$t.parent().find('.locations-wrapper').length) {
					$.ajax({
						url: $t.attr('href')
					}).done(function (data) {
						var $html = $(data).find('.locations-map-list-wrapper').html();
						var viewmore  = '<div class="viewmore-locations"><p><strong>Having trouble finding something?</strong><br><a href="' + $t.attr('href') + '">View Locations in List View</a></p></div>';

						// GA - TRACK PAGE VIEW
						_gaq.push(['_trackPageview', $t.attr('href')]);

						$t.parent().find('.dropdown-loader').html($html + viewmore);
						loadmaps();
					});
				}
			} else {
				if (!$t.parent().find('.geolocation-wrapper').length) {
					$.ajax({
						url: $t.attr('href')
					}).done(function (data) {
						var $html = $(data).find('.geolocation-geocode-options').html();
						var viewmore  = '<div class="viewmore"><p><strong>Not your region?</strong><br><a href="/find-your-region/#postal-code">Explore All Regions</a></p></div>';

						// GA - TRACK PAGE VIEW
						_gaq.push(['_trackPageview', $t.attr('href')]);

						$t.parent().find('.dropdown-loader').html($html + viewmore);
						loadmaps();
					});
				}
			}

			if ($t.hasClass('dd-open')) {
				$t.next('.dropdown').slideUp(400, 'easeInExpo', function() {
					$t.toggleClass('dd-open');
					$t.find('span.icon').toggleClass('icon-caret-up icon-caret-down');
				});
			} else {
				$t.toggleClass('dd-open');
				$t.find('span.icon').toggleClass('icon-caret-up icon-caret-down');
				$t.next('.dropdown').slideDown(600, 'easeOutExpo');
			}
			e.preventDefault();
		}
	});

	/*
	 * *************************
	 * SUB NAV
	 * *************************
	*/

	if ($('#sub-nav-menu').length) {
		$('#main-content').addClass('sticky-sub-nav-buffer');

		$('#sub-nav-menu').click(function (e) {
			var $t = $(this);

			$t.toggleClass('open');
			if ($t.hasClass('open')) {
				$t.children('.icon-caret-down').addClass('icon-caret-up').removeClass('icon-caret-down');
			} else {
				$t.children('.icon-caret-up').addClass('icon-caret-down').removeClass('icon-caret-up');
			}

			$('#sub-nav').slideToggle(600, 'easeOutExpo', function () {
				if ($(this).css('display') == 'none') {
					$(this).css('display', '');
				}
			});
			e.preventDefault();
		});
	}

	/*
	 * *************************
	 * NAVICON
	 * *************************
	*/

	$('#navicon').click(function (e) {
		if (!$(this).hasClass('animating')) {
			var $t = $(this);
			$t.addClass('animating');
			$t.toggleClass('open');

			// IF MOBILE SUB NAV MENU IS OPENED, CLOSE IT
			if ($('#sub-nav-menu').hasClass('open')) {
				$('#sub-nav-menu').trigger('click');
			}

			$('#nav-wrapper').slideToggle(600, 'easeOutExpo', function () {
				if ($(this).css('display') == 'none') {
					$(this).css('display', '');
				}
				$t.toggleClass('animating');
			});
		}
		e.preventDefault();
	});

	/*
	 * *************************
	 * HOME PAGE SLIDESHOW
	 * REQUIRES: lib/js/jquery.touchSwipe.min.js
	 * *************************
	*/

	if ($('#slideshow-wrapper .slide-container').length > 1) {
		$('#slideshow-wrapper').each(function (i) {
			var $slideshow = $(this).find('#slideshow');
			var $loader = $('#slide-loader');
			var $transitional = $('#slide-transition');
			var curSlide = 1;
			var prevSlide = 1;
			var slideDuration = 8000;
			var slideTimer = null;
			var offset = 150;

			// UPDATE SLIDE POSITION
			function nextSlide() {
				prevSlide = curSlide;
				curSlide = (curSlide + 1 > $('.slide-nav').first().children('li').length) ? 1 : curSlide + 1;
				goToSlide();
			}

			// LOAD SLIDE
			function goToSlide() {
				// ADD ANIMATING CLASS (PREVENTS US FROM GOING TO ANOTHER SLIDE UNTIL CURRENT ANIMATION IS COMPLETED
				$slideshow.addClass('animating');

				// LOADING ICON
				$loader.show();

				// LOAD DROPDOWN MENU BACKGROUND IMAGE
				$('<img src="'+ $('.slide-container:nth-child(' + curSlide + ') .slide').attr('data-bg') +'">').load(function() {
					// WHEN IMAGE IS LOADED, FADE IN ON THE INNER CONTAINER AND THEN MOVE TO THE OUTER CONTAINER
					$transitional.css('background-image', 'url(' + $('.slide-container:nth-child(' + curSlide + ') .slide').attr('data-bg') + ')');
					transitionSlide();
				});
			}

			// SLIDE TRANSITION
			function transitionSlide() {
				var prevLocation = ($('.slide-container' + prevSlide).hasClass('slide-location1') || $('.slide-container' + prevSlide).hasClass('slide-location3')) ? 'left' : 'right';
				var curLocation = ($('.slide-container' + curSlide).hasClass('slide-location1') || $('.slide-container' + curSlide).hasClass('slide-location3')) ? 'left' : 'right';

				// HIDE LOADER
				$loader.hide();

				// GA - TRACK SLIDE VEIW
				//_gaq.push(['_trackEvent', 'Home Page Slideshow', 'View', 'Slide #' + curSlide + ': ' + $('.slide-container' + curSlide).find('h1').text()]);

				// SHOW TRANSITION DIV AND ANIMATE
				$transitional.show().stop().animate( { 'opacity': 1 }, 1400, 'easeOutQuad');

				// MOVE PREVIOUS SLIDE TEXT OFF SCREEN
				if ($(window).width() > 760) {
					if (prevLocation == 'right') {
						$('.slide-container' + prevSlide).stop().animate( { 'opacity': 0, right: offset }, 1400, 'easeOutQuad', function() {
							$(this).css({ left:'', right:''}).hide();
						});
					} else {
						$('.slide-container' + prevSlide).stop().animate( { 'opacity': 0, left: offset }, 1400, 'easeOutQuad', function() {
							$(this).css({ left:'', right:''}).hide();
						});
					}

					// SHOW CURRENT SLIDE, MOVE TEXT INTO PLACE
					if (curLocation == 'right') {
						$('.slide-container' + curSlide).css('right',30);
						$('.slide-container' + curSlide).show().stop().animate( { 'opacity': 1, right: 0 }, 1400, 'easeOutQuad', function() {
							// MOVE BACKGROUND GRAPHIC TO CURRENT DIV, CLEAR TRANSITION DIV ON COMPLETION,
							$slideshow.css('background-image',$transitional.css('background-image'));
							$transitional.css('opacity',0).hide();

							$slideshow.removeClass('animating');
						});
					} else {
						$('.slide-container' + curSlide).css('left',30);
						$('.slide-container' + curSlide).show().stop().animate( { 'opacity': 1, left: 0 }, 1400, 'easeOutQuad', function() {
							// MOVE BACKGROUND GRAPHIC TO CURRENT DIV, CLEAR TRANSITION DIV ON COMPLETION,
							$slideshow.css('background-image',$transitional.css('background-image'));
							$transitional.css('opacity',0).hide();

							$slideshow.removeClass('animating');
						});
					}
				} else {
					/* simply mobile transition (TODO: slide transition needs cleaned up) */
					$('.slide-container' + prevSlide).css({ left:'', right:''}).hide();
					$('.slide-container' + curSlide).css({ opacity: 1 }).show();
					$slideshow.css('background-image',$transitional.css('background-image'));
					$transitional.css('opacity',0).hide();
					$slideshow.removeClass('animating');
				}

				// REMOVE ACTIVE CLASS FROM SLIDE NAVIGATION, ADD CLASS TO CURRENT SLIDE
				$('.slide-nav li a').removeClass('active');
				$('.slide-nav li:nth-child(' + curSlide + ') a').addClass('active');

				// SET TIMEOUT FOR NEXT SLIDE
				clearTimeout(slideTimer);
				slideTimer = setTimeout(nextSlide, slideDuration);
			}

			// GA - TRACK SLIDE VEIW
			//_gaq.push(['_trackEvent', 'Home Page Slideshow', 'View', 'Slide #' + curSlide + ': ' + $('.slide-container' + curSlide).find('h1').text()]);

			// INIT SLIDESHOW TIMER
			clearTimeout(slideTimer);
			slideTimer = setTimeout(nextSlide, slideDuration);

			// SLIDESHOW NAVIGATION
			$('.slide-nav a').click(function (e) {
				if (!$slideshow.hasClass('animating') && !$(this).hasClass('active')) {
					clearTimeout(slideTimer);
					prevSlide = curSlide;
					curSlide = $(this).parent().index()+1;

					goToSlide();
				}
				e.preventDefault();
			});

			// SLIDESHOW PREV/NEXT BUTTON
			$('.slideshow-prev').click(function (e) {
				if (!$slideshow.hasClass('animating')) {
					clearTimeout(slideTimer);
					prevSlide = curSlide;
					curSlide = (curSlide == 1 ) ? $('.slide-nav').first().children('li').length : curSlide - 1;
					goToSlide();
				}
				e.preventDefault();
			});

			// SLIDESHOW NEXT BUTTON
			$('.slideshow-next').click(function (e) {
				if (!$slideshow.hasClass('animating')) {
					clearTimeout(slideTimer);
					prevSlide = curSlide;
					curSlide = (curSlide + 1 > $('.slide-nav').first().children('li').length) ? 1 : curSlide + 1;
					goToSlide();
				}
				e.preventDefault();
			});

			// SWIPE EVENT ON SLIDE
			$(this).swipe({
				threshold: 20,
				excludedElements: '',
				swipeLeft:function (event, distance, duration, fingerCount) {
					if ($('#navicon').css('display') != 'none') {
						$(this).find('.slideshow-next').trigger("click");
					}
				},
				swipeRight:function (event, distance, duration, fingerCount) {
					if ($('#navicon').css('display') != 'none') {
						$(this).find('.slideshow-prev').trigger("click");
					}
				}
			});

		});
	}

	/*
	 * *************************
	 * PARTNERS CAROUSEL
	 *   Requires: lib/js/owl.carousel.min.js
	 * *************************
	*/

	$(".owl-carousel").owlCarousel({
		items: 5,
		margin: 10,
		loop: true,
		nav: true,
		navText: [
			'<a href="#previous" class="icon-angle-left" rel="nofollow"><span>Previous</span></a>',
			'<a href="#next" class="icon-angle-right" rel="nofollow"><span>Next</span></a>'
		],
		responsiveClass: true,
		responsive : {
			0 : {
				items: 1
			},
			480 : {
				items: 2
			},
			760 : {
				items: 4
			},
			980 : {
				items: 5
			}
		}
	});

	/*
	 * *************************
	 * YOUTUBE VIDEO PLAYER
	 *   Requires: lib/js/jquery.simplemodal.js
	 * *************************
	*/

	if ($ytplayers.length || $("section a[data-behavior='modalize']").length) {
		// ADD YOUTUBE PLAYER TO SOCSH OBJECT
		window.SOCSH.YTPLAYER = {
			youtubeplayers: [],
			init: function () {
				// LOOP THROUGH ALL VIDEO PLAYERS
				$ytplayers.each(function (i) {
					var $ytplayer = $(this);
					var $vid = $ytplayer.parent().parent();
					var videoId = $vid.find('.videos-module-poster a').attr('href').split('?v=')[1];
					var id ='ytplayer-' + i;
					var ytplayer;

					// REPLACE CONTAINER WITH YOUTUBE CONTAINER (W/ ID)
					$ytplayer.replaceWith('<div id="' + id + '"></div>');

					// SET INDEX, USED FOR CONTROLLING APPROPRIATE PLAYER WIHTIN SOCSH.YTPLAYER.youtubeplayers OBJECT
					$vid.data('idx',i);

					ytplayer = new YT.Player(
						id, {
							videoId: videoId,
							width: '100%',
							height: '100%',
							playerVars: { autoplay: 0, rel: 0, showinfo: 0, wmode: "opaque" }
						}
					);
					ytplayer.addEventListener('onStateChange', function (e) {
						if (e.data == 1) {
							if ($vid.data('status') != 'started') {
								// GA - TRACK EVENT
								_gaq.push(['_trackEvent', 'Video', 'Play', 'https://www.youtube.com/watch?v=' + videoId]);

								$vid.data({ status: 'started' })
							}
						} else if (e.data == 0) {
							// GA - TRACK EVENT
							_gaq.push(['_trackEvent', 'Video', 'End', 'https://www.youtube.com/watch?v=' + videoId]);

							$vid.data({ status: 'ended' })
							$vid.find('.videos-module-mask').css('top','100%');
							$vid.find('.videos-module-poster').show();
						}
					});
					// ADD YOUTUBE PLAYER TO YTPLAYER OBJECT
					window.SOCSH.YTPLAYER.youtubeplayers.push(ytplayer);
				});
			}
		};

		// ADD YOUTUBE MODAL PLAYER TO SOCSH OBJECT
		$(document).on("click", "section a[data-behavior='modalize']", function (e) {
			if ($('#navicon').css('display') == 'none') {
				var $a = $(this),
						target = $a.attr('href').split('?v=')[1]
						title = $a.data("title"),
						$loader = $('#simplemodal-loader'),
						$modalwrapper = $('<div id="simplemodal-wrapper"/>'),
						$modal = $('<div class="modalcontent"/>');
						$ytplayer = $('<div id="ytplayer"/>');

				if(title.length) {
					$modal.append('<h3>' + title + '</h3>');
				}
				if(target.length) {
					$modal.append($ytplayer);
				} else {
					$modal.append('<p>Sorry, the video can not be viewed at this time</p>');
				}
				if (!$loader.length) {
					$('body').append($modalwrapper);
					$modalwrapper.append('<div id="simplemodal-loader"/>');
					$loader = $('#simplemodal-loader');
					$loader.hide();
				}
				$loader.fadeIn();

				$modal.modal({
					autoResize: true,
					autoPosition: true,
					minWidth: '680',
					opacity: 90,
					overlayClose: true,
					appendTo: $modalwrapper,
					onOpen: function (dialog) {
						dialog.overlay.fadeIn(400, function () {
							$loader.fadeOut(325);
							dialog.data.show();
							dialog.container.fadeIn(400, function() {
								SOCSH.YTMODALPLAYER.init(target, title);
							});
						});
					},
					onClose: function (dialog) {
						dialog.data.fadeOut(200, function () {
							dialog.container.fadeOut(200, function () {
								dialog.overlay.fadeOut(200, function () {
									$.modal.close();
									$modalwrapper.remove();
								});
							});
						});
					}
				});
				e.preventDefault();
			}
		});

		window.SOCSH.YTMODALPLAYER = {
			init: function(target, title) {
				var $vid = $('#ytplayer');
				var ytplayer = new YT.Player('ytplayer', {
					videoId: target,
					width: '853',
					height: '480',
					playerVars: { 'showinfo': 0, 'autoplay': true, 'rel': 0, 'enablejsapi': 1 }
				});
				ytplayer.addEventListener('onStateChange', function (e) {
					if (e.data == 1) {
						if ($vid.data('status') != 'started') {
							// GA - TRACK EVENT
							_gaq.push(['_trackEvent', 'Video', 'Play', 'https://www.youtube.com/watch?v=' + target]);
							$vid.data({ status: 'started' })
						}
					} else if (e.data == 0) {
						// GA - TRACK EVENT
						_gaq.push(['_trackEvent', 'Video', 'End', 'https://www.youtube.com/watch?v=' + target]);
						$vid.data({ status: 'ended' })

						// CLOSE MODAL
						$('.modalCloseImg').trigger('click');
					}
				});
			}
		};

		// LOAD GOOGLE YOUTUBE API
		$(window).load(function () {
			var script = document.createElement('script');
				script.src = 'https://www.youtube.com/iframe_api';
			document.body.appendChild(script);
		});

		// LOAD VIDEO PLAYERS WHEN YOUTUBE IS READY
		window.onYouTubePlayerAPIReady = function () {
			SOCSH.YTPLAYER.init();
		}

		// VIDEO POSTER CLICK
		$('.videos-module-poster > a').click(function (e) {
			if ($('.videos-module-mask').css('display') != 'none') {
				var idx = $(this).parent().parent().data('idx');
				if (typeof SOCSH.YTPLAYER.youtubeplayers == 'object') {
					if (typeof SOCSH.YTPLAYER.youtubeplayers[idx].loadVideoById == 'function') {
						// PAUSE ALL PLAYERS
						$.each(SOCSH.YTPLAYER.youtubeplayers, function (idx, ele) {
							if (typeof $(this)[0].pauseVideo == 'function') {
								$(this)[0].pauseVideo();
							}
						});

						// LOAD NEW VIDEO INTO THIS PLAYER
						SOCSH.YTPLAYER.youtubeplayers[idx].loadVideoById($(this).attr('href').split('?v=')[1]);
						$(this).parent().parent().find('.videos-module-mask').css('top',0);
						$(this).parent().fadeOut(300);
					}
				}
				e.preventDefault();
			}
		});
	}

	/*
	 * *************************
	 * FIND YOUR REGION
	 * *************************
	*/

	window.loadmaps = function() {
		var script;

		if (typeof google === 'object' && typeof google.maps === 'object') {
			setupmaps('#nav');
		} else {
			script = document.createElement('script');
			script.src = '//maps.googleapis.com/maps/api/js?key=' + $('body').attr('data-key') + '&v=3&callback=setupmaps';
			document.body.appendChild(script);
		}
	}

	window.setupmaps = function(scope) {
		var $parent = (scope === undefined) ? $('body') : $(scope);
		var mapOptions = {
			zoom: 11,
			styles: [{
				"featureType": "water",
				"stylers": [{
					"color": "#19a0d8"
				}]
			}, {
				"featureType": "administrative",
				"elementType": "labels.text.stroke",
				"stylers": [{
					"color": "#ffffff"
				}, {
					"weight": 6
				}]
			}, {
				"featureType": "administrative",
				"elementType": "labels.text.fill",
				"stylers": [{
					"color": "#f79022"
				}]
			}, {
				"featureType": "road.highway",
				"elementType": "geometry.stroke",
				"stylers": [{
					"color": "#ffdeba"
				}, {
					"lightness": -40
				}]
			}, {
				"featureType": "road.arterial",
				"elementType": "geometry.stroke",
				"stylers": [{
					"color": "#ffdeba"
				}, {
					"lightness": -20
				}]
			}, {
				"featureType": "road",
				"elementType": "labels.text.stroke",
				"stylers": [{
					"lightness": 100
				}]
			}, {
				"featureType": "road",
				"elementType": "labels.text.fill",
				"stylers": [{
					"lightness": -100
				}]
			}, {
				"featureType": "road.highway",
				"elementType": "labels.icon"
			}, {
				"featureType": "landscape",
				"elementType": "labels",
				"stylers": [{
					"visibility": "off"
				}]
			}, {
				"featureType": "landscape",
				"stylers": [{
					"lightness": 20
				}, {
					"color": "#fff2e4"
				}]
			}, {
				"featureType": "landscape.man_made",
				"stylers": [{
					"visibility": "off"
				}]
			}, {
				"featureType": "water",
				"elementType": "labels.text.stroke",
				"stylers": [{
					"lightness": 100
				}]
			}, {
				"featureType": "water",
				"elementType": "labels.text.fill",
				"stylers": [{
					"lightness": -100
				}]
			}, {
				"featureType": "poi",
				"elementType": "labels.text.fill",
				"stylers": [{
					"hue": "#11ff00"
				}]
			}, {
				"featureType": "poi",
				"elementType": "labels.text.stroke",
				"stylers": [{
					"lightness": 100
				}]
			}, {
				"featureType": "poi",
				"elementType": "labels.icon",
				"stylers": [{
					"hue": "#4cff00"
				}, {
					"saturation": 58
				}]
			}, {
				"featureType": "poi",
				"elementType": "geometry",
				"stylers": [{
					"visibility": "on"
				}, {
					"color": "#f0e4d3"
				}]
			}, {
				"featureType": "road.highway",
				"elementType": "geometry.fill",
				"stylers": [{
					"color": "#ffdeba"
				}, {
					"lightness": -25
				}]
			}, {
				"featureType": "road.arterial",
				"elementType": "geometry.fill",
				"stylers": [{
					"color": "#ffdeba"
				}, {
					"lightness": -10
				}]
			}, {
				"featureType": "poi",
				"elementType": "labels",
				"stylers": [{
					"visibility": "simplified"
				}]
			}]
		};

		if ($parent.find('.geolocation-wrapper').length) {
			$parent.find('.geolocation-wrapper').each(function(i) {
				var map;
				var geocoder;
				var $mapWrapper = $(this);
				var $map = $(this).find('.geolocation-canvas');
				var id ='geolocation-canvas-' + i;
				var arrRegions;
				var showRegionRects = false; // used for debugging, turn on to see region rectangles
				var regionRects = []; // holds previously drawn region rectangles, so they can be cleared when map is redrawn
				var radiusMilesInner = 25; // search radius, used to find all regions within preferred miles of lat/lng
				var radiusMilesOuter = 50; // search radius, used to find closest region if none fit inside inner radius
				var content = '';

				// REPLACE STATIC IMAGE WITH INTERACTIVE MAP
				$map.replaceWith('<div id="' + id + '" class="geolocation-canvas"></div>');

				map = new google.maps.Map(document.getElementById(id), mapOptions);

				geocoder = new google.maps.Geocoder();

				// LOAD ALL REGIONS, USED TO MATCH CLOEST REGION
				$.ajax({
					dataType: 'text',
					url: '/wp-content/themes/soccershots/lib/services/regions.php'
				}).fail(function (data) {
					// FAIL
				}).done(function (data) {
					arrRegions = $.parseJSON(data);
					geolocate();
				});

				// TRY GEOLOCATION
				function geolocate() {
					// Try HTML5 geolocation
					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(function(position) {
							findClosest(arrRegions, {
								lat: position.coords.latitude,
								lng: position.coords.longitude
							});
						}, function() {
							handleNoGeolocation(true);
						});
					} else {
						// Browser doesn't support Geolocation
						handleNoGeolocation(false);
					}
				}

				// HANDLE GEOLOCATION ERRORS
				function handleNoGeolocation(errorFlag) {
					if (errorFlag) {
						content += '<div class="region multiple-regions region-error">';
						content += '<p class="multiple-regions-title">The Geolocation service failed. Please search by Postal Code.</p>';
						content += '</div>';
					} else {
						content += '<div class="region multiple-regions region-error">';
						content += '<p class="multiple-regions-title">our browser doesn\'t support Geolocation. Please search by Postal Code.</p>';
						content += '</div>';
					}

					showFullMap();
					showMapBanner(content);
				}

				// FIND CLOSEST MATCH FROM ENTERED COORDINATES (VIA GEOLOCATION OR GEOCODE)
				function findClosest(arrRegions, latlng) {
					var i = 0;
					var distanceMiles = 0;
					var distanceMeters = 0;
					var closest = [];
					var nextClosest;

					while (i < arrRegions.length) {
						distanceMeters = latlngDistance(latlng, arrRegions[i].geo.bounds.center);
						distanceMiles = 0.000621371 * distanceMeters;
						// region must be either inside the INNER radius or the closest region inside the OUTER radius
						if (distanceMiles <= radiusMilesInner) {
							closest.push(i);
						} else if (distanceMiles <= radiusMilesOuter && (!nextClosest || distanceMiles < nextClosest.distanceMiles)) {
							nextClosest = {
								distanceMiles: distanceMiles,
								i: i
							};
						}
						i++;
					}

					if (!closest.length && nextClosest) {
						closest.push(nextClosest.i);
					}

					updateMap(closest);
				}


				function showFullMap() {
					map.fitBounds(new google.maps.LatLngBounds(
						new google.maps.LatLng(28.495218, -125.703630),
						new google.maps.LatLng(48.427356, -67.256369)
					));
				}

				// UPDATE MAP WITH NEW LAT/LONG, POPULATE TITLE/BUTTON
				function updateMap(closest) {
					var bounds = new google.maps.LatLngBounds();
					var html = '';
					var region;
					var sw;
					var ne;

					if (showRegionRects) {
						for (var i = 0, ii = regionRects.length; i < ii; ++i) {
							regionRects[i].setMap(null);
						}
						regionRects = [];
					}

					if (!closest.length) {
						html += '<div class="region multiple-regions region-error">';
						html += '<p class="multiple-regions-title">No Nearby Regions.<br>Please try a different postal code below.</p>';
						html += '</div>';
						showFullMap();
					} else {
						if (closest.length > 1) {
							html += '<div class="region multiple-regions">';
							html += '<p class="multiple-regions-title">Multiple regions found. Please select your region below.</p>';
							html += '<ul class="clist cf multiple-regions-list">';
						} else {
							html += '<div class="region one-region">';
						}

						for (var i = 0, ii = closest.length; i < ii; ++i) {
							region = arrRegions[closest[i]];
							sw = new google.maps.LatLng(region.geo.bounds.sw.lat, region.geo.bounds.sw.lng);
							ne = new google.maps.LatLng(region.geo.bounds.ne.lat, region.geo.bounds.ne.lng);

							// debugging, show region rectangles
							if (showRegionRects) {
								regionRects.push(new google.maps.Rectangle({
									fillColor: '#F79022',
									fillOpacity: 0.35,
									map: map,
									bounds: {
										north: ne.lat(),
										south: sw.lat(),
										east: ne.lng(),
										west: sw.lng()
									}
								}));
							}

							bounds.extend(ne);
							bounds.extend(sw);

							if (closest.length > 1) {
								html += '<li>';
								html += '<a href="' + region['url'] + '">';
								html += '<span class="banner-title"><span>' + region['name'] + '</span></span>';
								html += '<span class="banner-cta">Click Here to View This Region</span>';
								html += '</a>';
								html += '</li>';
							} else {
								html += '<a href="' + region['url'] + '">';
								html += '<span class="banner-title">Your Region:</span>';
								html += '<span class="banner-title"><span>' + region['name'] + '</span></span>';
								html += '<span class="banner-cta">Click Here to View This Region</span>';
								html += '</a>';
							}
						}
						if (closest.length > 1) {
							html += '</ul>';
						}
						html += '</div>';

						map.fitBounds(bounds);
					}

					showMapBanner(html);
				}

				function showMapBanner(content) {
					$mapWrapper.find('.geolocation-loader-wrapper').fadeOut(600);
					$('#'+id).animate( { top: 0 }, 600);
					$mapWrapper.find('.geolocation-banner').html(content);
					$mapWrapper.find('.geolocation-banner > .region').delay(600).slideDown(600);
				}

				// GET DISTANCE BETWEEN TWO COORDINATES
				//based off of Leaflet method here: https://github.com/Leaflet/Leaflet/blob/45034155bdf8d958554b43ed8dbd7020df9ca6ab/src/geo/crs/CRS.Earth.js
				function latlngDistance(latlng1, latlng2) {
					var earthrad = 6378137;
					var rad = Math.PI / 180;
					var lat1 = latlng1.lat * rad;
					var lat2 = latlng2.lat * rad;
					var a = Math.sin(lat1) * Math.sin(lat2) + Math.cos(lat1) * Math.cos(lat2) * Math.cos((latlng2.lng - latlng1.lng) * rad);

					return earthrad * Math.acos(Math.min(a, 1));
				}

				// GEOCODE ADDRESS
				$('#postal-code-search').submit(function (e) {
					var val = $(this).find('input#postal_code').val();
					var $parent = $(this).parent().parent();

					if (val && val != '' && $('#postal-code-search').data('prev-search') != val) {
						$('#postal-code-search').data('prev-search',val);
						if (geocoder) {
							$parent.find('.region-error').remove();
							$parent.find('.geolocation-loader-wrapper').show();
							$parent.find('.geolocation-canvas').css('top','100%');
							$parent.find('.geolocation-title').html('');
							$parent.find('.geolocation-loader-txt').html('Determining your region via postal code, please wait...');

							geocoder.geocode( { 'address': val }, function(results, status) {
								if (status == google.maps.GeocoderStatus.OK) {
									findClosest(arrRegions, {
										lat: results[0].geometry.location.lat(),
										lng: results[0].geometry.location.lng()
									});

									// SCROLL TO MAP RESULT
									$('html,body').stop().animate( { scrollTop: $('.geolocation-wrapper').offset().top-175 }, 800, 'easeOutExpo');
								} else {
									alert('Geocode was not successful for the following reason: ' + status);
								}
							});
						}
					}
					e.preventDefault();
				});
			});
		}

		if ($parent.find('.locations-wrapper').length) {
			$parent.find('.locations-wrapper').each(function(i) {
				var map;
				var bounds = new google.maps.LatLngBounds();
				var $mapWrapper = $(this);
				var $map = $(this).find('.locations-canvas');
				var id ='locations-canvas-' + i;
				var infoWindow = new google.maps.InfoWindow();
				var marker;

				// REPLACE STATIC IMAGE WITH INTERACTIVE MAP
				$map.replaceWith('<div id="' + id + '" class="locations-canvas"></div>');

				map = new google.maps.Map(document.getElementById(id), mapOptions);

				// Multiple Markers
				var markers = [];

				// Info Window Content
				var infoWindowContent = [];

				$('.location').each(function(i, el) {
					markers.push(
						[
							$(this).find('.name').text(),
							Number($(this).find('a').attr('data-lat')),
							Number($(this).find('a').attr('data-lng'))
						]
					);
					infoWindowContent.push(
						[
							'<div class="info_content">' +
							'<h4>' + $(this).find('.name').text() + '</h4>' +
							'<p>' + $(this).find('.address').html() + '</p>' +
							'<p class="cta cta-dark"><a href="' + $(this).find('a').attr('href') + '" target="_blank">Enroll</a></p>' +
							'</div>'
						]
					);
				});

				// Loop through our array of markers & place each one on the map
				for (var i = 0; i < markers.length; i++) {
					var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
					bounds.extend(position);
					marker = new google.maps.Marker({
						position: position,
						map: map,
						title: markers[i][0],
						icon: '/wp-content/themes/soccershots/lib/img/map-icon.png'
					});

					// Allow each marker to have an info window
					google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
							infoWindow.setContent(infoWindowContent[i][0]);
							infoWindow.open(map, marker);
						}
					})(marker, i));
				}

				// Automatically center the map fitting all markers on the screen
				map.fitBounds(bounds);

				$mapWrapper.find('.locations-loader-wrapper').fadeOut(600);
				$('#'+id).animate( { top: 0 }, 600);
			});
		}
	}

	// LOAD GOOGLE MAPS API
	if ($('.geolocation-wrapper').length || $('.locations-wrapper').length) {
		loadmaps();
	}

	$('#location-select').change(function (e) {
		if ($(this).val() == '') {
			$('.location-list-wrapper div').css('display','block');
		} else {
			$('.location-list-wrapper div').css('display','none');
			$('.location-list-wrapper div.' + $(this).val()).css('display','block');
		}
	});
	if ($('#location-select').val() != '') {
		$('#location-select').trigger('change');
	}

	/*
	 * *************************
	 * FRANCHISE ALERT (SHOW/HIDE)
	 * *************************
	*/

	if ($('#alert').length) {
		var showAlertTimeout = null

		$('#alert .icon-close').click(function () {
			// SET SESSION COOKIE (DISMISS ALERT)
			setCookie('alert-' + $('body').attr('data-region'),'dismiss');

			$('#alert').slideUp(600, function() {
				$(this).remove();
			});
		});
	}

	/*
	 * *************************
	 * MODULE - EXPAND/COLLAPSE
	 * *************************
	*/

	$('.module-expand-collapse .ec-title a').click(function (e) {
		if (!$(this).hasClass('animating')) {
			var $t = $(this).toggleClass('open');
			var val = 'Expand';

			if ($t.hasClass('open')) {
				$t.attr('title','Hide Details').children('.icon-caret-down').addClass('icon-caret-up').removeClass('icon-caret-down');
			} else {
				$t.attr('title','Show Details').children('.icon-caret-up').addClass('icon-caret-down').removeClass('icon-caret-up');
				val = 'Collapse';
			}

			// GA - TRACK EVENT
			_gaq.push(['_trackEvent', 'Expand/Collapse Module', val, $(this).children('.txt').text()]);

			$(this).addClass('animating');
			$(this).parent().next().slideToggle(400, 'easeOutExpo', function () {
				$t.toggleClass('animating');
			});
		}
		e.preventDefault();
	});

	/*
	 * *************************
	 * SCROLL TO SPECIFIC LOCATION ON PAGE
	 * USING ANCHOR SUCH AS #mini BUT THERE IS NO DOM OBJECT W/ AN ID OF "mini", THIS WAY WE CAN USE THE ANIMATION EFFECT
	 * #mini CONVERTS TO .scrollto-mini
	 * *************************
	*/

	function goToByScroll(id) {
		var classTimeout = null;

		$module = $(id).addClass("highlighted");

		clearTimeout(classTimeout);
		classTimeout = setTimeout(function() {
			$('.module').removeClass("highlighted");
		},1500);

		$('html,body').stop().animate( { scrollTop: $(id).offset().top-25 }, 800, 'easeOutExpo');
	}
	function jumpToAnchor(href) {
		$('.module').addClass('winload');

		var hash = window.location.hash.replace('#','');
		if (href != undefined) {
			hash = href;
		}
		if (hash != '') {
			// IF MOBILE SUB NAV MENU IS OPENED, CLOSE IT
			if ($('#sub-nav-menu').hasClass('open')) {
				$('#sub-nav-menu').trigger('click');
			}

			$('.module').removeClass("highlighted");
			if ($('.scrollto-' + hash).length) {
				goToByScroll('.scrollto-' + hash);
			}
		}
	}
	jumpToAnchor();

	// ANCHOR LINKS (IF ANCHOR IS ON PAGE, THEN PREVENT DEFAULT ACTION OF LINK AND SCROLL TO LOCATION
	$('#sub-nav').find('a').click(function (e) {
		var hash = $(this).attr('href').split('#')[1];

		if ($('.scrollto-' + hash).length) {
			window.location.hash = hash;
			jumpToAnchor(hash);
			e.preventDefault();
		}
	});

	/*
	 * *************************
	 * LOCATION FILTER - FILTER RESULTS BY VALUE OF SEARCH INPUT FIELD
	 * REQUIRES: lib/js/list.min.js
	 * *************************
	*/

	window.listResults = function() {
		if ($('#location-wrapper').length) {

			// RESET SEARCH VALUE
			$('#location_name').val('');

			$('<span id="location-results"><span>' + $('ul.list > li').length + '</span> location(s)</span>').insertAfter('#location_name');
			$results = $('#location-results span');

			var listOptions = {
				valueNames: [ 'name' ]
			};
			var userList = new List('location-wrapper', listOptions);

			/* UPDATE RESULT TOTAL */
			userList.on('updated', function() {
				$results.text($('ul.list > li').length);
			});
		}
	}();

	/*
	 * *************************
	 * BIND GOOGLE TRACKING (EXTERNAL LINKS, MAILTO LINKS AND FILE DOWNLOADS USING CUSTOM NAMESPACE)
	 * *************************
	*/

	window.loadGoogleTrackingEvents = function(el) {
		var filetypes = /\.(pdf|doc*|xls*|ppt*)$/i;

		$(el).each(function() {
			var $href = $(this).prop('href');
			var pageTracker = null;
			var linkerUrl = null;

			if ($href && ( $href.match(/^https?\:/i) ) && (!$href.match(document.domain))) {
				// GOOGLE TRACK EXTERNAL LINK
				$(this).unbind('click.socsh_ga').bind('click.socsh_ga', function (e) {

					// GA - TRACK EVENT
					_gaq.push(['_trackEvent', 'External', 'Click', $href.replace(/^https?\:\/\//i, '')]);

					// CROSS-DOMAIN TRACKING WITH SSREG.ORG
					if ($href.indexOf("ssreg.org") > -1) {
						pageTracker = _gat._getTrackerByName();
						linkerUrl = pageTracker._getLinkerUrl($href);

						if ($(this).attr('target') == '_blank') {
							_gaq.push(function() {
								window.open(linkerUrl);
							});
						} else {
							_gaq.push(function() {
								setTimeout('document.location = "' + linkerUrl + '"', 100);
							});
						}
						e.preventDefault();
					} else {
						if ($(this).attr('target') !== '_blank') {
							setTimeout('document.location = "' + $href + '"', 100);
							e.preventDefault();
						}
					}
				});
			} else if ($href && $href.match(/^mailto\:/i)) {
				// GOOGLE TRACK MAILTO LINK
				$(this).unbind('click.socsh_ga').bind('click.socsh_ga', function () {
					var mailLink = $href.replace(/^mailto\:/i, '');

					// GA - TRACK EVENT
					_gaq.push(['_trackEvent', 'Email', 'Click', mailLink]);
				});
			} else if ($href && $href.match(filetypes)) {
				// GOOGLE TRACK DOWNLOAD
				$(this).unbind('click.socsh_ga').bind('click.socsh_ga', function (e) {
					var extension = (/[.]/.exec($href)) ? (/[^.]+$/.exec($href)) : undefined;
					var filePath = $href;

					// GA - TRACK EVENT
					_gaq.push(['_trackEvent', 'Download', 'Click-' + extension.toString().toUpperCase(), filePath]);

					if ($(this).attr('target') == '_blank') {
						setTimeout("window.open('" + $href + "')", 100);
					} else {
						setTimeout('document.location = "' + $href + '"', 100);
					}
					e.preventDefault();
				});
			}
		});
	}

	// BIND TRACKING IF 'ga-exclude' CLASS IS NOT PRESENT
	loadGoogleTrackingEvents('section a:not(.ga-exclude), #header a:not(.ga-exclude), #footer a:not(.ga-exclude)');
});
