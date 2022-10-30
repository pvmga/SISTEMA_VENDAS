<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if($this->session->userdata()['CODIGO'] == false)
            redirect('login');
    }

    public function index() {

        $data['title'] = 'ADMIN | Listagem de clientes';
        
        $this->load->model('vendas_models');
        $vendedor = $this->session->userdata()['VENDEDOR'];

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('telas/view_listagemCliente');

        $this->load->view('template/footer');
        $this->load->view('ajax/listagemCliente');
    }

}
