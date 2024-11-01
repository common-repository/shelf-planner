<?php

/**
 * The helper plugin class.
 * 
 * @link			https://www.shelfplanner.com
 * @since			0.0.1
 * @version			0.0.1
 * @package			Shelf_Planner_Connector
 * @subpackage		Shelf_Planner_Connector/includes
 * @author	  		Shelf Planner <service@shelfplanner.com>
 */

class Shelf_Planner_Connector_Helper
{
	// protected $shelf_planner_connector_env = 'LOCALDEV';
	// protected $shelf_planner_connector_env = 'DEV';
	// protected $shelf_planner_connector_env = 'UAT';
	protected $shelf_planner_connector_env = 'PROD';

	/**
	 * The title of this plugin.
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 * @access		protected
	 * @var			string			$plugin_title	 "Shelf Planner Connector"
	 */
	protected $plugin_title = "Shelf Planner Connector";

	/**
	 * The id of this plugin.
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 * @access		protected
	 * @var			string	 		$plugin_id	 	"shelf-planner-connector"
	 */
	protected $plugin_id = "shelf-planner-connector";

	/**
	 * The slug of this plugin.
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 * @access		protected
	 * @var			string			$plugin_slug	 "shelf_planner_connector"
	 */
	protected $plugin_slug = "shelf_planner_connector";

	/**
	 * The current version of the plugin.
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 * @access		protected
	 * @var			string			 $plugin_version	 The current version of the plugin.
	 */
	protected $plugin_version;

