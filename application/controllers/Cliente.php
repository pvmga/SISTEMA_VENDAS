<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliente extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata()['CODIGO'] == false)
            redirect('login');
    }

    public function index() {

        $data['title'] = 'ADMIN | Listagem de clientes';
        $data['active'] = 'listagemCliente';
        
        $this->load->model('vendas_models');
        $vendedor = $this->session->userdata()['VENDEDOR'];
        
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('template/modal');
        $this->load->view('telas/view_listagemCliente');

        $this->load->view('template/footer');
        $this->load->view('ajax/listagemCliente');
    }

    public function cadastrarCliente() {
        $data['title'] = 'ADMIN | Cadastrar clientes';
        $data['active'] = 'listagemCliente';
        
        $this->load->model('vendas_models');
        $vendedor = $this->session->userdata()['VENDEDOR'];

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('template/modal');
        $this->load->view('telas/view_cliente');

        $this->load->view('template/footer');
        $this->load->view('ajax/dadosCliente');
        $this->load->view('ajax/dadosClienteFinanceiro');
    }

    public function listagemTelaClienteAjax() {

        $onlineVisClientes = $this->session->userdata['ONLINE_VIS_CLIENTES'];
        $vendedor = $this->session->userdata()['VENDEDOR'];
        $usuarioVisualizarVendas = $this->session->userdata()['VISUALIZAR_VENDAS'];
        $parametroVisualizarVendas = $this->session->userdata()['VEND_VISUALIZA_VENDAS'];
        
        $ativo_inativo = $this->input->post('ativo_inativo');

        $this->load->model('clientes_models');
        $retorno = $this->clientes_models->listagemTelaClienteAjax($vendedor, $onlineVisClientes, $usuarioVisualizarVendas, $ativo_inativo, $parametroVisualizarVendas);
        echo json_encode($retorno);
    }

    public function verificaCliente() {

        if ($this->input->post('cpf')) {
            $cpf_cnpj = $this->input->post('cpf');
        } else {
            $cpf_cnpj = $this->input->post('cnpj');
        }

        $tipoPessoa = $this->input->post('tipoPessoa');

        $this->load->model('clientes_models');
        $dados = $this->clientes_models->verificaCadastro($cpf_cnpj, $tipoPessoa);

        if (count($dados) > 0) {
            echo json_encode(array("status" => "EX", "vendedor" => ($dados['vendedor']), "cliente" => ($dados['cliente'])));
        } else {
            echo json_encode(array("status" => "OK"));
        }
    }

    public function inserirCliente() {

        if ($this->input->post('dados')[19] == 'J') {
            $CGC = $this->input->post('dados')[20];
            $CPF = NULL;
            $RG = NULL;
            if ($this->input->post('dados')[0] != '') {
                $INSCRICAO = $this->input->post('dados')[0];
            } else {
                $INSCRICAO = 'ISENTO';
            }
        } else if ($this->input->post('dados')[19] == 'R') {
            $CGC = '00.000.000/0000-00';
            $CPF = $this->input->post('dados')[25];
            $RG = NULL;
            if ($this->input->post('dados')[26] != '') {
                $INSCRICAO = $this->input->post('dados')[26];
            } else {
                $INSCRICAO = 'ISENTO';
            }
        } else {
            $CGC = '00.000.000/0000-00';
            $CPF = $this->input->post('dados')[21];
            if ($this->input->post('dados')[22] != '') {
                $RG = $this->input->post('dados')[22];
            } else {
                $RG = 0;
            }
            $INSCRICAO = NULL;
        }

        $this->load->model('clientes_models');

        // Verifica a existência do codigo interno, caso exista será considerado alteração de registro.
        if ($this->input->post('dados')[23] == '') {
            $CODIGO = $this->clientes_models->gerarCodigoCliente();
        } else {
            $CODIGO = $this->input->post('dados')[23];
        }

        $dados = array(
            'CODIGO' => $CODIGO,
            'NATUREZA' => $this->input->post('dados')[19],
            'CGC' => $CGC,
            'INSCRICAO' => $INSCRICAO,
            'CPF' => $CPF,
            'RG' => $RG,
            'RAZAO_SOCIAL' => ($this->uppercasebr(addslashes($this->input->post('dados')[1]))),
            'NOME_FANTASIA' => ($this->uppercasebr($this->input->post('dados')[2])),
            'CEP' => $this->input->post('dados')[3],
            'ENDERECO' => ($this->uppercasebr($this->formataTextoAspas(addslashes($this->input->post('dados')[4])))),
            'NUM_END_PRINCIPAL' => $this->input->post('dados')[5],
            'COMP_ENDERECO' => ($this->uppercasebr(addslashes($this->input->post('dados')[6]))),
            'BAIRRO' => ($this->uppercasebr(addslashes($this->input->post('dados')[7]))),
            'CIDADE' => ($this->uppercasebr(addslashes($this->input->post('dados')[8]))),
            'ESTADO' => ($this->uppercasebr(addslashes($this->input->post('dados')[9]))),
            'TELEFONE' => $this->input->post('dados')[10],
            'CELULAR' => $this->input->post('dados')[11],
            'FAX' => $this->input->post('dados')[12],
            'CONTATO' => ($this->uppercasebr(addslashes($this->input->post('dados')[13]))),
            'WEBSITE' => ($this->uppercasebr(addslashes($this->input->post('dados')[14]))),
            'TRANSPORTADORA' => $this->input->post('dados')[18],
            'EMAIL' => ($this->uppercasebr(addslashes($this->input->post('dados')[15]))),
            'VENDEDOR_EXTERNO' => $this->input->post('dados')[16],
            'OBS_CADASTRO' => ($this->uppercasebr(($this->input->post('dados')[17]))),
            'TIPO_CLIENTE' => 'A',
            'TIPO' => 'A',
            'DATA_CADASTRO' => date('Ymd'),
            'USUARIO_CADASTRO' => 'VOL',
            'ECOMMERCE' => 'S',
            'CODIGO_VENDEDOR' => $this->input->post('dados')[24]
        );
        
//        echo json_encode(array('$CGC' => $CGC, '$CPF' => $CPF, '$RG' => $RG, '$INSCRICAO' => $INSCRICAO, '$dados' => $dados));
//        exit();

//        $validador = $this->validarDados($dados);

//        if ($validador) {
            if ($this->input->post('dados')[23] == '') {
                $result = $this->clientes_models->inserirCliente($dados);
            } else {
                $vendedor = $this->session->userdata()['VENDEDOR'];
                $result = $this->clientes_models->updateCliente($dados, $vendedor);
            }
            echo json_encode('true');
            return false;
//        } else {
//            echo json_encode('false');
//            return false;
//        }
    }

