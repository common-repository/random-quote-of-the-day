<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', $this->plugin_slug) ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('header_bg_color'); ?>"><?php _e('Header Background Color:', $this->plugin_slug) ?></label>
	<input type="text" class="widefat bumin-color-picker" id="<?php echo $this->get_field_id('header_bg_color'); ?>" name="<?php echo $this->get_field_name('header_bg_color'); ?>" value="<?php echo $instance['header_bg_color']; ?>" />
</p>


<p>
	<label for="<?php echo $this->get_field_id('header_font_color'); ?>"><?php _e('Header Font Color:', $this->plugin_slug) ?></label>
	<input type="text" class="widefat bumin-color-picker" id="<?php echo $this->get_field_id('header_font_color'); ?>" name="<?php echo $this->get_field_name('header_font_color'); ?>" value="<?php echo $instance['header_font_color']; ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('body_bg_color'); ?>"><?php _e('Body Background Color:', $this->plugin_slug) ?></label>
	<input type="text" class="widefat bumin-color-picker" id="<?php echo $this->get_field_id('body_bg_color'); ?>" name="<?php echo $this->get_field_name('body_bg_color'); ?>" value="<?php echo $instance['body_bg_color']; ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('body_font_color'); ?>"><?php _e('Body Font Color:', $this->plugin_slug) ?></label>
	<input type="text" class="widefat bumin-color-picker" id="<?php echo $this->get_field_id('body_font_color'); ?>" name="<?php echo $this->get_field_name('body_font_color'); ?>" value="<?php echo $instance['body_font_color']; ?>" />
</p>

<p>
	<input type="checkbox" id="<?php echo $this->get_field_id('social'); ?>" name="<?php echo $this->get_field_name('social'); ?>" value="1" <?php echo $instance['social'] ? 'checked="checked"' : ''; ?> />
	<label for="<?php echo $this->get_field_id('social'); ?>"><?php _e('Show social links', $this->plugin_slug) ?></label>
</p>