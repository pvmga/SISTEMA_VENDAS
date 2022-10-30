<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produtos_models extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function listaProdutoAjax($produto = NULL, $estado_cliente, $optante_simples_cliente, $parametros, $decimal, $calcula_st, $desconsidera_ipi, $cod_condicao_pagamento, $em_massa = 'S', $tipo_busca) {
        // caso seja N significa que não poderá mostrar produtos cujo o estoque seja menor ou igual a 0
        $where = " C.ECOMMERCE = 'S' AND C.ATIVO = 'S'";
        $where .= ($parametros['ONLINE_ESTOQUE'] == 'N') ? " AND C2.ESTOQUEATUAL > 0" : "";
        if ($tipo_busca != 'string') {
            if ($tipo_busca == 'codigo') {
                $where .= " AND C.CODIGO = {$produto}";
            } else if ($tipo_busca == 'descricao') {
                $where .= " AND C.DESCRICAO LIKE '%{$produto}%'";
            } else if ($tipo_busca == 'ref_fabricante') {
                $where .= " AND C.REF_FABRICANTE = '{$produto}'";
            }
        } else {
            if ($em_massa == 'N') {
                $where = " C.CODIGO = {$produto}";
            } else {
                $words = explode(" ", $produto);
                if (count($words) > 0) {
                    foreach($words as $word) {
                        $where .= " AND (C.DESCRICAO LIKE '%{$word}%' OR C.CODIGO LIKE '{$word}%')";
                    }
                }
            }
        }
        $tipo_preco = $this->session->userdata('CALC_RENTABILIDADE');
        $coluna_tipo_preco = 'PRECO_CUSTO';
        if ($tipo_preco == 'C') {
            $coluna_tipo_preco = 'CUSTO_BRUTO';
        }
        
        $sql = "SELECT
                    C.CODIGO,
                    C.DESCRICAO,
                    C2.ESTOQUEATUAL,
                    C.PRECO_VENDA_A,
                    C.ALIQUOTAIPIVENDA,
                    C.PROMOCIONAL,
                    C.".$coluna_tipo_preco." AS CUSTO_BRUTO,
                    C.PESO,
                    C.GRUPO,
                    C.COMPLEMENTO,
                    C.EMBALAGEM_VENDA,
                    C.PRECO_VENDA_V,
                    C.PRECO_PROMOCIONAL,
                    C.PRECO_VENDA_C,
                    C.PRECO_VENDA_5,
                    C.PRECO_VENDA_6,

                    (SELECT
                        COND.ACRESCIMO
                    FROM CON_PGTO COND
                    WHERE
                        COND.CODIGO = ?) AS ACRESCIMO,
                    (SELECT
                        TOP(1) PERC_DESC
                    FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST_DESC CD
                    WHERE
                        (GETDATE() BETWEEN CD.DATA_HORA_INICIAL AND CD.DATA_HORA_FINAL) AND
                        CD.COD_PROD = C.CODIGO) AS PERC_DESCONTO

                FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST C
                JOIN " . $this->session->userdata('DATABASE_INC_MOV') . ".DBO.CAD_IEST C2 ON(C.CODIGO = C2.CODIGO)
                WHERE
                    $where";

        $query = $this->db->query($sql, $cod_condicao_pagamento);
    
        $produtos = $query->result_array();
        foreach ($produtos as $produto) {
            
            $preco_base_validacao = '0';
            if ($this->session->userdata('PRECO_MINIMO_PEDIDO') == 'S') {
                if ($parametros['TABELA_PRECO_MINIMO_PEDIDO'] == 1) {
                    $preco_base_validacao = $produto['PRECO_VENDA_A'];
                } else if ($parametros['TABELA_PRECO_MINIMO_PEDIDO'] == 2) {
                    $preco_base_validacao = $produto['PRECO_VENDA_V'];
                } else if ($parametros['TABELA_PRECO_MINIMO_PEDIDO'] == 3) {
                    $preco_base_validacao = $produto['PRECO_PROMOCIONAL'];
                } else if ($parametros['TABELA_PRECO_MINIMO_PEDIDO'] == 4) {
                    $preco_base_validacao = $produto['PRECO_VENDA_C'];
                } else if ($parametros['TABELA_PRECO_MINIMO_PEDIDO'] == 5) {
                    $preco_base_validacao = $produto['PRECO_VENDA_5'];
                } else {
                    $preco_base_validacao = $produto['PRECO_VENDA_6'];
                }
            }

            if ($this->session->userdata('ONLINE_DESC_MAX_VERIF') == 'I') {
                $percentual = ($produto['PERC_DESCONTO'] != NULL) ? $produto['PERC_DESCONTO'] : 0;
                $promocional = $produto['PROMOCIONAL'];

            } else {
                $percentual = $this->session->userdata('DESCONTO_MAXIMO');
                $promocional = 'N';
            }
            
            $percentual_acrecimo = ($produto['ACRESCIMO'] != NULL) ? $produto['ACRESCIMO'] : 0;
            $preco_venda_a = round($produto['PRECO_VENDA_A']+($produto['PRECO_VENDA_A'] * ($percentual_acrecimo / 100)), 3);
            
            // calculo de desconto com percentual de promoção
            $preco_venda_a = round($preco_venda_a - ($preco_venda_a *($percentual / 100)), 3); // estava com duas casas decimais
            
            // calcula ST produto
            $preco_st = $this->retornaImposto($preco_venda_a, $produto['CODIGO'], $estado_cliente, $optante_simples_cliente, $parametros, $decimal, $calcula_st, $produto['ALIQUOTAIPIVENDA'], $desconsidera_ipi);
            
            $result['items'][] = array(
                'id' => $produto['CODIGO'],
                'descricao' => $produto['DESCRICAO'],
                'estoqueatual' => number_format($produto['ESTOQUEATUAL'], 0, ',', '.'),
                'preco_venda_a' => number_format($produto['PRECO_VENDA_A'], $decimal, ',', ''),
                'preco_st' => number_format($preco_st, $decimal, ',', '.'),
//                'preco_st' => number_format($preco_st - $preco_venda_a, $decimal, ',', '.'),
                'aliquota_ipi' => ($desconsidera_ipi == 'S') ? 0 : number_format($produto['ALIQUOTAIPIVENDA'], $decimal, '.', ''),
                'promocional' => $promocional,
//                'percentual' => number_format($percentual, 2, ',', ''),
                'percentual' => ($percentual == 0) ? '': number_format($percentual, 2),
                'preco_original' => number_format($produto['PRECO_VENDA_A'], $decimal, ',', ''),
                'percentual_acrescimo' => number_format($percentual_acrecimo, $decimal),
                'custo_bruto' => $produto['CUSTO_BRUTO'],
                'peso' => number_format($produto['PESO'], $decimal, ',', '.'),
                'cod_grupo' => $produto['GRUPO'],
                'complemento' => $produto['COMPLEMENTO'],
                'tipo_busca' => $tipo_busca,
                'embalagem_venda' => $produto['EMBALAGEM_VENDA'],
                'preco_base_validacao' => number_format($preco_base_validacao, $decimal, ',', ''),
            );
        }
        if ($query->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
    
    public function recuperarFotoProduto($codigo_produto, $decimal) {
        $sql = "SELECT
                    C.CODIGO,
                    C.FOTO_PRODUTO,
                    G.DESCRICAO AS GRUPO,
                    U.UNIDADE,
                    C2.ESTOQUEATUAL,
                    C.COMPLEMENTO,
                    C.REF_FABRICANTE,
                    C.INFORMACOES,
                    C.PESO,
                    C.DETALHES,
                    C.INF_TECNICAS,
                    C.GARANTIA,
                    C.OBSERVACOES
                FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST C
                JOIN " . $this->session->userdata('DATABASE_INC_MOV') . ".DBO.CAD_IEST C2 ON(C.CODIGO = C2.CODIGO)
                LEFT JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_GRUP G ON(C.GRUPO = G.CODIGO)
                LEFT JOIN CAD_UNID U ON(C.UNIDADE = U.CODIGO)
                WHERE
                    C.ECOMMERCE = 'S' AND
                    C.ATIVO = 'S' AND
                    C.CODIGO = ?";

        $query = $this->db->query($sql, $codigo_produto);

        $produtos = $query->result_array();
        foreach ($produtos as $produto) {
            
            $result['items'][] = array(
                'id' => $produto['CODIGO'],
                'estoqueatual' => number_format($produto['ESTOQUEATUAL'], 0, ',', '.'),
                'foto_produto' => base64_encode($produto['FOTO_PRODUTO']),
                'complemento' => $produto['COMPLEMENTO'],
                'fabricante' => $produto['REF_FABRICANTE'],
                'grupo' => $produto['GRUPO'],
                'unidade' => $produto['UNIDADE'],
                'obs_cadastro' => $produto['INFORMACOES'],
                'peso' => number_format($produto['PESO'], $decimal, ',', ''),
                'detalhes' => $produto['DETALHES'],
                'inf_tecnicas' => $produto['INF_TECNICAS'],
                'garantia' => $produto['GARANTIA'],
                'observacoes' => $produto['OBSERVACOES']
            );
        }
        if ($query->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
    
//    public function recuperarAcrescimoCondPagamento($codigo = null) {
//        $sql = "SELECT
//                    CODIGO,
//                    ACRESCIMO
//                FROM CON_PGTO
//                WHERE
//                    CODIGO = ? AND
//                    ATIVO = 'S' AND
//                    ECOMMERCE = 'S'";
//        $query = $this->db->query($sql, array($codigo));
//                                    
//        if ($query->num_rows() > 0)
//            return $query->row();
//        else
//            return false;                            
//
//    }

    public function recuperarPercentualPromocao($codigo = null) {
        $sql = "SELECT
                    TOP(1) PERC_DESC,
                    C.CODIGO

                FROM " . $this->session->userdata('DIRETORIO') . ".dbo.CAD_IEST C
                JOIN " . $this->session->userdata('DIRETORIO') . ".dbo.CAD_IEST_DESC CD ON(C.CODIGO = CD.COD_PROD)
                WHERE
                    (GETDATE() BETWEEN CD.DATA_HORA_INICIAL AND CD.DATA_HORA_FINAL)
                    AND
                    C.CODIGO = {$codigo}

                ORDER BY CD.SEQUENCIA DESC";
        $query = $this->db->query($sql, array($codigo));
                                    
        if ($query->num_rows() > 0)
            return $query->row();
        else
            return false;                            

    }
    
    public function listagemTelaProdutoAjax($decimal, $online_estoque, $data_inicial, $data_final) {
        // caso seja N significa que não poderá mostrar produtos cujo o estoque seja menor ou igual a 0
        $where = ($online_estoque == 'N') ? " AND C2.ESTOQUEATUAL > 0" : "";
        
        $sql = "SELECT
                    C.CODIGO,
                    C.DESCRICAO,
                    C2.ESTOQUEATUAL,
                    C.PRECO_VENDA_A,
                    G.DESCRICAO AS DESCRICAO_GRUPO,
                    (
                    SELECT (ISNULL(R.TOTAL_QTDE, 0.00))
                    FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST C3
                    JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.PROD_RESERVADOS R ON (C3.CODIGO = R.COD_PROD)
                    WHERE C3.CODIGO = C.CODIGO
                    ) AS TOTAL_RESERVADO,
                    
                    (
                    SELECT TOP 1  CD.PERC_DESC
                    FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST_DESC CD
                    WHERE
                       CD.COD_PROD = C.CODIGO AND
                       (GETDATE() BETWEEN CD.DATA_HORA_INICIAL AND CD.DATA_HORA_FINAL)
                    ORDER BY CD.SEQUENCIA DESC
                    ) AS PERC_DESC,
                    
                    (
                    SELECT
                        SUM(I.QUANTIDADE) AS QUANTIDADE
                    FROM " . $this->session->userdata('DIRETORIO') . ".DBO.VENDA V
                    JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.ITENSVEN I ON(V.COD_VENDA = I.COD_VENDA)
                    WHERE
                        I.COD_PROD = C.CODIGO AND
                        V.DATA_FECHAMENTO BETWEEN '{$data_inicial}' AND '{$data_final}'
                    ) AS QUANTIDADE_VENDIDA

                FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST C
                JOIN " . $this->session->userdata('DATABASE_INC_MOV') . ".DBO.CAD_IEST C2 ON(C.CODIGO = C2.CODIGO)
                JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_GRUP G ON(C.GRUPO = G.CODIGO)
                JOIN CAD_UNID U ON(C.UNIDADE = U.CODIGO)
                WHERE
                    C.ECOMMERCE = 'S' AND
                    C.ATIVO = 'S'
                    $where";
        
        $query = $this->db->query($sql);
        
        foreach ($query->result_array() as $produto) {
            
            if ($this->session->userdata('ONLINE_DESC_MAX_VERIF') == 'I') {
                $percentual = ($produto['PERC_DESC'] != NULL) ? $produto['PERC_DESC'] : 0;

            } else {
                $percentual = $this->session->userdata('DESCONTO_MAXIMO');
            }
            
            $background = '';
            $font_color = '';
            if ($produto['PERC_DESC'] > 0) {
                $background = '#e74c3c';
                $font_color = 'white';
            }
            
            $background_estoque = '';
            if ($produto['ESTOQUEATUAL'] <= 0) {
                $background_estoque = 'color: #e74c3c; background-color: #2c3e50;';
            }
            
            $disponivel = $produto['ESTOQUEATUAL'] - $produto['TOTAL_RESERVADO'];
            $data['data'][] = [
                'codigo' => $produto['CODIGO'],
                'descricao' => $produto['DESCRICAO'],
                'grupo' => $produto['DESCRICAO_GRUPO'],
                'estoqueatual' => '<span style="'.$background_estoque.'">'.number_format($produto['ESTOQUEATUAL'], 2, ',', '').'</span>',
                'reservado' => number_format($produto['TOTAL_RESERVADO'], 2, ',', ''),
                'disponivel' => number_format($disponivel, 2, ',', ''),
                'preco_venda_a' => number_format($produto['PRECO_VENDA_A'], $decimal, ',', '.'),
                'perc_desc' => '<span class="lista_percentual_desconto" style="background-color: '.$background.'; color: '.$font_color.'">'.number_format($produto['PERC_DESC'], $decimal, ',', '').'</span>',
                'quantidade_vendida' => number_format($produto['QUANTIDADE_VENDIDA'], $decimal, ',', ''),
                'visualizar' => "<button class='btn btn-flat btn-info' onclick='visualizarInformacoesProduto(".$produto['CODIGO'].");'>Visualizar</button>",
            ];
        }
        
        if ($query->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }
    
    public function listaProdutoTelaDeLista($decimal, $online_estoque, $condicao_pagamento) {
        // caso seja N significa que não poderá mostrar produtos cujo o estoque seja menor ou igual a 0
        $where = ($online_estoque == 'N') ? " AND C2.ESTOQUEATUAL > 0" : "";
        
        $sql = "SELECT
                    C.CODIGO,
                    C.DESCRICAO,
                    C2.ESTOQUEATUAL,
                    C.PRECO_VENDA_A,
                    C.COMPLEMENTO,
                    C.EMBALAGEM_VENDA,
                    (
                    SELECT (ISNULL(R.TOTAL_QTDE, 0.00))
                    FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST C3
                    JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.PROD_RESERVADOS R ON (C3.CODIGO = R.COD_PROD)
                    WHERE C3.CODIGO = C.CODIGO
                    ) AS TOTAL_RESERVADO,
        
                    (SELECT
                        COND.ACRESCIMO
                    FROM CON_PGTO COND
                    WHERE
                        COND.CODIGO = ?) AS ACRESCIMO,
                    (SELECT
                        TOP(1) PERC_DESC
                    FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST_DESC CD
                    WHERE
                        (GETDATE() BETWEEN CD.DATA_HORA_INICIAL AND CD.DATA_HORA_FINAL) AND
                        CD.COD_PROD = C.CODIGO) AS PERC_DESCONTO

                FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST C
                JOIN " . $this->session->userdata('DATABASE_INC_MOV') . ".DBO.CAD_IEST C2 ON(C.CODIGO = C2.CODIGO)
                WHERE
                    C.ECOMMERCE = 'S' AND
                    C.ATIVO = 'S'
                    $where";
        
        $query = $this->db->query($sql, array($condicao_pagamento));
        
        
        foreach ($query->result_array() as $produto) {
            
            $percentual_acrecimo = ($produto['ACRESCIMO'] != NULL) ? $produto['ACRESCIMO'] : 0;
            // apenas para mostrar no combo o valor já com desconto de condição de pagamento.
            $preco_venda_a = $produto['PRECO_VENDA_A']+($produto['PRECO_VENDA_A'] * ($percentual_acrecimo / 100));

            if ($this->session->userdata('ONLINE_DESC_MAX_VERIF') == 'I') {
                $percentual = (!empty($produto['PERC_DESCONTO'])) ? $produto['PERC_DESCONTO'] : 0;

            } else {
                $percentual = $this->session->userdata('DESCONTO_MAXIMO');
            }

            $background = '';
            $font_color = '';
            if ($percentual > 0) {
                $background = '#e74c3c';
                $font_color = 'white';
            }
            
            $background_estoque = '';
            if ($produto['ESTOQUEATUAL'] <= 0) {
                $background_estoque = 'color: #e74c3c; background-color: #2c3e50;';
            }
            
            // calculo de desconto com percentual de promoção
            $preco_st = $preco_venda_a - ($preco_venda_a *($percentual / 100));
            $disponivel = $produto['ESTOQUEATUAL'] - $produto['TOTAL_RESERVADO'];
            $data['data'][] = [
                'codigo' => $produto['CODIGO'],
                'descricao' => $produto['DESCRICAO'],
                'estoqueatual' => '<span style="'.$background_estoque.'">'.number_format($produto['ESTOQUEATUAL'], 2, ',', '').'</span>',
                'reservado' => number_format($produto['TOTAL_RESERVADO'], 2, ',', ''),
                'disponivel' => number_format($disponivel, 2, ',', ''),
                'preco_venda_a' => number_format($produto['PRECO_VENDA_A'], $decimal, ',', '.'),
                'acrescimo' => number_format($produto['ACRESCIMO'], $decimal, ',', '.'),
//                'desconto' => '<span class="lista_percentual_desconto" style="background-color: '.$background.'; color: '.$font_color.'">'.(!empty($produto['PERC_DESCONTO'])).'</span>',
                'desconto' => '<span class="lista_percentual_desconto" style="background-color: '.$background.'; color: '.$font_color.'">'.number_format($produto['PERC_DESCONTO'], $decimal, ',', '.').'</span>',
                'total_sem_impostos' => number_format($preco_st, $decimal, ',', '.'),
                'complemento' => $produto['COMPLEMENTO'],
                'input' => "<input id='mtqtde".$produto['CODIGO']."' onchange='produtosParaAdicionar(".$produto['CODIGO'].",(this).value, ".$percentual.", ".$disponivel.", ".$produto['EMBALAGEM_VENDA'].");' 'class='lista_quantidade_digitada' type='text' value='' />",
            ];
        }
        
        if ($query->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }
    
    public function listarGrupos() {
        $query = $this->db->query("SELECT
                                        CODIGO, 
                                        DESCRICAO
                                        --CASE WHEN (RELEVANCIA IS NULL) THEN 999 ELSE RELEVANCIA END AS ORDEM
                                    FROM 
                                        " . $this->session->userdata('DIRETORIO') . ".dbo.CAD_GRUP
                                    WHERE 
                                        ATIVO = 'S' AND 
                                        ECOMMERCE = 'S'
                                    ORDER BY
                                        --ORDEM
                                        DESCRICAO");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function listarSubgrupos() {
        $query = $this->db->query("SELECT
                                    CODIGO,
                                    DESCRICAO
                                FROM " . $this->session->userdata('DIRETORIO') . ".dbo.SUBGRUPO
                                WHERE
                                        ATIVO = 'S' AND
                                    ECOMMERCE = 'S'
                                ORDER BY DESCRICAO");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    public function buscarSimilarMelhorado($grupo = NULL, $subgrupo = NULL) {

        $where = ($grupo != 0) ? " AND C.GRUPO = {$grupo}" : "AND C.GRUPO > 0";
        $where .= ($subgrupo != 0) ? " AND C.SUBGRUPO = {$subgrupo}" : '';
        $query = $this->db->query("SELECT
                                        --TOP 250
                                        C.CODIGO,
                                        C.DESCRICAO AS DESCRICAO,
                                        C.FOTO,
                                        C.GRUPO AS GRUPO,
                                        G.DESCRICAO AS DESCRICAO_GRUPO,
                                        G.RELEVANCIA AS RELEVANCIA_GRUPO,
                                        S.DESCRICAO AS DESCRICAO_SUBGRUPO,
                                        S.RELEVANCIA AS RELEVANCIA_SUBGRUPO,
                                        G.IMAGEM

                                    FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_SIMILAR C
                                    LEFT JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_GRUP G ON(G.CODIGO = C.GRUPO)
                                    LEFT JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.SUBGRUPO S ON(S.CODIGO = C.SUBGRUPO)
                                    WHERE
                                        C.ATIVO = 'S' AND
                                        G.ECOMMERCE = 'S' --AND C.CODIGO BETWEEN 755 AND 776
                                        $where
                                    ORDER BY G.RELEVANCIA, S.RELEVANCIA, C.DESCRICAO");
        
        if ($query->num_rows() > 0) {
            $grupo_anterior = 0;
            $upload_capa = '';
            $upload_grupo = '';
            $upload_foto = '';
            
            $foto_capa = './files/catalogo/capa.png';
            $file = "data:image/png;base64," . base64_encode($this->session->userdata('LOGO_CATALOGO'));
            $arquivoBinário = file_get_contents($file);

            $fp = fopen($foto_capa, 'w');
            fwrite($fp, $arquivoBinário);
            fclose($fp);
//            $upload_capa = $this->uploadArquivos('capa.png');
            $quantidade_sem_itens = 0;
            foreach ($query->result_array() as $key => $produto) {
                $itens_similar = $this->buscarSimilarItens($produto['CODIGO']);
                $foto = './img/grupo_padrao_catalogo.png';
                //if ($grupo_anterior != $produto['GRUPO']) {
                    //$grupo_anterior = $produto['GRUPO'];
                    if ($produto['IMAGEM'] != '') {
                        // Arquivo
                        // CRIAR OPÇÃO PARA QUANDO EXISTIR IMAGEM NÃO CRIAR OUTRA.
                        $foto = './files/catalogo/' . $produto['GRUPO'] . '_grupo.png';
                        $file = "data:image/png;base64," . base64_encode($produto['IMAGEM']);
                        $arquivoBinário = file_get_contents($file);

                        $fp = fopen($foto, 'w');
                        fwrite($fp, $arquivoBinário);
                        fclose($fp);
                    }
//                    $upload_grupo = $this->uploadArquivos($produto['GRUPO'] . '_grupo.png');
                //}
                if ($itens_similar[0]['COD_SIMILAR'] != '') {
                    $existe_foto_pasta = '';
                    if ($produto['FOTO'] == '') {
                        $arquivo = './img/catalogo/1.jpg';
                        $existe_foto_pasta = 'BANCO_SEM_IMAGEM';
                    } else {
                        // Arquivo
                        // CRIAR OPÇÃO PARA QUANDO EXISTIR IMAGEM NÃO CRIAR OUTRA.
                        $arquivo = './files/catalogo/' . $produto['CODIGO'] . '.png';
    //                    $existe_foto_pasta = 'EXISTE_FOTO_PASTA';
                        $file = "data:image/png;base64," . base64_encode($produto['FOTO']);
                        $arquivoBinário = file_get_contents($file);

                        $fp = fopen($arquivo, 'w');
                        fwrite($fp, $arquivoBinário);
                        fclose($fp);
                    }

    //                $upload_foto = $this->uploadArquivos($produto['CODIGO'] . '.png');
                    $data[] = array(
                        'CODIGO' => $produto['CODIGO'],
                        'DESCRICAO' => $produto['DESCRICAO'],
                        'GRUPO' => $produto['GRUPO'],
                        'DESCRICAO_GRUPO' => $produto['DESCRICAO_GRUPO'],
                        'FOTO' => $arquivo,
    //                    'FOTO' => $produto['CODIGO'],
                        'FOTO_GRUPO' => $foto,
    //                    'FOTO_GRUPO' => $produto['GRUPO'],
                        'FOTO_CAPA' => $foto_capa,
                        'EXISTE_FOTO_PASTA' => $existe_foto_pasta,
                        'UPLOAD_FOTO' => $upload_foto,
                        'UPLOAD_GRUPO' => $upload_grupo,
                        'UPLOAD_CAPA' => $upload_capa,
                    );

                    $quantidade = 0;
                    if (isset($itens_similar[0])) {
                        foreach ($itens_similar as $itens) {
                            if ($quantidade < 9) {
                                $data[$key-$quantidade_sem_itens]['ITENS'][] = array(
                                    'COD_SIMILAR' => $itens['COD_SIMILAR'],
                                    'COD_ITEM' => $itens['COD_ITEM'],
                                    'DESCRICAO_PRODUTO' => $itens['REF_FABRICANTE']
                                );
                            }
                            $quantidade++;
                        }
                    } else {
//                        $key = $key -1;
                        $data[$key-$quantidade_sem_itens]['ITENS'][] = array(
                            'COD_SIMILAR' => '',
                            'COD_ITEM' => '',
                            'DESCRICAO_PRODUTO' => ''
                        );
                    }
    //                if (isset($itens_similar[0]) != 1) {
    //                    unset($data[$key]);
    //                }
                } else {
                    $quantidade_sem_itens += 1;
                }
            }
            
            return ($data);
        } else {
            return false;
        }
    }
    
    public function uploadArquivos($arquivo) {
        $ftp_server="ftp.ingasoft.com.br"; 
        $ftp_user_name="ingasoft"; 
        $ftp_user_pass="tlo1980"; 
        $file = "./files/catalogo/".$arquivo; // meu arquivo;
        $remote_file = "/public_html/download/fotos/".$arquivo;// arquivo a ser feito upload; 

        // set up basic connection 
        $conn_id = ftp_connect($ftp_server); 

        // login with username and password 
        $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

        // upload a file 
        if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)) { 
//        if (ftp_put($conn_id, "/public_html/download/fotos/texto.txt", base_url()."files/catalogo/1490.png", FTP_BINARY)) { 
            $tipo = true;
        } else { 
            $tipo = false;
        } 
        // close the connection 
        ftp_close($conn_id);
        return $tipo;
    }
    
    public function buscarSimilar($grupo = NULL, $tipo_preco = NULL, $subgrupo = NULL, $promocional = NULL) {
                
        $where = ($grupo != NULL) ? " AND C.GRUPO = {$grupo}" : " AND C.GRUPO <> -1";
        $where .= ($subgrupo != NULL) ? " AND P.SUBGRUPO = {$subgrupo}" : '';
        $where .= ($promocional != NULL) ? " AND P.PROMOCIONAL = '{$promocional}'" : '';
        $query = $this->db->query(";WITH TB AS
                                    (

                                    SELECT
                                        C.CODIGO,
                                        C.DESCRICAO AS DESCRICAO,
                                        --C.FOTO AS FOTO,
                                        FOTO,
                                        P.". $tipo_preco ." AS PRECO_VENDA_A,
                                        P.PRECO_VENDA_6 AS PRECO_VENDA_V,
                                        P.CODIGO AS CODIGO_PRODUTO,
                                        C.GRUPO AS GRUPO,
                                        G.DESCRICAO AS DESCRICAO_GRUPO,
                                        P.ALIQUOTAIPIVENDA,
                                        P.PROMOCIONAL,

                                        ROW_NUMBER() OVER (PARTITION BY C.CODIGO ORDER BY C.CODIGO) ROW

                                    FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_SIMILAR C

                                    JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_ITENS_SIMILAR I ON(C.CODIGO = I.COD_SIMILAR)
                                    JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST P ON(I.COD_ITEM = P.CODIGO)
                                    JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_GRUP G ON(G.CODIGO = C.GRUPO)
                                    WHERE
                                        P.ATIVO = 'S' AND
                                        P.LISTA_PRECOS = 'S'
                                    $where
                                    )

                                    SELECT * FROM TB
                                    WHERE ROW = 1
                                    ORDER BY TB.GRUPO, TB.DESCRICAO");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    public function buscarSimilarItens($codigoSimilar = NULL, $filtro = NULL) {
        
        if ($filtro == NULL) {
            $where = "AND C2.ESTOQUEATUAL > 0 AND C2.ATIVO = 'S' AND C2.ECOMMERCE = 'S'";
        } else {
            $where = "";
        }
        
        $sql = "SELECT C.*,
                    C2.REF_FABRICANTE, C2.PESO, C2.ESTOQUEATUAL, C2.DESCRICAO
                FROM 
                    " . $this->session->userdata('DIRETORIO') . ".dbo.CAD_ITENS_SIMILAR C
                    JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST C2 ON(C.COD_ITEM = C2.CODIGO)
                WHERE
                    C.COD_SIMILAR = ? $where
                ORDER BY C2.PRECO_VENDA_A";
                                        
        $query = $this->db->query($sql, $codigoSimilar);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    public function retornaImposto($valor_venda = NULL, $codigoProduto = NULL, $estado = NULL, $optante = NULL, $parametros = NULL, $decimal = NULL, $calcula_st, $aliquota_ipi = NULL, $desconsidera_ipi = NULL) {
        if ($estado == '') {
            $estado = 'PR';
        }
        $aliquota = $this->aliquotaEstado($estado);
//        $informacoes_produtos = $this->percentualNBMI($estado, $codigoProduto);
        
        if ($desconsidera_ipi == 'S') {
            $aliquota_ipi = 0;
        }
        
        $valor_venda_st = round($valor_venda + ($valor_venda * $aliquota_ipi / 100), 2);
        
//        if (($calcula_st == 'N') || (substr($informacoes_produtos->ST,1,2) <> '10' && substr($informacoes_produtos->ST,1,2) <> '30' && substr($informacoes_produtos->ST,1,2) <> '70')) {
        if ($aliquota->OPTANTE_ST == 'N') {
            $valor_4 = 0;
        } else {
            $informacoes_produtos = $this->percentualNBMI($estado, $codigoProduto);
            if (((substr($informacoes_produtos->ST,1,2) == '60') && (($parametros['ESTADO_EMPRESA'] == $estado) || ($calcula_st == 'N'))) || ((substr($informacoes_produtos->ST,1,2) <> '10' && substr($informacoes_produtos->ST,1,2) <> '30' && substr($informacoes_produtos->ST,1,2) <> '60' && substr($informacoes_produtos->ST,1,2) <> '70')) || ($calcula_st == 'N')) {
                $valor_4 = 0;
            } else {
                if (substr($informacoes_produtos->ST, 0, 1) == '1' || substr($informacoes_produtos->ST, 0, 1) == '2') {

                    $aliquotaExterna = $aliquota->IMP_ALIQUOTA_EXTERNA_ICMS;
                    $aliquotaInterna = $aliquota->IMP_ALIQUOTA_INTERNA_ICMS;
                } else {
                    if ($informacoes_produtos->ICMS > 0 && $estado == $parametros['ESTADO_EMPRESA']) {

                        $aliquotaExterna = $informacoes_produtos->ICMS;
                        $aliquotaInterna = $informacoes_produtos->ICMS;
                    } else {

                        if (($informacoes_produtos->ST == '100') || ($informacoes_produtos->ST == '160'))
                            $aliquotaExterna = 4;
                        else
                            $aliquotaExterna = $aliquota->ALIQUOTA_EXTERNA_ICMS;

                        $aliquotaInterna = $aliquota->ALIQUOTA_INTERNA_ICMS;
                    }
                }
                
                $percNBMI = $informacoes_produtos->PERC_NBMI;
                if ($optante == 'S') {
                    $percNBMI = ($informacoes_produtos->PERC_SN > 0) ? ($informacoes_produtos->PERC_NBMI * ($informacoes_produtos->PERC_SN / 100)) : $informacoes_produtos->PERC_NBMI;
                }

                if ($parametros['CALC_IMPOSTOS_NF'] == 'S') {
                    $percNBMI = number_format((((($percNBMI / 100) + 1) * (($aliquotaInterna / 100) - 1) / (($aliquotaExterna / 100) - 1)) - 1) * 100, 2, '.', '');
                }

                $valor_1 = 0;
                $valor_2 = 0;
                $valor_4 = 0;
                $valor_4 = 0;
                if ($percNBMI != '' && $percNBMI != 0) {
                    $valor_1 = round(($valor_venda * $aliquotaExterna ) / 100, 2);
                    $valor_2 = round((($valor_venda_st * $percNBMI) / 100 ) + $valor_venda_st, 2);
                    if ($estado == $parametros['ESTADO_EMPRESA']) {
                        $valor_2 = round(($valor_2 - ($valor_2 * ($informacoes_produtos->PERC_RED_ST / 100))), 2);
                    }
                    $valor_3 = round(($valor_2 * $aliquotaInterna) / 100, 2);
                    $valor_4 = round(($valor_3 - $valor_1), 2);
                }
            }
        }
        $valor_venda_st = $valor_venda_st + $valor_4;
        return $valor_venda_st;
    }

    public function aliquotaEstado($estado = NULL) {
        
        $sql = "SELECT
                    E.ALIQUOTA_EXTERNA_ICMS, 
                    E.ALIQUOTA_INTERNA_ICMS,
                    E.IMP_ALIQUOTA_EXTERNA_ICMS,
                    E.IMP_ALIQUOTA_INTERNA_ICMS,
                    E.OBRIGATORIO,
                    E.OPTANTE_ST
                FROM " . $this->session->userdata('DIRETORIO') . ".DBO.ESTADO_ST E
                WHERE
                    E.SIGLA_ESTADO = ?";

        $query = $this->db->query($sql, $estado);
        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function percentualNBMI($estadoCliente = NULL, $codigoProduto = NULL) {
        $query = $this->db->query("SELECT
                                        (CASE '" . $estadoCliente . "'
                                           WHEN 'AC' THEN CAD_NBMI.ST_AC
                                           WHEN 'AL' THEN CAD_NBMI.ST_AL
                                           WHEN 'AM' THEN CAD_NBMI.ST_AM
                                           WHEN 'AP' THEN CAD_NBMI.ST_AP
                                           WHEN 'BA' THEN CAD_NBMI.ST_BA
                                           WHEN 'CE' THEN CAD_NBMI.ST_CE
                                           WHEN 'DF' THEN CAD_NBMI.ST_DF
                                           WHEN 'ES' THEN CAD_NBMI.ST_ES
                                           WHEN 'EX' THEN CAD_NBMI.ST_EX
                                           WHEN 'GO' THEN CAD_NBMI.ST_GOI
                                           WHEN 'MA' THEN CAD_NBMI.ST_MA
                                           WHEN 'MG' THEN CAD_NBMI.ST_MG
                                           WHEN 'MS' THEN CAD_NBMI.ST_MS
                                           WHEN 'MT' THEN CAD_NBMI.ST_MT
                                           WHEN 'PA' THEN CAD_NBMI.ST_PA
                                           WHEN 'PB' THEN CAD_NBMI.ST_PB
                                           WHEN 'PE' THEN CAD_NBMI.ST_PE
                                           WHEN 'PI' THEN CAD_NBMI.ST_PI
                                           WHEN 'PR' THEN CAD_NBMI.ST_PR
                                           WHEN 'RJ' THEN CAD_NBMI.ST_RJ
                                           WHEN 'RN' THEN CAD_NBMI.ST_RN
                                           WHEN 'RO' THEN CAD_NBMI.ST_RO
                                           WHEN 'RR' THEN CAD_NBMI.ST_RR
                                           WHEN 'RS' THEN CAD_NBMI.ST_RS
                                           WHEN 'SC' THEN CAD_NBMI.ST_SC
                                           WHEN 'SE' THEN CAD_NBMI.ST_SE
                                           WHEN 'SP' THEN CAD_NBMI.ST_SP
                                           WHEN 'TO' THEN CAD_NBMI.ST_TOC

                                           ELSE 0.00

                                        END) PERC_NBMI,
                                     (CASE '" . $estadoCliente . "'
                                               WHEN 'AC' THEN CAD_NBMI.ST_SN_AC
                                               WHEN 'AL' THEN CAD_NBMI.ST_SN_AL
                                               WHEN 'AM' THEN CAD_NBMI.ST_SN_AM
                                               WHEN 'AP' THEN CAD_NBMI.ST_SN_AP
                                               WHEN 'BA' THEN CAD_NBMI.ST_SN_BA
                                               WHEN 'CE' THEN CAD_NBMI.ST_SN_CE
                                               WHEN 'DF' THEN CAD_NBMI.ST_SN_DF
                                               WHEN 'ES' THEN CAD_NBMI.ST_SN_ES
                                               WHEN 'GO' THEN CAD_NBMI.ST_SN_GOI
                                               WHEN 'MA' THEN CAD_NBMI.ST_SN_MA
                                               WHEN 'MG' THEN CAD_NBMI.ST_SN_MG
                                               WHEN 'MS' THEN CAD_NBMI.ST_SN_MS
                                               WHEN 'MT' THEN CAD_NBMI.ST_SN_MT
                                               WHEN 'PA' THEN CAD_NBMI.ST_SN_PA
                                               WHEN 'PB' THEN CAD_NBMI.ST_SN_PB
                                               WHEN 'PE' THEN CAD_NBMI.ST_SN_PE
                                               WHEN 'PI' THEN CAD_NBMI.ST_SN_PI
                                               WHEN 'PR' THEN CAD_NBMI.ST_SN_PR
                                               WHEN 'RJ' THEN CAD_NBMI.ST_SN_RJ
                                               WHEN 'RN' THEN CAD_NBMI.ST_SN_RN
                                               WHEN 'RO' THEN CAD_NBMI.ST_SN_RO
                                               WHEN 'RR' THEN CAD_NBMI.ST_SN_RR
                                               WHEN 'RS' THEN CAD_NBMI.ST_SN_RS
                                               WHEN 'SC' THEN CAD_NBMI.ST_SN_SC
                                               WHEN 'SE' THEN CAD_NBMI.ST_SN_SE
                                               WHEN 'SP' THEN CAD_NBMI.ST_SN_SP
                                               WHEN 'TO' THEN CAD_NBMI.ST_SN_TOC

                                               ELSE 0.00
                                        END) PERC_SN,
                                        CAD_IEST.ST,
                                        CAD_NBMI.ICMS,
                                        CAD_IEST.ALIQUOTAIPIVENDA,
                                        CAD_NBMI.PERC_RED_ST
                                        --CAD_NBMI.VAR_CF
                                     FROM " . $this->session->userdata('DIRETORIO') . "..CAD_IEST
                                     LEFT JOIN " . $this->session->userdata('DIRETORIO') . "..CAD_NBMI ON (CAD_IEST.NBMIPI = CAD_NBMI.CODIGO)

                                     WHERE CAD_IEST.CODIGO = $codigoProduto");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    
    public function estoqueProdutoRes($codigo_produto) {
        $sql = "SELECT CAD_IEST.CODIGO, (ISNULL(PROD_RESERVADOS.TOTAL_QTDE, 0.00)) TOTAL_QTDE
			   FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST
			   LEFT JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.PROD_RESERVADOS ON (CAD_IEST.CODIGO = PROD_RESERVADOS.COD_PROD)
		   WHERE CAD_IEST.CODIGO = {$codigo_produto}";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $dados = $query->result_array();
            return  number_format($dados[0]['TOTAL_QTDE']);
        } else {
            return false;
        }
    }
    
    public function listaProdutoGrupoSubgrupo() {
        $sql = "SELECT G.CODIGO, G.DESCRICAO
                FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST C
                JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_GRUP G ON(G.CODIGO = C.GRUPO) 
                WHERE
                    C.ATIVO = 'S' AND G.ATIVO = 'S' --AND G.CODIGO > 1 AND G.CODIGO < 10
                GROUP BY G.CODIGO, G.DESCRICAO
                ORDER BY G.CODIGO";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            
            foreach ($query->result_array() as $key => $grupo) {
                $sql2 = "SELECT S.CODIGO AS CODIGO_SUBGRUPO, S.DESCRICAO AS DESCRICAO_SUBGRUPO
                        FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST C
                        JOIN " . $this->session->userdata('DIRETORIO') . ".DBO.SUBGRUPO S ON(C.SUBGRUPO = S.CODIGO) 
                        WHERE
                            C.ATIVO = 'S' AND 
                            S.ATIVO = 'S' AND
                            C.GRUPO = {$grupo['CODIGO']}
                            --AND C.SUBGRUPO IN ( 91 , 21 )
                        GROUP BY S.CODIGO, S.DESCRICAO";
                $query2 = $this->db->query($sql2);
                
                $data[$key]['CODIGO_GRUPO'] = $grupo['CODIGO'] . ' - ' . $grupo['DESCRICAO'];

                foreach ($query2->result_array() as $key2 => $subgrupo) {
                    $sql3 = "SELECT C.CODIGO AS CODIGO_PRODUTO, C.DESCRICAO AS DESCRICAO_PRODUTO, U.UNIDADE, C.PRECO_VENDA_A, C.PRECO_VENDA_V, C.PRECO_PROMOCIONAL
                            FROM " . $this->session->userdata('DIRETORIO') . ".DBO.CAD_IEST C
                            JOIN CAD_UNID U ON(C.UNIDADE = U.CODIGO)
                            WHERE
                                C.ATIVO = 'S' AND
                                C.GRUPO = {$grupo['CODIGO']} AND C.SUBGRUPO = {$subgrupo['CODIGO_SUBGRUPO']}";
                    $query3 = $this->db->query($sql3);
                    
                    $data[$key]['SUBGRUPO'][$subgrupo['CODIGO_SUBGRUPO']][$key2]['CODIGO_SUBGRUPO'] = $subgrupo['CODIGO_SUBGRUPO'] . ' - ' . $subgrupo['DESCRICAO_SUBGRUPO'];
                    $data[$key]['SUBGRUPO'][$subgrupo['CODIGO_SUBGRUPO']][$key2]['PRODUTOS'] = $query3->result_array();
                }
            }
            return $data;
        } else {
            return false;
        }    
    } 

}
