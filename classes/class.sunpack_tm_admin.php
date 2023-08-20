<?php

class Sunpack_Admin
{
    private $bootstrap_css;
    private $bootstrap_js;
    private $sunpack_js;
    private $feather_icons;
    private $request_ajax;
    private $sweet_alert;

    public function __construct()
    {
        $this->bootstrap_css = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css";
        $this->bootstrap_js = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js";
        $this->sunpack_js = SPK_PLUGIN_URL . "/includes/js/sunpack.js";
        $this->feather_icons = "https://unpkg.com/feather-icons";
        $this->request_ajax = SPK_PLUGIN_URL . "/includes/js/ajax_request.js";
        $this->sweet_alert = "https://cdn.jsdelivr.net/npm/sweetalert2@11";

        add_action('admin_enqueue_scripts', array($this, 'include_lib'));
        add_action('admin_menu', array($this, 'bar_admin'));
    }
    public function bar_admin()
    {
        add_menu_page(
            'Sunpack Hahaha', // The title of the page
            'Gestão Hahaha', // The text to display in the left-hand menu
            'manage_options', // The capability required for access to this page
            'gestao-hahaha',
            array($this, 'admin_bar_view'), // The unique slug for this menu item
            'dashicons-groups',
            4
        );
    }

    public function admin_bar_view()
    { 
        $data_spk = $this->display_data();
        require_once( SPK_PLUGIN_DIR . '/includes/views/view.php');
        wp_die();
    }

    public function include_lib()
    {
        wp_enqueue_style('spk_script', $this->bootstrap_css);
        wp_enqueue_script('spk_script', $this->bootstrap_js);
        wp_enqueue_script('spk_sweet_alert', $this->sweet_alert);
        wp_enqueue_script('spk_custom_script', $this->sunpack_js);
        wp_enqueue_script('spk_feather_icons', $this->feather_icons);
        wp_enqueue_script('spk_request_ajax', $this->request_ajax);

        wp_localize_script(
            'spk_request_ajax', 
            'script_ajax', 
            array(
                'ajax_url' => admin_url('admin-ajax.php')
            )
        );
    }

    private function display_data()
    {
        global $wpdb;
        $table_patrocinador = $wpdb->prefix . "spk_patrocinador";
        $data = $wpdb->get_results("SELECT 
            id,
            (SELECT nome FROM {$wpdb->prefix}spk_projeto WHERE {$wpdb->prefix}spk_projeto.id = {$wpdb->prefix}spk_patrocinador.patrocinador_id) as patrocinador,
            (SELECT logo FROM {$wpdb->prefix}spk_projeto WHERE {$wpdb->prefix}spk_projeto.id = {$wpdb->prefix}spk_patrocinador.patrocinador_id) as logo,
            (SELECT nome FROM {$wpdb->prefix}spk_grupo WHERE {$wpdb->prefix}spk_grupo.id = {$wpdb->prefix}spk_patrocinador.grupo_id) as grupo,
            (SELECT nome FROM {$wpdb->prefix}spk_origem_verba WHERE {$wpdb->prefix}spk_origem_verba.id = {$wpdb->prefix}spk_patrocinador.origem_verba_id) as origem_verba,
            (SELECT descricao FROM {$wpdb->prefix}spk_origem_verba WHERE {$wpdb->prefix}spk_origem_verba.id = {$wpdb->prefix}spk_patrocinador.origem_verba_id) as desc_origem_verba,
            (SELECT nome FROM {$wpdb->prefix}spk_nivel_patrocinio WHERE {$wpdb->prefix}spk_nivel_patrocinio.id = {$wpdb->prefix}spk_patrocinador.nivel_patrocinio_id) as nivel_patrocinio
        FROM {$table_patrocinador} ORDER BY patrocinador_id ASC");
        
        return $data;
    }
}
