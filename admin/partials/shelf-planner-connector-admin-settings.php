<?php

/**
 * Area view for the plugin: Hello World page
 *
 * @link		https://www.shelfplanner.com
 * @since		0.0.1
 * @version		0.0.1
 * @package		Shelf_Planner_Connector
 * @subpackage	Shelf_Planner_Connector/admin/partials
 * @author		Shelf Planner <service@shelfplanner.com>
 */

/*
	Uses Backend Frontend Template 1.0.0
	https://moisesbarrachina.online
*/

//Hello world

//Log of $this->admin_pages
//$this->debug_log_write($this->admin_pages); 

//PHP text translated:
//$this->__("string");

//PHP text translated and HTML escaped 
//$this->esc_html_e("string");

// function toInteger($string)
// {
// 	sscanf($string, '%u%c', $number, $suffix);
// 	if (isset($suffix)) {
// 		$number = $number * pow(1024, strpos(' KMG', strtoupper($suffix)));
// 	}
// 	return $number;
// }
global $woocommerce;


$this->admin_permission_check();
?>
<div class="wrap bft_wrap">
	<h1>
		<?php echo esc_html_e($this->admin_title); ?>
	</h1>
	<p>
		<?php
		$licenseKey = get_option($this->plugin_slug . '_license_key');
		$serverKey = get_option($this->plugin_slug . '_server_key');
		$logging = get_option($this->plugin_slug . '_enable_logs');
		$websiteUrl = get_site_url();

		//echo "<p><strong>Logs:</strong> " . $logging . "</p>";
		
		//echo "<p><strong>optimized wc tables:</strong> " . $optimized_wc_tables . "</p>";
		/*
					echo ("<br>");
					echo ("<br>");
					echo ("<pre>");
					var_dump($woocommerce);
					echo ("</pre>");
					*/
		?>
	<div><label class="ckbox"><input <?php echo esc_attr(get_option($this->plugin_slug . '_enable_logs', '')); ?>
				type="checkbox"
				onchange='jQuery.get(ajaxurl, {"action": "spc-ajax", "log": jQuery(this).prop("checked")});'><span
				style="display: inline-block;padding-top: 3px;"><?php echo esc_html(__('Enable debug logging', 'shelf-planner-connector')); ?></span></label>
	</div>
	</p>
</div>