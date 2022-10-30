<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Relatório Vendas</title>    
</head>
<!--<body onload="window.print();">-->
<body style="font-size: 10px;">
    <div class="wrapper">
        <section class="invoice">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-globe"></i> <?= $this->session->userdata('RAZAO_SOCIAL_PEDIDO'); ?>
                        <small class="pull-right">Data: <?= date('d/m/Y H:i:s'); ?></small>
                    </h2>
                </div>
            </div>
            <div class="row invoice-info">
                <div class="col-md-4 invoice-col">
                    De:
                    <address>
                        <strong><?= $this->session->userdata('RAZAO_SOCIAL_PEDIDO'); ?></strong><br>
                        <?= $this->session->userdata('ENDERECO_PEDIDO') .', '. $this->session->userdata('NUMERO_END_PEDIDO'); ?><br>
                        <?= $this->session->userdata('CIDADE_PEDIDO') .'-'. $this->session->userdata('ESTADO_PEDIDO'); ?><br>
                        Telefone: <?= $this->session->userdata('TELEFONE_PEDIDO'); ?><br>
                        Email: <?= $this->session->userdata('EMAIL_PEDIDO'); ?>
                    </address>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table id="myTable" class="table table-striped display" width="100%" cellspacing="0" border="1">
                        <thead>
                            <tr>
                                <th>Venda</th>
                                <th style="text-align: left;">Cliente</th>
                                <th style="text-align: center;">Total Venda</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php 
                            $total_vendas = 0;
                            $total_venda = 0;
                            foreach($relatorioVendas['data'] as $vendas) {
//                                echo '<pre>';
//                                echo str_replace(",", ".", substr($vendas['total_venda'], 2));
                                $total_vendas += str_replace(",", ".", substr($vendas['total_venda'], 2));
                                $total_venda = str_replace(",", ".", substr($vendas['total_venda'], 2));
//                                echo '</pre>';
                                ?>
                                <tr>
                                    <td style="width: 50px;"><?= $vendas['cod_venda'];  ?></td>
                                    <td style="text-align: left;"><?= $vendas['razao_social']; ?></td>
                                    <td style="text-align: center;">R$ <?= number_format($total_venda, 2, ',', '.'); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th style="text-align: left; font-size: 13px;">Total Vendas</th>
                                <th style="text-align: center;">R$ <?= number_format($total_vendas, 2, ',', '.'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
</body>
</html>
