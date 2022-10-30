<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendas_models extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listagemTelaVendaAjax($vendedor, $tipo_pedido = 'N', $decimal = NULL, $data_venda_inicial = NULL, $data_venda_final = NULL, $codigo_cliente_buscar = NULL) {
        $base_url = base_url();
        $table = 'VENDA';
        
        // orçamentos e historico de pedidos
        $historico = "('V')";
        if ($tipo_pedido == 'O' || $tipo_pedido == 'H') {
            if ($tipo_pedido == 'H') {
                $historico = "('C', 'E')";
            }
            $table = 'VENDA2';
            $where = " AND V.DATA_VENDA BETWEEN '{$data_venda_inicial}' AND '{$data_venda_final}'";
        }

        // pedidos abertos
        if ($tipo_pedido == 'N') {
            $where = " AND V.DATA_VENDA BETWEEN '{$data_venda_inicial}' AND '{$data_venda_final}' AND V.DATA_FECHAMENTO IS NULL";
        }

        // pedidos fechados
        if ($tipo_pedido == 'S') {
            $where = " AND V.DATA_FECHAMENTO BETWEEN '{$data_venda_inicial}' AND '{$data_venda_final}'";
        }
        
        if ($codigo_cliente_buscar != 0) {
            $where .= " AND C.CODIGO = {$codigo_cliente_buscar}";
        }
        
        $sql = "SELECT
                    V.COD_VENDA, 
                    V.DATA_VENDA,
                    C.CODIGO AS COD_CLIE,
                    C.RAZAO_SOCIAL,
                    CP.DESCRICAO AS DESCRICAO_COND,
                    T.DESCRICAO AS TIPO_PAGTO,
                    --V.TRANSPORTE,
                    V.VALOR_PAGO,
                    V.COD_TRANSP,
                    NF.NDANOTA,
                    V.COD_CLIENTE,
                    V.SITUACAO
                FROM " . $this->session->userdata('DIRETORIO') . ".DBO." . $table . " V
                JOIN CAD_CLIE C ON(V.COD_CLIENTE = C.CODIGO)
                LEFT JOIN CON_PGTO CP ON(CP.CODIGO = V.COD_PAGAMENTO)
                LEFT JOIN CAD_TIPO T ON(T.SIGLA = V.TIPO_PAGTO)
                LEFT JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.NOTAF2 NF ON(NF.NDAVENDA = V.COD_VENDA)
                WHERE
                    V.COD_VENDEDOR_EXT = ? AND
                    V.SITUACAO IN {$historico} AND
                    V.CLASSIFICACAO IN ('I', 'A')
                    --V.PED_WEB = 'S'
                    $where";

        $query = $this->db->query($sql, array($vendedor));
        
        $data['data'] = array();
        foreach ($query->result_array() as $venda) {
            if ($venda['DATA_VENDA'] != NULL) {
                $date_venda = date_create($venda['DATA_VENDA']);
            }
            
            if ($tipo_pedido == 'S' || $tipo_pedido == 'N' || $tipo_pedido == 'H') {
                $alterar = '<a href="'.$base_url.'alterarVenda/' . $venda['COD_VENDA'] . '/V" class="btn btn-block btn-info btn-flat btnVisualizarPedido" title="Visualizar pedido">Visualizar</a>';
                if ($venda['SITUACAO'] == 'C') {
                    $fechar = '<button class="btn btn-block btn-default btn-flat" onclick="retornarStatusPedido('.$venda['COD_VENDA'].');">Retornar</button>';
                } else {
                    $fechar = '';
                }
                if ($venda['NDANOTA'] != '' && $tipo_pedido != 'H') {
                    $fechar = '<a href="'.$base_url.'venda/visualizardanfe/' . $venda['COD_CLIE'] . '/' . $venda['NDANOTA'] . '/" target="_blank" title="Salvar PDF"><img src="'.$base_url.'img/imagens/icones/pdf.jpg" width="30"/></a>';
                    $fechar .= '<a href="'.$base_url.'venda/visualizarxml/' . $venda['COD_CLIE'] . '/' . $venda['NDANOTA'] . '/" target="_blank" title="Salvar XML"><img src="'.$base_url.'img/imagens/icones/Xml-tool-icon.png" width="30"/></a>';
                }
            } else {
                $alterar = '<a href="'.$base_url.'alterarVenda/' . $venda['COD_VENDA'] . '/A" class="btn btn-block btn-warning btn-flat btnAlterar" title="Alterar pedido">Alterar</a> ';
                //$alterar .= '<a href="salvarVenda" class="btn btn-block btn-info btn-flat btnVisualizarPedido" title="Baixar PDF pedido.">Visualizar</a>';
                $fechar = '<a href="'.$base_url.'alterarVenda/' . $venda['COD_VENDA'] . '/F" class="btn btn-block btn-success btn-flat btnFechar" title="Fechar pedido">Confirmar Pedido</a>';
            }
            
            $tipo_envio = '';
            if ($tipo_pedido == 'H') {
                if ($venda['SITUACAO'] == 'C') {
                    $tipo_envio = '#e74c3c';
                } else {
                    $tipo_envio = 'green';
                }
            }

            $data['data'][] = [
                'cod_venda' => '<span style="color: '.$tipo_envio.';">'.$venda['COD_VENDA'].'</span>',
                'data_venda' => '<span style="color: '.$tipo_envio.';">'.date_format($date_venda, 'd/m/Y').'</span>',
                'razao_social' => '<span style="color: '.$tipo_envio.';">'.$venda['COD_CLIENTE'].'-'.$venda['RAZAO_SOCIAL'].'</span>',
                'descricao_cond' => '<span style="color: '.$tipo_envio.';">'.$venda['DESCRICAO_COND'].'</span>',
                'tipo_pagto' => '<span style="color: '.$tipo_envio.';">'.$venda['TIPO_PAGTO'].'</span>',
                //'transporte' => '<span style="color: '.$tipo_envio.';">'.$venda['TRANSPORTE'].'</span>',
                'total_venda' =>  'R$ '. (number_format($venda['VALOR_PAGO'], $decimal, ',', '')),
                'alterar' => $alterar,
                'fechar' => $fechar,
                'situacao' => $venda['SITUACAO'],
            ];
        }

        return $data;
    }
    
    public function getCountSales($vendedor, $data_hoje, $tipo_pedido) {
        $table = 'VENDA';
        
        // orçamentos
        if ($tipo_pedido == 'O') {
            $table = 'VENDA2';
            $where = " AND V.DATA_VENDA <= '{$data_hoje}'";
        }

        // pedidos abertos
        if ($tipo_pedido == 'N') {
            $where = " AND V.DATA_VENDA <= '{$data_hoje}' AND V.DATA_FECHAMENTO IS NULL";
        }

        // pedidos fechados
        if ($tipo_pedido == 'S') {
            $where = " AND V.DATA_VENDA <= '{$data_hoje}' AND V.DATA_FECHAMENTO IS NOT NULL";
        }
        
        $sql = "SELECT
                    V.COD_VENDA
                FROM " . $this->session->userdata('DIRETORIO') . ".DBO." . $table . " V
                WHERE
                    V.COD_VENDEDOR_EXT = ? AND
                    V.SITUACAO = 'V' --AND
                    --V.PED_WEB = 'S'
                    $where";

        $query = $this->db->query($sql, array($vendedor));


        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $venda) {
                $data['data'][] = [
                    'cod_venda' => $venda['COD_VENDA'],
                ];
            }
            return $data;
        } else {
            return false;
        }
    }

    public function graficoResumo($data_inicial, $data_final, $vendedor_ext, $data_meta) {
        $sql = "SELECT
                    SUM(V.VALOR_PAGO) AS QUANTIDADE_VENDA
                    --RIGHT('0' + CAST(MONTH(V.DATA_FECHAMENTO) AS VARCHAR(2)),2) AS MES,
                    --CAST(YEAR(V.DATA_FECHAMENTO) AS CHAR(4)) AS ANO
                FROM " . $this->session->userdata('DIRETORIO') . ".DBO.VENDA V
                WHERE
                    --(CAST(YEAR(V.DATA_FECHAMENTO) AS CHAR(4)) + RIGHT('0' + CAST(MONTH(V.DATA_FECHAMENTO) AS VARCHAR(2)),2)) BETWEEN ? AND ? AND
                    V.DATA_FECHAMENTO BETWEEN '{$data_inicial}' AND '{$data_final}' AND
                    V.COD_VENDEDOR_EXT = {$vendedor_ext} AND
                    V.SITUACAO = 'V' AND
                    V.CLASSIFICACAO IN ('I', 'A')

                --GROUP BY CAST(YEAR(V.DATA_FECHAMENTO) AS CHAR(4))--, RIGHT('0' + CAST(MONTH(V.DATA_FECHAMENTO) AS VARCHAR(2)),2)
                
                --ORDER BY CAST(YEAR(V.DATA_FECHAMENTO) AS CHAR(4))";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $venda) {
                $data[] = [
                    'QUANTIDADE_VENDA' => $venda['QUANTIDADE_VENDA'],
                    'ANO_MES' => substr($data_meta, 4, 2).'/'.substr($data_meta, 0, 4),
                    '$data_inicial' => $data_inicial,
                    '$data_final' => $data_final,
                    '$vendedor_ext' => $vendedor_ext
                ];
            }
            return $data;
        } else {
            return false;
        }
    }
    
    public function geraCodigoVenda($generator_nome = 'SEQ_VENDA') {
        $update = "UPDATE G SET G.GEN_VALUE = G.GEN_VALUE +1
                FROM " . $this->session->userdata('DIRETORIO') . ".DBO.GENERATOR G
                WHERE
                    G.GEN_CODIGO = ?";
        $this->db->query($update, array($generator_nome));
                
        $sql = "SELECT GEN_VALUE FROM " . $this->session->userdata('DIRETORIO') . ".DBO.GENERATOR WHERE GEN_CODIGO = ?";
        
        $query = $this->db->query($sql, array($generator_nome));
        
        return $query->row_array();
        
    }
    
    public function alterarObsItemPedidoModels($numero_pedido, $codigo, $sequencia, $observacao) {
        $update = "UPDATE " . $this->session->userdata('DIRETORIO') . ".DBO.ITENSVEN2 SET ITENSVEN2.OBSERVACAO = '{$observacao}'
                WHERE
                    ITENSVEN2.COD_VENDA = {$numero_pedido} AND ITENSVEN2.SEQUENCIA = {$sequencia} AND ITENSVEN2.COD_PROD = {$codigo}";
        
        return $this->db->query($update);
    }

    public function inserirVenda($dados, $tabelaVenda) {
        return $this->db->insert($this->session->userdata('DIRETORIO').'.DBO.'.$tabelaVenda, $dados);
    }

    public function deleteVenda($codigo_venda) {
        $this->db->where('COD_VENDA', $codigo_venda);
        return $this->db->delete($this->session->userdata('DIRETORIO').'.DBO.VENDA2');
    }
    
    public function inserirVendaItens($dados, $tabelaItens) {
        return $this->db->insert_batch($this->session->userdata('DIRETORIO').'.DBO.'.$tabelaItens, $dados);
    }
    
    public function deleteVendaItens($codigo_venda) {
        $this->db->where('COD_VENDA', $codigo_venda);
        return $this->db->delete($this->session->userdata('DIRETORIO').'.DBO.ITENSVEN2');
    }
    
    public function updateSituacaoPedido($codigo_venda, $tipo_venda) {
        $data = array(
                'SITUACAO' => $tipo_venda
        );

        $this->db->where('COD_VENDA', $codigo_venda);
        
        return $this->db->update($this->session->userdata('DIRETORIO').'.DBO.VENDA2', $data);
    }
    
    public function buscarPedido($numero_venda, $table) {
        $sql = "SELECT
                    V.COD_VENDA
                FROM " . $this->session->userdata('DIRETORIO') . ".DBO." . $table . " V
                WHERE
                    V.COD_VENDA = ? AND
                    V.COD_VENDEDOR_EXT = ?";

        $query = $this->db->query($sql, array($numero_venda, $this->session->userdata('VENDEDOR')));
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        
        return false;
    }
    
    public function buscarDadosPedido($numero_venda, $table) {
        $sql = "SELECT
                    V.COD_VENDA,
                    C.CODIGO AS CODIGO_CLIENTE,
                    C.RAZAO_SOCIAL,
                    CP.CODIGO AS CODIGO_CONDICAO_PAGAMENTO,
                    CP.DESCRICAO AS DESCRICAO_CONDICAO_PAGAMENTO,
                    T.CODIGO AS CODIGO_TIPO_PAGAMENTO,
                    T.DESCRICAO AS DESCRICAO_TIPO_PAGAMENTO,
                    T.SIGLA,
                    V.TRANSPORTE,
                    V.TOTAL_VENDA,
                    V.COD_TRANSP AS CODIGO_TRANSPORTADORA,
                    F.RAZAO_SOCIAL AS RAZAO_SOCIAL_TRANSPORTADORA,
                    C.LIMITE_CREDITO,
                    C.CIDADE,
                    C.ESTADO,
                    C.ENDERECO,
                    C.NUM_END_PRINCIPAL,
                    V.OBS_COMP,
                    C.ESTADO,
                    C.OPTANTE_SIMPLES,
                    C.EMAIL,
                    C.CODIGO_VENDEDOR,
                    VE.NOME AS NOME_VENDEDOR_INTERNO,
                    C.VENDEDOR_EXTERNO,
                    V2.NOME AS NOME_VENDEDOR_EXTERNO,
                    V.DATA_VENDA,
                    V.DATA_HORA_VENDA,
                    V.DATA_FECHAMENTO,
                    V.FRETE,
                    C.TELEFONE,
                    C.EMAIL
                FROM " . $this->session->userdata('DIRETORIO') . ".DBO." . $table . " V
                LEFT JOIN CAD_CLIE C ON(V.COD_CLIENTE = C.CODIGO)
                LEFT JOIN CON_PGTO CP ON(CP.CODIGO = V.COD_PAGAMENTO)
                LEFT JOIN CAD_FORN F ON(F.CODIGO = V.COD_TRANSP)
                LEFT JOIN CAD_TIPO T ON(T.SIGLA = V.TIPO_PAGTO)
                LEFT JOIN CAD_VEND VE ON(VE.CODIGO = C.CODIGO_VENDEDOR)
                LEFT JOIN CAD_VEND V2 ON(V2.CODIGO = C.VENDEDOR_EXTERNO)
                WHERE
                    V.COD_VENDA = ? AND
                    V.COD_VENDEDOR_EXT = ?";

        $query = $this->db->query($sql, array($numero_venda, $this->session->userdata('VENDEDOR')));
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        
        return false;
    }
    
    public function buscarItensPedido($numero_venda, $produto = NULL, $table, $sequencia = NULL) {
        $where = '';
        if ($produto != NULL) {
            $where = " AND V.COD_PROD = {$produto}";
            if ($sequencia != NULL) {
                $where .= " AND V.SEQUENCIA = {$sequencia}";
            }
        }
        
        $sql = "SELECT 
                    V.ACRESCIMO,
                    V.COD_PROD,
                    V.COD_VENDA,
                    V.DESCONTO,
                    V.IPI,
                    V.QUANTIDADE,
                    V.UNIDADE,
                    V.VALOR_CUSTO,
                    --V.VALOR_FRETE,
                    V.VALOR_UNIT,
                    C.DESCRICAO,
                    V.IPI,
                    V.SEQUENCIA,
                    V.DIF_ST,
                    V.CUSTO_PRODUTO,
                    V.ACRESCIMO,
                    V.OBSERVACAO,
                    C.GRUPO
                FROM " . $this->session->userdata('DIRETORIO') . ".DBO." . $table . " V
                JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST C ON(C.CODIGO = V.COD_PROD)
                WHERE
                    V.COD_VENDA = ?
                    $where
                ORDER BY V.SEQUENCIA";

        $query = $this->db->query($sql, array($numero_venda));
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        
        return false;
    }
    
    public function excluirProdutos($codigo_produto, $codigo_venda, $sequencia_produto) {
        $sql = "DELETE FROM ".$this->session->userdata('DIRETORIO').".DBO.ITENSVEN2 WHERE COD_PROD = ? AND COD_VENDA = ? AND SEQUENCIA = ?";
        $query = $this->db->query($sql, array($codigo_produto, $codigo_venda, $sequencia_produto));
    }
    
    public function notaCliente($cliente, $nota) {
        $query = $this->db->query("SELECT
                                    FILE_PDF_NFE,
                                    FILE_XML_NFE
                                FROM
                                    " . $this->session->userdata('DIRETORIO') . ".dbo.NOTAF2
                                WHERE
                                    NDANOTA = '$nota' and
                                    COD_CLIE = '$cliente'");
        return $query->row_array();
    }
    
    public function metavendas($data_meta, $data_init, $data_final, $vendedor) {
        // PARAMETRO DATA DEVE RECEBER UMA DATA '201807'
        $query = $this->db->query("(
                                    SELECT
                                        --CAST(SUBSTRING(M.MES_ANO, 4, 4)+''+SUBSTRING(M.MES_ANO, 1, 2)+'01' AS DATE) AS DATA_FILTRO,
                                        M.VALOR
                                    FROM METAS_VEND M
                                    WHERE
                                        SUBSTRING(M.MES_ANO, 4, 4)+''+SUBSTRING(M.MES_ANO, 1, 2) = '{$data_meta}' AND
                                        M.COD_VENDEDOR = {$vendedor}
                                    ) UNION ALL (
                                    SELECT
                                        --CAST(YEAR(V.DATA_FECHAMENTO) AS CHAR(4))+''+RIGHT('0' + CAST(MONTH(V.DATA_FECHAMENTO) AS VARCHAR(2)),2)+'01' AS DATA_FILTRO,
                                        SUM(V.VALOR_PAGO) AS VALOR
                                    FROM ".$this->session->userdata('DIRETORIO').".DBO.VENDA V
                                    WHERE
                                        V.DATA_FECHAMENTO BETWEEN '{$data_init}' AND '{$data_final}' AND
                                        V.COD_VENDEDOR_EXT = {$vendedor} AND
                                        V.SITUACAO = 'V' AND
                                        V.CLASSIFICACAO IN ('I', 'A')

                                    --GROUP BY CAST(YEAR(V.DATA_FECHAMENTO) AS CHAR(4)), RIGHT('0' + CAST(MONTH(V.DATA_FECHAMENTO) AS VARCHAR(2)),2)
                                    )");

        return $query->result_array();
    }
    
}

/* End of file vendas_models.php */
/* Location: ./application/models/vendas_models.php */
