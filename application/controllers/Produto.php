<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produto extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata()['CODIGO'] == false)
            redirect('login');
    }

    public function index() {

        $data['title'] = 'ADMIN | Listagem de produtos';

        $this->load->model('vendas_models');
        $this->load->model('produtos_models');
        $data['active'] = 'listagemProdutos';
        
        $vendedor = $this->session->userdata()['VENDEDOR'];
        
        $data['grupos'] = $this->produtos_models->listarGrupos();
        
        $data['subgrupos'] = $this->produtos_models->listarSubgrupos();

        $data['tipo_ordenacao'] = $this->uri->segment(2);
        
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('template/modal');
        $this->load->view('telas/view_listatemProduto');

        $this->load->view('template/footer');
        $this->load->view('ajax/listagemProduto');
    }
    public function listagemTelaProdutoAjax() {
        
        $this->load->model('produtos_models');
        $decimal = $this->session->userdata('CASAS_DECIMAIS_VENDA');
        
        $data_venda_inicial = explode("/", empty($this->input->post('data_venda_inicial')) ? '01/01/1993' : $this->input->post('data_venda_inicial'));
        $data_venda_final = explode("/", empty($this->input->post('data_venda_final')) ? date('Ymd') : $this->input->post('data_venda_final'));

        $data_inicial = $data_venda_inicial[2].$data_venda_inicial[1].$data_venda_inicial[0];
        $data_final = $data_venda_final[2].$data_venda_final[1].$data_venda_final[0];

        $data = $this->produtos_models->listagemTelaProdutoAjax($decimal, $this->session->userdata('ONLINE_ESTOQUE'), $data_inicial, $data_final);
        if ($data == NULL) {
            $data['data'] = array();
            $data['data'][] = [
                'codigo' => '',
                'descricao' => 'NÃO LOCALIZADO...',
                'estoqueatual' => '',
                'reservado' => '',
                'disponivel' => '',
                'preco_venda_a' => '',
                'perc_desc' => '',
                'quantidade_vendida' => ''
            ];
        }

        echo json_encode($data);
    }

    public function catalogoProdutos() {

        $this->load->model('produtos_models');     

        $this->load->library('PHPExcel');

        $objPHPExcel = new PHPExcel();

        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        $objPHPExcel->getActiveSheet()->getStyle('E2:E9')->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true
                    )
                )
        );
        $objPHPExcel->getActiveSheet()->getStyle('G2:G9')->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true
                    )
                )
        );

        // CABECALHO
//        $objPHPExcel->getActiveSheet()->mergeCells('E2:F2');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', 'EMPRESA: ');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', $this->session->userdata('RAZAO_SOCIAL'));

//        $objPHPExcel->getActiveSheet()->mergeCells('H2:K2');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', 'DATA:');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', date('d/m/Y'));

//        $objPHPExcel->getActiveSheet()->mergeCells('H3:K3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', 'USUARIO:');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', $this->session->userdata('NOME'));

//        $objPHPExcel->getActiveSheet()->mergeCells('E3:F3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', 'GRUPO:');
        if ($this->input->post('grupos') != '') {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', $this->input->post('grupos'));
        } else {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', 'Todos');
        }

//        $objPHPExcel->getActiveSheet()->mergeCells('E4:F4');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', 'PREÇO BASE:');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', $this->input->post('precos'));

//        $objPHPExcel->getActiveSheet()->mergeCells('E5:F5');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E5', 'ESTADO:');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F5', $this->input->post('estados'));

//        $objPHPExcel->getActiveSheet()->mergeCells('E6:F6');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E6', 'OPTANTE SIMPLES:');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F6', $this->input->post('optante'));

