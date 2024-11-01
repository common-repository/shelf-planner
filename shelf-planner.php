<?php
/**
 * @link				https://www.shelfplanner.com
 * @since				0.0.1
 * @package				Shelf_Planner_Connector
 *
 * @wordpress-plugin
 * Plugin Name:			Inventory Management by Shelf Planner
 * Plugin URI:			https://www.shelfplanner.com/
 * Description:			AI-driven Stock Management, Demand Forecasting, Replenishment and Order Management for WooCommerce, all in one powerful tool.
 * 
 * Version:				2.3.3
 * Author:				Shelf Planner
 * Author URI:			https://www.shelfplanner.com
 * License:				GPL-2.0+
 * License URI:			http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:			shelf-planner-connector
 * Domain Path:			/languages
 */

/*
	Uses Backend Frontend Template 1.0.0
	https://moisesbarrachina.online
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Use SemVer - https://semver.org
 */
$shelf_planner_connector_version = "2.3.3";
define('SHELF_PLANNER_CONNECTOR_VERSION', $shelf_planner_connector_version);
update_option('shelf_planner_connector_version', $shelf_planner_connector_version);

require_once plugin_dir_path(__FILE__) . 'includes/lib/class-shelf-planner-connector-helper.php';
$spc_helper = new Shelf_Planner_Connector_Helper();

/**
 * The code that runs during plugin activation.
 * 
 * @since    	0.0.1
 * @version		0.0.1
 */
function activate_shelf_planner_connector()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-shelf-planner-connector-install-upgrade-deinstall-database.php';
	require_once plugin_dir_path(__FILE__) . 'includes/class-shelf-planner-connector-activator.php';
	Shelf_Planner_Connector_Activator::activate();
}
register_activation_hook(__FILE__, 'activate_shelf_planner_connector');

/**
 * The code that runs during plugin deactivation.
 * 
 * @since    	0.0.1
 * @version		0.0.1
 */
function deactivate_shelf_planner_connector()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-shelf-planner-connector-install-upgrade-deinstall-database.php';
	require_once plugin_dir_path(__FILE__) . 'includes/class-shelf-planner-connector-deactivator.php';
	Shelf_Planner_Connector_Deactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_shelf_planner_connector');

/**
 * Grab latest post title by an author!
 *
 * @param array $data Options for the function.
 * @return string|null Post title for the latest, * or null if none.
 */
function my_awesome_func($data)
{
	$posts = get_posts(
		array(
			'author' => $data['id'],
		)
	);

	if (empty($posts)) {
		return null;
	}

	return $posts[0]->post_title;
}

function add_product_stock($data)
{
	// Validate request auth
	if (!validate_request_auth($data)) {
		return null;
	}

	$product = wc_get_product($data['ProductId']);
	if (!$product) {
		return null;
	}

	$current_stock = $product->get_stock_quantity();
	$updated_stock = $current_stock + $data['Stock'];
	$product->set_stock_quantity($updated_stock);
	$product->save();

	return $product->get_stock_quantity();
}

function update_product_stock($data)
{
	// Validate request auth
	if (!validate_request_auth($data)) {
		return null;
	}

	$product = wc_get_product($data['ProductId']);
	if (!$product) {
		return null;
	}
	$product->set_stock_quantity($data['Stock']);
	$product->save();

	return $product->get_stock_quantity();
}

function update_products_track_stock($data)
{
	// Validate request auth
	if (!validate_request_auth($data)) {
		return null;
	}
	// spcApiLog("update_products_track_stock call parameters:" . json_encode($data->get_json_params()));
	foreach ($data['ProductsToUpdateTrackStock'] as $key => $value) {
		// spcApiLog("update_products_track_stock item: " . $key . ' :: ' . (true == $value ? 'true' : 'false'));
		$product = wc_get_product($key);
		if (!$product) {
			return null;
		}
		$product->set_manage_stock($value);
		$product->save();
	}
}

