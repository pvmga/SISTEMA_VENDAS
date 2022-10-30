<?php
$classHidden = '';
$titulo = 'Listagem de produtos / Produtos mais vendidos';
if ($tipo_ordenacao == 'lista_mais_vendidos') {
    $classHidden = 'hidden';
    $titulo = 'Produtos mais vendidos';
} 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Lista de preço
            <!--<small>Painel de Controle</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $titulo; ?></li>
        </ol>
    </section>
    <section class="content">
        <input class="hidden" id="tipo_ordenacao" value="<?= $tipo_ordenacao; ?>">
        <?php if ($this->session->userdata('ONLINE_LISTA_PRECOS') == 'S') { ?>
        <div class="box box-primary <?= $classHidden; ?>">
            <div class="box-header">
                <h3 class="box-title">Lista de preços</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Tipo:</label>
                            <select id="tipo_lista" class="form-control" style="width: 100%;">
                                <option value="L">Lista de preço</option>
                                <option value="C">Catálogo</option>
                                <option value="LG">Lista de preço (Grupo)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2" hidden>
                        <div class="form-group">
                            <label>Visualização:</label>
                            <select id="tipo_visualizacao" class="form-control" style="width: 100%;">
<!--                                <option value="HTML">VISUALIZAR HTML</option>
                                <option value="TELA">EM TELA</option>-->
                                <option value="0">DOWNLOAD</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 grupo">
                        <div class="form-group">
                            <label>Grupo:</label>
                            <select name="grupos" id="grupo" class="form-control" style="width: 100%;">
                                <option value="">Todos</option>
                                <?php foreach ($grupos as $grupo) { ?>
                                    <option id="opt" value="<?php echo $grupo['CODIGO']; ?>"><?php echo $grupo['CODIGO'] .' - '. $grupo['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 subgrupo">
                        <div class="form-group">
                            <label>Subgrupo:</label>
                            <select name="subgrupos" id="subgrupo" class="form-control" style="width: 100%;">
                                <option value="">Todos</option>
                                <?php foreach ($subgrupos as $subgrupo) { ?>
                                    <option id="opt" value="<?php echo $subgrupo['CODIGO']; ?>"><?php echo $subgrupo['CODIGO'] .' - '. $subgrupo['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 hidden">
                        <div class="form-group">
                            <label>Preço base:</label>
                            <select id="preco" class="form-control" style="width: 100%;">
                                <option value="PRECO_VENDA_A">Selecione...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 estado">
                        <div class="form-group">
                            <label>Estado:</label>
                            <?php if ($this->session->userdata('ESTADO_VENDEDOR') == '') {
                                $estado = 'PR';
                            } else {
                                $estado = $this->session->userdata('ESTADO_VENDEDOR');
                            } ?>
                            <select id="estado" class="form-control" style="width: 100%;">
                                <option value="<?php echo $this->session->userdata('ESTADO_VENDEDOR') ?>"><?php echo $this->session->userdata('ESTADO_VENDEDOR'); ?></option>
                                <option value="PR">PR</option>
                                <option value="SC">SC</option>
                                <option value="SP">SP</option>
                                <option value="AC">AC</option>
                                <option value="AL">AL</option>
                                <option value="AM">AM</option>
                                <option value="AP">AP</option>
                                <option value="BA">BA</option>
                                <option value="CE">CE</option>
                                <option value="DF">DF</option>
                                <option value="ES">ES</option>
                                <option value="GO">GO</option>
                                <option value="MA">MA</option>
                                <option value="MG">MG</option>
                                <option value="MS">MS</option>
                                <option value="MT">MT</option>
                                <option value="PA">PA</option>
                                <option value="PB">PB</option>
                                <option value="PE">PE</option>
                                <option value="PI">PI</option>
                                <option value="RJ">RJ</option>
                                <option value="RN">RN</option>
                                <option value="RO">RO</option>
                                <option value="RR">RR</option>
                                <option value="RS">RS</option>
                                <option value="SE">SE</option>
                                <option value="TO">TO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 optante">
                        <div class="form-group">
                            <label>Simples:</label>
                            <select id="optante" class="form-control" style="width: 100%;">
                                <option value="N">Não</option>
                                <option value="S">Sim</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 foto">
                        <div class="form-group">
                            <label>Foto:</label>
                            <select id="foto" class="form-control" style="width: 100%;">
                                <option value="N">Não</option>
                                <option value="S">Sim</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 promocional">
                        <div class="form-group">
                            <label>Promocional:</label>
                            <select id="promocional" class="form-control" style="width: 100%;">
                                <option value="">Todos</option>
                                <option value="S">Sim</option>
                                <option value="N">Não</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>.</label>
                        <div class="form-group">
                            <button class="btn btn-primary" id="gerar_lista">Gerar</button>
                            <a href="<?php echo base_url('') .'/files/'. $this->session->userdata('NOME'); ?>.xlsx" class="btn_download" target="_blank">DOWNLOAD LISTA</a>
                            <a href="<?php echo base_url('') .'/files/'. $this->session->userdata('NOME'); ?>_catalogo.pdf" class="btn_download_catalogo hidden" style="font-size: 12px;" target="_blank">DOWNLOAD CATÁLOGO</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        
        <?php } ?>
        
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?= $titulo; ?></h3>
            </div>
             <!--/.box-header--> 
            <div class="box-body">
                <div class="row">
                    <?php
                    $data_inicial = date('dmY', strtotime('-3 month'));
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
                        
                </div>
                <div class="row table-responsive">
                    <div class="col-md-12">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="background-color: #3c8dbc; color: white; width: 10px;">Código</th>
                                    <th style="background-color: #3c8dbc; color: white;">Descrição</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 60px;">Grupo</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 10px;">Estoque</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 10px;">Reservado</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 10px;">Disponivel</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 10px;">Preço</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 60px;">(%) Desc.</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 100px;">Qtd. Vendida</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 50px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="background-color: #3c8dbc; color: white; width: 10px;">Código</th>
                                    <th style="background-color: #3c8dbc; color: white;">Descrição</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 60px;">Grupo</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 10px;">Estoque</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 10px;">Reservado</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 10px;">Disponivel</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 10px;">Preço</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 60px;">(%) Desc.</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 100px;">Qtd. Vendida</th>
                                    <th style="background-color: #3c8dbc; color: white; width: 50px;"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
             <!--/.box-body--> 
        </div>
    </section>

</div>