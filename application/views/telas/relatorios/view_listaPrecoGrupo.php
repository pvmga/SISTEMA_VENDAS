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
                    <b>De:</b>
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
                    <?php foreach($dados as $dado) { 
                        $grupo = isset($dado['CODIGO_GRUPO']) ? $dado['CODIGO_GRUPO'] : '';
                        ?>
                        <p style="font-size: 16px; font-weight: bold;">GRUPO: <?= $grupo ?></p>
                        <?php 
                        if (isset($dado['SUBGRUPO'])) {
                            $SUB = isset($dado['SUBGRUPO']) ? $dado['SUBGRUPO'] : '';
                            foreach($SUB as $subgrupo) {
                                foreach($subgrupo as $produtos) {
                                ?>

                                <p style="">SUBGRUPO: <?= $produtos['CODIGO_SUBGRUPO'] ?></p>
                                <table class="table table-striped display" width="100%" cellspacing="0" border="1">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left;">Cod.</th>
                                            <th style="text-align: left;">Descrição</th>
                                            <th style="text-align: center;">UN</th>
                                            <th style="text-align: center;">1</th>
                                            <th style="text-align: center;">2</th>
                                            <th style="text-align: center;">3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
//                                        echo '<pre>';
//                                        var_dump($produtos['PRODUTOS']);
//                                        echo '</pre>';
                                        ?>
                                        
                                        <?php 
                                        $total = 0;
                                        foreach($produtos['PRODUTOS'] as $produto) { 
                                            $total = $total + 1;
                                            ?>
                                        <tr>
                                            <td style="width: 50px;"><?= $produto['CODIGO_PRODUTO'] ?></td>
                                            <td style="text-align: left;"><?= $produto['DESCRICAO_PRODUTO'] ?></td>
                                            <td style="text-align: center;"><?= $produto['UNIDADE'] ?></td>
                                            <td style="text-align: center;"><?= $produto['PRECO_VENDA_A'] ?></td>
                                            <td style="text-align: center;"><?= $produto['PRECO_VENDA_V'] ?></td>
                                            <td style="text-align: center;"><?= $produto['PRECO_PROMOCIONAL'] ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th style="text-align: left; font-size: 13px;">Total Registros</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th style="text-align: center;"><?= $total; ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <?php
                                }
                            }
                        }
                    }
                    ?>
                    <br />
                </div>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
</body>
</html>
