<?php
class OSM_Whats_Next extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * The widget constructor. Specifies the classname and description, instantiates
	 * the widget, loads localization files, and includes necessary scripts and
	 * styles.
	 */
	function OSM_Whats_Next() {

	    // Define constants used throughout the plugin
	    $this->init_plugin_constants();

		$widget_opts = array (
			'classname' => 'OSM_Whats_Next',
			'description' => __('Shows your upcoming events and/or meetings', PLUGIN_LOCALE)
		);

		$this->WP_Widget('OSM_Whats_Next', __('OSM: Coming Up', PLUGIN_LOCALE), $widget_opts);
		load_plugin_textdomain(PLUGIN_LOCALE, false, dirname(plugin_basename( __FILE__ ) ) . '/lang/' );

	    // Load JavaScript and stylesheets
	    $this->register_scripts_and_styles();

	} // end constructor

	/*--------------------------------------------------*/
	/* API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @args			The array of form elements
	 * @instance
	 */
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		// Display the widget
		include(WP_PLUGIN_DIR . '/' . PLUGIN_SLUG . '/views/comingup_widget_view.php');

	} // end widget

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @new_instance	The previous instance of values before the update.
	 * @old_instance	The new instance of values to be generated via the update.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

	    $instance['wtitle'] = strip_tags(stripslashes($new_instance['wtitle']));
	    $instance['sectionid'] = strip_tags(stripslashes($new_instance['sectionid']));
	    $instance['type'] = strip_tags(stripslashes($new_instance['type']));
	    $instance['numentries'] = strip_tags(stripslashes($new_instance['numentries']));

		return $instance;

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @instance	The array of keys and values for the widget.
	 */
	function form($instance) {

		$instance = wp_parse_args(
			(array)$instance,
			array(
				'wtitle' => '',
		        'sectionid' => '',
		        'numentries' => '',
		        'type' => ''
			)
		);
		// Display the admin form
    	include(WP_PLUGIN_DIR . '/' . PLUGIN_SLUG . '/views/comingup_widget_admin.php');

	} // end form

	/*--------------------------------------------------*/
	/* Private Functions
	/*--------------------------------------------------*/

  /**
   * Initializes constants used for convenience throughout
   * the plugin.
   */
  private function init_plugin_constants() {

    if(!defined('PLUGIN_LOCALE')) {
      define('PLUGIN_LOCALE', 'online-scout-manager-locale');
    } // end if

    if(!defined('PLUGIN_NAME')) {
      define('PLUGIN_NAME', 'OSM: Coming Up');
    } // end if

    if(!defined('PLUGIN_SLUG')) {
      define('PLUGIN_SLUG', 'online-scout-manager');
    } // end if

  } // end init_plugin_constants

	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	private function register_scripts_and_styles() {
		if(is_admin()) {
     		$this->load_file(PLUGIN_NAME, '/' . PLUGIN_SLUG . '/js/admin.js', true);
		} else {
			$this->load_file(PLUGIN_NAME, '/' . PLUGIN_SLUG . '/css/widget.css');
		} // end if/else
	} // end register_scripts_and_styles

	/**
	 * Helper function for registering and enqueueing scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	private function load_file($name, $file_path, $is_script = false) {

    	$url = WP_PLUGIN_URL . $file_path;
		$file = WP_PLUGIN_DIR . $file_path;

		if(file_exists($file)) {
			if($is_script) {
				wp_register_script($name, $url);
				wp_enqueue_script($name);
			} else {
				wp_register_style($name, $url);
				wp_enqueue_style($name);
			} // end if
		} // end if

	} // end load_file

} // end class
?>
