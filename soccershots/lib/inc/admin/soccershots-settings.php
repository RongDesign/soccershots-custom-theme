<div class="wrap">
	<h2>Soccer Shots Website Settings</h2>
	<form method="post" action="options.php">
		<?php settings_fields('jpl-settings-group'); ?>
		<?php do_settings_sections('jpl-settings-group'); ?>

		<h3 style="padding-top: 30px;">Social Media Settings</h3>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="soccershots_facebook_url">Facebook URL</label></th>
					<td><input class="regular-text" type="text" id="soccershots_facebook_url" name="soccershots_facebook_url" value="<?php echo get_option('soccershots_facebook_url'); ?>"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="soccershots_twitter_url">Twitter URL</label></th>
					<td><input class="regular-text" type="text" id="soccershots_twitter_url" name="soccershots_twitter_url" value="<?php echo get_option('soccershots_twitter_url'); ?>"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="soccershots_linkedin_url">Linked In URL</label></th>
					<td><input class="regular-text" type="text" id="soccershots_linkedin_url" name="soccershots_linkedin_url" value="<?php echo get_option('soccershots_linkedin_url'); ?>"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="soccershots_youtube_url">YouTube URL</label></th>
					<td><input class="regular-text" type="text" id="soccershots_youtube_url" name="soccershots_youtube_url" value="<?php echo get_option('soccershots_youtube_url'); ?>"></td>
				</tr>
			</tbody>
		</table>

		<h3 style="padding-top: 30px;">Footer Settings</h3>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="soccershots_footer_email_address">Soccer Shots Copyright</label></th>
					<td><input class="regular-text" type="text" id="soccershots_footer_copyright" name="soccershots_footer_copyright" value="<?php echo get_option('soccershots_footer_copyright'); ?>"></td>
				</tr>
			</tbody>
		</table>

		<h3 style="padding-top: 30px;">Home Feature Areas</h3>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="soccershots_home_highlight1">Corporate Home Highlight 1</label></th>
					<td>
						<input class="regular-text" type="text" id="soccershots_home_highlight1" name="soccershots_home_highlight1" value="<?php echo get_option('soccershots_home_highlight1'); ?>">
						<p class="description">
							Specify the ID of the <a href="/wp-admin/edit.php?post_type=homehighlights">Home Highlight Post Type</a> that you'd like to appear in this location. (For example: 81)
						</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="soccershots_home_highlight2">Corporate Home Highlight 2</label></th>
					<td>
						<input class="regular-text" type="text" id="soccershots_home_highlight2" name="soccershots_home_highlight2" value="<?php echo get_option('soccershots_home_highlight2'); ?>">
						<p class="description">
							Specify the ID of the <a href="/wp-admin/edit.php?post_type=homehighlights">Home Highlight Post Type</a> that you'd like to appear in this location. (For example: 81)
						</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="soccershots_home_highlight3">Corporate Home Highlight 3</label></th>
					<td>
						<input class="regular-text" type="text" id="soccershots_home_highlight3" name="soccershots_home_highlight3" value="<?php echo get_option('soccershots_home_highlight3'); ?>">
						<p class="description">
							Specify the ID of the <a href="/wp-admin/edit.php?post_type=homehighlights">Home Highlight Post Type</a> that you'd like to appear in this location. (For example: 81)
						</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="soccershots_home_video">Franchise Home Video</label></th>
					<td>
						<input class="regular-text" type="text" id="soccershots_home_video" name="soccershots_home_video" value="<?php echo get_option('soccershots_home_video'); ?>">
						<p class="description">
							Specify the ID of the <a href="/wp-admin/post.php?post=176&action=edit">Home Videos Post Type</a> that you'd like to appear on ALL Franchise home pages. (For example: 176)
						</p>
					</td>
				</tr>
			</tbody>
		</table>

		<h3 style="padding-top: 30px;">Miscellaneous Settings</h3>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="soccershots_google_maps_key">Google Maps Key</label></th>
					<td>
						<input class="regular-text" type="text" id="soccershots_google_maps_key" name="soccershots_google_maps_key" value="<?php echo get_option('soccershots_google_maps_key'); ?>">
						<p class="description">
							Google Maps API Key -- <a href="https://code.google.com/apis/console/" target="_blank">https://code.google.com/apis/console/</a><br>
							(make sure both the "Google Maps API v3" and "Static Maps API" services are turned on)
						</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="soccershots_google_analytics_account_id">Google Analytics Account ID</label></th>
					<td>
						<input class="regular-text" type="text" id="soccershots_google_analytics_account_id" name="soccershots_google_analytics_account_id" value="<?php echo get_option('soccershots_google_analytics_account_id'); ?>">
						<p class="description">Google Analytics Account ID &ndash; <b>UA-XXXXXXXX-X</b>.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="soccershots_typekit_account_id">Typekit Account ID</label></th>
					<td><input class="regular-text" type="text" id="soccershots_typekit_account_id" name="soccershots_typekit_account_id" value="<?php echo get_option('soccershots_typekit_account_id'); ?>"></td>
				</tr>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
