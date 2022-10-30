<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Listagem de vendas
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Listagem de vendas</li>
        </ol>
        <div class="col-md-10"></div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-2">
                <!--<a href="<?= base_url('cadastrarVenda'); ?>" class="btn btn-block btn-success btn-flat"><i class="fa fa-plus-square"></i> Criar Pedido</a>-->
                <a href="<?= base_url('listagemCliente'); ?>" class="btn btn-block btn-success btn-flat"><i class="fa fa-plus-square"></i> Criar Pedido</a>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-info btn-flat" id="modalRelatorio">Relatório</button>
            </div>
            <div class="col-md-8"></div>
        </div>
        <br />
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Listagem de vendas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <?php
                    $data_inicial = date('dmY', strtotime('-5 month'));
                    if ($this->uri->segment('3') == 'O' || $this->uri->segment('3') == 'N' || $this->uri->segment('3') == 'S') {
                        $data_inicial = '';    
                    }
                    ?>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input class="form-control" id="data_venda_inicial" placeholder="Data Inicial: <?= date('d/m/Y'); ?>" value="<?= $data_inicial; ?>" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input class="form-control" id="data_venda_final" value="<?= date('dmY'); ?>" />
                        </div>
                    </div>
                    
                    <?php                    
                    $tipo_pedidos = array(
                        array(
                            'value' => 'O',
                            'descricao' => 'ORÇAMENTO'
                        ),
                        array(
                            'value' => 'N',
                            'descricao' => 'PEDIDOS ENVIADOS'
                        ),
                        array(
                            'value' => 'S',
                            'descricao' => 'PEDIDOS FATURADOS'
                        ),
                        array(
                            'value' => 'H',
                            'descricao' => 'HISTÓRICO(Ped. Cancelado)'
                        )
                    );
                    ?>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <!--<label>:</label>-->
                            <select id="tipo_pedidoss" class="form-control" style="width: 100%;">
                                <?php foreach ($tipo_pedidos as $tipo_pedido) { 
                                    if ($tipo_pedido['value'] == $this->uri->segment(3)) { ?>
                                        <option value="<?= $tipo_pedido['value']; ?>"><?= $tipo_pedido['descricao']; ?></option>
                                    <?php } ?>
                                <?php }
                                foreach ($tipo_pedidos as $tipo_pedido) { 
                                    if ($tipo_pedido['value'] != $this->uri->segment(3)) { ?>
                                        <option value="<?= $tipo_pedido['value']; ?>"><?= $tipo_pedido['descricao']; ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row table-responsive">
                    <div class="col-md-12">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="background-color: #3c8dbc; color: white; width: 10px;">Venda</th>
                                    <th style="background-color: #3c8dbc; color: white;">Cliente</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 80px;">Dt. Venda</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 80px;">Cond. Pgto.</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 80px;">Tipo Pgto.</th>
                                    <!--<th style="background-color: #3c8dbc; color: white;">Frete</th>-->
                                    <th style="background-color: #3c8dbc; color: white; width: 80px;">Total Venda</th>
                                    <!--<th style="background-color: #3c8dbc; color: white; width: 132px"></th>-->
                                    <th style="background-color: #3c8dbc; color: white; width: 80px;"></th>
                                    <th style="background-color: #3c8dbc; color: white; width: 60px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="background-color: #3c8dbc; color: white; width: 10px;">Venda</th>
                                    <th style="background-color: #3c8dbc; color: white;">Cliente</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 80px;">Dt. Venda</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 80px;">Cond. Pgto.</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 80px;">Tipo Pgto.</th>
                                    <!--<th style="background-color: #3c8dbc; color: white;">Frete</th>-->
                                    <th style="background-color: #3c8dbc; color: white; width: 80px;">Total Venda</th>
                                    <!--<th style="background-color: #3c8dbc; color: white; width: 132px"></th>-->
                                    <th style="background-color: #3c8dbc; color: white; width: 80px;"></th>
                                    <th style="background-color: #3c8dbc; color: white; width: 60px;"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
</div>