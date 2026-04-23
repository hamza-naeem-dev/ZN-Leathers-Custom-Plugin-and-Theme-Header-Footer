<?php 
/**
 * Plugin Name: ZN Contact Form
 * Description: This is a contact form plugin. It is developed specifically for ZN Leathers.
 * Version: 1.0
 * Author: Hamza Naeem
 */


if(!defined('ABSPATH'))
    {
        exit;
    }

class ZNcfPlugin{

public function __construct()
{
    $this -> define_constant();
    $this -> init_hooks();
    $this -> includes();
}

private function define_constant()
{
   define('PLUGIN_VERSION', '1.0');
   define('PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
   define('PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
}

private function init_hooks(){
    register_activation_hook(__FILE__, array($this, "activation"));
    register_deactivation_hook(__FILE__, array($this, "deactivation"));
    add_action("wp_enqueue_scripts", array($this, "enqueue_assets"));
}

private function includes(){
require_once PLUGIN_DIR_PATH. 'includes/class_zn_cf_plugin.php';
new ZNCF_Plugin();
}

public function activation(){
    /**@var wpdb $wpdb */
    global $wpdb;
    $tableName = $wpdb->prefix . "leather_product_queries";
    $char_collate = $wpdb->get_charset_collate();

    $sql= "CREATE TABLE $tableName(`id` INT NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(255) NOT NULL,
        `email` VARCHAR(255) NOT NULL,
        `phone_number` VARCHAR(20) NOT NULL,
        `subject` VARCHAR(255) NOT NULL,
        `message` TEXT NOT NULL,
        attached_file VARCHAR(255),
        created_at DATETIME DEFAULT NULL,
        PRIMARY KEY (id)) $char_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    return flush_rewrite_rules();
}

public function deactivation(){
    return flush_rewrite_rules();
}

public function enqueue_assets(){
    wp_enqueue_script("zncf_script", PLUGIN_DIR_URL . "includes/script.js", array(), PLUGIN_VERSION, true);
    wp_enqueue_style( "zncf_style", PLUGIN_DIR_URL . "includes/style.css", array(), PLUGIN_VERSION );

    //Set up env for ajax
    wp_localize_script("zncf_script", "zncf_ajax", array(
        "ajax_url" => admin_url("admin-ajax.php"),
        "ajax_nonce" => wp_create_nonce("zn_cf_nonce_action")
    ));
}
}
function zn_cfplugin_init(){
    return new ZNcfPlugin();
}
zn_cfplugin_init();