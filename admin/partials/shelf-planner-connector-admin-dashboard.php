<?php
/**
 * Area view for the plugin: Dashboard
 *
 * @link		https://www.shelfplanner.com
 * @since		2.0.0
 * @version		2.0.0
 * @package		Shelf_Planner_Connector
 * @subpackage	Shelf_Planner_Connector/admin/partials
 * @author		Shelf Planner <service@shelfplanner.com>
 */

$this->admin_permission_check();

?>
<style>
	.spc_setup {
		color: #ffffff;
		background-color: #ac6078;
		font-size: 19px;
		border: 1px solid #ac6078;
		border-radius: 16px;
		padding: 15px 50px;
		cursor: pointer;
		text-decoration: none;
	}

	.spc_setup:hover {
		color: #ac6078;
		background-color: #ffffff;
	}

	.spc_my {
		color: #ffffff;
		background-color: #9DAB8A;
		font-size: 19px;
		border: 1px solid #9DAB8A;
		border-radius: 16px;
		padding: 15px 50px;
		cursor: pointer;
		text-decoration: none;
	}

	.spc_my:hover {
		color: #9DAB8A;
		background-color: #ffffff;
	}
</style>

<div class="wrap bft_wrap">
	<h1>
		<?php echo esc_html_e($title); ?>
	</h1>
	<?php
	global $spc_helper;
	$imgSrc = plugin_dir_url(__FILE__) . "../" . "img/woo_sp_connector.png";

	if ($spc_helper->get_server_key() == "") {
		$spc_helper->activate();
	}
	?>

	<table>
		<tr>
			<td style="width: 350px; text-align: center; vertical-align: middle;">
				<img src="<?php echo $imgSrc; ?>">
			</td>

			<?php if ($spc_helper->has_license_key()) { ?>
				<td>
					<h1>Your store + Shelf Planner integration is connected!</h1>
					Open your Shelf Planner account to get live sales forecasts and recommendations on how to improve your
					inventory.
					<br /><br /><br /><a class="spc_my" href="<?php echo $spc_helper->get_app_url(); ?>"
						target="_blank">Login to your account</a>
				</td>
			<?php } else { ?>
				<td>
					<h1>Create your Shelf Planner account to use the Shelf Planner + WooCommerce integration</h1>
					Synchronise stock between all your locations, create purchase orders and optimise your inventory with
					Shelf Planner. Log in to authorise your account.
					New to Shelf Planner and want to learn more? Check out <a
						href="https://support.shelfplanner.com/en/article/installation-inventory-management-for-woocommerce"
						target="_blank">How to get started with WooCommerce</a> on our support portal.
					<br /><br /><br /><a class="spc_setup" href="<?php echo $spc_helper->get_setup_url(); ?>"
						target="_blank">Create your account</a>
				</td>
			<?php } ?>
		</tr>
	</table>
	<?php
		if ($spc_helper->get_env() == 'LOCALDEV' || $spc_helper->get_env() == 'DEV') {
			echo "<br /><br /><fieldset style='border: 1px solid black; padding: 8px;'><legend>Dev Info</legend>";
			echo "<p><strong>Slug:</strong> " . $spc_helper->get_plugin_slug() . "</p>";
			echo "<p><strong>WebsiteUrl:</strong> " . $spc_helper->get_website_url() . "</p>";
			echo "<p><strong>ServerKey:</strong> " . $spc_helper->get_server_key() . "</p>";
			echo "<p><strong>LicenseKey:</strong> " . $spc_helper->get_license_key() . "</p>";
			echo "<p><strong>ApiUrl:</strong> " . $spc_helper->get_api_url() . "</p>";
			echo "<p><strong>AppUrl:</strong> " . $spc_helper->get_app_url() . "</p></fieldset>";
		}
	?>
</div>