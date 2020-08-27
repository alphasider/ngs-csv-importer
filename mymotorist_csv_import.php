<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           Mymotorist_csv_import
 *
 * @wordpress-plugin
 * Plugin Name:       Product CSV import
 * Plugin URI:        #
 * Description:       A plugin that import products from CSV
 * Version:           1.0.0
 * Author:            Jonathan Swiss
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mymotorist_csv_import
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MYMOTORIST_CSV_IMPORT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mymotorist_csv_import-activator.php
 */
function activate_mymotorist_csv_import() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mymotorist_csv_import-activator.php';
	Mymotorist_csv_import_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mymotorist_csv_import-deactivator.php
 */
function deactivate_mymotorist_csv_import() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mymotorist_csv_import-deactivator.php';
	Mymotorist_csv_import_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mymotorist_csv_import' );
register_deactivation_hook( __FILE__, 'deactivate_mymotorist_csv_import' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mymotorist_csv_import.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mymotorist_csv_import() {

	$plugin = new Mymotorist_csv_import();
	$plugin->run();

}
run_mymotorist_csv_import();

add_action( 'admin_menu', 'wfm_admin_menu' );
add_action( 'admin_init', 'wfm_admin_settings' );

function wfm_admin_settings(){
    register_setting(
        'wfm_theme_options_group',
        'wfm_theme_options',
        'wfm_theme_options_sanitize' );

    add_settings_section(
        'wfm_theme_options_id',
        'Section plugin options',
        '',
        'wfm-theme-options' );

    add_settings_field(
        'wfm_theme_options_body',
        'CSV file',
        'wfm_theme_body_cb',
        'wfm-theme-options',
        'wfm_theme_options_id' , array('label_for' => 'wfm_theme_options_body') );
//    add_settings_field(
//        'wfm_theme_options_header',
//        'Header color',
//        'wfm_theme_header_cb',
//        'wfm-theme-options',
//        'wfm_theme_options_id', array('label_for' => 'wfm_theme_options_header') );
}

function wfm_theme_body_cb(){
    $options = get_option('wfm_theme_options');
    // echo esc_attr($options['wfm_theme_options_body']);
    ?>

    <select name="wfm_theme_options[wfm_theme_options_body]" id="wfm_theme_options_body">
        <option value="">CSV file (050920)</option>
        <option value="">CSV file (060920)</option>
        <option value="">CSV file (070920)</option>
    </select>
    <?php
}

function wfm_theme_header_cb(){
    $options = get_option('wfm_theme_options');
    ?>

    <input type="text" name="wfm_theme_options[wfm_theme_options_header]" id="wfm_theme_options_header" value="<?php echo esc_attr($options['wfm_theme_options_header']); ?>" class="regular-text">

    <?php
}

function wfm_theme_options_sanitize($options){
    $clean_options = array();
    foreach($options as $k => $v){
        $clean_options[$k] = strip_tags($v);
    }
    return $clean_options;
}

function wfm_admin_menu(){
    // $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position
    add_menu_page( 'CSV Import', 'CSV Import', 'manage_options', 'wfm-theme-options', 'wfm_option_page', plugins_url( 'icon_mini.png', __FILE__ ) );
}

function wfm_option_page(){
    $options = get_option( 'wfm_theme_options' );
    ?>

    <div class="wrap">
        <h2>Product CSV Import</h2>
        <p>Custom description and notices</p>
        <form action="options.php" method="post">
            <?php settings_fields( 'wfm_theme_options_group' ); ?>
            <?php do_settings_sections( 'wfm-theme-options' ); ?>
            <?php  submit_button('Import CSV'); ?>
        </form>
    </div>

    <?php
}