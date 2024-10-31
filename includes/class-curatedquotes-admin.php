<?php
/**
 * Plugin class. This class is used to work with the
 * administrative side of the WordPress site.
 *
 * @package Curated_Quotes_Admin
 * @author  CuratedQuotes <contact@CuratedQuotes.com>
 */
class Curated_Quotes_Admin
{
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	protected $plugin_slug;

	protected $inline_js;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct()
	{
		/*
		 * Call $plugin_slug from public plugin class.
		 */
		$this->plugin_slug 	= Curated_Quotes::get_instance()->get_plugin_slug();

		add_action( 'media_buttons', 								array( $this, 'media_buttons' ), 20 );
		add_action( 'media_upload_insert_curatedquotes_shortcode', 	array( $this, 'media_browser' ) );
		add_action( 'admin_footer', 								array( $this, 'output_inline_js' ), 25 );

		add_action( 'admin_enqueue_scripts', 						array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', 						array( $this, 'enqueue_scripts' ) );

		add_action( 'admin_menu', 									array( $this, 'add_plugin_admin_menu' ) );
		add_action( 'admin_init', 									array( $this, 'process_options_page') );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance()
	{
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 */
	public function add_plugin_admin_menu()
	{

		$this->plugin_screen_hook_suffix = add_options_page(
			__('Random Daily Quote', $this->plugin_slug),
			__('Random Daily Quote', $this->plugin_slug),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);
	}

	/**
	 * Render options page.
	 */
	public function display_plugin_admin_page()
	{
		include_once( 'views/admin.php' );
	}


	/**
	 * Form handler for options page
	 * Fires when form is submitted.
	 */
	public function process_options_page()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['page']) && $_GET['page'] == $this->plugin_slug) {
			if (!wp_verify_nonce($_POST['_qqod'], 'clear')) {
				wp_die('You have no access to this page');
			}

			// clear all cache
			Curated_Quotes::get_instance()->clear_cache();

			wp_redirect(admin_url('admin.php?page=' . $this->plugin_slug . '&cleared'));
			exit;
		}
	}

	/**
	 * media_buttons function.
	 *
	 * @access public
	 * @return void
	 */
	public function media_buttons( $editor_id = 'content' )
	{
		global $post;

		echo '<a href="#" id="curatedquotes-insert-quote" class="button insert-quote" data-editor="' . esc_attr( $editor_id ) . '" title="' . esc_attr__( 'Insert Quote', $this->plugin_slug ) . '">' . __( 'Insert Quote', $this->plugin_slug ) . '</a>';

		ob_start();
		?>
		jQuery(function($){
			$('#curatedquotes-insert-quote').on('click', function(e){
				tb_show('<?php esc_attr_e( 'Insert Quote', $this->plugin_slug ); ?>', 'media-upload.php?post_id=<?php echo $post->ID; ?>&amp;type=insert_curatedquotes_shortcode&amp;from=wpdlm01&amp;TB_iframe=true&amp;height=200');
				return false;
			});
		});
		<?php

		$js_code = ob_get_clean();
		$this->add_inline_js( $js_code );
	}

	/**
	 * media_browser function.
	 *
	 * @access public
	 * @return void
	 */
	public function media_browser()
	{
		// Enqueue scripts and styles for panel
		wp_enqueue_script( 'common' );
		wp_enqueue_style( 'global' );
		wp_enqueue_style( 'wp-admin' );
		wp_enqueue_style( 'colors' );

		$this->enqueue_styles();
		$this->enqueue_scripts();

		echo '<!DOCTYPE html><html lang="en"><head><title>' . __( 'Insert S3 File', $this->plugin_slug ) . '</title><meta charset="utf-8" />';

		do_action( 'admin_print_styles' );
		do_action( 'admin_print_scripts' );
		do_action( 'admin_head' );

		$instance = Curated_Quotes::get_instance()->get_quote_default_settings();

		echo '<body id="ww-s3-file-insert-body" class="wp-core-ui">';
		?>
		<div class="wrap">


		<h2 class="nav-tab-wrapper">
			<span class="nav-tab nav-tab-active"><?php _e( 'Insert Shortcode', $this->plugin_slug ); ?></span>
		</h2>
		<form id="ww-s3-file-insert-shortcode" style="padding: 20px;">
			<p>
				<label for="curatedquotes_title"><?php _e('Title:', $this->plugin_slug) ?></label>
				<input type="text" class="widefat" id="curatedquotes_title" name="title" value="<?php echo $instance['title']; ?>" />
			</p>

			<p>
				<label for="curatedquotes_header_bg_color"><?php _e('Header Background Color:', $this->plugin_slug) ?></label>
				<input type="text" class="widefat bumin-color-picker" id="curatedquotes_header_bg_color" name="header_bg_color" value="<?php echo $instance['header_bg_color']; ?>" />
			</p>


			<p>
				<label for="curatedquotes_header_font_color"><?php _e('Header Font Color:', $this->plugin_slug) ?></label>
				<input type="text" class="widefat bumin-color-picker" id="curatedquotes_header_font_color" name="header_font_color" value="<?php echo $instance['header_font_color']; ?>" />
			</p>

			<p>
				<label for="curatedquotes_body_bg_color"><?php _e('Body Background Color:', $this->plugin_slug) ?></label>
				<input type="text" class="widefat bumin-color-picker" id="curatedquotes_body_bg_color" name="body_bg_color" value="<?php echo $instance['body_bg_color']; ?>" />
			</p>

			<p>
				<label for="curatedquotes_body_font_color"><?php _e('Body Font Color:', $this->plugin_slug) ?></label>
				<input type="text" class="widefat bumin-color-picker" id="curatedquotes_body_font_color" name="body_font_color" value="<?php echo $instance['body_font_color']; ?>" />
			</p>

			<p>
				<input type="checkbox" id="curatedquotes_social" name="social" value="1" <?php echo $instance['social'] ? 'checked="checked"' : ''; ?> />
				<label for="curatedquotes_social"><?php _e('Show social links', $this->plugin_slug) ?></label>
			</p>
			<p>
				<input type="button" id="curatedquotes-insert-quote-shortcode" class="button button-primary button-large" value="<?php _e( 'Insert Shortcode', $this->plugin_slug ); ?>" />
			</p>
		</form>
		</div>
		<script type="text/javascript">
			jQuery(function($) {
				$('#curatedquotes-insert-quote-shortcode').on('click', function(){
					var win = window.dialogArguments || opener || parent || top;
					var file_id = jQuery('#ww-s3-file-insert-id').val();

					var args = '';

					$('#ww-s3-file-insert-shortcode p input:text, select, input:checkbox').each(function(){
						var field = $(this);
						args += ' ' + field.attr('name') + '="' + field.val() + '"';
					})


					var shortcode   = '[randomdailyquotes' + args + ']';
					console.log(shortcode);
					win.send_to_editor( shortcode );
					return false;
				});
			});
		</script>
		<?php
		echo '</body></html>';
	}


	/**
	 * Enqueue JS to be added to the footer.
	 *
	 * @access public
	 * @param mixed $code
	 * @return void
	 */
	public function add_inline_js( $code )
	{
		$this->inline_js .= "\n" . $code . "\n";
	}

	/**
	 * Output enqueued JS
	 *
	 * @access public
	 * @return void
	 */
	public function output_inline_js()
	{
		if ( $this->inline_js ) {
			echo "<script type=\"text/javascript\">\njQuery(document).ready(function($) {";
			echo $this->inline_js;
			echo "});\n</script>\n";
			$this->inline_js = '';
		}
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Curated_Quotes::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), Curated_Quotes::VERSION );
	}
}