function get_categories_list($data)
{
	// Validate request auth
	spcApiLog("GetCategoryList  call parameters:" . json_encode($data->get_json_params()));
	if (!validate_request_auth($data)) {
		return [];
	}

	$taxonomy = 'product_cat';
	$orderby = 'name';
	$show_count = 0;      // 1 for yes, 0 for no
	$pad_counts = 0;      // 1 for yes, 0 for no
	$hierarchical = 1;      // 1 for yes, 0 for no  
	$title = '';
	$empty = 0;

	$args = array(
		'taxonomy' => $taxonomy,
		'orderby' => $orderby,
		'show_count' => $show_count,
		'pad_counts' => $pad_counts,
		'hierarchical' => $hierarchical,
		'title_li' => $title,
		'hide_empty' => $empty
	);
	$all_categories = get_categories($args);
	$categories = [];
	$tmpCategory = [];
	foreach ($all_categories as $category) {
		$catArray = $category->to_array();

		$tmpCategory['Title'] = $catArray['name'];
		$tmpCategory['Id'] = '' . $catArray['term_id'];
		$tmpCategory['Pid'] = '' . $catArray['parent'];
		$categories[] = $tmpCategory;
	}

	return $categories;
}


function get_products_list_v2($data)
{
	// Validate request auth
	spcApiLog("GetProductList call parameters:" . json_encode($data->get_json_params()));
	if (!validate_request_auth($data)) {
		return [];
	}

	global $wpdb;

	$product_status = 'publish';
	$datab = $wpdb->get_results(
		$wpdb->prepare(
			"
        SELECT ID
        FROM {$wpdb->posts} AS posts
        WHERE posts.post_type IN ('product', 'product_variation')
		AND post_modified >= %s
        AND post_status = %s 
		order by post_modified",
			$data['LastUpdateFrom'],
			$product_status,
			ARRAY_A
		)
	);

	return (array_map('strval', array_column($datab, 'ID')));
	//return implode(',', $data);
}

function get_order_list($data)
{
	global $spc_helper;
	$plugin_slug = $spc_helper->get_plugin_slug();

	// Validate request auth
	spcApiLog("GetOrderList call parameters:" . json_encode($data->get_json_params()));
	if (!validate_request_auth($data)) {
		return [];
	}

	global $wpdb;

	$order_type_column = "post_type";
	$order_status_column = "post_status";
	$order_date_column = "post_modified";
	$orders_table = $wpdb->prefix . "posts";

	// spcApiLog("woocommerce_custom_orders_table_enabled : " . get_option('woocommerce_custom_orders_table_enabled'));

	// woocommerce_custom_orders_table_enabled == 'yes' : hpos enabled (new wc_orders table)
	// woocommerce_custom_orders_table_enabled == 'no' : hpos disabled (legacy posts table)
	if ('yes' == get_option('woocommerce_custom_orders_table_enabled')) {
		$orders_table = $wpdb->prefix . "wc_orders";
		$order_type_column = "type";
		$order_status_column = "status";
		$order_date_column = "date_created_gmt";
	}

	$order_query =
		"
			 SELECT ID
			 FROM {$orders_table} 
			 WHERE {$order_type_column} = 'shop_order'
			 AND {$order_date_column} >= %s
			 AND {$order_status_column} IN ( 'wc-completed' ) order by {$order_date_column}";

	$order_status = array('wc-completed');
	$data = $wpdb->get_results(
		$wpdb->prepare(
			$order_query,
			$data['LastUpdateFrom'],
			ARRAY_A
		)
	);

	return (array_map('strval', array_column($data, 'ID')));
}

