<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fornecedor_models extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function listaTransportadora($nomeTransportadora = NULL) {
        $query = $this->db->query("SELECT 
                    CODIGO, 
                    NOME_FANTASIA
                FROM CAD_FORN 
                WHERE 
                    (
                        NOME_FANTASIA LIKE '%{$nomeTransportadora}%' OR
                        CODIGO LIKE '%{$nomeTransportadora}%'
                    ) AND
                    ECOMMERCE = 'S' AND
                    ATIVO = 'S' AND
                    TRANSPORTADOR = 'S'");
        
        $fornecedores = $query->result_array();
        foreach ($fornecedores as $fornecedor) {
            $result['items'][] = array(
                'id' => $fornecedor['CODIGO'],
                'nome_fantasia' => $fornecedor['NOME_FANTASIA']
            );
        }
        return $result;
    }

}
