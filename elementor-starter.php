<?php
/**
 * Plugin Name: Bodymovin Elementor
 * Description: Extends Elementor with the ability to incorporate Bodymovin renders within pages
 * Plugin URI: https://valentinecreative.co
 * Author: Valentine Creative
 * Version: 1.0.0
 * Author URI: https://valentinecreative.co
 *
 * Text Domain: val-bodymovin
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'BODYMOVIN_ELEMENTOR_VERSION', '1.0.0' );

define( 'BODYMOVIN_ELEMENTOR__FILE__', __FILE__ );
define( 'BODYMOVIN_ELEMENTOR_PLUGIN_BASE', plugin_basename( BODYMOVIN_ELEMENTOR__FILE__ ) );
define( 'BODYMOVIN_ELEMENTOR_PATH', plugin_dir_path( BODYMOVIN_ELEMENTOR__FILE__ ) );
define( 'BODYMOVIN_ELEMENTOR_MODULES_PATH', BODYMOVIN_ELEMENTOR_PATH . 'modules/' );
define( 'BODYMOVIN_ELEMENTOR_URL', plugins_url( '/', BODYMOVIN_ELEMENTOR__FILE__ ) );
define( 'BODYMOVIN_ELEMENTOR_ASSETS_URL', BODYMOVIN_ELEMENTOR_URL . 'assets/' );
define( 'BODYMOVIN_ELEMENTOR_MODULES_URL', BODYMOVIN_ELEMENTOR_URL . 'modules/' );

/**
 * Load gettext translate for our text domain.
 *
 * @since 1.0.0
 *
 * @return void
 */
function bodymovin_elementor_load_plugin() {
	load_plugin_textdomain( 'elementor-starter' );

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'bodymovin_elementor_fail_load' );
		return;
	}

	$elementor_version_required = '1.0.6';
	if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_required, '>=' ) ) {
		add_action( 'admin_notices', 'bodymovin_elementor_fail_load_out_of_date' );
		return;
	}

	require( BODYMOVIN_ELEMENTOR_PATH . 'plugin.php' );
}
add_action( 'plugins_loaded', 'bodymovin_elementor_load_plugin' );

/**
 * Show in WP Dashboard notice about the plugin is not activated.
 *
 * @since 1.0.0
 *
 * @return void
 */
function bodymovin_elementor_fail_load() {
	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	$plugin = 'elementor/elementor.php';

	if ( _is_elementor_installed() ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );

		$message = '<p>' . __( 'Bodymovin Elementor is not working because you need to activate the Elementor plugin.', 'elementor-starter' ) . '</p>';
		$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, __( 'Activate Elementor Now', 'elementor-starter' ) ) . '</p>';
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );

		$message = '<p>' . __( 'Bodymovin Elementor is not working because you need to install the Elementor plugin', 'elementor-starter' ) . '</p>';
		$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, __( 'Install Elementor Now', 'elementor-starter' ) ) . '</p>';
	}

	echo '<div class="error"><p>' . $message . '</p></div>';
}

function bodymovin_elementor_fail_load_out_of_date() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	$file_path = 'elementor/elementor.php';

	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
	$message = '<p>' . __( 'Bodymovin Elementor is not working because you are using an old version of Elementor.', 'elementor-starter' ) . '</p>';
	$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, __( 'Update Elementor Now', 'elementor-starter' ) ) . '</p>';

	echo '<div class="error">' . $message . '</div>';
}

if ( ! function_exists( '_is_elementor_installed' ) ) {

	function _is_elementor_installed() {
		$file_path = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}
}

