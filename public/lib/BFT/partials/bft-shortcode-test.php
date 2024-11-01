<?php

/**
 * Display a shortcode test
 *
 * @link		https://moisesbarrachina.online
 * @since		1.0.0
 * @version		1.1.0
 * @package		BFT
 * @subpackage	BFT/public/lib/BFT/partials
 * @author		Moisés Barrachina Planelles <info@moisesbarrachina.online>
*/

?>

<div>
    <h3>BFT: <?php echo $this->esc_html_e("Hello World")?>, <?php echo $this->esc_html_e("this is a static and cacheable text")?></h3>
    <?php echo $html_aux?>
</div>