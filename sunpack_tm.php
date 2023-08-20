<?php
/*
Plugin Name: Sunpack Team Management
Plugin URI: https://github.com/gesiellucas
Description: Team Management Plugin to wordpress
Version: 0.0.1
Author: Gesiel Lucas
Author URI: https://github.com/gesiellucas
License: GPL2
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Not allowed';
	exit;
}

// Global Variables of SunPack 
if (!defined('SPK_THEME_DIR'))
    define('SPK_THEME_DIR', ABSPATH . 'wp-content/themes/' . get_template());

if (!defined('SPK_PLUGIN_NAME'))
    define('SPK_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('SPK_PLUGIN_DIR'))
    define('SPK_PLUGIN_DIR', plugin_dir_path(__FILE__));

if (!defined('SPK_PLUGIN_URL'))
    define('SPK_PLUGIN_URL', WP_PLUGIN_URL . '/' . SPK_PLUGIN_NAME);
    
// Require function to create databases
require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

// Call activation/deactivation Hooks


// Chamar classes
require_once( SPK_PLUGIN_DIR . '/classes/class.sunpack_tm.php');
require_once(SPK_PLUGIN_DIR . "/classes/class.sunpack_tm_admin.php");

add_action('init', ['Sunpack_tm', '_init']);


// Instanciar a classe
new Sunpack_Admin();

// Entra no formulario para adicionar novo patrocionador
add_action('wp_ajax_request_ajax', 'request_ajax');
add_action('wp_ajax_nopriv_request_ajax', 'request_ajax');

// Cadastrar novo projeto
add_action('wp_ajax_new_projeto', 'new_projeto');
add_action('wp_ajax_nopriv_new_projeto', 'new_projeto');
    
// Cadastra novo patrocinador
add_action('wp_ajax_create_data', 'create_data');
add_action('wp_ajax_nopriv_create_data', 'create_data');

// Deletar patrocinador
add_action('wp_ajax_delete_data', 'delete_data');
add_action('wp_ajax_nopriv_delete_data', 'delete_data');

// Configuracao de grupo
add_action('wp_ajax_settings_grupo', 'settings_grupo');
add_action('wp_ajax_nopriv_settings_grupo', 'settings_grupo');

// Cadastrar novo grupo
add_action('wp_ajax_insert_grupo', 'insert_grupo');
add_action('wp_ajax_nopriv_insert_grupo', 'insert_grupo');

// Cadastrar novo grupo
add_action('wp_ajax_delete_grupo', 'delete_grupo');
add_action('wp_ajax_nopriv_delete_grupo', 'delete_grupo');

// Configuracao nivel patrocinio
add_action('wp_ajax_settings_nivel_patrocinio', 'settings_nivel_patrocinio');
add_action('wp_ajax_nopriv_settings_nivel_patrocinio', 'settings_nivel_patrocinio');

// Cadastrar novo nivel patrocinio
add_action('wp_ajax_insert_nivel_patrocinio', 'insert_nivel_patrocinio');
add_action('wp_ajax_nopriv_insert_nivel_patrocinio', 'insert_nivel_patrocinio');

// Deletar novo nivel patrocinio
add_action('wp_ajax_delete_nivel_patrocinio', 'delete_nivel_patrocinio');
add_action('wp_ajax_nopriv_delete_nivel_patrocinio', 'delete_nivel_patrocinio');

// Configuracao origem verba
add_action('wp_ajax_settings_origem_verba', 'settings_origem_verba');
add_action('wp_ajax_nopriv_settings_origem_verba', 'settings_origem_verba');

// Cadastrar nova origem de verba
add_action('wp_ajax_insert_origem_verba', 'insert_origem_verba');
add_action('wp_ajax_nopriv_insert_origem_verba', 'insert_origem_verba');

// Deletar novo nivel patrocinio
add_action('wp_ajax_delete_origem_verba', 'delete_origem_verba');
add_action('wp_ajax_nopriv_delete_origem_verba', 'delete_origem_verba');

function request_ajax(){
    include_once(SPK_PLUGIN_DIR . "/includes/ajax.php");
    wp_die();
}

function new_projeto(){
    include_once(SPK_PLUGIN_DIR . "/includes/ajax.php");
    wp_die();
}

function create_data(){
    include_once(SPK_PLUGIN_DIR . "/includes/ajax.php");
    wp_die();
}

function delete_data(){
    include_once(SPK_PLUGIN_DIR . "/includes/ajax.php");
    wp_die();
}

function settings_grupo(){
    include_once(SPK_PLUGIN_DIR . "/includes/ajax.php");
    wp_die();
}

function insert_grupo(){
    include_once(SPK_PLUGIN_DIR . "/includes/ajax.php");
    wp_die();
}

function delete_grupo(){
    include_once(SPK_PLUGIN_DIR . "/includes/ajax.php");
    wp_die();
}

function settings_nivel_patrocinio(){
    include_once(SPK_PLUGIN_DIR . "/includes/ajax.php");
    wp_die();
}

function insert_nivel_patrocinio(){
    include_once(SPK_PLUGIN_DIR . "/includes/ajax.php");
    wp_die();
}

function delete_nivel_patrocinio(){
    include_once(SPK_PLUGIN_DIR . "/includes/ajax.php");
    wp_die();
}

function settings_origem_verba(){
    include_once(SPK_PLUGIN_DIR . "/includes/ajax.php");
    wp_die();
}

function insert_origem_verba(){
    include_once(SPK_PLUGIN_DIR . "/includes/ajax.php");
    wp_die();
}

function delete_origem_verba(){
    include_once(SPK_PLUGIN_DIR . "/includes/ajax.php");
    wp_die();
}

add_shortcode('spk_show_patrocinadores', array('Sunpack_tm', 'get_shortcode') );
add_action('wp_enqueue_scripts', 'enqueue_custom_style');
function enqueue_custom_style() {
    wp_enqueue_style('spk-custom-style', SPK_PLUGIN_URL . "/includes/css/style_shortcode.css");
}
