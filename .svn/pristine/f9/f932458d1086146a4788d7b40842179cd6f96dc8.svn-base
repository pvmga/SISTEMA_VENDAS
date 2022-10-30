<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <!--<small>Painel de Controle</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Atalhos</h3>
                    </div>
                    <div class="box-body">
                        <?php if ($this->session->userdata['ONLINE_CAD_CLIENTES'] == 'S') { ?>
                        <a href="<?= base_url('cadastrarCliente'); ?>" class="btn btn-app">
                            <i class="fa fa-user-plus"></i> Cadastrar Cliente
                        </a>
                        <?php } ?>
                        <a href="<?= base_url('listagemCliente'); ?>" class="btn btn-app">
                            <i class="fa fa-briefcase"></i> Cadastrar Venda
                        </a>
                        <?php if ($this->session->userdata('ONLINE_LISTA_PRECOS') == 'S') { ?>
                        <a href="<?= base_url('listagemProduto/lista'); ?>" class="btn btn-app">
                            <i class="fa fa-cube"></i> Lista de preço / Produtos mais vendidos
                        </a>
                        <?php } ?>
                        <a href="<?= base_url('manualSistema'); ?>" class="btn btn-app">
                            <i class="fa fa-warning"></i> Manual Sistema
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3 id="orcamentos">0</h3>

                        <p>Orçamentos até: <?= date('d/m/Y'); ?></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="<?= base_url('listagemVenda/widget/O'); ?>" class="small-box-footer">Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3 id="novasVendas">0</h3>

                        <p>Novas Vendas até: <?= date('d/m/Y'); ?></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="<?= base_url('listagemVenda/widget/N'); ?>" class="small-box-footer">Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 id="todasVendas">0</h3>

                        <p>Todas Vendas: Concluídas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="<?= base_url('listagemVenda/widget/S'); ?>" class="small-box-footer">Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3 id="totalClientes">0</h3>

                        <p>Todos Clientes</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="<?= base_url('listagemCliente'); ?>" class="small-box-footer">Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Resumo Vendas (Com impostos)</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="columnchart_values" style="height: 325px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Gráfico - METAS</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="chart_div"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
//        echo '<pre>';
//        var_dump($this->session->userdata());
//        echo '</pre>';
        ?>
    </section>
</div>
