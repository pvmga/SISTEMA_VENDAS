<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
<!--        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url('img/Sem Título-1.jpg'); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $this->session->userdata('NOME') ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>-->

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">NAVEGAÇÃO PRINCIPAL</li>
            <li class="<?= (isset($active) && $active == 'dashboard') ? 'active' : '' ?>">
                <a href="<?= base_url('dashboard'); ?>">
                    <i class="fa fa-home"></i> <span>Home</span>
                </a>
            </li>
            
            <li class="<?= (isset($active) && $active == 'listagemCliente') ? 'active' : '' ?>">
                <a href="<?= base_url('listagemCliente'); ?>">
                    <i class="fa fa-user-plus"></i> <span>Clientes</span>
                </a>
            </li>
            
            <li class="<?= (isset($active) && $active == 'listagemVenda') ? 'active' : '' ?>">
                <a href="<?= base_url('listagemVenda/'); ?>"><i class="fa fa-briefcase"></i> <span>Vendas</span>
                </a>
            </li>

            <?php if ($this->session->userdata('ONLINE_VIS_COMISSAO') == 'S') { ?>
                <li class="<?= (isset($active) && $active == 'listagemComissao') ? 'active' : '' ?>">
                    <a href="<?= base_url('visualizarComissoes'); ?>">
                        <i class="fa fa-edit"></i> <span>Comissões</span>
                    </a>
                </li>
            <?php } ?>

            <?php if ($this->session->userdata('ONLINE_UTIL_AGENDA') == 'S') { ?>
                <li >
                    <a href="#">
                        <i class="fa fa-edit"></i> <span>Agenda</span>
                    </a>
                </li>
            <?php } ?>

            <li class="<?= (isset($active) && $active == 'listagemProdutos') ? 'active' : '' ?>">
                <a href="<?= base_url('listagemProduto/lista'); ?>">
                    <i class="fa fa-cube"></i> <span>Lista de Preços</span>
                </a>
            </li>

            <li class="<?= (isset($active) && $active == 'manualSistema') ? 'active' : '' ?>">
                <a href="<?= base_url('manualSistema'); ?>">
                    <i class="fa fa-warning"></i> <span>Manual Sistema</span>
                </a>
            </li>
<!--            <li class="<?= (isset($active) && $active == 'perfilUsuario') ? 'active' : '' ?>">
                <a href="<?= base_url('perfilUsuario'); ?>">
                    <i class="fa fa-institution"></i> <span>Perfil</span>
                </a>
            </li>-->
            <li class="">
                <a href="https://ingasoft.com.br/download/sup_team.exe">
                    <i class="fa fa-retweet"></i> <span>Teamviewer</span>
                </a>
            </li>
            <li class="">
                <a href="<?= base_url('logout'); ?>">
                    <i class="fa fa-sign-in"></i> <span>Sair</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>