//    public function validarDados($dados) {
//
//        if ($dados['NATUREZA'] == 'J') {
//            if ($dados['NATUREZA'] != '' AND $dados['CGC'] != '' AND $dados['INSCRICAO'] != '' AND $dados['RAZAO_SOCIAL'] != '' AND $dados['NOME_FANTASIA'] != '' AND strlen($dados['CEP']) == 9 AND $dados['ENDERECO'] != '' AND $dados['NUM_END_PRINCIPAL'] != '' AND $dados['BAIRRO'] != '' AND $dados['CIDADE'] != '' AND $dados['ESTADO'] != '' AND $dados['TELEFONE'] != '' AND $dados['CONTATO'] != '' AND $dados['EMAIL'] != '') {
//                return true;
//            } else {
//                return false;
//            }
//        } else {
//            if ($dados['NATUREZA'] != '' AND $dados['CPF'] != '' AND $dados['RG'] != '' AND $dados['RAZAO_SOCIAL'] != '' AND $dados['NOME_FANTASIA'] != '' AND strlen($dados['CEP']) == 9 AND $dados['ENDERECO'] != '' AND $dados['NUM_END_PRINCIPAL'] != '' AND $dados['BAIRRO'] != '' AND $dados['CIDADE'] != '' AND $dados['ESTADO'] != '' AND $dados['TELEFONE'] != '' AND $dados['CONTATO'] != '' AND $dados['EMAIL'] != '') {
//                return true;
//            } else {
//                return false;
//            }
//        }
//    }

    public function buscaClientePreencheFormulario() {
        $this->load->model('clientes_models');
        $result = $this->clientes_models->buscaClientePreencheFormulario($this->input->post('codigo'));
        echo json_encode($result);
    }

    public function uppercasebr($str) {

        return strtoupper(strtr($str, "áéíóúâêôãõàèìòùç", "ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
    }

    public function formataTextoAspas($string) {
        $search = array("'", "‘", "’");
        $replace = array(" ", " ", " ");
        $string = str_replace($search, $replace, $string);
        return $string;
    }

    public function listaTransportadora() {
        $this->load->model('fornecedor_models');
        $result = $this->fornecedor_models->listaTransportadora($this->input->get('q'));
        echo json_encode($result);
    }
    
    public function listaVendedor() {
        $this->load->model('clientes_models');
        $result = $this->clientes_models->buscarVendedores($this->input->get('q'));
        echo json_encode($result);
    }
    
    public function getByIdClientFinancial() {
        $this->load->model('clientes_models');
        
        $codeClient = $this->input->post('codeClient');
        
        $data['dados'] = $this->clientes_models->getByIdFinancial($codeClient);
        echo json_encode($data);
    }

    public function getByIdClientMarketing() {
        $this->load->model('clientes_models');
        
        $codeClient = $this->input->post('codeClient');
        $codigo = $this->input->post('codigo');
        if ($this->input->post('data_inicial') != '') {
            $data_inicial = $this->formatarData($this->input->post('data_inicial'));
            $data_final = $this->formatarData($this->input->post('data_final'));
        } else {
            $data_inicial = date('Ymd');
            $data_final = date('Ymd');
        }
        
        $data['dados'] = $this->clientes_models->getByIdMarketing($codeClient, $codigo, $data_inicial, $data_final);
        echo json_encode($data);
    }
    
    public function salvarTelemarketing() {
        $this->load->model('clientes_models');

        $data_contato = $this->formatarData($this->input->post('data_telemarketing_contato'));
        $proximo_contato = $this->formatarData($this->input->post('data_telemarketing_proximo_contato'));
        $cliente = $this->input->post('cliente');
        $contato = $this->input->post('contato_telemarketing');
        $vendedor = $this->input->post('vendedor_telemarketing');
        $obs = $this->input->post('observacao_telemarketing');
        $motivos = $this->input->post('motivos');
        $retorno = $this->input->post('retorno');
        $codigoTelemarketing = $this->input->post('codigoTelemarketing');
        
        if ($codigoTelemarketing == '') {
            $result = $this->clientes_models->buscaUltimoTlmk($cliente);
            $codigo = ($result[0]['CODIGO'] == NULL) ? 1: $result[0]['CODIGO'];
        } else {
            $codigo = $codigoTelemarketing;
        }
        $dados = array(
            'CODIGO' => $codigo,
            'CLIENTE' => $cliente,
            'VENDEDOR' => $vendedor,
            'OBSERVACAO' => ($this->uppercasebr(addslashes($obs))),
            'CONTATO' => $this->uppercasebr($contato),
            'VENDEDOR_EXTERNO' => $vendedor,
            'RETORNO' => ($retorno == 'false') ? 'N' : 'S',
            'MOTIVO' => $motivos,
            'DATA_CONTATO' => $data_contato,
            'PROXIMO_CONTATO' => $proximo_contato,
            'ECOMMERCE ' => 'S',
            'DATA_LANCAMENTO' => date('Ymd'),
        );

        if ($codigoTelemarketing == '') {
            $result = $this->clientes_models->inserirTelemarketing($dados);
        } else {
            $result = $this->clientes_models->updateTelemarketing($dados);
        }
        
        echo json_encode($result);
    }
    
}