//        $objPHPExcel->getActiveSheet()->mergeCells('E7:F7');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E7', 'PROMOCIONAL:');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F7', 'Todos');

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E9', 'TOTAL:');
        $objPHPExcel->getActiveSheet()->setCellValue('F9', '=SUM(J12:J100000)');

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objDrawing->setName('Logo Interesses Pessoais');
        $objDrawing->setDescription('Logo Interesses Pessoais');

        // Arquivo
        $file = "data:image/png;base64," . base64_encode($this->session->userdata('LOGOMARCA'));
        $arquivoBinário = file_get_contents($file);

        $arquivo = './files/logoemp.png';

        $fp = fopen($arquivo, 'w');
        fwrite($fp, $arquivoBinário);
        fclose($fp);

        if (!file_get_contents($arquivo)) {
            $arquivo = './img/image.jpg';
        }

        $objDrawing->setPath($arquivo);

        $objDrawing->setWidth(160);
        $objDrawing->setHeight(160);
        $objDrawing->getShadow()->setVisible(true);
        $objDrawing->getShadow()->setDirection(45);

        $objDrawing->setCoordinates('B2');

        $objPHPExcel->getActiveSheet()->getStyle('F2:F9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        // CABECALHO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B10', 'CATÁLOGO DE PRODUTOS');

        // Merge cells
        $objPHPExcel->getActiveSheet()->mergeCells('B10:N10');
        $objPHPExcel->getActiveSheet()->getStyle('B10:N10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B10:N10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // Alterando o tamanho da fonte
        $objPHPExcel->getActiveSheet()->getStyle('B10:N10')->getFont()->setSize(20);

        //Seta o cabeçalho e os estilos da Planilha 1( Planilha 0 é a primeira, Planilha 1 segunda....)
        $objPHPExcel->getActiveSheet()->getStyle('B10:N10')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '218c74')
                    ),
                    'font' => array(
                        'bold' => true,
                        'color' => array('rgb' => 'f5f6fa')
                    )
                )
        );

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B11', 'EMPRESA:')->setCellValue('D11', 'CNPJ:');
        $objPHPExcel->getActiveSheet()->getStyle('B11:N11')->getFont()->setSize(15);
        //Seta o cabeçalho e os estilos da Planilha 1( Planilha 0 é a primeira, Planilha 1 segunda....)
        $objPHPExcel->getActiveSheet()->getStyle('B11:N11')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '95A5A6')
                    ),
                    'font' => array(
                        'bold' => true,
                        'color' => array('rgb' => 'f5f6fa')
                    )
                )
        );

        // TABELA
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B12', 'CODIGO')->setCellValue('C12', 'PESO')->setCellValue('D12', 'TAMANHO')->setCellValue('E12', 'MODELO')->setCellValue('F12', 'PREÇO VENDA')->setCellValue('G12', 'PREÇO (IPI+ST)')->setCellValue('H12', 'QUANT.')->setCellValue('I12', 'TOTAL')->setCellValue('J12', 'FOTO');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B12', 'CODIGO')->setCellValue('C12', 'PESO')->setCellValue('D12', 'TAMANHO')->setCellValue('E12', 'MODELO')->setCellValue('F12', 'PREÇO')->setCellValue('G12', 'CONSUMIDOR')->setCellValue('H12', 'PREÇO (IPI+ST)')->setCellValue('I12', 'QUANT.')->setCellValue('J12', 'TOTAL')->setCellValue('K12', 'FOTO');
        $objPHPExcel->getActiveSheet()->getStyle('B12:G12')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('C12:C12')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('D12:D12')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('E12:E12')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('F12:F12')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('G12:G12')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('H12:H12')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('I12:I12')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('J12:J12')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('K12:N12')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('B12:N12')->getFont()->setSize(15);
//        $objPHPExcel->getActiveSheet()->getStyle('B12:L12' . $indice)->applyFromArray(
        $objPHPExcel->getActiveSheet()->getStyle('B12:N12')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '34ace0')
                    ),
                    'font' => array(
                        'bold' => true,
                        'color' => array('rgb' => 'f5f6fa')
                    )
                )
        );
        $objPHPExcel->getActiveSheet()->setTitle('Catalogo');

