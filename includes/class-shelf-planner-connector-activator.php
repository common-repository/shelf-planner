<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link		https://www.shelfplanner.com
 * @since		0.0.1
 * @version		0.0.1
 * @package		Shelf_Planner_Connector
 * @subpackage	Shelf_Planner_Connector/includes
 * @author	  	Shelf Planner <service@shelfplanner.com>
 */

class Shelf_Planner_Connector_Activator
{

	/**
	 * Plugin activation.
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 */
	public static function activate()
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/lib/class-shelf-planner-connector-helper.php';
		$spc_helper = new Shelf_Planner_Connector_Helper();
		$spc_helper->activate();
	}
}
