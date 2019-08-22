<?php

/**
 * Plugin Name: Bodymovin Elementor
 * Description: Extends Elementor with the ability to incorporate Lottie/Bodymovin renders within pages
 * Plugin URI: https://valentinecreative.co
 * Author: Valentine Creative
 * Version: 2.2.0
 * Author URI: https://valentinecreative.co
 *
 * Text Domain: val-bodymovin
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Elementor_Bodymovin_Extension
{

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elementor_Bodymovin_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Bodymovin_Extension An instance of the class.
	 */
	public static function instance()
	{

		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct()
	{

		add_action('init', [$this, 'i18n']);
		add_action('plugins_loaded', [$this, 'init']);
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n()
	{

		load_plugin_textdomain('elementor-bodymovin-extension');
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init()
	{

		// Check if Elementor installed and activated
		if (!did_action('elementor/loaded')) {
			add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
			return;
		}

		// Check for required Elementor version
		if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
			return;
		}

		// Check for required PHP version
		if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
			return;
		}

		// Add Plugin actions
		add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
		add_action('elementor/controls/controls_registered', [$this, 'init_controls']);
		add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);

		// Check Github repo for updates

		require 'plugin-update-checker/plugin-update-checker.php';
		$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
			'https://github.com/dmichaelglenn/val-bme',
			__FILE__,
			'bm-elementor'
		);

		// add_filter( 'wp_check_filetype_and_ext', 'add_json_mimes', 10, 4 );

// function add_json_mimes( $info, $file, $filename, $mimes ) {
//     $wp_filetype = wp_check_filetype( $filename, $mimes );
//     $ext = $wp_filetype['ext'];
//     $type = $wp_filetype['type'];

//     if ( $ext !== 'json' ) {
//         return $info;
//     }

//     if ( function_exists( 'finfo_file' ) ) {
//         // Use finfo_file if available to validate non-image files.
//         $finfo = finfo_open( FILEINFO_MIME_TYPE );
//         $real_mime = finfo_file( $finfo, $file );
//         finfo_close( $finfo );

//         // If the extension matches an alternate mime type, let's use it
//         if ( in_array( $real_mime, array( 'application/json', 'text/plain' ) ) ) {
//             $info['ext'] = $ext;
//             $info['type'] = $type;
//         }
//     }

//     return $info;
// }
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-bodymovin-extension'),
			'<strong>' . esc_html__('Elementor Bodymovin Extension', 'elementor-bodymovin-extension') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'elementor-bodymovin-extension') . '</strong>'
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-bodymovin-extension'),
			'<strong>' . esc_html__('Elementor Bodymovin Extension', 'elementor-bodymovin-extension') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'elementor-bodymovin-extension') . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-bodymovin-extension'),
			'<strong>' . esc_html__('Elementor Bodymovin Extension', 'elementor-bodymovin-extension') . '</strong>',
			'<strong>' . esc_html__('PHP', 'elementor-bodymovin-extension') . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}


	public function widget_scripts()
	{
		wp_enqueue_script('lottie', plugin_dir_url( __FILE__ ) .  '/assets/js/lottie.js', 'jQuery');
		wp_enqueue_script('enter-view', plugin_dir_url( __FILE__ ) .  '/assets/js/enter-view.js', 'jQuery');
		// wp_enqueue_script('val-bm-js', '/wp-content/plugins/bm-elementor/assets/js/val-bm.js');
		// the script below is for when we aren't on a local install
		wp_enqueue_script('val-bm-js', plugin_dir_url( __FILE__ ) .  '/custom.js');
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets()
	{

		// Include Widget files
		require_once(__DIR__ . '/widgets/bm-widget.php');

		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Bodymovin_Widget());
	}

	/**
	 * Init Controls
	 *
	 * Include controls files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_controls()
	{

		// Include Control files
		require_once(__DIR__ . '/controls/bm-control.php');

		// Register control
		\Elementor\Plugin::$instance->controls_manager->register_control('control-type-1', new \Bodymovin_Control());
	}

	function val_update()
	{ }
}


Elementor_Bodymovin_Extension::instance();

add_filter( 'upload_mimes', 'add_json_type', 1, 1 );
function add_json_type( $mime_types ) {
  $mime_types['json'] = 'application/json'; // Adding .json extension
  return $mime_types;
}

// echo '<h1>' . print_r(get_allowed_mime_types()) . '</h1>';

add_filter( 'wp_check_filetype_and_ext', 'add_json_mimes', 10, 4 );

function add_json_mimes( $info, $file, $filename, $mimes ) {
    $wp_filetype = wp_check_filetype( $filename, $mimes );
    $ext = $wp_filetype['ext'];
    $type = $wp_filetype['type'];

    if ( $ext !== 'json' ) {
        return $info;
    }

    if ( function_exists( 'finfo_file' ) ) {
        // Use finfo_file if available to validate non-image files.
        $finfo = finfo_open( FILEINFO_MIME_TYPE );
        $real_mime = finfo_file( $finfo, $file );
        finfo_close( $finfo );

        // If the extension matches an alternate mime type, let's use it
        if ( in_array( $real_mime, array( 'application/json', 'text/plain' ) ) ) {
            $info['ext'] = $ext;
            $info['type'] = $type;
        }
    }

    return $info;
}