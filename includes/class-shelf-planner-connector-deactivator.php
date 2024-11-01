<?php
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
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

class Shelf_Planner_Connector_Deactivator
{
	/**
	 * Plugin deactivation.
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 */
	public static function deactivate()
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/lib/class-shelf-planner-connector-helper.php';
		$spc_helper = new Shelf_Planner_Connector_Helper();
		$spc_helper->deactivate();
	}
}
