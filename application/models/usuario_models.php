<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario_models extends CI_Model {

    public $variable;

    public function __construct() {
        parent::__construct();
    }

    /**
     * Buscar informações do login 
     * @param  String $login Apelido que o usuário usa para logar
     * @param  String $senha Senha do usuário
     * @return Array         Retorna array com informações o usuário
     */
    public function get_login($login = null, $senha = null) {
        $sql = "SELECT
                USR.CODIGO,
                USR.NOME,
                USR.APELIDO,
                USR.VENDEDOR,
                USR.SENHA,
                USR.PERM_EMPRESA,
                USR.VISUALIZAR_VENDAS,
                VEND.EMAIL,
                VEND.ESTADO,

                VEND.ENDERECO,
                VEND.BAIRRO,
                VEND.CIDADE,
                VEND.OBSERVACOES,
                VEND.TELEFONE,
                VEND.CELULAR,
                VEND.NOME AS NOME_VENDEDOR
            FROM CAD_USUA AS USR
            INNER JOIN CAD_VEND AS VEND ON (USR.VENDEDOR = VEND.CODIGO)
            WHERE
                VEND.TIPO = 'E' AND
                USR.ATIVO = 'S' AND
                (USR.APELIDO = ? AND USR.SENHA = ?)";
        $query = $this->db->query($sql, array($login, $senha));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    
    public function get_comissao() {
        $meses = array();
        $mes = intval(date('m'));
        $ano = intval(date('Y'));
        $fi = $this->session->userdata('CODIGO_EMPRESA');
        for ($i = 0; $i <= 11; $i++) {
            if ($mes == 0) {
                $mes = 12;
                $ano--;
            }
            $meses['ano' . str_pad($mes, 2, "0", STR_PAD_LEFT)] = array(
                'arquivo' => (file_exists('comissao/'.$fi. '_' . $ano . str_pad($mes, 2, "0", STR_PAD_LEFT) . '_' . str_pad($this->session->userdata('VENDEDOR'),3, "0", STR_PAD_LEFT) . '.pdf')) ? 'comissao/'.$fi. '_' . $ano . str_pad($mes, 2, "0", STR_PAD_LEFT) . '_' . str_pad($this->session->userdata('VENDEDOR'), 3, "0", STR_PAD_LEFT) . '.pdf' : "",
                'mes' => str_pad($mes, 2, "0", STR_PAD_LEFT) . "/" . $ano
            );
            $mes -= 1;
        }

        ksort($meses);
        return $meses;
    }

}