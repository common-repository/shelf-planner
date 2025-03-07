<?php

/**
 * Explaining the menu system
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
	<p><?php echo $this->esc_html_e("Edit your menu in the variable")?> <b>$this->admin_pages</b> <?php echo $this->esc_html_e("of the file")?> <b>admin/class-shelf-planner-connector-admin.php</b></p>
	<p><?php echo $this->esc_html_e("Designing a BFT menu look like this")?>:</p>
	<pre>
	$this->admin_pages = [
		<!-- "hello_world" => [
			"page_title" => $this->__("Hello world page"),
			"menu_title" => $this->__("Hello world"),
			"file" => "shelf-planner-connector-admin-display-hello-world.php",
		], -->
		"blank_page" => [
			"page_title" => $this->__("Blank page"),
			"menu_title" => $this->__("Blank page"),
			"file" => "bft-admin-display-blank-page-with-title.php",
		],	
	];	
	</pre>
	<p><b>$this->admin_pages</b> <?php echo $this->esc_html_e("can have all the pages you want, but in BFT the admin pages can't have children, that's only possible on")?> <a href="<?php echo admin_url()?>admin.php?page=<?php echo $this->plugin_slug?>_want_more" target="_blank">Backend Frontend Template Pro</a></p>
	<p><?php echo $this->esc_html_e("Note")?>: <?php echo $this->esc_html_e("the array data is expanded by the function")?> <b>$this->admin_pages_prepare()</b>, <?php echo $this->esc_html_e("if you make an")?> <b>$this->debug_log_write($this->admin_pages)</b> <?php echo $this->esc_html_e("on a page: you can see the actual state of the array on the WordPress Log")?></p>
	<p><?php echo $this->esc_html_e("Explaining the WPTT menu")?>:</p>
	<ol>
		<li>
			<h3><?php echo $this->esc_html_e("Automatic parameters added to the array")?></h3>
			<ul>
				<li><b>id</b>: <?php echo $this->esc_html_e("the array key")?></li>
				<li><?php echo $this->esc_html_e("More automatic parameters on BFT Pro")?></li>
			</ul>
		</li>
		<li>
			<h3><?php echo $this->esc_html_e("Parametters with default data if missing")?></h3>
			<ul>
				<li><b>page_title</b>: <?php echo $this->esc_html_e("page title")?>, <?php echo $this->esc_html_e("default")?>: $this->admin_pages_page_title_default</li>
				<li><b>menu_title</b>: <?php echo $this->esc_html_e("page tab title")?>, <?php echo $this->esc_html_e("default")?>: $this->admin_pages_page_title_default</li>
				<li><b>menu_slug</b>: <?php echo $this->esc_html_e("page slug")?>, <?php echo $this->esc_html_e("default")?>: <?php echo $this->esc_html_e("key page")?>. <?php echo $this->esc_html_e("The menu slug will be changed to")?>: $this->admin_pages_slug_name_prefix."_".menu_slug <?php echo $this->esc_html_e("because it's needed a unique page name among the plugins")?></li>
				<li><b>tab_show</b>: <?php echo $this->esc_html_e("if false does not display the page tab, even if the page is selected")?>, <?php echo $this->esc_html_e("default")?>: true</li>
				<li><b>function</b>: <?php echo $this->esc_html_e("the function for when a page is displayed")?>, <?php echo $this->esc_html_e("default")?>: $this->admin_pages_function_default</li>
				<li><b>function_load</b>: <?php echo $this->esc_html_e("loads the function before a page is displayed")?>,<?php echo $this->esc_html_e("default")?>: $this->admin_pages_function_load_default</li>
				<li><b>file</b>: <?php echo $this->esc_html_e("the")?> admin/partials <?php echo $this->esc_html_e("file that will be displayed")?>, default: $this->admin_pages_file_default (<?php echo $this->esc_html_e("If the file starts with")?> 'bft-' <?php echo $this->esc_html_e("the file will be loaded of the folder")?> admin/lib/BFT/partials</li>
				<li><b>error_throw_what_do</b>, <?php echo $this->esc_html_e("it's used on error_throw")?>, <?php echo $this->esc_html_e("options")?>:
					<ul>
						<li><b>show_error</b>: <?php echo $this->esc_html_e("show the error")?> (<?php echo $this->esc_html_e("default option")?>)</li>
						<li><b>show_error_and_die</b>: <?php echo $this->esc_html_e("show the error and stop the execution")?></li>
						<li><b>go_to_parent</b>: <?php echo $this->esc_html_e("go to the parent page and anotes on the GET data the error")?> (<?php echo $this->esc_html_e("only works on")?> BFT Pro <?php echo $this->esc_html_e("and if")?> $triggered_on_function_load = true, <?php echo $this->esc_html_e("because on a normal WordPress function will cause the error")?>: 'Cannot modify header information - headers already sent')</li>
					</ul>
				</li>
				<li><b>error_throw_file_change</b>: <?php echo $this->esc_html_e("change the file option if")?> error_throw_what_do <?php echo $this->esc_html_e("is triggered")?>, <?php echo $this->esc_html_e("default")?>: false</li>
				<li><b>capability</b>, <?php echo $this->esc_html_e("default")?>: "manage_options", <?php echo $this->esc_html_e("WordPress capabilities")?>: https://wordpress.org/support/article/roles-and-capabilities/</li>
				<li><?php echo $this->esc_html_e("More parameters on BFT Pro")?></li>
			</ul>
		</li>
		<li>
			<h3><?php echo $this->esc_html_e("Available functions out of the box")?> (<?php echo $this->esc_html_e("you can create whatever function you need")?>)</h3>
			<ul>
				<li><b>admin_menu_page_display</b>: <?php echo $this->esc_html_e("displays the page selected on")?> 'file'</li>
				<li><?php echo $this->esc_html_e("More functions on")?> BFT Pro</li>
			</ul>
		</li>
		<li>
			<h3><?php echo $this->esc_html_e("Functions load available out of the box")?> (<?php echo $this->esc_html_e("you can create whatever function you need")?>)</h3>
			<ul>
				<li><?php echo $this->esc_html_e("More functions load on")?> BFT Pro</li>
			</ul>
		</li>
		<li>
			<h3><?php echo $this->esc_html_e("Optional parameters")?></h3>
			<ul>
				<li><b>page_copy_of</b>: <?php echo $this->esc_html_e("copy the data of a page. Only copy the data not found on the page, neither copy id, is_child, page_parent, menu_slug and children")?></li>
				<li><?php echo $this->esc_html_e("More optional parameters on")?> BFT Pro</li>
			</ul>
		</li>
		<li>
			<h3><?php echo $this->esc_html_e("Your own parameters")?></h3>
			<ul>
				<li>
					<?php echo $this->esc_html_e("You can create your own parameter, later on you can access to the info on a function or on a page with")?>:
					</br>
					<b>$variable_name = $this->admin_pages_data_get("parametter_name");</b>
					<p>
						<?php echo $this->esc_html_e("And if you want you can retrieve the data of a certain page with")?> $page_name, <?php echo $this->esc_html_e("and retrieve all the array data with")?> $key = false
						</br>
						<b>$variable_name = $this->admin_pages_data_get($key = false, $page_name = NULL)</b>
					</p>
				</li>
				<li>
					<?php echo $this->esc_html_e("You can set later your own parameter by code with")?>:
					</br>
					<b>$this->admin_pages_data_set($key, $data, $page_name = NULL)</b>
				</li>
			</ul>
		</li>
	</ol>
</div>