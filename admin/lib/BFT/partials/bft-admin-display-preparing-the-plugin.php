<?php

/**
 * Explaining how chante BFT to a custom plugin
 *
 * @link		https://moisesbarrachina.online
 * @since		1.0.0
 * @version		1.1.0
 * @package		BFT
 * @subpackage	BFT/admin/lib/BFT/partials
 * @author		Moisés Barrachina Planelles <info@moisesbarrachina.online>
*/

$this->admin_permission_check();
?>
<div class="wrap bft_wrap bft_wrap_ol_ul">
	<h1><?php echo $this->esc_html_e($this->admin_title)?></h1>
	<?php echo $this->html_tabs(false)?>
	<h2><?php echo $this->esc_html_e($title)?></h2>
	<ol>
		<li>
			<h3><?php echo $this->esc_html_e("Make the plugin your own")?></h3>
			<ol>
				<li><?php echo $this->esc_html_e("Change the files of")?> wp-content/plugins/backend-frontend-template <?php echo $this->esc_html_e("with the id of your plugin")?> (<?php echo $this->esc_html_e("like");?> 'a-plugin-name')</li>
				<li><?php echo $this->esc_html_e("Delete the files or change their extension")?>: 
					<ol>
						<li><b>wp-content/plugins/backend-frontend-template/backend-frontend-template.php</b></li>
						<li><b>wp-content/plugins/backend-frontend-template/includes/class-bft.php</b></li>
					</ol>
				</li>
				<li><?php echo $this->esc_html_e("Change the extension of the files to PHP")?>:
					<ol>
						<li><b>wp-content/plugins/backend-frontend-template/shelf-planner-connector.txt</b></li>
						<li><b>wp-content/plugins/backend-frontend-template/includes/class-shelf-planner-connector.txt</b></li>
					</ol>
				</li>
				<li><?php echo $this->esc_html_e("Uncomment")?>: "<b>//$this->admin_pages_main_name = $this->plugin_title;</b> on <b>wp-content/plugins/backend-frontend-template/admin/class-shelf-planner-connector-admin.php</b></li>
				<li><?php echo $this->esc_html_e("Find and replace all the file names with")?> <b>'shelf-planner-connector'</b> <?php echo $this->esc_html_e("like")?> 'class-shelf-planner-connector.php' <?php echo $this->esc_html_e("to your plugin id")?>, <?php echo $this->esc_html_e("example")?>: 'class-a-plugin-name.php'.</li>
				<li><?php echo $this->esc_html_e("On")?> <b>wp-content/plugins/backend-frontend-template/languages</b> <?php echo $this->esc_html_e("replace the file names with")?> <b>'shelf-planner-connector'</b> <?php echo $this->esc_html_e("to")?> 'shelf-planner-connector', <?php echo $this->esc_html_e("example")?>: 'a-plugin-name-es_ES.mo'</li>
				<li><?php echo $this->esc_html_e("Go to search and replace of your editor, active 'match case' and replace these strings")?>:
					<ol>
						<li><b>'shelf-planner-connector'</b> <?php echo $this->esc_html_e("to")?> <b>'shelf-planner-connector'</b></li>
						<li><b>'$plugin_slug = "shelf_planner_connector"'</b> <?php echo $this->esc_html_e("to")?> <b>$plugin_slug = "shelf_planner_connector"</b></li>
						<li><b>'shelf_planner_connector_shortcode'</b> <?php echo $this->esc_html_e("to")?> <b>shelf_planner_connector_shortcode</b></li>
						<li><b>'shelf-planner-connector-shortcode'</b> <?php echo $this->esc_html_e("to")?> <b>shelf-planner-connector-shortcode</b></li>
					</ol>
				</li>
				<li><?php echo $this->esc_html_e("Go to search and replace of your editor, active 'match case' and replace the words with the names and ids of your plugin")?>:
					<ol>
						<li><b>Shelf Planner Connector description</b></li>
						<li><b>https://www.shelfplanner.com/</b></li>
						<li><b>https://www.shelfplanner.com</b></li>
						<li><b>Shelf Planner</b></li>
						<li><b>service@shelfplanner.com</b></li>
						<li><b>Shelf Planner Connector</b></li>
						<li><b>shelf_planner_connector</b></li>
						<li><b>Shelf_Planner_Connector</b></li>
						<li><b>shelf-planner-connector</b></li>
						<li><b>SHELF_PLANNER_CONNECTOR</b></li>
					</ol>
				</li>
				<li><?php echo $this->esc_html_e("Replace the icon for you own on")?> <b>wp-content/plugins/backend-frontend-template/admin/img/icon-16px.png</b></li>
			</ol>
		</li>
		<li>
			<h3><?php echo $this->esc_html_e("Know the main plugin folders")?></h3>
			<ol>
				<li>/admin -> <?php echo $this->esc_html_e("administration folder")?></li>
				<li>/includes -> <?php echo $this->esc_html_e("global folder")?>, <?php echo $this->esc_html_e("for administration and plublic files")?></li>
				<li>/languages -> <?php echo $this->esc_html_e("translation files")?>, <?php echo $this->esc_html_e("these binarian files are made with programs like")?> <a href="https://poedit.net/" target="_blank">Poedit</a> <?php echo $this->esc_html_e("or")?> <a href="http://www.eazypo.ca/" target="_blank">Eazy Po</a></li>
				<li>/private -> <?php echo $this->esc_html_e("for sensitive data that only a download script can send the file to the user")?></li>
				<li>/admin -> <?php echo $this->esc_html_e("public folder")?></li>
			</ol>
		</li>
		<li>
			<h3><?php echo $this->esc_html_e("Know the plugin sub-folders")?></h3>
			<ol>
				<li>/css -> <?php echo $this->esc_html_e("CSS files")?></li>
				<li>/img -> <?php echo $this->esc_html_e("images")?></li>
				<li>/js -> <?php echo $this->esc_html_e("JavaScript files")?></li>
				<li>/lib -> <?php echo $this->esc_html_e("library")?>, <?php echo $this->esc_html_e("the internal BFT files are stored here")?></li>
				<li>/partials -> <?php echo $this->esc_html_e("frontend files")?></li>
			</ol>
		</li>
		<li>
			<h3><?php echo $this->esc_html_e("Know the main files")?> <span>(<?php echo $this->esc_html_e("using the original filenames")?>)</span></h3> 
			<ol>
				<li>/includes/<b>class-shelf-planner-connector.txt</b> -> <?php echo $this->esc_html_e("main class of the plugin")?></li>
				<li>/includes/<b>class-shelf-planner-connector-activator.php</b> -> <?php echo $this->esc_html_e("control when the plugin is activated")?></li>
				<li>/includes/<b>class-shelf-planner-connector-deactivator.php</b> -> <?php echo $this->esc_html_e("control when the plugin is deactivated")?></li>
				<li>/includes/<b>class-shelf-planner-connector-cronjobs.php</b> -> <?php echo $this->esc_html_e("control the cronjobs of the plugin")?></li>
				<li>/includes/<b>class-shelf-planner-connector-install-upgrade-deinstall-database.php</b> -> <?php echo $this->esc_html_e("install and erase the plugin database")?></li>
				<li>/includes/<b>class-shelf-planner-connector-functions-admin-public.php</b> -> <?php echo $this->esc_html_e("class with functions for admin and public classes")?>, <?php echo $this->esc_html_e("it's an extension of the BFT admin-public class")?></li>
				<li>/admin/<b>class-shelf-planner-connector-admin.php</b> -> <?php echo $this->esc_html_e("class for the admin section")?>, <?php echo $this->esc_html_e("it's an extension of the BFT admin-public class, your admin-public class and BFT admin class")?></li>
				<li>/public/<b>class-shelf-planner-connector-public.php</b> -> <?php echo $this->esc_html_e("class for the public section")?>, <?php echo $this->esc_html_e("it's an extension of the BFT admin-public class, your admin-public class and BFT public class")?></li>
			</ol>
		</li>
		<li>
			<h3><?php echo $this->esc_html_e("See the examples")?></h3>
			<ol>
				<li><?php echo $this->esc_html_e("On the next tabs you can see examples of how to work with Backend Frontend Template")?></li>
			</ol>
		</li>
	</ol>
</div>