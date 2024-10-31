<?php
class Curated_Quotes_Widget extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	protected $plugin_slug;

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct()
	{

		$this->plugin_slug = Curated_Quotes::get_instance()->get_plugin_slug();

		parent::__construct(
			'curatedquotes-widget',
			__( 'Random Daily Quote', $this->plugin_slug ),
			array(
				'classname'		=>	'curatedquotes-class',
				'description'	=>	__( 'Get daily quote from CuratedQuotes.com', $this->plugin_slug )
			)
		);

	} // end constructor

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param	array	args		The array of form elements
	 * @param	array	instance	The current instance of the widget
	 */
	public function widget( $args, $instance )
	{
		extract( $args, EXTR_SKIP );

		echo $before_widget;

		Curated_Quotes::get_instance()->quote_html($instance);

		echo $after_widget;

	} // end widget

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param	array	new_instance	The new instance of values to be generated via the update.
	 * @param	array	old_instance	The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;

		$instance['title'] 					= strip_tags($new_instance['title']);
		$instance['color'] 					= Curated_Quotes::get_instance()->filter_in_array($new_instance['color'], 	Curated_Quotes::get_instance()->get_color_options());
		$instance['social']					= (int) $new_instance['social'];
		$instance['header_bg_color'] 		= $new_instance['header_bg_color'];
		$instance['header_font_color'] 		= $new_instance['header_font_color'];
		$instance['body_bg_color'] 			= $new_instance['body_bg_color'];
		$instance['body_font_color'] 		= $new_instance['body_font_color'];
		return $instance;
	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param	array	instance	The array of keys and values for the widget.
	 */
	public function form( $instance )
	{
		$instance = wp_parse_args(
			(array) $instance,
			Curated_Quotes::get_instance()->get_quote_default_settings()
		);

		// Display the admin form
		include( plugin_dir_path( __FILE__ ) . 'views/widget-admin.php' );

	} // end form

} // end class

add_action( 'widgets_init', create_function( '', 'register_widget("Curated_Quotes_Widget");' ) );