	public function __construct()
	{
		if (defined('SHELF_PLANNER_CONNECTOR_VERSION')) {
			$this->plugin_version = SHELF_PLANNER_CONNECTOR_VERSION;
		} else {
			$this->plugin_version = get_option("shelf_planner_connector_version");
		}
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since		0.0.1
	 * @version		0.0.1
	 * @return	 	string	 The name of the plugin.
	 */
	public function get_info()
	{
		$plugin_info = [
			"title" => $this->plugin_title,
			"id" => $this->plugin_id,
			"slug" => $this->plugin_slug,
			"version" => $this->plugin_version,
		];
		return $plugin_info;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since	  0.0.1
	 * @return	 string	 The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->plugin_version;
	}

	function toInteger($string)
	{
		sscanf($string, '%u%c', $number, $suffix);
		if (isset($suffix)) {
			$number = $number * pow(1024, strpos(' KMG', strtoupper($suffix)));
		}
		return $number;
	}

	public function get_website_url()
	{
		$url = get_site_url();
		$parsed_url = parse_url($url);
		$host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
		$port = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
		$path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
		return "$host$port$path";
	}

	public function get_plugin_title()
	{
		return $this->plugin_title;
	}

	public function get_plugin_slug()
	{
		return $this->plugin_slug;
	}

	public function get_env()
	{
		return $this->shelf_planner_connector_env;
	}

	public function get_api_url()
	{
		switch ($this->shelf_planner_connector_env) {
			case 'LOCALDEV':
				return 'http://localhost:5204/api/v1/';
			case 'DEV':
				return 'https://api-dev.shelfplanner.com/api/v1/';
			case 'UAT':
				return 'https://api-uat.shelfplanner.com/api/v1/';
			case 'PROD':
				return 'https://api.shelfplanner.com/api/v1/';
		}
	}

	public function get_app_url()
	{
		switch ($this->shelf_planner_connector_env) {
			case 'LOCALDEV':
				return 'http://localhost:4200/#/';
			case 'DEV':
				return 'https://my-dev.shelfplanner.com/#/';
			case 'UAT':
				return 'https://my-uat.shelfplanner.com/#/';
			case 'PROD':
				return 'https://my.shelfplanner.com/#/';
		}
	}

	public function get_server_key()
	{
		return get_option($this->plugin_slug . '_server_key');
	}

	public function set_server_key($serverKey)
	{
		update_option($this->plugin_slug . '_server_key', $serverKey);
	}

	public function delete_server_key()
	{
		delete_option($this->plugin_slug . '_server_key');
	}

	public function get_license_key()
	{
		return get_option($this->plugin_slug . '_license_key');
	}

	public function has_license_key()
	{
		$license_key = $this->get_license_key();
		return $license_key != null && trim($license_key) != '';
	}

	public function set_license_key($licenseKey)
	{
		update_option($this->plugin_slug . '_license_key', $licenseKey);
	}

	public function delete_license_key()
	{
		delete_option($this->plugin_slug . '_license_key');
	}

	public function get_setup_url($is_embedded = false)
	{
		return $this->get_app_url() . "connector/setup/" . $this->get_server_key() . "/" . $this->base64url_encode($this->get_website_url()) . ($is_embedded ? "/embedded" : "/external");
	}

	public function base64url_encode($data)
	{
		return str_replace("==", "=", strtr(base64_encode($data), '+/', '-_'));
	}

	public function get_store_info()
	{
		if (!class_exists('WooCommerce')) {
			trigger_error('NO WOOCOMMERCE DETECTED', E_USER_ERROR);
			return;
		}

		global $wp_version;
		global $wc_version;
		global $woocommerce;

		$total_memory = ini_get('memory_limit');
		$used_memory = memory_get_usage();
		$available_memory = $used_memory;

		// Store country
		// https://wp-kama.com/plugin/woocommerce/function/WC_Countries::get_base_country
		$WC_Countries = new WC_Countries();
		$storeCountry = $WC_Countries->get_base_country();

		// Store currency
		// https://wp-kama.com/plugin/woocommerce/function/get_woocommerce_currency
		$storeCurrency = get_woocommerce_currency();

		$sp_payload = [
			'Title' => get_bloginfo(),
			'CountryId' => $storeCountry, // get store country
			'CurrencyCode' => $storeCurrency, // get store currency
			'WebsiteUrl' => $this->get_website_url(),
			'ConnectorHook' => get_site_url() . '/wp-json/shelf-planner-connector/v1',
			'ConnectorVersion' => $this->plugin_version,
			'AvailableCpuCores' => 1,
			'UsedMemory' => $available_memory,
			'TotalMemory' => $this->toInteger($total_memory),
			'ApplicationName' => 'WORDPRESS',
			'ApplicationVersion' => $wp_version,
			'EnvironmentName' => 'WOOCOMMERCE',
			'EnvironmentVersion' => $woocommerce->version,
			'Metadata' => ''
		];

		return $sp_payload;
	}

	public function activate()
	{
		if (!class_exists('WooCommerce')) {
			trigger_error('NO WOOCOMMERCE DETECTED', E_USER_ERROR);
			return;
		}

		//error_log("Shelf Planner Connector plugin: activate");

		//$database_de_install = new Shelf_Planner_Connector_Install_Upgrade_Deinstall_Database();
		//$database_de_install->database_install_and_or_upgrade($database_de_install);

		$this->set_server_key('');
		$this->set_license_key('');
		update_option($this->plugin_slug . '_enable_logs', 'checked');

		$sp_payload = $this->get_store_info();

		$sp_json_data = json_encode(
			$sp_payload,
			JSON_PRETTY_PRINT
		);

		$url = $this->get_api_url() . 'connector/helo';
		$args = array(
			'method' => 'POST',
			'headers' => array(
				'content-type' => 'application/json',
			),
			'body' => $sp_json_data,
			'timeout' => 60,
		);

		$response = wp_remote_request($url, $args);

		if (json_decode($response['body'])->serverKey) {
			$this->set_server_key(json_decode($response['body'])->serverKey);
			update_option($this->plugin_slug . '_installed_plugin_version' , $this->plugin_version );
			
		} else {
			trigger_error('SPC HELO FAILED', E_USER_ERROR);
		}

	}

	public function deactivate()
	{
		$sp_payload = [
			'websiteUrl' => $this->get_website_url(),
			'serverKey' => $this->get_server_key(),
			'licenseKey' => $this->get_license_key(),
		];

		$sp_json_data = json_encode(
			$sp_payload,
			JSON_PRETTY_PRINT
		);

		$url = $this->get_api_url() . 'connector/gbye';
		$args = array(
			'method' => 'POST',
			'headers' => array(
				'content-type' => 'application/json',
			),
			'body' => $sp_json_data,
			'timeout' => 60,
		);

		$response = wp_remote_request($url, $args);

		error_log(print_r("ELIMINO", true));
		error_log(print_r($response, true));

		$this->delete_server_key();
		$this->delete_license_key();
	}

	public function send_order_completed_sync_request($order_id) {
		$sp_payload = [
			'WebsiteUrl' => $this->get_website_url(),
			'ServerKey' => $this->get_server_key(),
			'LicenseKey' => $this->get_license_key(),
			'ItemId' => ''.$order_id,
		];

		$sp_json_data = json_encode(
			$sp_payload,
			JSON_PRETTY_PRINT
		);

		$url = $this->get_api_url() . 'connector/sync/order';
		$args = array(
			'method' => 'POST',
			'headers' => array(
				'content-type' => 'application/json',
			),
			'body' => $sp_json_data,
			'timeout' => 60,
		);
		$response = wp_remote_request($url, $args);
	}

	public function send_product_update_sync_request($product_id) {
		$sp_payload = [
			'WebsiteUrl' => $this->get_website_url(),
			'ServerKey' => $this->get_server_key(),
			'LicenseKey' => $this->get_license_key(),
			'ItemId' => ''.$product_id,
		];

		$sp_json_data = json_encode(
			$sp_payload,
			JSON_PRETTY_PRINT
		);

		$url = $this->get_api_url() . 'connector/sync/product';
		$args = array(
			'method' => 'POST',
			'headers' => array(
				'content-type' => 'application/json',
			),
			'body' => $sp_json_data,
			'timeout' => 60,
		);
		$response = wp_remote_request($url, $args);
	}
}
