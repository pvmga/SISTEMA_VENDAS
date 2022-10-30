<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Lista de telemarketing
            <!--<small>Painel de Controle</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Telemarketing</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary ">
            <div class="box-header">
                <h3 class="box-title">Telemarketing</h3>
            </div>
            <input class="hidden" id="codigoInterno" />
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <input class="form-control" id="data_telemarketing_filtro_inicial" value="<?= date('d/m/Y'); ?>" onchange="getDadosTelemarketing();" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input class="form-control" id="data_telemarketing_filtro_final" value="<?= date('d/m/Y'); ?>" onchange="getDadosTelemarketing();" />
                        </div>
                    </div>
                </div>
                <div class="row table-responsive">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Dt. Contato</th>
                                    <th style="width: 10%;">Contato</th>
                                    <th>Próx. Retorno</th>
                                    <th>Retorno</th>
                                    <th>Motivo</th>
                                </tr>
                            </thead>
                            <tbody id="tabela_telemarketing">
                            <tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>

</div>