//        $objPHPExcel->getActiveSheet()->mergeCells('H12:K12');
        $objPHPExcel->getActiveSheet()->getStyle('J12:M12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
        $objPHPExcel->getActiveSheet()->getStyle('J12:M12')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('B12:M12')->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true
                    )
                )
        );
        $produtos = $this->produtos_models->buscarSimilar($this->input->post('grupos'), $this->input->post('precos'), $this->input->post('subgrupos'), $this->input->post('promocional'));
        $indice = 12;

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

        $grupo_anterior = '';
        if ($produtos != FALSE) {
        foreach ($produtos as $produto) {

                $similarItens = $this->produtos_models->buscarSimilarItens($produto['CODIGO']);
                $estq_reservado = $this->produtos_models->estoqueProdutoRes($produto['CODIGO']);
                if ($similarItens != FALSE) {
                    if (($similarItens[0]['ESTOQUEATUAL'] - $estq_reservado) > 0) {
                        if ($produto['GRUPO'] != $grupo_anterior) {
                            $indice++;
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $indice, 'GRUPO: ')->setCellValue('C' . $indice, $produto['GRUPO'] . ' - ' . $produto['DESCRICAO_GRUPO']);
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $indice . ':N' . $indice)->getFont()->setSize(20);
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $indice . ':N' . $indice)->applyFromArray(
                                    array(
                                        'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => 'ffda79')
                                        ),
                                        'font' => array(
                                            'bold' => true,
                                            'color' => array('rgb' => '40407a')
                                        )
                                    )
                            );
                            $grupo_anterior = $produto['GRUPO'];
                        }

                        // Iniciar novo componente Drawing para a primeira imagem
    //                    echo json_encode($this->input->post('foto'));
    //                    exit();
                        if ($this->input->post('foto') == 'S') {
                            $objDrawing = new PHPExcel_Worksheet_Drawing();

                            // Arquivo
                            $file = "data:image/png;base64," . base64_encode($produto['FOTO']);
                            $arquivoBinário = file_get_contents($file);

                            $arquivo = './files/' . $produto['CODIGO'] . '.png';

                            $fp = fopen($arquivo, 'w');
                            fwrite($fp, $arquivoBinário);
                            fclose($fp);

                            if (!file_get_contents($arquivo)) {
                                $arquivo = './img/image.jpg';
                            }

                            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                            $objDrawing->setName('Logo Interesses Pessoais');
                            $objDrawing->setDescription('Logo Interesses Pessoais');

                            $objDrawing->setPath($arquivo);

                            $objDrawing->setWidth(140);
                            $objDrawing->setHeight(135);
                            $objDrawing->setOffsetX(5);
                            $objDrawing->setOffsetY(2);
                            $objDrawing->getShadow()->setVisible(true);
                            $objDrawing->getShadow()->setDirection(45);
                        }

                        // Posição da primeira imagem no excel
                        $indice++;
                        $indiceInicioMargem = $indice;

                        if ($this->input->post('foto') == 'S') {
                            $objDrawing->setCoordinates('K' . $indice);
                        }

                        $indice = $indice - 1;

                        // calculo de desconto.
                        $perc_desconto = $this->produtos_models->recuperarPercentualPromocao($produto['CODIGO_PRODUTO']);
                        $percentualDesconto = 0;
                        if ($perc_desconto == FALSE) {
                            $valor_com_desconto = $produto['PRECO_VENDA_A'];
                            $valor_sugerido_com_desconto = $produto['PRECO_VENDA_V'];
                        } else {
                            $percentualDesconto = json_decode($perc_desconto->PERC_DESC, true);
                            $valor_com_desconto = $produto['PRECO_VENDA_A'] - ($produto['PRECO_VENDA_A'] * ($percentualDesconto / 100));
                            $valor_sugerido_com_desconto = $produto['PRECO_VENDA_V'] - ($produto['PRECO_VENDA_V'] * ($percentualDesconto / 100));
                        }
                        $valor_novo = number_format($valor_com_desconto, 2, ',', '.');
                        $valor_sugerido_novo = number_format($valor_sugerido_com_desconto, 2, ',', '.');

                        // calculo de st com produto já deduzido o desconto.
                        $parametros = array(
                            'ESTADO_EMPRESA' => $this->session->userdata('ESTADO_EMPRESA'),
                            'CALC_IMPOSTOS_NF' => $this->session->userdata('CALC_IMPOSTOS_NF'),
                        );
                        $decimal = $this->session->userdata('CASAS_DECIMAIS_VENDA');
                        $calcula_st = 'S';
                        $desconsidera_ipi = $this->session->userdata('DESC_IPI_VENDA');
                        $valor_ipi_st = $this->produtos_models->retornaImposto($valor_com_desconto, $produto['CODIGO_PRODUTO'], $this->input->post('estados'), $this->input->post('optante'), $parametros, $decimal, $calcula_st, $produto['ALIQUOTAIPIVENDA'], $desconsidera_ipi);
    //                $valor_ipi_st = $valor_com_desconto;
                        $valor_novo_ipi_st = number_format($valor_ipi_st, 2, ',', '.');

    //                echo json_encode(array('valor_original' => $produto['PRECO_VENDA_A'], 'valor_novo_ipi_st' => $valor_novo_ipi_st, 'codigo' => $produto['CODIGO_PRODUTO'], 'descricao' => $produto['DESCRICAO'], 'valor_novo' => $valor_novo));
    //                exit();
                        foreach ($similarItens as $itens) {
                            $indice++;

                            $objPHPExcel->getActiveSheet()->getStyle('B' . $indice . ':B' . $indice)->applyFromArray($styleThinBlackBorderOutline);
                            $objPHPExcel->getActiveSheet()->getStyle('C' . $indice . ':C' . $indice)->applyFromArray($styleThinBlackBorderOutline);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $indice . ':D' . $indice)->applyFromArray($styleThinBlackBorderOutline);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $indice . ':H' . $indice)->applyFromArray($styleThinBlackBorderOutline);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $indice . ':I' . $indice)->applyFromArray($styleThinBlackBorderOutline);

                            $objPHPExcel->getActiveSheet()->getStyle('I' . $indice . ':I' . $indice)->applyFromArray(
                                    array(
                                        'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '95A5A6')
                                        ),
                                        'font' => array(
                                            'bold' => true,
                                            'color' => array('rgb' => 'f5f6fa')
                                        )
                                    )
                            );

                            $objPHPExcel->getActiveSheet()->getStyle('B' . $indice . ':B' . $indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);

                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $indice, $itens['COD_ITEM'])
                                    ->setCellValue('C' . $indice, $itens['PESO'])
                                    ->setCellValue('D' . $indice, $itens['REF_FABRICANTE']);
                        }

                        $objPHPExcel->getActiveSheet()->mergeCells('E' . $indiceInicioMargem . ':E' . $indice);
                        $objPHPExcel->getActiveSheet()->getCell('E' . $indiceInicioMargem)->setValue($produto['CODIGO'] . '-' . ($produto['DESCRICAO']));
                        $objPHPExcel->getActiveSheet()->getStyle('E' . $indiceInicioMargem . ':E' . $indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                        $objPHPExcel->getActiveSheet()->getStyle('E' . $indiceInicioMargem . ':E' . $indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('E' . $indiceInicioMargem . ':E' . $indice)->applyFromArray($styleThinBlackBorderOutline);
                        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);

                        $objPHPExcel->getActiveSheet()->mergeCells('F' . $indiceInicioMargem . ':F' . $indice);
                        $objPHPExcel->getActiveSheet()->getCell('F' . $indiceInicioMargem)->setValue('R$ ' . $valor_novo);
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $indiceInicioMargem . ':F' . $indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $indiceInicioMargem . ':F' . $indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $indiceInicioMargem . ':F' . $indice)->applyFromArray($styleThinBlackBorderOutline);

                        $objPHPExcel->getActiveSheet()->mergeCells('G' . $indiceInicioMargem . ':G' . $indice);
                        //$objPHPExcel->getActiveSheet()->getCell('G' . $indiceInicioMargem)->setValue('R$ ' . $valor_sugerido_novo);
                        $objPHPExcel->getActiveSheet()->getCell('G' . $indiceInicioMargem)->setValue('');
                        $objPHPExcel->getActiveSheet()->getStyle('G' . $indiceInicioMargem . ':G' . $indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('G' . $indiceInicioMargem . ':G' . $indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('G' . $indiceInicioMargem . ':G' . $indice)->applyFromArray($styleThinBlackBorderOutline);

                        $objPHPExcel->getActiveSheet()->mergeCells('H' . $indiceInicioMargem . ':H' . $indice);
                        $objPHPExcel->getActiveSheet()->getCell('H' . $indiceInicioMargem)->setValue('R$ ' . $valor_novo_ipi_st);
                        $objPHPExcel->getActiveSheet()->getStyle('H' . $indiceInicioMargem . ':H' . $indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('H' . $indiceInicioMargem . ':H' . $indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('H' . $indiceInicioMargem . ':H' . $indice)->applyFromArray($styleThinBlackBorderOutline);

                        // aplica cor quando tiver desconto.
    //                    if ($percentualDesconto > 0 && empty($percentualDesconto) == false) {
                        if ($produto['PROMOCIONAL'] == 'S') {
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $indiceInicioMargem . ':H' . $indice)->applyFromArray(
                                    array(
                                        'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '22A7F0')
                                        ),
                                        'font' => array(
                                            'bold' => true,
                                            'color' => array('rgb' => 'ecf0f1')
                                        )
                                    )
                            );
                        }

                        $objPHPExcel->getActiveSheet()->mergeCells('J' . $indiceInicioMargem . ':J' . $indice);
                        $objPHPExcel->getActiveSheet()->getStyle('J' . $indiceInicioMargem . ':J' . $indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('J' . $indiceInicioMargem . ':J' . $indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('J' . $indiceInicioMargem . ':J' . $indice)->applyFromArray($styleThinBlackBorderOutline);

                        if (count($similarItens) == 1) {
                            $indice = $indice + 7;
                        } else if (count($similarItens) == 2) {
                            $indice = $indice + 6;
                        } else if (count($similarItens) == 3) {
                            $indice = $indice + 5;
                        } else if (count($similarItens) == 4) {
                            $indice = $indice + 4;
                        } else if (count($similarItens) == 5) {
                            $indice = $indice + 3;
                        } else if (count($similarItens) == 6) {
                            $indice = $indice + 2;
                        } else {
                            $indice++;
                        }

                        $teste = $indice - 1;

                        $objPHPExcel->getActiveSheet()->getStyle('G' . $indice)->applyFromArray(
                                array(
                                    'font' => array(
                                        'bold' => true
                                    )
                                )
                        );

                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $indice, 'TOTAL:');
                        $objPHPExcel->getActiveSheet()->setCellValue('I' . $indice, '=SUM(I' . $indiceInicioMargem . ':I' . $teste . ')');
                        $objPHPExcel->getActiveSheet()->setCellValue('J' . $indiceInicioMargem, '=I' . $indice . ' * ' . $valor_ipi_st);

                        $indiceFimMargem = $indice;
                        $indiceFimMargem--;

                        $objPHPExcel->getActiveSheet()->mergeCells('K' . $indiceInicioMargem . ':N' . $indiceFimMargem);
                        $objPHPExcel->getActiveSheet()->getStyle('K' . $indiceInicioMargem . ':N' . $indiceFimMargem)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('K' . $indiceInicioMargem . ':N' . $indiceFimMargem)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->getActiveSheet()->getStyle('B' . $indiceInicioMargem . ':N' . $indiceFimMargem)->applyFromArray($styleThinBlackBorderOutline);
                    } else {
                        echo json_encode('EXISTE PRODUTOS COM ESTOQUE POREM RESERVADO !');
                    }
                } else {
                    echo json_encode('EXISTE PRODUTOS SEM ESTOQUE !');
                }
            }
        } else {
            echo json_encode('NAO EXISTE SIMILAR !');
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $saveFilePATH = './files/' . $this->session->userdata('NOME') . '.xlsx';
        $objWriter->save($saveFilePATH);

        echo json_encode('ENCERROU !');
    }

    public function listapdf() {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288'); // Setting to 512M - for pdo_sqlsrv
//        pcre.backtrack_limit=100000000
//        pcre.recursion_limit=100000000
        $data['title'] = 'ADMIN | Impressão catálogo';

        $this->load->model('produtos_models');

//        $grupo = $this->uri->segment(2);
        $grupo = $this->input->post('grupo');
//        $subgrupo = $this->uri->segment(3);
        $subgrupo = $this->input->post('subgrupo');
//        $visualizacao = $this->uri->segment(4);
        $visualizacao = $this->input->post('visualizacao');

        $data['produtos'] = $this->produtos_models->buscarSimilarMelhorado($grupo, $subgrupo);
//        echo '<pre>';
//        print_r($data['produtos']);
//        echo '</pre>';
//        exit();

        if ($visualizacao == 'HTML') {
            $this->load->view('telas/relatorios/view_listapdf', $data);
        } else if ($visualizacao == 'TELA') {
            $this->gerarPdf($this->load->view('telas/relatorios/view_listapdf', $data, TRUE));
        } else {
            $this->gerarPdfSalva($this->load->view('telas/relatorios/view_listapdf', $data, TRUE));
        }

    }

    public function downloadPdf() {
        $arq = 'files/'.$this->session->userdata('NOME').'_catalogo.pdf';
        $this->myDownloadPdf($arq);
    }
    
    public function listaPrecoGrupo() {
//        pcre.backtrack_limit='100000000';
//        pcre.recursion_limit='100000000';
        $data['title'] = 'ADMIN | Impressão lista de preço';
        
        $this->load->model('produtos_models');
        $data['dados'] = $this->produtos_models->listaProdutoGrupoSubgrupo();

//        $this->load->view('telas/relatorios/view_listaPrecoGrupo', $data);
        $this->gerarPdf($this->load->view('telas/relatorios/view_listaPrecoGrupo',$data, TRUE));
    }

}
