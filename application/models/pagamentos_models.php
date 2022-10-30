<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pagamentos_models extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function listaCondicaoPagamentoAjax($condicaoPagamento = NULL) {
        /* Combo que alimenta clientes da venda */
        $sql = "SELECT
                    CODIGO,
                    DESCRICAO
                FROM CON_PGTO
                WHERE
                    (
                        CODIGO LIKE ?
                        OR
                        DESCRICAO LIKE ?
                    ) AND
                    ATIVO = 'S' AND
                    ECOMMERCE = 'S'";

        $query = $this->db->query($sql, array('%' . $condicaoPagamento . '%', '%' . $condicaoPagamento . '%'));

        $pagamentos = $query->result_array();
        foreach ($pagamentos as $pagamento) {
            $result['items'][] = array(
                'id' => $pagamento['CODIGO'],
                'descricao' => $pagamento['DESCRICAO'],
            );
        }
        return $result;
    }
    
    public function listaTipoPagamentoAjax($tipoPagamento = NULL) {
        /* Combo que alimenta clientes da venda */
        $sql = "SELECT
                    CODIGO,
                    DESCRICAO,
                    SIGLA
                FROM CAD_TIPO
                WHERE
                    (
                        CODIGO LIKE ?
                        OR
                        DESCRICAO LIKE ?
                    ) AND
                    ATIVO = 'S' AND
                    ECOMMERCE = 'S'";

        $query = $this->db->query($sql, array('%' . $tipoPagamento . '%', '%' . $tipoPagamento . '%'));

        $pagamentos = $query->result_array();
        foreach ($pagamentos as $pagamento) {
            $retorno[] = array(
                'id' => $pagamento['SIGLA'],
                'descricao' => $pagamento['DESCRICAO'],
                'codigo' => $pagamento['CODIGO'],
            );
        }
        $result['items'] = $retorno;
        return $result;
    }

}
