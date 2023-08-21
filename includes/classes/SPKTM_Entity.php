<?php

namespace LuaSpk\Classes;

/**
 * Class to deal with database and its behavior
 * 
 */
class SPKTM_Entity
{

    /**
     * Run database migrations
     * @return void
     */
    public static function run () :void
    {
        $data = require_once SPK_PLUGIN_DIR . '/includes/migrations/SPKTM_Migrations.php';

        if(!empty($data)) {
            foreach($data as $value) {
                self::spk_maybe_create_table($value['table'], $value['sql']);
            }
        }
    }

    /**
     * Create table only if it doesn't already exists
     * Reference https://developer.wordpress.org/reference/functions/maybe_create_table/
     * 
     * @param mixed $table_name
     * @param mixed $create_ddl
     * 
     * @return bool
     */
    private static function spk_maybe_create_table($table_name, $create_ddl) :bool 
    {
        global $wpdb;
    
        $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );
    
        if ( $wpdb->get_var( $query ) === $table_name ) {
            return true;
        }
    
        // Didn't find it, so try to create it.
        $wpdb->query( $create_ddl );
    
        // We cannot directly tell that whether this succeeded!
        if ( $wpdb->get_var( $query ) === $table_name ) {
            return true;
        }
    
        return false;
    }

    public function display_data()
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


    public static function get_grupos()
    {
        global $wpdb;
        $table_grupo = $wpdb->prefix . "spk_grupo";
        $table_patrocinador = $wpdb->prefix. "spk_patrocinador";
        return $wpdb->get_results("SELECT nome as grupo, (SELECT count(id) FROM {$table_patrocinador} WHERE {$table_patrocinador}.grupo_id = {$table_grupo}.id ) as qtd, id FROM {$table_grupo}"); 
    }

    public static function insert_grupo($nome)
    {
        global $wpdb;
        $tabela_grupo = $wpdb->prefix . "spk_grupo";
        try {
            //code...
            return $wpdb->insert($tabela_grupo, array('nome' => $nome));
        } catch (\Throwable $th) {
            //throw $th;
        }

        return false;
    }

    public static function get_all_patrocinadores()
    {
        global $wpdb;
        $table_projeto = $wpdb->prefix . "spk_projeto";
        $table_patrocinadores = $wpdb->prefix . "spk_patrocinador";
        
        return $wpdb->get_results("SELECT (SELECT nome FROM {$table_projeto} WHERE {$table_projeto}.id = {$table_patrocinadores}.patrocinador_id ) as nome, (SELECT count(id) FROM {$table_projeto} WHERE {$table_projeto}.id = {$table_patrocinadores}.patrocinador_id ) as qtd, id FROM {$table_patrocinadores} GROUP BY patrocinador_id"); 

    }

    public static function new_projeto($data) 
    {
        global $wpdb;
        $table_projeto = $wpdb->prefix . "spk_projeto";
        $logo = '';
        
        if (!empty($data[1])){
            $logo = self::handle_image($data[1]);
            if(!$logo) {
                return 'Erro na imagem';
            }
        }
        $data = array(
            'nome' => $data[0]['nome'],
            'logo' => $logo
        );
        $insert_projeto = $wpdb->insert($table_projeto, $data);
        if ($insert_projeto) 
        {
            return $wpdb->insert_id;
        }
        return false;
    }

    public static function get_nivel_patrocinio()
    {
        global $wpdb;
        $table_patrocinador = $wpdb->prefix . "spk_patrocinador";
        $tabela_nivel_patrocinio = $wpdb->prefix . "spk_nivel_patrocinio";

        return $wpdb->get_results("SELECT nome as nome_patrocinio, (SELECT count(id) FROM {$table_patrocinador} WHERE {$table_patrocinador}.nivel_patrocinio_id = {$tabela_nivel_patrocinio}.id ) as qtd, id FROM {$tabela_nivel_patrocinio}"); 
    }

    public static function insert_nivel_patrocinio($nome)
    {
        global $wpdb;
        $tabela_nivel_patrocinio = $wpdb->prefix . "spk_nivel_patrocinio";
        try {
            //code...
            return $wpdb->insert($tabela_nivel_patrocinio, array('nome' => $nome));
        } catch (\Throwable $th) {
            //throw $th;
        }

        return false;
    }

    public static function get_origem_verba()
    {
        global $wpdb;
        $table_patrocinador = $wpdb->prefix . "spk_patrocinador";
        $table_origem_verba = $wpdb->prefix . "spk_origem_verba";

        return $wpdb->get_results("SELECT nome as origem_verba, descricao, (SELECT count(id) FROM {$table_patrocinador} WHERE {$table_patrocinador}.origem_verba_id = {$table_origem_verba}.id ) as qtd, id FROM {$table_origem_verba}"); 
    }

    public static function insert_origem_verba($nome, $desc = null)
    {
        global $wpdb;
        $table_origem_verba = $wpdb->prefix . "spk_origem_verba";
        if(!empty($nome)) {
            if(!empty($desc)){
                return $wpdb->insert($table_origem_verba, array('nome' => $nome, 'descricao' => $desc));
            }
            
            return $wpdb->insert($table_origem_verba, array('nome' => $nome));
        }
        
        return false;
    }

    public static function delete_origem_verba($id)
    {
        global $wpdb;
        $tabela_grupo = $wpdb->prefix . "spk_origem_verba";
        return $wpdb->delete($tabela_grupo, array('id'=> $id));
    }

    public static function insert_patrocinadores($data)
    {
        global $wpdb;
        $table_patrocinador = $wpdb->prefix . "spk_patrocinador";

        $data = array(
            'patrocinador_id' => $data['patrocinador'],
            'origem_verba_id' => $data['origem_verba'],
            'grupo_id' => (int) $data['grupo'],
            'nivel_patrocinio_id' => (int) $data['nivel_patrocinio'],
        );

        $insert = $wpdb->insert($table_patrocinador, $data);
        if(!$insert) {
            return false;
        }

        wp_send_json($insert);
    }

    public static function handle_image($img)
    {
        $upload_dir = wp_upload_dir();
        $target_dir = $upload_dir['path'] . '/';
        $target_file = $target_dir . basename($img['logo']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image exists
        if ($img['logo']["tmp_name"] == '')
            wp_send_json('Imagem inexistente');

        if ($img['logo']["size"] > 50000000)
            wp_send_json('Imagem grande');

        // Restrict formats
        if (
            $imageFileType != "jpg"
            &&  $imageFileType != "png"
            &&  $imageFileType != "jpeg"
        )
            wp_send_json('Restrict formats');

        $attachment = $img['logo'];
        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }

        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($img['logo'], $upload_overrides);
        
        if ($movefile && !isset($movefile['error'])) {
            // Sanitize the file name and add a timestamp
            $filename = sanitize_file_name($movefile['file']);
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $filename = sprintf('%s-%s.%s', substr($filename, 0, -(strlen($ext) + 1)), time(), $ext);
            $new_file_path = $movefile['file'] . '-' . time() . '.' . $ext;
            rename($movefile['file'], $new_file_path);
            $movefile['file'] = $new_file_path;

            // Step 3: Save the image to the WordPress Media Library
            $attachment = array(
                'post_mime_type' => $movefile['type'],
                'post_title' => $filename,
                'post_content' => '',
                'post_status' => 'inherit'
            );
            
            $attach_id = wp_insert_attachment($attachment, $movefile['file']);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $movefile['file']);
            wp_update_attachment_metadata($attach_id, $attach_data);
            
            return wp_get_attachment_url( $attach_id );
        }
        
        return wp_send_json('Imagem nao');
    }

    public static function get_image($img)
    {
        $default = '<div style="width:100px;height:50px;overflow:hidden;background:rgba(1,1,1,0.2);display:flex;align-content:center;align-items:center;justify-content:center;"><p style="align-self:center;"><small>sem logo</small></p></div>';
        if($img) {
            $image_url = $img ?? '';
            $attachment_id = attachment_url_to_postid($image_url);
            if($attachment_id){
                $image_data = wp_get_attachment_image_src( $attachment_id, 'full' );
                if ( $image_data ) {
                    $image_src = $image_data[0];
                    $image_width = $image_data[1];
                    $image_height = $image_data[2];
                    $image_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
            
                    // Output the image HTML
                    return '<div style="width:100px;height:50px;overflow:hidden;"><img src="' . $image_src . '" alt="' . $image_alt . '" style="object-fit:cover;width:100%;"></div>';
                }
                return $default;
            }
            return $default;
        } 
        return $default;
    }

    public static function delete_data($id)
    {
        global $wpdb;
        $table_patrocinadores = $wpdb->prefix . "spk_patrocinador";
        return $wpdb->delete($table_patrocinadores, array('id'=> $id));
    }

    public static function delete_grupo($id)
    {
        global $wpdb;
        $tabela_grupo = $wpdb->prefix . "spk_grupo";
        return $wpdb->delete($tabela_grupo, array('id'=> $id));
    }

    public static function delete_nivel_patrocinio($id)
    {
        global $wpdb;
        $tabela_nivel_patrocinio = $wpdb->prefix . "spk_nivel_patrocinio";
        return $wpdb->delete($tabela_nivel_patrocinio, array('id'=> $id));
    }

    private static function get_data_to_shortcode($nivel, $id_grupo)
    {
        global $wpdb;
        // Retornar os patrocinadores que sao gargalhada e do grupo de patrocinadores

        $data = [];
        $patrocinadores = $wpdb->prefix . "spk_patrocinadores";
        $grupo = $wpdb->prefix . "spk_grupo";
        $nivel_patrocinio = $wpdb->prefix . "spk_nivel_patrocinio";
        
        $results = $wpdb->get_results("SELECT * FROM ".$patrocinadores." WHERE nivel_patrocinadores_id = {$nivel} AND grupo_id = {$id_grupo}");
        if(!empty($results)){
            foreach($results as $value) {
                $data_grupo = $wpdb->get_results("SELECT * FROM ".$grupo." WHERE id = ".$value->grupo_id." LIMIT 1");
                $data_nivel_patrocinio = $wpdb->get_results("SELECT * FROM ".$nivel_patrocinio." WHERE id = ".$value->nivel_patrocinadores_id." LIMIT 1");
                $data[] = [
                    'patrocinador' => $value->projeto,
                    'origem_verba' => $value->origem_verba,
                    'grupo' => $data_grupo[0]->nome_grupo,
                    'nivel_patrocinio'=> $data_nivel_patrocinio[0]->nome_patrocinio,
                    'logo' => $value->logo,
                    'id' => $value->id
                ];
            }
        }
        return $data;
    }

    public static function get_shortcode( $atts )
    {       
        global $wpdb;
        $html = '';
        $tabela_grupo = $wpdb->prefix . "spk_grupo";
        $table_projeto = $wpdb->prefix . "spk_projeto";
        $table_origem_verba = $wpdb->prefix . "spk_origem_verba";
        $table_nivel_patrocinio = $wpdb->prefix . "spk_nivel_patrocinio";
        $table_patrocinador = $wpdb->prefix . "spk_patrocinador";

        // Patrocinadores
        $patrocinadores = $wpdb->get_results("SELECT 
            (SELECT nome FROM {$wpdb->prefix }spk_projeto WHERE {$wpdb->prefix }spk_projeto.id = {$wpdb->prefix }spk_patrocinador.patrocinador_id) as patrocinador,
            (SELECT nome FROM {$wpdb->prefix }spk_grupo WHERE {$wpdb->prefix }spk_grupo.id = {$wpdb->prefix }spk_patrocinador.grupo_id) as grupo,
            (SELECT nome FROM {$wpdb->prefix }spk_origem_verba WHERE {$wpdb->prefix }spk_origem_verba.id = {$wpdb->prefix }spk_patrocinador.origem_verba_id) as origem_verba,
            (SELECT nome FROM {$wpdb->prefix }spk_nivel_patrocinio WHERE {$wpdb->prefix }spk_nivel_patrocinio.id = {$wpdb->prefix }spk_patrocinador.nivel_patrocinio_id) as nivel_patrocinio
        FROM {$table_patrocinador} WHERE grupo_id = 1");

        // Encontrar somente os grupos
        $nome_grupo = "SELECT nome FROM {$tabela_grupo} WHERE {$wpdb->prefix }spk_grupo.id = {$wpdb->prefix }spk_patrocinador.grupo_id";
        $grupos = $wpdb->get_results("SELECT ($nome_grupo) as grupo, grupo_id FROM " . $table_patrocinador . " GROUP BY grupo_id;", OBJECT);
        $html .= "<section id='spk-shortcode'>";
        foreach ($grupos as $value) {
            $html .= "<h2 class='grupo'>{$value->grupo}</h2>";

            $origem = $wpdb->get_results("SELECT 
                (SELECT nome FROM {$wpdb->prefix }spk_projeto WHERE {$wpdb->prefix }spk_projeto.id = {$wpdb->prefix }spk_patrocinador.patrocinador_id) as patrocinador,
                (SELECT nome FROM {$wpdb->prefix }spk_grupo WHERE {$wpdb->prefix }spk_grupo.id = {$wpdb->prefix }spk_patrocinador.grupo_id) as grupo,
                (SELECT nome FROM {$wpdb->prefix }spk_origem_verba WHERE {$wpdb->prefix }spk_origem_verba.id = {$wpdb->prefix }spk_patrocinador.origem_verba_id) as origem_verba,
                (SELECT descricao FROM {$wpdb->prefix }spk_origem_verba WHERE {$wpdb->prefix }spk_origem_verba.id = {$wpdb->prefix }spk_patrocinador.origem_verba_id) as descricao,
                (SELECT nome FROM {$wpdb->prefix }spk_nivel_patrocinio WHERE {$wpdb->prefix }spk_nivel_patrocinio.id = {$wpdb->prefix }spk_patrocinador.nivel_patrocinio_id) as nivel_patrocinio,
                origem_verba_id
            FROM {$table_patrocinador} WHERE grupo_id = {$value->grupo_id} GROUP BY origem_verba_id");

            foreach ($origem as $og) {
                $html .= "<h4 class='origem'>{$og->origem_verba}</h4>";
                $html .= "<p style='font-size: 28px;
                font-family='Fredoka': ;
                line-height: 30px;' class='desc'>". (isset($og->descricao) ? $og->descricao : '')."</p>";

                $nivel = $wpdb->get_results("SELECT 
                    (SELECT nome FROM {$wpdb->prefix }spk_projeto WHERE {$wpdb->prefix }spk_projeto.id = {$wpdb->prefix }spk_patrocinador.patrocinador_id) as patrocinador,
                    (SELECT logo FROM {$wpdb->prefix }spk_projeto WHERE {$wpdb->prefix }spk_projeto.id = {$wpdb->prefix }spk_patrocinador.patrocinador_id) as logo,
                    (SELECT nome FROM {$wpdb->prefix }spk_grupo WHERE {$wpdb->prefix }spk_grupo.id = {$wpdb->prefix }spk_patrocinador.grupo_id) as grupo,
                    (SELECT nome FROM {$wpdb->prefix }spk_origem_verba WHERE {$wpdb->prefix }spk_origem_verba.id = {$wpdb->prefix }spk_patrocinador.origem_verba_id) as origem_verba,
                    (SELECT nome FROM {$wpdb->prefix }spk_nivel_patrocinio WHERE {$wpdb->prefix }spk_nivel_patrocinio.id = {$wpdb->prefix }spk_patrocinador.nivel_patrocinio_id) as nivel_patrocinio,
                    nivel_patrocinio_id
                FROM {$table_patrocinador} WHERE origem_verba_id = {$og->origem_verba_id} AND grupo_id = {$value->grupo_id} GROUP BY origem_verba_id, nivel_patrocinio ORDER BY nivel_patrocinio_id ASC");
                $html .= "<section class='nivel'>";
                foreach ($nivel as $np) {
                    
                    $patrocinador = $wpdb->get_results("SELECT 
                        id,
                        (SELECT nome FROM {$wpdb->prefix }spk_projeto WHERE {$wpdb->prefix }spk_projeto.id = {$wpdb->prefix }spk_patrocinador.patrocinador_id) as patrocinador,
                        (SELECT logo FROM {$wpdb->prefix }spk_projeto WHERE {$wpdb->prefix }spk_projeto.id = {$wpdb->prefix }spk_patrocinador.patrocinador_id) as logo,
                        (SELECT nome FROM {$wpdb->prefix }spk_grupo WHERE {$wpdb->prefix }spk_grupo.id = {$wpdb->prefix }spk_patrocinador.grupo_id) as grupo,
                        (SELECT nome FROM {$wpdb->prefix }spk_origem_verba WHERE {$wpdb->prefix }spk_origem_verba.id = {$wpdb->prefix }spk_patrocinador.origem_verba_id) as origem_verba,
                        (SELECT nome FROM {$wpdb->prefix }spk_nivel_patrocinio WHERE {$wpdb->prefix }spk_nivel_patrocinio.id = {$wpdb->prefix }spk_patrocinador.nivel_patrocinio_id) as nivel_patrocinio
                    FROM {$table_patrocinador} WHERE nivel_patrocinio_id = {$np->nivel_patrocinio_id} AND origem_verba_id = {$og->origem_verba_id} AND grupo_id = {$value->grupo_id} ORDER BY id");

                    foreach ($patrocinador as $ptr) {
                        $html .= "<div class='box ".($np->nivel_patrocinio_id == '1' ? 'border-red' : ($np->nivel_patrocinio_id == '2' ? 'border-green' :  ($np->nivel_patrocinio_id == '4' ? 'border-normal' :'border-yellow')))."' data-label='{$ptr->nivel_patrocinio}'>";
                        $html .= "<aside class='img' style='background-position:center;background-size:contain;background-repeat:no-repeat;background-image: url({$ptr->logo})'>";
                        $html .= "</aside>";
                        $html .= "</div>";
                    }
                   
                }
                $html .= "</section>";
            }
        }
        $html .= "</>";
       return $html;
    }
    
}
