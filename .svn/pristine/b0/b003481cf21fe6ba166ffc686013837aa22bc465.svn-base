<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comissao extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if($this->session->userdata()['CODIGO'] == false)
            redirect('login');
    }

    public function index() {

        $data['title'] = 'ADMIN | Listagem de comissões';
        
        $this->load->model('vendas_models');
        $vendedor = $this->session->userdata()['VENDEDOR'];
        
        $data['active'] = 'listagemComissao';
        
        $this->load->model('usuario_models');
        $data['comissao'] = $this->usuario_models->get_comissao();     

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('telas/view_comissoes');

        $this->load->view('template/footer');
//        $this->load->view('ajax/listagemCliente');
    }

}
