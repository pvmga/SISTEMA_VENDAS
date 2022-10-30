<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        date_default_timezone_set('America/Sao_Paulo');
        parent::__construct();
    }
    
    public function getNovidades() {
        global $wsdl, $client;
 
        $this->load->library("Nusoap_lib");

        $wsdl = 'http://ingasoft.com.br/adm/WS_NOVIDADES/service.php?wsdl';
        $client = new nusoap_client($wsdl, 'wsdl');

        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
        }
 
        try {
            $senha = 'e9e5c81693a07fb7ce2772ccd491f058';
            $param = array('senha' => $senha);
            $result = $client->call('getNovidades', $param, '', '', false, true);
//            echo '<h2>Result</h2><pre>';
            return (json_decode($result, true));
//            echo '</pre>';
        } catch (SoapFault $exception) {
            echo $exception;
        }
 
        echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
        echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
        //echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>'; //this generates a lot of text!
    }
    
    private function config_email($dados_pedido) {        
        /* ESTRUTURA PADRÃO */
        $protocol = 'smtp';
        $smtp_crypto = '';
        $smtp_host = $this->session->userdata('ONLINE_SERVER_SMTP_USUARIO');
        $smtp_user = $this->session->userdata('ONLINE_USER_SMTP');
        $smtp_pass = $this->session->userdata('ONLINE_SENHA_EMAIL_USUARIO');
        $smtp_port = $this->session->userdata('ONLINE_PORT_SMTP');
        
        $config['protocol'] = $protocol;
        $config['smtp_host'] = $smtp_host;
        $config['smtp_user'] = $smtp_user;
        $config['smtp_pass'] = $smtp_pass;
        $config['smtp_port'] = $smtp_port;
        $config['smtp_crypto'] = $smtp_crypto;
        $config['smtp_timeout'] = '60';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE; // define se haverá quebra de palavra no texto
        $config['validate'] = TRUE; // define se haverá validação dos endereços de email

        $config['mailtype'] = 'html';
        
        // Inicializa a library Email, passando os parâmetros de configuração
        $this->load->library('email');
        $this->email->initialize($config);
        
        $email_vendedor  = $this->session->userdata('EMAIL_VENDEDOR');
        $email_destinatario_nome = $this->session->userdata('ONLINE_NOME_EMAIL_USUARIO');
        $nome_usuario_sistema = $this->session->userdata('NOME');
        
        $email_responsavel = $this->session->userdata('EMAIL_RESPONSAVEL');
        if ($email_vendedor == '') {
            $email_vendedor = $email_responsavel;
        }
        
        // Define remetente e destinatário
        $this->email->from($email_vendedor, $email_destinatario_nome); // Remetente
        $this->email->to($dados_pedido['EMAIL_CLIENTE']); // Destinatário
        $this->email->cc(array($email_responsavel, $email_vendedor)); // Cópia
        
        // Define o assunto do email
        $this->email->subject('PEDIDO: ' . $dados_pedido['COD_VENDA']);
        
        // dados e-mail
        $data['empresa'] = $this->session->userdata('RAZAO_SOCIAL');
        $data['codigo_vendedor'] = $this->session->userdata('VENDEDOR');
        $data['nome_usuario'] = $this->session->userdata('NOME');
        $data['codigo_e_nome_clie'] = $dados_pedido['CODIGO_E_NOME_CLIE'];
        $data['total_pago'] = $dados_pedido['TOTAL_PAGO'];
        $data['valor_total_produtos'] = $dados_pedido['VALOR_TOTAL_PRODUTOS'];
        $data['valor_total_imposto'] = $dados_pedido['VALOR_TOTAL_IMPOSTO'];
        $data['produtos'] = $dados_pedido['ITENS'];
        $data['observacao'] = $dados_pedido['OBSERVACAO'];
        $data['condicao_pagamento'] = $dados_pedido['CONDICAO_PAGAMENTO'];
        $data['tipo_pagamento'] = $dados_pedido['TIPO_PAGAMENTO'];
        $data['mensagem'] = 'Dados pedido !';
        $data['numero_pedido'] = $dados_pedido['COD_VENDA'];
        $data['nome_transportadora'] = $dados_pedido['CODIGO_E_NOME_TRANSPORTADORA'];
        $data['cidade_cliente'] = $dados_pedido['CIDADE_CLIENTE'];
        
        $this->email->message($this->load->view('telas/view_email_template', $data, TRUE)); 
        
        if ($this->email->send()) {
            return '1';
        } else {
            return '0';
        }
    }
    
    public function gerarPdf($html) {
        // Instancia a classe mPDF
	$mpdf = new \Mpdf\Mpdf();
//        $mpdf->SetDisplayMode('fullpage');
//        $mpdf->SetMargins(5, 5, 5);
	// Ao invés de imprimir a view 'welcome_message' na tela, passa o código
	// Define um Cabeçalho para o arquivo PDF
//	$mpdf->SetHeader('Relatório - PDF');
	// Define um rodapé para o arquivo PDF, nesse caso inserindo o número da
	// página através da pseudo-variável PAGENO
	$mpdf->SetFooter('{PAGENO}');
	// Insere o conteúdo da variável $html no arquivo PDF
//        $mpdf->showImageErrors = true;
	$mpdf->writeHTML($html);
        
	// Cria uma nova página no arquivo
//	$mpdf->AddPage();
	// Insere o conteúdo na nova página do arquivo PDF
//	$mpdf->WriteHTML('<p><b>Gerando PDF</b></p>');
	// Gera o arquivo PDF
        // ====== caso queira abrir no navegador, deixe o output vazio e comente o código da linha 91 para baixo;
	$mpdf->Output();
//	$mpdf->Output('files/teste.pdf', \Mpdf\Output\Destination::FILE);

//        $arquivo = 'files/teste.pdf';
//        header("Content-Type: pdf"); // informa o tipo do arquivo ao navegador
//        header("Content-Length: ".filesize($arquivo)); // informa o tamanho do arquivo ao navegador
//        header("Content-Disposition: attachment; filename=".basename($arquivo)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
//        readfile($arquivo); // lê o arquivo
//        exit; // aborta pós-ações
        
    }
    
    public function gerarPdfSalva($html) {
        // Instancia a classe mPDF
	$mpdf = new \Mpdf\Mpdf();
	//$mpdf->SetHeader('Gerador de PDF');
	$mpdf->SetFooter('{PAGENO}');
        $mpdf->showImageErrors = true;
	$mpdf->writeHTML($html);
        
	$mpdf->Output('files/'.$this->session->userdata('NOME').'_catalogo.pdf', \Mpdf\Output\Destination::FILE);
        exit;
    }
    
    public function myDownloadPdf($arq) {
        $arquivo = $arq;
        header("Content-Type: pdf"); // informa o tipo do arquivo ao navegador
        header("Content-Length: ".filesize($arquivo)); // informa o tamanho do arquivo ao navegador
        header("Content-Disposition: attachment; filename=".basename($arquivo)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
        readfile($arquivo); // lê o arquivo
        unlink($arquivo);
        exit; // aborta pós-ações
    }
    
    public function salvaHTML_PDF($html = NULL) {
        $dompdf = new \Dompdf\Dompdf;
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $output = $dompdf->output();
        file_put_contents('files/'.$this->session->userdata('NOME').'_catalogo.pdf', $output);
    }
    
    public function getConfigEmail($dados_pedido) {
        return $this->config_email($dados_pedido);
    }
    
    public function rastreamentoXml($pagina = 'login', $usuario, $msg = 'VAZIO') {
        #versao do encoding xml
        $dom = new DOMDocument("1.0", "ISO-8859-1");

        #retirar os espacos em branco
        $dom->preserveWhiteSpace = false;

        #gerar o codigo
        $dom->formatOutput = true;

        #criando o nó principal (root)
        $root = $dom->createElement("modulo");
        
        #nó filho (contato)
        $modulo = $dom->createElement($pagina);
        
        #setanto nomes e atributos dos elementos xml (nós)
        $nos = $dom->createElement("usuario", $usuario);
        $msg_rastreamento = $dom->createElement("msg", $msg);
        
        #adiciona os nós (informacaoes do contato) em contato
        $modulo->appendChild($nos);
        $modulo->appendChild($msg_rastreamento);

        #adiciona o nó contato em (root) agenda
        $root->appendChild($modulo);
        $dom->appendChild($root);
        
        # Para salvar o arquivo, descomente a linha
        $url = 'files/'. date('Ymd his') . '_' . strtoupper($usuario) . '.xml';
        $dom->save($url);

        #cabeçalho da página
        $dom->saveXML();
        return 'true';
        
    }

    public function salvarXmlVenda($cod_venda = NULL, $cod_cliente = NULL, $item = NULL, $tabela = NULL, $msg = NULL, $condicaoPagamento = NULL, $tipo_pagamento = NULL) {

        #versao do encoding xml
        $dom = new DOMDocument("1.0", "ISO-8859-1");

        #retirar os espacos em branco
        $dom->preserveWhiteSpace = false;

        #gerar o codigo
        $dom->formatOutput = true;

        #criando o nó principal (root)
        $root = $dom->createElement("venda");

        #nó filho (contato)
        $dados_venda = $dom->createElement("dados");

        #setanto nomes e atributos dos elementos xml (nós)
        $codigo_venda = $dom->createElement("codigo_venda", $cod_venda);
        $codigo_cliente = $dom->createElement("codigo_cliente", $cod_cliente);
        
        $condicao_pagamento = $dom->createElement("condicao_pagamento", $condicaoPagamento);
        $tipo_pagamento = $dom->createElement("tipo_pagamento", $tipo_pagamento);

        $nome = $dom->createElement("usuario_nome", $this->session->userdata('NOME'));
        $apelido = $dom->createElement("usuario_apelido", $this->session->userdata('APELIDO'));
        $tabela_venda = $dom->createElement("tabela_venda", $tabela);
        $msg_erro = $dom->createElement("msg", $msg);

        #adiciona os nós (informacaoes do contato) em contato
        $dados_venda->appendChild($codigo_venda);
        $dados_venda->appendChild($codigo_cliente);
        $dados_venda->appendChild($condicao_pagamento);
        $dados_venda->appendChild($tipo_pagamento);
        $dados_venda->appendChild($nome);
        $dados_venda->appendChild($apelido);
        $dados_venda->appendChild($tabela_venda);
        $dados_venda->appendChild($msg_erro);

        #adiciona o nó contato em (root) agenda
        $root->appendChild($dados_venda);
        $dom->appendChild($root);
                
        for ($x = 0; $x < count($item); $x++) {
            $valor_unitario = str_replace(",", ".", substr($item[$x]->valor_unitario, 2));
            $percentual_desconto = str_replace(",", ".", substr($item[$x]->percentual_desconto, 0, -1));
            $quantidade = number_format($item[$x]->quantidade_digitada, 2, '.', '');
            #nó filho (itens)
            $items = $dom->createElement("item");

            $venda = $dom->createElement("codigo_venda", $cod_venda);
            $codigo_produto = $dom->createElement("codigo_produto", $item[$x]->codigo);
            $quantidade = $dom->createElement("quantidade", $quantidade);
            $valor_unitario = $dom->createElement("valor_unitario", $valor_unitario);
            $perc_desconto = $dom->createElement("perc_desconto", $percentual_desconto);

            $items->appendChild($venda);
            $items->appendChild($codigo_produto);
            $items->appendChild($quantidade);
            $items->appendChild($valor_unitario);
            $items->appendChild($perc_desconto);

            #adiciona o nó contato em (root) agenda
            $root->appendChild($items);
            $dom->appendChild($root);
        }
        
        # Para salvar o arquivo, descomente a linha
        $url = 'files/' . $cod_venda. '_' . $this->session->userdata('NOME') . '.xml';
        $dom->save($url);

        #cabeçalho da página
//        header("Content-Type: text/xml");
        # imprime o xml na tela
        $dom->saveXML();

    }
    
    public function formatarData($data) {
        return substr($data, 4).substr($data, 2, -4).substr($data, 0, -6);
    }

}
