<?php

/**
 * The admin-specific functionality of Shelf Planner Connector
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

class Shelf_Planner_Connector_Admin extends Shelf_Planner_Connector_BFT_Admin {

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
	**/


	/**
	 * BFT admin variables
	 * 
	 * @var		string				$admin_title											Main title of the admin menu
	 * @var		array				$database_status_options								Database: array with the options database_status_option_active and database_status_option_bin
	 * @var		string				$database_i18n_column_language							Database: column with the code of the language 
	 * @var		string				$submit_text_default									Database: column with the translated text
	 * @var		int					$items_per_page											Number of items per list table
	 * @var		string				$security_code_database_uninstall						Security code: delete the database
	 * @var		string				$admin_pages_main_name									Name of the plugin on the admin menu
	 * @var		string				$admin_pages_page_title_default							Title default of a admin page
	 * @var		string				$admin_pages_menu_title_default							Menú text default of a admin page
	 * @var		string				$admin_pages_slug_name_prefix							Slug prefix for the admin pages
	 * @var		string				$admin_pages_capability_default							Capability default for the admin pages
	 * @var		string				$admin_pages_function_default							Function default for the admin pages
	 * @var		string				$admin_pages_function_load_default						Function load default for the admin pages
	 * @var		string				$admin_pages_file_default								File default for the admin pages
	 * @var		string				$settings_section_function_default						Function default for the admin pages
	 * @var		string				$page_name												Page displaying at this moment
	 * @var		array				$admin_pages											Array of admin pages of the menu
	 * @var		array				$admin_settings									Array of page's settings controlled by WordPress by 
	 * @var		array				$admin_forms										Array of the page's custom forms
	 * @var		array				$admin_forms_many_to_many_relationships				Array of the many to manu relations
	 * @var		array				$errors_messages_shown									Messages already shown
	 * @var		string				$date_format_admin										Date format on the admin side
	 */

	/**
	 * Set the class variables
	 * 
	 * Most important variables:
	 * $this->admin_pages									The administration pages
	 * $this->admin_settings							The forms for save WordPress options
	 * $this->admin_forms								The custom automated forms for save data on custom database tables
	 * $this->admin_forms_many_to_many_relationships		Relations many to many
	 * 
	 * @since		0.0.1
	 * @version		0.0.1
	 */
	protected function custom_variables_set () {
		global $wpdb;
		//$variable = $this->__("string");
		//echo(esc_html($variable);
		//Don't use directly $this->esc_html_e("string");


		$this->database_version = $this->option_field_get('database_version_installed');
		if(false !== $this->database_version)
		{
			$this->items_per_page = $this->option_field_get('items_per_page');
			$shelf_planner_connector_calendar_date_start = $this->option_field_get('calendar_date_start');
			$shelf_planner_connector_calendar_date_end = $this->option_field_get('calendar_date_end');

			$shelf_planner_connector_calendar_date_start_datetime = new DateTime($shelf_planner_connector_calendar_date_start);
			$shelf_planner_connector_calendar_date_end_datetime = new DateTime($shelf_planner_connector_calendar_date_end);

			if ($shelf_planner_connector_calendar_date_start_datetime > $shelf_planner_connector_calendar_date_end_datetime) {
				$this->update_option_field('calendar_date_start', $shelf_planner_connector_calendar_date_end);
			}
		}

		$this->on_update_send_email_to =  [
			"admin" => [
				"boolean" => true,
				"value" => "yes",
				"changed" => false,
			],
			"contact" => [
				"boolean" => true,
				"value" => "yes",
				"changed" => false,
			],
			"lodgings" => [
				"boolean" => true,
				"value" => "yes",
				"changed" => false,
			],
		];

		$this->custom_variables_admin_public_set();

		$this->admin_title = $this->plugin_title;
		$this->submit_text_default = $this->__("Save Settings");

		$this->database_status_column_text = $this->__("Status");
		$this->database_status_option_active_text = $this->__("Active");
		$this->database_status_option_bin_text = $this->__("Bin");

		$this->database_datetime_created_text = $this->__("Creation date");
		$this->database_datetime_modified_text = $this->__("Last modification date");
		$this->database_datetime_removed_text = $this->__("Last elimination date");

		$this->database_status_options = [
			$this->database_status_option_active_name => $this->database_status_option_active_text,
			$this->database_status_option_bin_name => $this->database_status_option_bin_text,
		];

		$this->admin_pages_main_name = "BFT";
		$this->admin_pages_main_name = $this->plugin_title;
		$this->admin_pages_slug_name_prefix = $this->plugin_slug;
		$this->admin_pages_page_title_default = $this->admin_pages_main_name." ".$this->__("page");
		$this->admin_pages_menu_title_default = $this->admin_pages_main_name." ".$this->__("section");
		$this->admin_pages_file_default = "bft-admin-display-blank-page-with-title.php";

		$this->admin_pages_function_default = "admin_permission_check_and_ids_required_and_optional_check_page_display";
		$this->admin_pages_function_load_default = "admin_permission_check_and_ids_required_check_function_load";

		$this->admin_pages_capability_default = "manage_woocommerce";
		
		$this->admin_pages = [
			"dashboard" => [
				"menu_title" => $this->__("Dashboard"),
				"page_title" => $this->__("ShelfPlanner Connector"),
				"file" => "shelf-planner-connector-admin-dashboard.php",
			],
			"settings" => [
				"menu_title" => $this->__("Settings"),
				"page_title" => $this->__("ShelfPlanner Connector"),
				"file" => "shelf-planner-connector-admin-settings.php",
			],

		];


		
		/**
		 * The language data
		 */
		$languages_codes = $this->languages_codes_names_get();
		$languages_codes_selected = $this->languages_selected_get();

		/**
		 * The countries data
		 */
		$countries_codes = $this->countries_codes_names_get();

		$this->admin_pages_settings_prefix = $this->plugin_slug."_settings";
		$this->admin_pages_settings_page_suffix = "page";
		$this->admin_pages_settings_page_title_default = "Settings";
		
		$this->admin_settings = [];

		$this->admin_forms = [];


		$this->admin_forms_many_to_many_relationships = [];
	}


	/**
	 * Prepare the variables for an empty database
	 * Almost all display pages are deleted
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 * @return		NULL
	 */
	protected function database_check() {
		if(false !== $this->database_version)
		{
			//Database installed, check if an update is needed
			$database_de_install = new Shelf_Planner_Connector_Install_Upgrade_Deinstall_Database();
			$database_de_install->database_install_and_or_upgrade($database_de_install);
		}
		else {
			//Database not installed
		}
	}

	/**
	 * Register the Shelf Planner Connector stylesheets for the admin area.
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 */
	public function enqueue_styles_plugin() {
		wp_enqueue_style($this->plugin_id, plugin_dir_url( __FILE__ ). "css/shelf-planner-connector-admin.css", array(), $this->plugin_version);
	}


		/**
	 * HTML styles of You Plugin for the admin area through function_load_page_display
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 * @return		null
	 */
	public function html_styles_plugin() {
		?>
		<link rel="stylesheet" href="<?php echo plugin_dir_url( __FILE__ ). "css/shelf-planner-connector-admin.css"?>?ver=<?php echo $this->plugin_version?>" media="all" />
		<?php
	}

	
	/**
	 * Register the Shelf Planner Connector JavaScript for the admin area.
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 */
	public function enqueue_scripts_plugin() {
		//Own
		wp_enqueue_script($this->plugin_id, plugin_dir_url( __FILE__ )."js/shelf-planner-connector-admin.js", array( "jquery" ), $this->plugin_version, false );
	
		//Other
		//wp_enqueue_style( "script-name", "script-url", array("jquery"));
	}


	/**
	 * JavaScript styles of You Plugin for the admin area through function_load_page_display
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 * @return		null
	 */
	public function html_scripts_plugin() {
		?>
		<script src="<?php echo plugin_dir_url( __FILE__ )."js/shelf-planner-connector-admin.js"?>?ver=<?php echo $this->plugin_version?>"></script>
		<?php
	}

	/**
	 * Header of the section form, default function from $this->admin_settings
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 * @param		array		$arg
	 * @return	NULL
	 */
	public function settings_section_form_header($arg = array()) {
	}

}
