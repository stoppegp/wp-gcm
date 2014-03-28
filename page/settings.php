<?php
/*
* The content of the settings page
*/

function px_display_page_setting() {
?>
  <div class="wrap">
        <?php screen_icon(); ?>
	<h2 class="">Google Cloud Messaging</h2>
	
	<div id="poststuff">
	
    	<?php if( isset($_GET['settings-updated']) ) { ?>
        <div id="message" class="updated">
            <p><strong><?php _e('Settings saved','px_gcm') ?></strong></p>
        </div>
        <?php } ?>
	
		<div id="post-body" class="metabox-holder columns-1"> 
	
			<div id="post-body-content">
					<div class="postbox">
					  <h3><?php _e('GCM Settings','px_gcm'); ?></h3>
						<div class="inside">
							<div id="settings">
							 <form method="post" action="options.php">
					           <?php settings_fields('px-gcm-settings-group'); ?>
					           <?php do_settings_sections('px-gcm'); ?>
	                              <?php submit_button(); ?>
	                           </form>
	                        </div>
						</div> 
					</div>
			</div>
		</div> 
		<br class="clear">
	</div>
</div>
<?php
}

?>