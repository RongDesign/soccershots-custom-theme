<?php
/**
 * @package SOCCERSHOTS
 */
?>
<?php
$ga_id     = get_option('soccershots_google_analytics_account_id');
$tk_id     = get_option('soccershots_typekit_account_id');
$gamaps_id = get_option('soccershots_google_maps_key');
$html_atts = '';
$body_atts = '';

if (is_page_template('page-templates/franchise-home.php') || is_page_template('page-templates/franchise-interior.php') || is_page_template('page-templates/franchise-interior-stories.php') || is_page_template('page-templates/franchise-interior-parent-resources.php')) {
	$body_atts = ' id="body-franchise" data-region="' . get_post_top_ancestor_slug() . '"';
} else if (is_404()) {
	$html_atts = ' id="not-found"';
}
$body_atts .= ' data-key="' . $gamaps_id . '"';
?>
<!doctype html>
<html<?php echo $html_atts; ?>>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php if (!is_404()): ?>
	<title><?php wp_title(); ?></title>
	<?php else: ?>
	<title><?php echo "Page Not Found"; ?></title>
	<?php endif; ?>

	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
	<link rel="apple-touch-icon" href="/apple-touch-icon-57x57.png" sizes="57x57">
	<link rel="apple-touch-icon" href="/apple-touch-icon-60x60.png" sizes="60x60">
	<link rel="apple-touch-icon" href="/apple-touch-icon-72x72.png" sizes="72x72">
	<link rel="apple-touch-icon" href="/apple-touch-icon-76x76.png" sizes="76x76">
	<link rel="apple-touch-icon" href="/apple-touch-icon-114x114.png" sizes="114x114">
	<link rel="apple-touch-icon" href="/apple-touch-icon-120x120.png" sizes="120x120">
	<link rel="apple-touch-icon" href="/apple-touch-icon-144x144.png" sizes="144x144">
	<link rel="apple-touch-icon" href="/apple-touch-icon-152x152.png" sizes="152x152">
	<link rel="apple-touch-icon" href="/apple-touch-icon-180x180.png" sizes="180x180">

	<meta name="msapplication-TileImage" content="/mstile-144x144.png">
	<meta name="msapplication-TileColor" content="#2d89ef">
	<meta name="theme-color" content="#ffffff">

	<?php wp_head(); ?>

	<?php if (!empty($ga_id)): ?>
	<script>
		var _gaq = _gaq || [];
			_gaq.push(['_setAccount', '<?php echo $ga_id; ?>']);
			_gaq.push(['_setDomainName', '<?php echo str_replace("www.", "", $_SERVER["HTTP_HOST"]); ?>']);
			_gaq.push(['_setAllowLinker', true]);
			_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
	<?php endif; ?>

	<?php if (!empty($tk_id)): ?>
	<script>
		(function(d) {
			var config = {
				kitId: '<?php echo $tk_id; ?>',
				scriptTimeout: 3000
			},
			h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
		})(document);
	</script>
	<?php endif; ?>

	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/lib/js/html5shiv.min.js"></script>
	<![endif]-->
</head>

<body<?php echo $body_atts; ?>>
