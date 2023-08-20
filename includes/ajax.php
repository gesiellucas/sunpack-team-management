<?php 

if(isset($_POST['action'])) {
    $action = $_POST['action'];
    switch($action){
        case 'create_data':
            echo Sunpack_tm::insert_patrocinadores($_POST);
            break;
        case 'request_ajax':
            $patrocinadores = Sunpack_tm::get_all_patrocinadores();
            $grupos = Sunpack_tm::get_grupos();
            $nivel_patrocinio = Sunpack_tm::get_nivel_patrocinio();
            $origem_verba = Sunpack_tm::get_origem_verba();
            include_once(SPK_PLUGIN_DIR . '/includes/views/create.php');
            break;
        case 'delete_data':
            Sunpack_tm::delete_data($_POST['id']);
            break;
        case 'settings_grupo':
            $grupos = Sunpack_tm::get_grupos();
            include_once(SPK_PLUGIN_DIR . '/includes/views/grupos.php');
            break;
        case 'new_projeto':
            echo Sunpack_tm::new_projeto([$_POST, $_FILES]);
            break;
        case 'insert_grupo':
            Sunpack_tm::insert_grupo($_POST['nome_grupo']);
            break;
        case 'delete_grupo':
            Sunpack_tm::delete_grupo($_POST['grupo']);
            break;
        case 'settings_nivel_patrocinio':
            $nivel_patrocinio = Sunpack_tm::get_nivel_patrocinio();
            include_once(SPK_PLUGIN_DIR . '/includes/views/nivel_patrocinio.php');
            break;
        case 'insert_nivel_patrocinio':
            Sunpack_tm::insert_nivel_patrocinio($_POST['nivel_patrocinio']);
            break;
        case 'delete_nivel_patrocinio':
            Sunpack_tm::delete_nivel_patrocinio($_POST['nivel_patrocinio']);
            break;
        case 'settings_origem_verba':
            $origem_verba = Sunpack_tm::get_origem_verba();
            include_once(SPK_PLUGIN_DIR . '/includes/views/origem_verba.php');
            break;
        case 'insert_origem_verba':
            if($_POST['origem_verba_name']) {
                $origem_verba = $_POST['origem_verba_name'];

                if($_POST['origem_verba_desc']) {
                    $origem_verba_desc = $_POST['origem_verba_desc'];
                    Sunpack_tm::insert_origem_verba($origem_verba, $origem_verba_desc);
                    break;
                }
                Sunpack_tm::insert_origem_verba($origem_verba);
                break;
            }
            break;
        case 'delete_origem_verba':
            Sunpack_tm::delete_origem_verba($_POST['origem_verba']);
            break;

        default:
            
    }
}