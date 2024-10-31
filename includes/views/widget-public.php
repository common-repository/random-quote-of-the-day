<div class="curatedquotes-widget">
	<div class="curatedquotes-widget-title" style="background-color: <?php echo $instance['header_bg_color'] ?>;color: <?php echo $instance['header_font_color'] ?>;"><?php echo $title ?></div>
	<div class="curatedquotes-widget-body" style="background-color: <?php echo $instance['body_bg_color'] ?>">
		<div class="curatedquotes-widget-quote" style="color: <?php echo $instance['body_font_color'] ?>;">
			&lsquo;<?php echo $quote ?>&rsquo; <br/><b><?php echo $author; ?></b>
		</div>
		<?php if ($instance['social']): ?>
			<div class="curatedquotes-widget-social">
				<span>Share</span>
				<a href="//pinterest.com/pin/create/%20button?url=<?php echo $url_for_share; ?>&amp;media=<?php echo $author->image?>&amp;description=<?php echo $quote?>" rel="nofollow" class="entypo-social pinterest"></a>
				<a href="//plus.google.com/share?url=<?php echo $url_for_share; ?>" class="entypo-social googlep"></a>
				<a href="//twitter.com/share?url=<?php echo $url_for_share; ?>&amp;text=<?php echo $quote?>" class="entypo-social twitter" rel="nofollow" ></a>
				<a href="//www.facebook.com/sharer.php?u=<?php echo $url_for_share; ?>&amp;title=<?php echo $quote?>" class="entypo-social facebook" rel="nofollow" ></a>
				<a href="//www.tumblr.com/share?s=&amp;v=3&amp;u=<?php echo urlencode($url_for_share); ?>&amp;t=<?php echo $quote?>" class="entypo-social tumblr" rel="nofollow" ></a>
			</div>
		<?php endif ?>
	</div>
	<div class="curatedquotes-widget-copy"><?php _e('Powered by ', $this->plugin_slug) ?> <a href="http://www.curatedquotes.com/?utm_source=wp-widget" target="_blank" rel="nofollow">curatedquotes.com</a></div>
</div>
