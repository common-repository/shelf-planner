<?php

/**
 * Explaining the next updates
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
	<div>
		<h3>1.1.0</h3>
		<p>2023-10-02</p>
		<h4>BFT <?php echo $this->esc_html_e("and")?> BFT Pro</h4>
		<ul>
			<li><?php echo $this->esc_html_e("Example images are now loaded from moisesbarrachina.online to make the plugin lighter")?></li>
			<li><?php echo $this->esc_html_e("Improved explanation and readability of texts")?></li>
			<li><?php echo $this->esc_html_e("Fixed typos")?></li>
		</ul>
		<h4><?php echo $this->esc_html_e("Upgrade guide")?></h4>
		<p><?php echo $this->esc_html_e("Select the entire plugin, give to find and replace, select Caps Match and Replace")?></p>
		<ul>
			<li>“only_on” <?php echo $this->esc_html_e("by")?> “only_in"</li>
			<li>“admin_forms_relations_many_to_many” <?php echo $this->esc_html_e("by")?> “admin_forms_many_to_many_relationships"</li>
			<li>“relation_many_to_many” <?php echo $this->esc_html_e("by")?> “many_to_many_relationship"</li>
			<li>“aditional_text” <?php echo $this->esc_html_e("by")?> “additional_text"</li>
		</ul>
	</div><div>
		<h3>1.0.0</h3>
		<p>2023-09-14</p>
		<p><?php echo $this->esc_html_e("First stable version of Backend Frontend Template")?></p>
		<h4>BFT</h4>
		<ul>
			<li><?php echo $this->esc_html_e("Menú system")?></li>
			<li><?php echo $this->esc_html_e("Log manipulation")?></li>
			<li><?php echo $this->esc_html_e("Error manipulation")?></li>
			<li><?php echo $this->esc_html_e("Internationalization")?></li>
			<li><?php echo $this->esc_html_e("Frontend system by shortcode")?></li>
			<li><?php echo $this->esc_html_e("Internalization into Spanish")?></li>
		</ul>
		<h4>BFT Pro</h4>
		<ul>
			<li><?php echo $this->esc_html_e("Menu system with children")?></li>
			<li><?php echo $this->esc_html_e("Settings system")?></li>
			<li><?php echo $this->esc_html_e("Inputs system: text, textarea, number, select, select multiple, date, checkbox, checkbox multiple, radio, image, file and input comented")?></li>
			<li><?php echo $this->esc_html_e("Example database")?></li>
			<li><?php echo $this->esc_html_e("Install and deinstall plugin database")?></li>
			<li><?php echo $this->esc_html_e("Automated data manipulation")?></li>
			<li><?php echo $this->esc_html_e("Manual data manipulation")?></li>
			<li><?php echo $this->esc_html_e("Paginated listing by query")?></li>
			<li><?php echo $this->esc_html_e("Direct listing by array")?></li>
			<li><?php echo $this->esc_html_e("Manual form")?></li>
			<li><?php echo $this->esc_html_e("Log manipulation")?></li>
			<li><?php echo $this->esc_html_e("Error manipulation")?></li>
			<li><?php echo $this->esc_html_e("Internationalization")?></li>
			<li><?php echo $this->esc_html_e("Download system for private files")?></li>
			<li><?php echo $this->esc_html_e("Iframe system")?></li>
			<li><?php echo $this->esc_html_e("PDF by iframe system")?></li>
			<li><?php echo $this->esc_html_e("Frontend system by shortcode")?></li>
			<li><?php echo $this->esc_html_e("AJAX frontend system")?></li>
			<li><?php echo $this->esc_html_e("Internalization into Spanish")?></li>
		</ul>
	</div>
</div>