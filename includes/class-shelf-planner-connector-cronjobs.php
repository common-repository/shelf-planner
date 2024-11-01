<?php

/**
 * The cronjobs of the plugin
 * 
 * @link		https://www.shelfplanner.com
 * @since		0.0.1
 * @version		0.0.1
 * @package		Shelf_Planner_Connector
 * @subpackage	Shelf_Planner_Connector/includes
 * @author	  	Shelf Planner <service@shelfplanner.com>
 */

 /*
	Uses Backend Frontend Template 1.0.0
	https://moisesbarrachina.online
*/

class Shelf_Planner_Connector_Cronjobs extends Shelf_Planner_Connector_Admin_Public {
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 * @param		string			$shelf_planner_connector		Title, id, slug and version of the plugin
	 */
	public function __construct($plugin_info) {
		/*
		For testing the cronjob
		$this->debug_log_write("Construct of Shelf_Planner_Connector_Cronjobs");
		$this->shelf_planner_connector_cronjob();
		*/
	}
	
	/**
	 * Ejecute cronjobs
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 * @return		boolean
	 */
	public function shelf_planner_connector_cronjob() {
		global $wpdb;

		/*$wpdb->query( "
			UPDATE
				".$wpdb->prefix."shelf_planner_connector_table
			SET
				xxxxxx
			WHERE
				xxxxxx");*/

		return true;
	}
}