function get_order_detail($request)
{
	// Validate request auth

	//spcApiLog("GetOrderDetail call"));
	if (!validate_request_auth($request)) {
		return [];
	}

	$params = $request->get_params(); // Ottieni i parametri passati nella richiesta POST
	$param_value = $params['IDS']; // Ottieni il valore del parametro specifico
	$tmpOrders = [];
	foreach ($params['IDS'] as $orderId) {
		//$order_ids[] = $order->get_id();
		$order = wc_get_order($orderId);
		//$orderArray = $order->to_array();
		// https://wp-kama.com/plugin/woocommerce/function/wc_get_order
		$data = $order->get_data(); // order data

		$tmpOrder['Id'] = '' . $orderId;
		$tmpOrder['DateCreated'] = isset($data['date_created']) ? $data['date_created']->getTimestamp() : null;
		$tmpOrder['DateModified'] = isset($data['date_modified']) ? $data['date_modified']->getTimestamp() : null;
		$tmpOrder['CustomerId'] = '' . $data['customer_id'];
		$tmpOrder['BillingCity'] = $data['billing']['city'];
		$tmpOrder['BillingCountry'] = $data['billing']['country'];
		$tmpOrder['ShippingCity'] = $data['shipping']['city'];
		$tmpOrder['ShippingCountry'] = $data['shipping']['country'];
		$tmpOrder['CartTax'] = $order->get_cart_tax();
		$tmpOrder['Currency'] = $order->get_currency();
		$tmpOrder['DiscountTax'] = $order->get_discount_tax();
		$tmpOrder['DiscountTotal'] = $order->get_discount_total();
		$tmpOrder['TotalFees'] = $order->get_total_fees();
		$tmpOrder['ShippingTax'] = $order->get_shipping_tax();
		$tmpOrder['ShippingTotal'] = $order->get_shipping_total();
		$tmpOrder['Subtotal'] = $order->get_subtotal();
		$tmpOrder['TaxTotals'] = $order->get_tax_totals();
		$tmpOrder['Taxes'] = $order->get_taxes();
		$tmpOrder['Total'] = $order->get_total();
		$tmpOrder['TotalDiscount'] = $order->get_total_discount();
		$tmpOrder['TotalTax'] = $order->get_total_tax();
		$tmpOrder['TotalRefunded'] = $order->get_total_refunded();
		$tmpOrder['TotalTaxRefunded'] = $order->get_total_tax_refunded();
		$tmpOrder['TotalShippingRefunded'] = $order->get_total_shipping_refunded();
		$tmpOrder['Items'] = [];
		$tmpOrderItem = [];
		foreach ($order->get_items() as $item_id => $item) {
			$tmpOrderItem["ProductId"] = '' . $item->get_product_id();
			$tmpOrderItem["VariationId"] = '' . $item->get_variation_id();
			//$tmpOrderItem["product = $item->get_product(); // see link above to get $product info
			$tmpOrderItem["ProductName"] = $item->get_name();
			$tmpOrderItem["Quantity"] = '' . $item->get_quantity();
			$tmpOrderItem["Subtotal"] = $item->get_subtotal();
			$tmpOrderItem["Total"] = $item->get_total();
			$tmpOrderItem["Tax"] = $item->get_subtotal_tax();
			$tmpOrderItem["TaxClass"] = $item->get_tax_class();
			$tmpOrderItem["TaxStatus"] = $item->get_tax_status();
			$tmpOrderItem["ItemType"] = $item->get_type(); // e.g. "line_item", "fee"
			$tmpOrder['Items'][] = $tmpOrderItem;
		}

		$tmpOrders[] = $tmpOrder;
	}

	return $tmpOrders;

	/*return array(
															  'orderby'    => 'date',
															  'order'      => 'DESC',
															  'post_type'  => 'shop_order',
															  'limit'      => 2,
															  'meta_query' => [
																  [
																	  'key'     => "SHELF-PLANNER-CONNECTOR-SYNC",
																	  'value'   => 0,
																	  'compare' => 'NOT EXISTS',
																  ],
															  ],
															  'include' =>  $params['IDS'] 
														  );*/
	/*$orders = wc_get_orders(array(
															  'include' 	=>  array{106,207,83},
															  'orderby'    => 'date',
															  'order'      => 'DESC',
															  'post_type'  => 'shop_order',
															  'limit'      => 10
															  
															   
														  ));*/

	if ($orders) {
		$order_ids = [];

		foreach ($orders as $order) {
			$order_ids[] = $order->get_id();
		}

		//sp_payment_complete($order_ids);
	}

	global $wpdb;
	$order_status = array('wc-completed');
	$data = $wpdb->get_results($wpdb->prepare("
	SELECT ID
	FROM {$wpdb->posts} AS posts
	WHERE posts.post_type = 'shop_order'
	AND posts.post_status IN ( 'wc-completed' ) order by post_date", ARRAY_A));

	return (array_map('intval', array_column($data, 'ID')));
	//return implode(',', $data);
}

function get_products_detail_v2($data)
{
	// Validate request auth
	spcApiLog("GetProductDetail call parameters:" . json_encode($data->get_json_params()));
	if (!validate_request_auth($data)) {
		return [];
	}

	$ar_return = [];

	/*$args = array(
												  'orderby' => 'name', 
												  'limit' => -1, // Retrieves all products
											  );
											  $products = wc_get_products($args);
										  */
	$tmpProduct = [];
	$tmpSubProducts = [];

	foreach ($data['IDS'] as $productId) {
		$product = wc_get_product($productId);
		$tmpProduct['Title'] = $product->get_name();
		$tmpProduct['Id'] = '' . $product->get_id();
		$tmpProduct['Type'] = $product->get_type();



		$tmpProduct['Categories'] = array_map('strval', $product->get_category_ids());
		$tmpProduct['DateCreated'] = $product->get_date_created();
		$tmpProduct['DateModified'] = $product->get_date_modified();
		$tmpProduct['DateCreatedTimestamp'] = isset($tmpProduct['DateCreated']) ? $tmpProduct['DateCreated']->getTimestamp() : null;
		$tmpProduct['DateModifiedTimestamp'] = isset($tmpProduct['DateModified']) ? $tmpProduct['DateModified']->getTimestamp() : null;
		$tmpProduct['SKU'] = $product->get_sku();
		$tmpProduct['Price'] = $product->get_price();
		$tmpProduct['RegularPrice'] = $product->get_regular_price();
		$tmpProduct['SalePrice'] = $product->get_sale_price();
		$tmpProduct['TotalSales'] = '' . $product->get_total_sales();
		$tmpProduct['TaxStatus'] = $product->get_tax_status();
		$tmpProduct['TaxClass'] = $product->get_tax_class();
		$tmpProduct['ManageStock'] = $product->get_manage_stock();
		$tmpProduct['StockQuantity'] = $product->get_stock_quantity();
		$tmpProduct['StockStatus'] = $product->get_stock_status();
		$tmpProduct['Backorders'] = $product->get_backorders();
		$tmpProduct['Pid'] = '' . $product->get_parent_id();
		$tmpProduct['Childs'] = array_map('strval', $product->get_children());
		$tmpProduct['ThumbUri'] = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail')[0];
		$ar_return[] = $tmpProduct;
		foreach ($tmpSubProducts as $tmpSubProduct) {
			$ar_return[] = $tmpSubProduct;
		}

		$tmpSubProducts = [];
	}

	return $ar_return;
}

function get_products_list($data)
{
	// Validate request auth
	if (!validate_request_auth($data)) {
		return [];
	}

	$ar_return = [];

	$args = array(
		'orderby' => 'name',
		'limit' => -1, // Retrieves all products
	);
	$products = wc_get_products($args);

	$tmpProduct = [];
	$tmpSubProducts = [];

	foreach ($products as $product) {
		$tmpProduct['Title'] = $product->get_name();
		$tmpProduct['Id'] = '' . $product->get_id();
		$tmpProduct['Type'] = $product->get_type();

		if ($tmpProduct['Type'] == "variable") {
			$variations = $product->get_available_variations('objects');
			$tmpSubProducts = [];
			foreach ($variations as $variation) {
				$tmpSubProduct['Title'] = $variation->get_name();
				$tmpSubProduct['Id'] = '' . $variation->get_id();
				$tmpSubProduct['Type'] = $variation->get_type();
				$tmpSubProduct['Categories'] = array_map('strval', $variation->get_category_ids());
				$tmpSubProduct['DateCreated'] = $variation->get_date_created();
				$tmpSubProduct['DateModified'] = $variation->get_date_modified();
				$tmpSubProduct['SKU'] = $variation->get_sku();
				$tmpSubProduct['Price'] = $variation->get_price();
				$tmpSubProduct['RegularPrice'] = $variation->get_regular_price();
				$tmpSubProduct['SalePrice'] = $variation->get_sale_price();
				$tmpSubProduct['TotalSales'] = '' . $variation->get_total_sales();
				$tmpSubProduct['TaxStatus'] = $variation->get_tax_status();
				$tmpSubProduct['TaxClass'] = $variation->get_tax_class();
				$tmpSubProduct['ManageStock'] = $variation->get_manage_stock();
				$tmpSubProduct['StockQuantity'] = $variation->get_stock_quantity();
				$tmpSubProduct['StockStatus'] = $variation->get_stock_status();
				$tmpSubProduct['Backorders'] = $variation->get_backorders();
				$tmpSubProduct['Pid'] = '' . $variation->get_parent_id();
				$tmpSubProduct['Childs'] = array_map('strval', $variation->get_children());
				$tmpSubProduct['ThumbUri'] = wp_get_attachment_image_src(get_post_thumbnail_id($variation->get_id()), 'single-post-thumbnail')[0];
				$tmpSubProducts[] = $tmpSubProduct;
			}
		}

		$tmpProduct['Categories'] = array_map('strval', $product->get_category_ids());
		$tmpProduct['DateCreated'] = $product->get_date_created();
		$tmpProduct['DateModified'] = $product->get_date_modified();
		$tmpProduct['SKU'] = $product->get_sku();
		$tmpProduct['Price'] = $product->get_price();
		$tmpProduct['RegularPrice'] = $product->get_regular_price();
		$tmpProduct['SalePrice'] = $product->get_sale_price();
		$tmpProduct['TotalSales'] = '' . $product->get_total_sales();
		$tmpProduct['TaxStatus'] = $product->get_tax_status();
		$tmpProduct['TaxClass'] = $product->get_tax_class();
		$tmpProduct['ManageStock'] = $product->get_manage_stock();
		$tmpProduct['StockQuantity'] = $product->get_stock_quantity();
		$tmpProduct['StockStatus'] = $product->get_stock_status();
		$tmpProduct['Backorders'] = $product->get_backorders();
		$tmpProduct['Pid'] = '' . $product->get_parent_id();
		$tmpProduct['Childs'] = array_map('strval', $product->get_children());
		$tmpProduct['ThumbUri'] = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail')[0];
		$ar_return[] = $tmpProduct;
		foreach ($tmpSubProducts as $tmpSubProduct) {
			$ar_return[] = $tmpSubProduct;
		}

		$tmpSubProducts = [];
	}

	return $ar_return;
}

function get_store_info($data)
{
	// Validate request auth
	if (!validate_request_auth($data)) {
		return null;
	}
	global $spc_helper;
	$sp_payload = $spc_helper->get_store_info();
	return $sp_payload;
}

function ping($data)
{
	// Validate request auth
	if (!validate_request_auth($data)) {
		return null;
	}

	return "pong";
}

function validate_request_auth_website_url($data)
{
	global $spc_helper;

	// Verify WebsiteUrl validity
	if ($spc_helper->get_website_url() != $data['WebsiteUrl']) {
		spcApiLog("ERROR SITE: doesn't match ");
		return false;
	}

	return true;
}

function validate_request_auth_website_url_server_key($data)
{
	global $spc_helper;

	// Verify WebsiteUrl validity
	if ($spc_helper->get_website_url() != $data['WebsiteUrl']) {
		spcApiLog("ERROR SITE: doesn't match ");
		return false;
	}

	// Verify ServerKey validity
	if ($spc_helper->get_server_key() != $data['ServerKey']) {
		spcApiLog("ERROR SERVER: doesn't match ");
		return false;
	}

	return true;
}

function validate_request_auth($data)
{
	global $spc_helper;

	// Verify WebsiteUrl validity
	if ($spc_helper->get_website_url() != $data['WebsiteUrl']) {
		spcApiLog("ERROR SITE: doesn't match ");
		return false;
	}

	// Verify ServerKey validity
	if ($spc_helper->get_server_key() != $data['ServerKey']) {
		spcApiLog("ERROR SERVER: doesn't match ");
		return false;
	}

	// Verify LicenseKey validity
	if ($spc_helper->get_license_key() != $data['LicenseKey']) {
		spcApiLog("ERROR LICENSE doesn't match ");
		return false;
	}

	return true;
}

function setup_connector_helo($data)
{
	global $spc_helper;

	// Verify WebsiteUrl validity
	if ($spc_helper->get_website_url() != $data['WebsiteUrl']) {
		return;
	}
	// Set serverKey
	spcApiLog("HELO: " . $spc_helper->get_website_url());
	$spc_helper->set_server_key($data['ServerKey']);
}

function setup_connector($data)
{
	global $spc_helper;

	// Verify WebsiteUrl validity
	if ($spc_helper->get_website_url() != $data['WebsiteUrl']) {
		return;
	}

	// Verify ServerKey validity
	if ($spc_helper->get_server_key() != $data['ServerKey']) {
		return;
	}

	// Set licenseKey
	$spc_helper->set_license_key($data['LicenseKey']);
}

/**
 * Description.
 *
 * @param $data
 * @param string $type
 */

define('LOG_FILE', dirname(__FILE__) . '/logs/' . gmdate('Y-m-d') . '.log');

function spcApiLog($data, $type = 'info')
{
	global $spc_helper;

	$log_enabled = get_option($spc_helper->get_plugin_slug() . '_enable_logs', 'checked');
	if ('checked' == $log_enabled) {
		$data = gmdate('[d.m.Y H:i:s]') . ' ' . $data . PHP_EOL;
		file_put_contents(LOG_FILE, $data, FILE_APPEND);
	}
}

add_action('wp_ajax_spc-ajax', 'find_spc_ajax__ajax_callback');
function find_spc_ajax__ajax_callback()
{
	global $spc_helper;
	$plugin_slug = $spc_helper->get_plugin_slug();

	if (isset($_GET['optimized_wc_tables'])) {
		if ('true' == sanitize_text_field(empty($_GET['optimized_wc_tables']) ? '' : $_GET['optimized_wc_tables'])) {
			update_option($plugin_slug . '_optimized_wc_tables', 'checked');
		} else {
			update_option($plugin_slug . '_optimized_wc_tables', 'false');
		}
	} elseif (isset($_GET['log'])) {
		if ('true' == sanitize_text_field(empty($_GET['log']) ? '' : $_GET['log'])) {
			update_option($plugin_slug . '_enable_logs', 'checked');
		} else {
			update_option($plugin_slug . '_enable_logs', 'false');
		}
	}
	exit;
}

add_action('rest_api_init', function () {
	register_rest_route(
		'shelf-planner-connector/v1',
		'/store/info',
		array(
			'methods' => 'POST',
			'callback' => 'get_store_info',
			'permission_callback' => 'validate_request_auth',
		)
	);

	register_rest_route(
		'shelf-planner-connector/v1',
		'/setup/helo',
		array(
			'methods' => 'POST',
			'callback' => 'setup_connector_helo',
			'permission_callback' => 'validate_request_auth_website_url',
		)
	);

	register_rest_route(
		'shelf-planner-connector/v1',
		'/setup',
		array(
			'methods' => 'POST',
			'callback' => 'setup_connector',
			'permission_callback' => 'validate_request_auth_website_url_server_key',
		)
	);

	register_rest_route(
		'shelf-planner-connector/v1',
		'/author/(?P<id>\d+)',
		array(
			'methods' => 'POST',
			'callback' => 'my_awesome_func',
			'permission_callback' => 'validate_request_auth',
		)
	);

	register_rest_route(
		'shelf-planner-connector/v1',
		'/sync/categories/',
		array(
			'methods' => 'POST',
			'callback' => 'get_categories_list',
			'permission_callback' => 'validate_request_auth',
		)
	);

	register_rest_route(
		'shelf-planner-connector/v1',
		'/sync/products/',
		array(
			'methods' => 'POST',
			'callback' => 'get_products_list',
			'permission_callback' => 'validate_request_auth',
		)
	);


	register_rest_route(
		'shelf-planner-connector/v1',
		'/sync/products/init',
		array(
			'methods' => 'POST',
			'callback' => 'get_products_list_v2',
			'permission_callback' => 'validate_request_auth',
		)
	);


	register_rest_route(
		'shelf-planner-connector/v1',
		'/sync/products/detail',
		array(
			'methods' => 'POST',
			'callback' => 'get_products_detail_v2',
			'permission_callback' => 'validate_request_auth',
		)
	);



	register_rest_route(
		'shelf-planner-connector/v1',
		'/sync/orders/init',
		array(
			'methods' => 'POST',
			'callback' => 'get_order_list',
			'permission_callback' => 'validate_request_auth',
		)
	);

	register_rest_route(
		'shelf-planner-connector/v1',
		'/sync/orders/detail',
		array(
			'methods' => 'POST',
			'callback' => 'get_order_detail',
			'permission_callback' => 'validate_request_auth',
			'args' => array(
				'IDS' => array(
					'required' => true,
					//'validate_callback' => 'my_custom_validation_function'
				),
				// Aggiungi altri parametri qui se necessario
			),
		)
	);

	register_rest_route(
		'shelf-planner-connector/v1',
		'/products/stock/add',
		array(
			'methods' => 'PUT',
			'callback' => 'add_product_stock',
			'permission_callback' => 'validate_request_auth',
			'args' => array(
				'ProductId' => array(
					'required' => true,
				),
				'Stock' => array(
					'required' => true,
				),
			),
		)
	);

	register_rest_route(
		'shelf-planner-connector/v1',
		'/products/stock/update',
		array(
			'methods' => 'PUT',
			'callback' => 'update_product_stock',
			'permission_callback' => 'validate_request_auth',
			'args' => array(
				'ProductId' => array(
					'required' => true,
				),
				'Stock' => array(
					'required' => true,
				),
			),
		)
	);

	register_rest_route(
		'shelf-planner-connector/v1',
		'/products/stock/track/update',
		array(
			'methods' => 'PUT',
			'callback' => 'update_products_track_stock',
			'permission_callback' => 'validate_request_auth',
		)
	);

	register_rest_route(
		'shelf-planner-connector/v1',
		'/sync/orders/',
		array(
			'methods' => 'POST',
			'callback' => 'dummy_response_func',
			'permission_callback' => 'validate_request_auth',
		)
	);

	register_rest_route(
		'shelf-planner-connector/v1',
		'/ping',
		array(
			'methods' => 'GET',
			'callback' => 'ping',
			'permission_callback' => 'validate_request_auth',
		)
	);

	register_rest_route(
		'shelf-planner-connector/v1',
		'/ping',
		array(
			'methods' => 'POST',
			'callback' => 'ping',
			'permission_callback' => 'validate_request_auth',
		)
	);
});

add_action('woocommerce_update_product', 'connector_product_update', 10, 2);
function connector_product_update($product_id, $product)
{
	global $spc_helper;
	if (!$spc_helper->has_license_key()) {
		return;
	}
	$updating_product_id = 'update_product_' . $product_id;
	if (false === ($updating_product = get_transient($updating_product_id))) {
		set_transient($updating_product_id, $product_id, 2); // change 2 seconds if not enough
		spcApiLog('PRODUCT UPDATED! PRODUCT_ID: ' . $product_id);
		$spc_helper->send_product_update_sync_request($product_id);
	}
}

add_action('woocommerce_order_status_completed', 'connector_order_completed');
function connector_order_completed($order_id)
{
	global $spc_helper;
	if (!$spc_helper->has_license_key()) {
		return;
	}
	spcApiLog('ORDER COMPLETED! ORDER_ID: ' . $order_id);
	$spc_helper->send_order_completed_sync_request($order_id);
}

/**
 * The core plugin class that is used to define internationalization
 */
require plugin_dir_path(__FILE__) . 'includes/class-shelf-planner-connector.php';

/**
 * Begins execution of the plugin.
 * 
 * @since    	0.0.1
 * @version		0.0.1
 */
function run_shelf_planner_connector()
{
	$plugin = new Shelf_Planner_Connector();
	$plugin->run();
}
run_shelf_planner_connector();