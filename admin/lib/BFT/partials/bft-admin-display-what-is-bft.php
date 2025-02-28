<?php

/**
 * Explaining what is Backend Frontend Template
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
	<p>Backend Frontend Template <?php echo $this->esc_html_e("is a template and library")?> <b><?php echo $this->esc_html_e("for develop WordPress plugins easily and quickly")?></b>. <?php echo $this->esc_html_e("Save time, do more")?></p>
	<p><?php echo $this->esc_html_e("It's not needed to know all the")?> <a target="_blank" href="https://developer.wordpress.org/plugins/intro/"><?php echo $this->esc_html_e("WordPress developer plugin documentation")?></a>, <?php echo $this->esc_html_e("with this template/library you can develop your plugin now only following the")?> <a target="_blank" href="<?php echo admin_url()."admin.php?page=".$this->plugin_slug?>_quick_guide"><?php echo $this->esc_html_e("first steps page")?></a></p>
	<hr>
	<p><?php echo $this->esc_html_e("Backend Frontend Template is available on GitHub")?> <a href="https://github.com/moisesbarrachina/Backend-Frontend-Template-the-WordPress-Plugin-Template" target="_blank"><?php echo $this->esc_html_e("here")?></a></p>
	<hr>
	<p><b><?php echo $this->esc_html_e("Do you want more capabilities/possibilities and save more time?")?></b>, <?php echo $this->esc_html_e("check")?> <a href="<?php echo admin_url()?>admin.php?page=<?php echo $this->plugin_slug?>_want_more" target="_blank">Backend Frontend Template Pro</a></p>
	<p>BFT <?php echo $this->esc_html_e("and")?> BFT Pro <?php echo $this->esc_html_e("are libraries in continuous growth and developed by")?> <a target="_blank" href="https://moisesbarrachina.online/">Moisés Barrachina Planelles</a></p>
</div>