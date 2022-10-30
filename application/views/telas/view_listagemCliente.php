<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Listagem de clientes
            <!--<small>Painel de Controle</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Listagem de clientes</li>
        </ol>
        <div class="col-md-10"></div>
    </section>
    <section class="content">
        <div class="row">
            <?php if ($this->session->userdata['ONLINE_CAD_CLIENTES'] == 'S') { ?>
                <div class="col-md-2">
                    <a href="<?= base_url('cadastrarCliente'); ?>" class="btn btn-block btn-success btn-flat"><i class="fa fa-plus-square"></i> Cadastrar Cliente</a>
                </div>
<!--                <div class="col-md-2">
                    <button class="btn btn-block btn-info btn-flat" id="modalRelatorio">Relatório</button>
                </div>-->
                <div class="col-md-8"></div>
            <?php } ?>
        </div>
        <br />
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Listagem de clientes</h3>
            </div>
            <!--<input type="hidden" id="valorASerAlterado" value="0"/>-->
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <!--<label>:</label>-->
                            <select class="form-control" id="ativo_inativo" style="width: 100%;">
                                <?php if ($this->session->userdata['ONLINE_VENDER_CLIENTE_BLOQ'] == 'N') { ?>
                                    <option value="A">ATIVOS</option>
                                    <option value="I">INATIVOS</option>
                                    <option value="B">BLOQUEADOS</option>
                                    <option value="P">PROSPECTOS</option>
                                    <option value="D">DESCARTADOS</option>
                                <?php } else { ?>
                                    <option value="T">TODOS</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                    
                <div class="row table-responsive">
                    <div class="col-md-12">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 40px; background-color: #3c8dbc; color: white;">Código</th>
                                    <th style="background-color: #3c8dbc; color: white;">Razão Social</th>
                                    <th style="background-color: #3c8dbc; color: white;">Nome Fantasia</th>
                                    <th style="background-color: #3c8dbc; color: white;">Cidade</th>
                                    <th style="width: 15px; background-color: #3c8dbc; color: white;">UF</th>
                                    <th style="width: 15px; background-color: #3c8dbc; color: white;">Tipo</th>
                                    <th style="background-color: #3c8dbc; color: white;"></th>
                                    <th style="background-color: #3c8dbc; color: white;"></th>
                                    <th style="background-color: #3c8dbc; color: white;"></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="width: 40px; background-color: #3c8dbc; color: white;">Código</th>
                                    <th style="background-color: #3c8dbc; color: white;">Razão Social</th>
                                    <th style="background-color: #3c8dbc; color: white;">Nome Fantasia</th>
                                    <th style="background-color: #3c8dbc; color: white;">Cidade</th>
                                    <th style="width: 15px; background-color: #3c8dbc; color: white;">UF</th>
                                    <th style="width: 15px; background-color: #3c8dbc; color: white;">Tipo</th>
                                    <th style="background-color: #3c8dbc; color: white;"></th>
                                    <th style="background-color: #3c8dbc; color: white;"></th>
                                    <th style="background-color: #3c8dbc; color: white;"></th>
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