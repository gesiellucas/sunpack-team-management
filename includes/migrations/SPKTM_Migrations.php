<?php
global $wpdb;
return [
    [
        'table' => $wpdb->prefix . "spk_projeto",
        'sql' => 'CREATE TABLE ' . $wpdb->prefix . "spk_projeto" . ' (id INT NOT NULL AUTO_INCREMENT, nome VARCHAR(200) NOT NULL, logo VARCHAR(255), created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY(id) ) ' . $wpdb->get_charset_collate() . ';'
    ],
    [
        'table' => $wpdb->prefix . "spk_grupo",
        'sql' => 'CREATE TABLE ' . $wpdb->prefix . "spk_grupo" . ' (id INT NOT NULL AUTO_INCREMENT, nome VARCHAR(200) NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY(id) ) ' . $wpdb->get_charset_collate() . ';'
    ],
    [
        'table' => $wpdb->prefix . "spk_origem_verba",
        'sql' => 'CREATE TABLE ' . $wpdb->prefix . "spk_origem_verba" . ' (id INT NOT NULL AUTO_INCREMENT, nome VARCHAR(200) NOT NULL, descricao TEXT, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY(id) ) ' . $wpdb->get_charset_collate() . ';'
    ],
    [
        'table' => $wpdb->prefix . "spk_nivel_patrocinio",
        'sql' => 'CREATE TABLE ' . $wpdb->prefix . "spk_nivel_patrocinio" . ' (id INT NOT NULL AUTO_INCREMENT, nome VARCHAR(200) NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY(id) )' . $wpdb->get_charset_collate() . ';'
    ],
    [
        'table' => $wpdb->prefix . "spk_patrocinador",
        'sql' => 'CREATE TABLE ' . $wpdb->prefix . "spk_patrocinador" . ' (id INT NOT NULL AUTO_INCREMENT, patrocinador_id INT, grupo_id INT, origem_verba_id INT, nivel_patrocinio_id INT, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, FOREIGN KEY (patrocinador_id) REFERENCES ' . $wpdb->prefix . "spk_projeto" . '(id), FOREIGN KEY (grupo_id) REFERENCES ' . $wpdb->prefix . "spk_grupo" . '(id), FOREIGN KEY (origem_verba_id) REFERENCES '.$wpdb->prefix . "spk_origem_verba".'(id), FOREIGN KEY (nivel_patrocinio_id) REFERENCES ' . $wpdb->prefix . "spk_nivel_patrocinio" . '(id), PRIMARY KEY(id) )' . $wpdb->get_charset_collate() . ';'
    ]
];