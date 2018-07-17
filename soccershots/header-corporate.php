<?php
/**
 * @package SOCCERSHOTS
 */
?>
<header id="header">
	<div class="container">
		<p id="logo"><a href="/"><img src="<?php echo get_template_directory_uri(); ?>/lib/img/logos/soccer-shots.png" width="162" height="97" alt="Soccer Shots - The Children's Soccer Experience"></a></p>

		<nav id="nav">
			<a href="#main-menu" id="navicon" rel="nofollow">
				<span class="brd"></span>
				<span class="txt">Menu</span>
			</a>
			<div id="nav-wrapper">
				<?php soccershots_custom_menu('corporate-main-menu', 'corporate-main-menu', 'main-nav', 'clist cf'); ?>
				<?php soccershots_custom_menu('corporate-secondary-menu', 'corporate-secondary-menu', 'secondary-nav', 'clist cf'); ?>
			</div>
		</nav>
	</div>
</header>
