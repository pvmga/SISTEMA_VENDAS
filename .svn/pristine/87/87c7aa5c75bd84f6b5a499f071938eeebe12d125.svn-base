<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title; ?></title>   
</head>
<!--<body onload="window.print();">-->
<body style="font-size: 10px;">
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!--<a href="<?= base_url('alterarVenda/'.$this->uri->segment('2').'/'.$this->uri->segment('3')); ?>" class="btn btn-flat btn-default">Voltar</a>-->
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-globe"></i> <?= $this->session->userdata('RAZAO_SOCIAL_PEDIDO'); ?>
                        <small class="pull-right">Data: <?= date('d/m/Y H:i:s'); ?></small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table" width="100%" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <strong>De</strong> <br />
                                    <strong><?= $this->session->userdata('RAZAO_SOCIAL_PEDIDO'); ?></strong><br>
                                    <?= $this->session->userdata('ENDERECO_PEDIDO') .', '. $this->session->userdata('NUMERO_END_PEDIDO'); ?><br>
                                    <?= $this->session->userdata('CIDADE_PEDIDO') .'-'. $this->session->userdata('ESTADO_PEDIDO'); ?><br>
                                    Telefone: <?= $this->session->userdata('TELEFONE_PEDIDO'); ?><br>
                                    E-mail: <?= $this->session->userdata('EMAIL_PEDIDO'); ?>
                                </td>
                                <td>
                                    <strong>Para</strong> <br />
                                    <strong><?= $dadosPedido['DADOS']['CODIGO_CLIENTE'] .'-'. substr($dadosPedido['DADOS']['RAZAO_SOCIAL'], 0, 20); ?></strong><br>
                                    <?= $dadosPedido['DADOS']['ENDERECO'] .', ' . $dadosPedido['DADOS']['NUM_END_PRINCIPAL']; ?><br>
                                    <?= $dadosPedido['DADOS']['CIDADE'] .'-' . $dadosPedido['DADOS']['ESTADO'] ?><br>
                                    Telefone: <?= $dadosPedido['DADOS']['TELEFONE'] ?><br>
                                    E-mail: <?= $dadosPedido['DADOS']['EMAIL'] ?>
                                </td>
                                <?php
                                $date = date_create($dadosPedido['DADOS']['DATA_VENDA']);
                                $tipo = ($this->uri->segment('3') == 'V') ? 'Pedido fechado' : 'Orçamento';
                                ?>
                                <td>
                                    <strong>Dados</strong> <br />
                                    <b>N° do pedido:</b> <?= $this->uri->segment('2'); ?><br>
                                    Data Pedido: <?php echo date_format($date, 'd/m/Y'); ?><br>
                                    Tipo: <?= $tipo; ?><br>
                                    Vendedor: <?= $dadosPedido['DADOS']['CODIGO_VENDEDOR'] .'-'. $dadosPedido['DADOS']['NOME_VENDEDOR_INTERNO']; ?><br>
                                    E-mail: <?= $this->session->userdata('EMAIL_VENDEDOR'); ?>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
            
            <br />

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table id="myTable" class="table table-striped display" width="100%" cellspacing="0" border="1">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th style="text-align: center;">Qtde.</th>
                                <!--<th style="text-align: center;">Vlr. Unit.</th>-->
<!--                                <th style="text-align: center;">(%) Acresc.</th>
                                <th style="text-align: center;">(%) Desc.</th>-->
                                <th style="text-align: center;">Unit. Liq.</th>
                                <th style="text-align: center;">Total Liq.</th>
                                <th style="text-align: center;">ST/IPI</th>
                                <th style="text-align: center;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_imposto = 0;
                            $total_produtos = 0;
                            foreach($dadosPedido['ITENS'] as $item) {
                                $total_imposto = $total_imposto + $item['valor_imposto_impressao'];
                                $total_produtos = $total_produtos + $item['total_liquido_impressao'];
                                ?>
                                <tr>
                                    <td style="width: 230px;"><?= $item['cod_prod'] .'-'. $item['descricao'];  ?></td>
                                    <td style="text-align: center;"><?= $item['quantidade']; ?></td>
                                    <!--<td style="text-align: center;">R$ <?= $item['valor_unit']; ?></td>-->
<!--                                    <td style="text-align: center;"><?= $item['acrescimo']; ?></td>
                                    <td style="text-align: center;"><?= $item['percentual_desconto']; ?></td>-->
                                    <td style="text-align: center;">R$ <?= $item['valor_unitario_com_desconto'] ?></td>
                                    <td style="text-align: center;">R$ <?= $item['total_liquido']; ?></td>
                                    <td style="text-align: center;">R$ <?= $item['valor_imposto']; ?></td>
                                    <td style="text-align: center;">R$ <?= $item['total']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <div class="col-xs-12">
                    <p class="lead">Metodo de pagamento: <?= $dadosPedido['DADOS']['DESCRICAO_CONDICAO_PAGAMENTO']; ?></p>
                    <p class="lead">Tipo de pagamento: <?= $dadosPedido['DADOS']['DESCRICAO_TIPO_PAGAMENTO']; ?></p>

                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                        <b>Observações:</b> <?= $dadosPedido['DADOS']['OBS_COMP']; ?>
                    </p>
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <p class="lead">Valores correspondente a data do pedido: <?php echo date_format($date, 'd/m/Y'); ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <div class="table-responsive">
                        <table class="table" cellspacing="0" border="1">
<!--                            <tr class="">
                                <th>Total Produtos:</th>
                                <td>R$ <?php echo number_format($total_produtos, 2, ',', '.'); ?></td>
                            </tr>-->
                            <tr>
                                <th>Total ST/IPI:</th>
                                <td>R$ <?php echo number_format($total_imposto, 2, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Total Produtos+Impostos:</th>
                                <td>R$ <?php echo number_format($dadosPedido['DADOS']['TOTAL_VENDA'], 2, ',', '.'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
</body>
</html>
