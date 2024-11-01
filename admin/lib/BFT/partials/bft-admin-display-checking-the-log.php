<?php

/**
 * Explaining how to check the log
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
	<p><?php echo $this->esc_html_e("The log in WordPress is activated in")?> <b>wp-config.php</b>, <?php echo $this->esc_html_e("change")?>:
	</p>
	<ul>
		<li><b>define( 'WP_DEBUG', true );</b></li>
		<li><b>define( 'WP_DEBUG_LOG', true );</b></li>
	</ul>
	<p><?php echo $this->esc_html_e("Now you can check the log in")?> <b>wp-content/debug.log</b></p>
	<p><?php echo $this->esc_html_e("For printing to the log you can use the WordPress function")?> <b>error_log($string_or_number)</b>, <?php echo $this->esc_html_e("but with Backend Frontend Template you can use")?>:  <b>$this->debug_log_write($whatever)</b></p>
	<p><b>$this->debug_log_write()</b> <?php echo $this->esc_html_e("it's a better option because it shows")?>:
	</p>
	<ul>
		<li>'NULL' <?php echo $this->esc_html_e("if its a NULL variable")?></li>
		<li>'TRUE' <?php echo $this->esc_html_e("and")?> 'FALSE' <?php echo $this->esc_html_e("if it's a boolean")?></li>
		<li>print_r() <?php echo $this->esc_html_e("if it's an array or object")?></li>
	</ul>
	<p><?php echo $this->esc_html_e("Now you can print in the log whatever variable you want")?></p>
	<p><?php echo $this->esc_html_e("Also BFT offers an alternative name for")?> debug_log_write: <b>$this->write_log()</b>
	</p>
</div>