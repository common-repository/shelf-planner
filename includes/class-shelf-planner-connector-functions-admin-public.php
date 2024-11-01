<?php
/**
 * Class for install, upgrade or deinstall the database
 *
 * @link       https://moisesbarrachina.online
 * @since      0.0.1
 * @version    0.0.1
 * @package    Shelf_Planner_Connector
 * @subpackage Shelf_Planner_Connector/includes
 */

class Shelf_Planner_Connector_Admin_Public extends Shelf_Planner_Connector_BFT_Admin_Public {


	/**
	 * BFT admin-public variables
	 * 
	 * @var		string				$bft_version											Version of BFT
	 * @var		string				$plugin_title											The title of this plugin: "Shelf Planner Connector"
	 * @var		string				$plugin_id												The id of this plugin: "shelf-planner-connector"
	 * @var		string				$plugin_slug											The slug of this plugin: "shelf_planner_connector"
	 * @var		string				$plugin_version											The current version of the plugin
	 * @var		string|boolean		$database_version										The current version of the plugin database
	 * @var		string				$admin_email											Admin where send the notifications
	 * @var		string				$language_current										The language of the user
	 * @var		int					$currency_id											Currency id used
	 * @var		string				$currency_symbol										Currency sybol used
	 * @var		string				$currency_order											Currency order used
	 * @var		string				$currency_decimals_type									Decimals character
	 * @var		string				$currency_decimals_on_interer							How to show an interger amount
	 * @var		string				$database_datetime_created_name							Database: column datetime creation, name
	 * @var		string				$database_datetime_created_text							Database: column datetime creation, text
	 * @var		string				$database_datetime_modified_name						Database: column datetime modification, name
	 * @var		string				$database_datetime_modified_text						Database: column datetime modification, text
	 * @var		string				$database_datetime_removed_name							Database: column datetime moved to bin, name
	 * @var		string				$database_datetime_removed_text							Database: column datetime moved to bin, text
	 * @var		string				$database_status_column_name							Database: column for the status (active-deactive), name
	 * @var		string				$database_status_column_text							Database: column for the status (active-deactive), text
	 * @var		string				$database_status_option_active_name						Database: enum option for active, name
	 * @var		string				$database_status_option_active_text						Database: enum option for active, text
	 * @var		string				$database_status_option_bin_name						Database: enum option for deactive, name
	 * @var		string				$database_status_option_bin_text						Database: enum option for deactive, text
	 * @var		string				$database_multiple_values_separator						Database: separator of multiples values
	 * @var		string				$database_i18n_suffix									Database: internationalization prefix 
	 * @var		string				$daterangepicker_script_printed_ids						Ids of daterangepiker printed
	 */


	/**
	 * Shelf Planner Connector admin-public variables
	 */
	


	/**
	 * Prepare the variables for the admin and public class
	 *
	 * @since		0.0.1
	 * @version		1.1.0
	 */
	protected function custom_variables_admin_public_set() {

		$this->admin_email  = $this->option_field_get('admin_email');	

		$this->currency_id = $this->option_field_get('currency_id');
		$this->currency_symbol = $this->currency_symbol_get($this->currency_id);
		$this->currency_order = $this->option_field_get('currency_order');
		$this->currency_decimals_type = $this->option_field_get('currency_decimals_type');
		$this->currency_decimals_on_interer = $this->option_field_get('currency_decimals_on_interer');
	}
}
?>