<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<?php if (isset($_GET['cleared'])): ?>
	    <div class="updated">
	        <p><?php _e( 'Cache has been successfully deleted.', $this->plugin_slug ); ?></p>
	    </div>
	<?php endif ?>
	<p><?php _e('If you want to re-initalize plugin please use the button below to clear cache.', $this->plugin_slug) ?></p>
	<form action="" method="POST">
		<p class="curatedquotes-clear">
			<?php wp_nonce_field('clear', '_qqod'); ?>
			<input type="submit" class="button action" value="<?php _e('Clear cache', $this->plugin_slug) ?>">
			&nbsp;&nbsp;&nbsp;
			<i><?php _e('Clear cache and reset quotes of the day.', $this->plugin_slug) ?></i>
		</p>
	</form>
</div>