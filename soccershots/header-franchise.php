<?php
/**
 * @package SOCCERSHOTS
 */

$topMostFranchisePageId   = get_post_top_ancestor_id();
$topMostFranchisePageSlug = get_post($topMostFranchisePageId)->post_name;
$settingsID               = get_franchise_settings_id($topMostFranchisePageSlug);
$franchise_root_path      = get_permalink(get_post_top_ancestor_id());
$location1                = get_field('location1', get_post_top_ancestor_id());
$location2                = get_field('location2', get_post_top_ancestor_id());
$show_alert               = get_field('show_alert', $settingsID);
$alert_title              = get_field('alert_title', $settingsID);
$alert_copy               = get_field('alert_copy', $settingsID);
$alert_end_date           = strtotime(get_field('alert_end_date', $settingsID));
$dismiss_alert            = isset($_COOKIE['alert-' . get_post_top_ancestor_slug()]) ? $_COOKIE['alert-' . get_post_top_ancestor_slug()] : '';
$pagename                 = get_query_var('pagename');

function is_current_page($page, $pagename) {
	$class = '';
	if ($page != '' && $pagename != '' && $page == $pagename) {
		$class = ' class="active"';
	}
	return $class;
}
?>
<?php if ($show_alert && time() < $alert_end_date && $dismiss_alert != 'dismiss'): ?>
<div id="alert">
	<div class="container">
		<div class="alert-content">
			<span class="icon icon-exclamation-circle"></span>
			<strong class="title"><?php echo $alert_title; ?></strong>
			<div class="alert-copy">
				<?php echo $alert_copy; ?>
			</div>
			<span class="icon icon-close"></span>
		</div>
	</div>
</div>
<?php endif; ?>
<header id="header">
	<div class="container">
		<div id="logo-wrapper" class="cf">
			<p id="logo"><a href="<?php echo $franchise_root_path; ?>"><img src="<?php echo get_template_directory_uri(); ?>/lib/img/logos/soccer-shots.png" width="162" height="97" alt="Soccer Shots - The Children's Soccer Experience"></a></p>
			<div id="franchise">
				<p>
					<span><?php echo $location1; ?></span>
					<?php
					if ($location2 != '') {
						echo $location2;
					}
					?>
				</p>
			</div>
		</div>

		<?php
			$args = array(
				'parent'      => get_post_top_ancestor_id(),
				'post_status' => 'publish'
			);
			$pages = get_pages($args);

			/* build array of post names */
			$arrPostNames = array();
			foreach ($pages as &$page) {
				array_push($arrPostNames, $page->post_name);
			}
		?>
		<nav id="nav">
			<a href="#main-menu" id="navicon" rel="nofollow">
				<span class="brd"></span>
				<span class="txt">Menu</span>
			</a>
			<a href="<?php echo $franchise_root_path; ?>enroll/" id="enroll">
				<span class="line1">Enroll</span> at a Site
				<span class="icon icon-location2"></span>
			</a>
			<div id="nav-wrapper">
				<ul class="clist cf" id="main-nav">
					<?php if (in_array('programs', $arrPostNames)): ?>
					<li>
						<a href="<?php echo $franchise_root_path; ?>programs/"<?php echo is_current_page("programs", $pagename); ?>>
							Programs
						</a>
					</li>
					<?php endif; ?>
					<?php if (in_array('meet-the-coaches', $arrPostNames)): ?>
					<li>
						<a href="<?php echo $franchise_root_path; ?>meet-the-coaches/"<?php echo is_current_page("meet-the-coaches", $pagename); ?>>
							Meet the Coaches
						</a>
					</li>
					<?php endif; ?>
					<?php if (in_array('stories', $arrPostNames)): ?>
					<li>
						<a href="<?php echo $franchise_root_path; ?>stories/"<?php echo is_current_page("stories", $pagename); ?>>
							Stories
						</a>
					</li>
					<?php endif; ?>
					<?php if (in_array('resources', $arrPostNames)): ?>
					<li>
						<a href="<?php echo $franchise_root_path; ?>resources/"<?php echo is_current_page("resources", $pagename); ?>>
							Parent Resources
						</a>
					</li>
					<?php endif; ?>
					<?php if (in_array('about', $arrPostNames)): ?>
					<li>
						<a href="<?php echo $franchise_root_path; ?>about/"<?php echo is_current_page("about", $pagename); ?>>
							About Us
						</a>
					</li>
					<?php endif; ?>
					<?php if (in_array('enroll', $arrPostNames)): ?>
					<li>
						<a href="https://<?php echo $topMostFranchisePageSlug; ?>.ssreg.org" class="enroll" target="_blank">
							Enroll at a Site
							<span class="icon icon-external-link"></span>
						</a>
					</li>
					<?php endif; ?>
				</ul>
				<ul class="clist cf" id="secondary-nav">
					<?php if (in_array('faqs', $arrPostNames)): ?>
					<li>
						<a href="<?php echo $franchise_root_path; ?>faqs/"<?php echo is_current_page("faqs", $pagename); ?>>
							<span class="icon icon-question-circle"></span>
							<span class="txt">FAQs</span>
						</a>
					</li>
					<?php endif; ?>
					<?php if (in_array('contact', $arrPostNames)): ?>
					<li>
						<a href="<?php echo $franchise_root_path; ?>contact/"<?php echo is_current_page("contact", $pagename); ?>>
							<span class="icon icon-whistle"></span>
							<span class="txt">Contact Us</span>
						</a>
					</li>
					<?php endif; ?>
				</ul>
				<ul class="clist cf" id="social-nav">
					<?php if (have_rows('social_channel', $settingsID)): ?>
					<?php while( have_rows('social_channel', $settingsID) ): the_row(); ?>
						<?php
						$icon     = get_sub_field( "icon");
						$iconText = get_sub_field_object( "icon");
						$link     = get_sub_field( "link");

						foreach( $iconText['choices'] as $k => $v ) {
							if( $k == $icon ) {
								$iconText = $v;
								break;
							}
						}
						?>
						<li>
							<a href="<?php echo $link; ?>" target="_blank">
								<span class="icon <?php echo $icon; ?>"></span>
								<span class="txt"><?php echo $v; ?></span>
							</a>
						</li>
					<?php endwhile; ?>
					<?php endif; ?>
				</ul>
			</div>
		</nav>
	</div>
</header>
