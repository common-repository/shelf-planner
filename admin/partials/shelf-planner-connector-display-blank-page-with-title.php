<?php

/**
 * Area view for the plugin: blank page with the menu tabs and page title
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

$this->admin_permission_check();
?>
<div class="wrap bft_wrap">
	<h1><?php echo $this->esc_html_e($this->admin_title)?></h1>
	<?php echo $this->html_tabs(false)?>
	<h2><?php echo $this->esc_html_e($title)?></h2>
</div>