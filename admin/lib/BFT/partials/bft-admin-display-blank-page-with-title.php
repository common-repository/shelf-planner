<?php

/**
 * Area view for the plugin: blank page with the menu tabs and page title
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
<div class="wrap bft_wrap">
	<h1><?php echo $this->esc_html_e($this->admin_title)?></h1>
	<?php echo $this->html_tabs(false)?>
	<h2><?php echo $this->esc_html_e($title)?></h2>
</div>