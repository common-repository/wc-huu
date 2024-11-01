<?php
/**
 * @package Plugins Huu WP for WooCommerce
 */
if ( ! defined('ABSPATH') ) { exit; }

/* callback */  
function wc_huu_callback()  {

/* título */	
echo '<h1>'. __('Setup Huu WP for WooCommerce','wc-huu').'</h1><hr>';

/* update */
if ( isset( $_POST["wc_huusetup_submit"] ) and $_POST["wc_huusetup_submit"]=="enviar_setup" ){

if ( ! isset( $_POST['wc_huu_enviar_nonce'] ) || ! wp_verify_nonce( $_POST['wc_huu_enviar_nonce'], 'wc_huu_valornonce' ) ) {
   _e( 'Sorry, has a error. Try again.', 'wc-huu' );
   exit;
} else {

// dados para whatsapp
if ( $_POST['setup_huu_wts_prod_box_block_woo']<>"1" ) 	{$setup_huu_wts_prod_box_block_woo="0";	}else{$setup_huu_wts_prod_box_block_woo="1";}
if ( $_POST['setup_huu_wts_prod_box_woo']<>"1" ) 		{$setup_huu_wts_prod_box_woo="0";	}else{$setup_huu_wts_prod_box_woo="1";			}
if ( $_POST['setup_huu_wts_prod_page_woo']<>"1" ) 		{$setup_huu_wts_prod_page_woo="0";	}else{$setup_huu_wts_prod_page_woo="1";			}

// updates
update_option(	'setup_huu_wts_prod_box_block_woo',		filter_var($setup_huu_wts_prod_box_block_woo, FILTER_SANITIZE_NUMBER_INT )			);
update_option(	'setup_huu_wts_prod_box_woo',			filter_var($setup_huu_wts_prod_box_woo, FILTER_SANITIZE_NUMBER_INT )				);
update_option(	'setup_huu_wts_prod_page_woo',			filter_var($setup_huu_wts_prod_page_woo, FILTER_SANITIZE_NUMBER_INT )				);
update_option(	'setup_huu_wts_text_woo',				sanitize_text_field($_POST['setup_huu_wts_text_woo'])								);
update_option(	'setup_huu_wts_number_woo',				sanitize_text_field($_POST['setup_huu_wts_number_woo'])								);

	}
}
?>	
<div class="huu-wpadmin-content">

<div id=huu-col-right>
	<div class=huu-wp-box>
		<div class=inner>
			<h2>Huu WP for WooCommerce</h2>
				<p class=version>1.1.4</p>
			<hr>
		</div>
		<div class="footer footer-blue">
			<ul class="left">
				<li><?php _e( 'Support', 'wc-huu' ); ?> : <a href="https://hugocalixto.com.br/" target="_blank"><?php _e( 'Click Here', 'wc-huu' ); ?></a></li>
			</ul>
		</div>
	</div>
</div>	

<div id=huu-col-left>
	<div id=huu-overview>
		<div class=inner>
			<form method="POST" action="">	
				<table class="widefat fixed">
					<tbody>
						<tr class="alternate">
						<td class="column-columnname">
						<label><?php _e( 'Number of whatsapp', 'wc-huu' ); ?>: </label>
						<input type="text" name="setup_huu_wts_number_woo" id="setup_huu_wts_number_woo" class='large-text' placeholder='<?php _e( 'type the whatsapp number XXYY123456789. Do not need +', 'wc-huu' ); ?>' value="<?php echo get_option('setup_huu_wts_number_woo')?>"  /> 
						</td>
						</tr>

						<tr class="alternate">
						<td class="column-columnname">
						<label><?php _e( 'Text to button', 'wc-huu' ); ?>: </label>
						<input type="text" name="setup_huu_wts_text_woo" id="setup_huu_wts_text_woo" class='large-text' placeholder='<?php _e( 'type a text to whatsapp button Ex.: Consulta por Whatsapp', 'wc-huu' ); ?>' value="<?php echo esc_html(get_option('setup_huu_wts_text_woo'))?>"  /> 
						</td>
						</tr>

						<tr class="alternate">
						<td class="column-columnname">
						<label class="huuguu-switch"><input type="checkbox" id="setup_huu_wts_prod_page_woo"  name="setup_huu_wts_prod_page_woo"  value="1" <?php if (get_option('setup_huu_wts_prod_page_woo') =="1") { echo "checked";} ?>><span class="slider round"></span></label>
						<label><?php _e( 'Active the button of Whatsapp in Single Product Page.', 'wc-huu' );?> </label>
						</td>
						</tr>

						<tr class="alternate">
						<td class="column-columnname">
						<label class="huuguu-switch"><input type="checkbox" id="setup_huu_wts_prod_box_woo"  name="setup_huu_wts_prod_box_woo"  value="1" <?php if (get_option('setup_huu_wts_prod_box_woo') =="1") { echo "checked";} ?>><span class="slider round"></span></label>
						<label><?php _e( 'Active Whatsapp icon on Loop of Product.', 'wc-huu' );?> </label>
						</td>
						</tr>
						
						<tr class="alternate">
						<td class="column-columnname">
						<label class="huuguu-switch"><input type="checkbox" id="setup_huu_wts_prod_box_block_woo"  name="setup_huu_wts_prod_box_block_woo"  value="1" <?php if (get_option('setup_huu_wts_prod_box_block_woo') =="1") { echo "checked";} ?>><span class="slider round"></span></label>
						<label><?php _e( 'Use icon with text to Loop of Product.', 'wc-huu' );?> </label>
						</td>
						</tr>						

						<tr class="alternate">
						<td class="column-columnname">
						<?php submit_button(); ?>
						<input type="hidden" name="wc_huusetup_submit" id="wc_huusetup_submit" value="enviar_setup" />
						<?php wp_nonce_field( 'wc_huu_valornonce', 'wc_huu_enviar_nonce' );?>
						</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
</div>


</div>

<?php	
}