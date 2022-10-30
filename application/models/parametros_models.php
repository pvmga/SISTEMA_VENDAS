<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parametros_models extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getEmpresas() {
        $sql = "SELECT
                    PAR_CASH.CODIGO,
                    PAR_CASH.NOME_FANTASIA,
                    PAR_CASH.LOGOMARCA
                    
                FROM PAR_CASH
                LEFT JOIN CON_PGTO ON (PAR_CASH.COD_CONDPGTO_PADRAO = CON_PGTO.CODIGO)";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function parametrosLogin($codigoEmpresa) {
        define('PAR_EMPRESA', $codigoEmpresa);

        $sql = "SELECT
                    ONLINE_CAD_CLIENTES, 
                    ONLINE_VIS_COMISSAO, 
                    ONLINE_LISTA_PRECOS, 
                    ONLINE_UTIL_AGENDA,
                    ONLINE_VIS_CLIENTES,
                    CASAS_DECIMAIS_VENDA,
                    ESTADO,
                    CALC_IMPOSTOS_NF,
                    PAR_CASH.ONLINE_VENDER_CLIENTE_BLOQ,
                    PAR_CASH.ONLINE_PERM_DIG_DESCONTO,
                    PAR_CASH.ONLINE_PERM_ALT_PRECOS,
                    PAR_CASH.ONLINE_ESTOQUE,
                    PAR_CASH.DESC_IPI_VENDA,
                    PAR_CASH.CODIGO AS COD_EMPRESA,
                    PAR_CASH.NOME_FANTASIA,
                    PAR_CASH.RAZAO_SOCIAL,
                    PAR_CASH.DIRETORIO,
                    PAR_CASH.DATABASE_INC_MOV,
                    
                    PAR_CASH.ONLINE_NOME_EMAIL_USUARIO,
                    PAR_CASH.ONLINE_PORT_SMTP,
                    PAR_CASH.ONLINE_SENHA_EMAIL_USUARIO,
                    PAR_CASH.ONLINE_USER_SMTP,
                    PAR_CASH.ONLINE_SERVER_SMTP_USUARIO,
                    PAR_CASH.EMAIL,
                    
                    PAR_CASH.TRANSP_PADRAO,
                    PAR_CASH.COD_CONDPGTO_PADRAO,
                    PAR_CASH.DESCONTO_MAXIMO,
                    PAR_CASH.ONLINE_DESC_MAX_VERIF,
                    PAR_CASH.ONLINE_COD_VEND_INTERNO_PADRAO,
                    
                    PAR_CASH.ENDERECO,
                    PAR_CASH.NUMERO_END,
                    PAR_CASH.CIDADE,
                    PAR_CASH.ESTADO,
                    PAR_CASH.TELEFONE,
                    PAR_CASH.FRETE_PADRAO,
                    
                    CON_PGTO.ACRESCIMO,

                    PAR_CASH.ONLINE_TRANSF_DESC_VENDA,
                    PAR_CASH.LOGOMARCA,
                    PAR_CASH.LOGO_CATALOGO,
                    PAR_CASH.CALC_RENTABILIDADE,

                    PAR_CASH.RAZAO_SOCIAL_PEDIDO, 
                    PAR_CASH.TELEFONE_PEDIDO, 
                    PAR_CASH.FAX_PEDIDO, 
                    PAR_CASH.CEP_PEDIDO, 
                    PAR_CASH.ENDERECO_PEDIDO,
                    PAR_CASH.NUMERO_END_PEDIDO,
                    PAR_CASH.COMPLEMENTO_END_PEDIDO,
                    PAR_CASH.BAIRRO_PEDIDO,
                    PAR_CASH.CIDADE_PEDIDO, 
                    PAR_CASH.ESTADO_PEDIDO,
                    PAR_CASH.EMAIL_PEDIDO,
                    PAR_CASH.META_VENDA_APARTIR_DIA,
                    PAR_CASH.VEND_VISUALIZA_VENDAS,
                    PAR_CASH.PRECO_MINIMO_PEDIDO,
                    PAR_CASH.TABELA_PRECO_MINIMO_PEDIDO,
                    PAR_CASH.VERIF_LIMITE_CREDITO,
                    PAR_CASH.AVISO_EST_NEGATIVO,
                    PAR_CASH.REPETICAO_ITENS,
                    PAR_CASH.ONLINE_OBS_ITEM
                    
                FROM PAR_CASH
                LEFT JOIN CON_PGTO ON (PAR_CASH.COD_CONDPGTO_PADRAO = CON_PGTO.CODIGO)
                WHERE
                    PAR_CASH.CODIGO = ?";
        $query = $this->db->query($sql, array($codigoEmpresa));

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }
}