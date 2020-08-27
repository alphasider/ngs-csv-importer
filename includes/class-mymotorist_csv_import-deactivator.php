<?php

/**
 * Fired during plugin deactivation
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Mymotorist_csv_import
 * @subpackage Mymotorist_csv_import/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Mymotorist_csv_import
 * @subpackage Mymotorist_csv_import/includes
 * @author     Jonathan Swiss <jonathan.swiss.dev@gmail.com>
 */
class Mymotorist_csv_import_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        delete_option('wfm_theme_options');
	}

}
