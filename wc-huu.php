<?php
/**
 * @package Plugins Huu WP for WooCommerce
 */
/**
Plugin Name: Huu WP for WooCommerce
Plugin URI: https://hugocalixto.com.br/
Description: To show Whatsapp button in Loop Products and/or Single Product Page
Version: 1.1.4
Author: Hugo Calixto
Author URI: https://hugocalixto.com.br/
License: GPLv2 (or later)
Text Domain: wc-huu
*/

if ( ! defined('ABSPATH') ) { exit; }

	/* load translations. */
	load_plugin_textdomain('wc-huu', false, dirname(plugin_basename(__FILE__)) . '/languages');

	/* Check if WooCommerce is active */
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {


	/* load style to admin. */
	if( is_admin() ) {
		wp_register_style('wc-huu-style-admin', plugins_url('css/huu-style-admin.css', __FILE__));
		wp_enqueue_style('wc-huu-style-admin');
    }
	

	/* add submenu to admin | theme */
	add_action('admin_menu', 'wc_huu_submenu', 99 );	
	function wc_huu_submenu() {
		add_submenu_page(
			'themes.php', // slug do menu principal 
			__('Setup Huu WP Woo', 'wc-huu'), 
			__('Setup Huu WP Woo', 'wc-huu'), 
			'manage_options', 
			'wc-huu-setup.php',
			'wc_huu_callback'
		);
	}
    include( plugin_dir_path( __FILE__ ) . 'wc-huu-setup.php');


	/* menu to page plugin.php add option setup */
	add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'wc_huu_add_plugin_page_settings_link');
	
	if ( !function_exists( 'wc_huu_add_plugin_page_settings_link' ) ) {
	function wc_huu_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .admin_url( 'themes.php?page=wc-huu-setup.php' ) .'"><b>' . __('Settings','wc-huu') . '</b></a>';
	return $links;
	}
	}


	/* add css inline */
	if ( !function_exists( 'wc_huu_setup_inline_css' ) ) {
	function wc_huu_setup_inline_css() {
	echo "\n<style type='text/css' id='inline-huu-wpwoo'>\n";	
	if (get_option('setup_huu_wts_prod_box_woo') =="1") {
	echo "#envolve-add{display: flex;justify-content: center;justify-items: center}\n";	
	if (get_option('setup_huu_wts_prod_box_block_woo') =="1") {
	echo ".huu-wts{margin-bottom:3px!important;background-color:#198754!important;color:white;display: flex;justify-content: center;align-items: center;}\n";
	echo "a.huu-wts img{display:unset!important;margin:unset!important;width:unset!important;margin-right:5px!important;}\n";	
	} else {
	echo ".huu-wts{margin-right:5px!important;background-color:#198754!important;max-width:55px;color:white;padding:0.52em 1em 0.25em!important}\n";
	echo "a.huu-wts img{display:unset!important;margin:1px 0 0.4em!important;padding:0!important}\n";
	}
	}
	if (get_option('setup_huu_wts_prod_page_woo') =="1") { echo ".huu-wts-page img{display:unset!important;}\n";
	echo ".huu-wts-page{text-decoration:none!important;display:inline-block!important;margin:20px 0!important;background-color:#198754!important;color:#fff!important}\n";}
	echo "</style>\n";
	}
	}
	add_action( 'wp_head', 'wc_huu_setup_inline_css', 99 );	

	
	/* whatsapp single product page */
	if (get_option('setup_huu_wts_prod_page_woo') =="1") {
	if ( !function_exists( 'wc_huu_print_prod_page_woo' ) ) {
	function wc_huu_print_prod_page_woo(){
	global $product;
	?>
	<a target="_blank" rel="nofollow noreferrer" href="https://api.whatsapp.com/send?phone=+<?php echo esc_html(get_option('setup_huu_wts_number_woo')); ?>&text=<?php _e( 'Interest in', 'wc-huu' ); ?>%20<?php echo esc_html(get_option('setup_huu_wts_text_woo')); ?>%20<?php _e( 'product', 'wc-huu' ); ?>:%20<?php echo $product->get_name(); ?>%20-%20<?php echo get_page_link(); ?>%20" class="huu-wts-page button bg-success"><?php echo "<img src='".plugins_url('imgs/whatsapp.png', __FILE__)."' alt='whatsapp'> ";  echo esc_html(get_option('setup_huu_wts_text_woo')); ?> </a>	
	<?php
	}
	}
	add_action ( 'woocommerce_product_meta_start', 'wc_huu_print_prod_page_woo');
	} 


	/* whatsapp loop products  */
	if (get_option('setup_huu_wts_prod_box_woo') =="1") {
	function wc_huu_print_prod_box_woo(){
	global $product;
	if (get_option('setup_huu_wts_prod_box_block_woo') =="1") {$textoloop=esc_html(get_option('setup_huu_wts_text_woo'));}
	echo "<a type='button' target='_blank' rel='nofollow noreferrer' href='https://api.whatsapp.com/send?phone=+".esc_html(get_option('setup_huu_wts_number_woo'))."&text=".__( 'Interest in', 'wc-huu' )."%20".esc_html(get_option('setup_huu_wts_text_woo'))."%20-%20".__( 'product', 'wc-huu' )."%20:%20".get_permalink( $product->ID )."%20".$product->get_name()."%20' class='huu-wts button bg-success'><img src='".plugins_url('imgs/whatsapp.png', __FILE__)."' alt='whatsapp'> ".$textoloop."</a>"; 
	}
	add_action ( 'woocommerce_after_shop_loop_item', 'wc_huu_print_prod_box_woo',10);
	}
	
	
	add_action ( "woocommerce_after_shop_loop_item", "wc_huu_after_add_started", 9 );
	if ( !function_exists( 'wc_huu_after_add_started' ) ) {
	function wc_huu_after_add_started () {
	echo "<div id='envolve-add'>";
	}
	}

	add_action( 'woocommerce_after_shop_loop_item', 'wc_huu_before_add_ended', 20 );
	if ( !function_exists( 'wc_huu_before_add_ended' ) ) {
	function wc_huu_before_add_ended(){
	echo  '</div>';
	}	
	}	
	
	} else {

	/* notice-error woocommerce not installed  */
	add_action( 'admin_notices', 'wc_huu_admin_notice_error' );

	}



	/* notice  */
	if ( !function_exists( 'wc_huu_admin_notice_error' ) ) {
	function wc_huu_admin_notice_error() {
		?>
		<div class="notice notice-error">
		<p><?php _e( 'To use Huu WP for WooCommerce you need to install WooCommerce.', 'wc-huu' ); ?></p>
		</div>
		<?php
	}
	}