<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>

    <link rel="stylesheet" href="<?= base_url('bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">    
    <link rel="stylesheet" href="<?= base_url('dist/css/AdminLTE.min.css'); ?>">

</head>
<body style="margin: 0px;">
    <?php
    $tamanho_produto = 150;
    $margin_left_foto_prod = '30px';
    $tamanho_pagina_width = '794px';
    $tamanho_pagina_height = '1123px';

    $quantidade_produtos = (count($produtos));
    $cont_produtos = 0;
    $font_size_itens = '8px;';
    $font_size_descricao = 'font-size: 10px;';
    $grupo_anterior = '';

//    echo '<pre>';
//    print_r(count($produtos));
//    echo '</pre>';
//    exit();

    ?>
    <!-- Primeira página-->
    <section>
        <img src="<?php echo base_url($produtos[$cont_produtos]['FOTO_CAPA']); ?>" />
        <!--FOTO CAPA--> 
    </section>
    <!-- /Primeira página-->

    <?php
    for ($x=0; $x<$quantidade_produtos; $x) {
        $retorna = 0;

        $grupo_anterior = $produtos[$x]['DESCRICAO_GRUPO'];
//        var_dump($produtos[$cont_produtos]['DESCRICAO_GRUPO']);
        ?>
        <section style="width: <?= $tamanho_pagina_width; ?>; height: <?= $tamanho_pagina_height; ?>">
            <?php // if ($grupo_anterior != $produtos[0]['DESCRICAO_GRUPO']) { ?>
            <div class="text-left">
                <!-- FOTO GRUPO -->
                <img src='<?php echo base_url($produtos[$x]['FOTO_GRUPO']); ?>' />
                <!--<img src='https://ingasoft.com.br/download/fotos/<?=$produtos[$cont_produtos]['FOTO_GRUPO'];?>_grupo.png' />-->
            </div>
            <div class="row invoice-info" style="<?= $font_size_descricao; ?>">
                <div class="invoice-col">
                    <?php if (isset($produtos[$cont_produtos]['ITENS'])) { ?>
                    <div class="col-xs-12">
                        <span>
                            <img style="margin-left: <?= $margin_left_foto_prod ?>;" src='<?php echo base_url($produtos[$cont_produtos]['FOTO']); ?>' width="<?= $tamanho_produto; ?>" />
                            <!--<img style="margin-left: <?= $margin_left_foto_prod ?>;" src='https://ingasoft.com.br/download/fotos/<?=$produtos[$cont_produtos]['FOTO'];?>.png' width="<?= $tamanho_produto; ?>" />-->
                        </span>
                    </div>
                    <div class="col-xs-12">
                        <p style="font-weight: bold;"><?php echo  $produtos[$cont_produtos]['CODIGO'].'-'. $produtos[$cont_produtos]['DESCRICAO']; ?></p>
                        <!--<p><?= $produtos[$cont_produtos]['DESCRICAO_GRUPO']; ?></p>-->
                        <?php for($i=0; $i<(count($produtos[$cont_produtos]['ITENS'])); $i++) { ?>
                            <span style="font-size: <?= $font_size_itens; ?>;"><?= ($produtos[$cont_produtos]['ITENS'][$i]['COD_ITEM'].' - '.$produtos[$cont_produtos]['ITENS'][$i]['DESCRICAO_PRODUTO']); ?></span><br />
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>

                <div class="invoice-col">
                    <?php if (isset($produtos[$cont_produtos+1]['ITENS'])) { ?>
                    <div class="col-xs-12">
                        <span >
                            <img style="margin-left: <?= $margin_left_foto_prod ?>;" src='<?php echo base_url($produtos[$cont_produtos+1]['FOTO']); ?>' width="<?= $tamanho_produto; ?>" />
                            <!--<img style="margin-left: <?= $margin_left_foto_prod ?>;" src='https://ingasoft.com.br/download/fotos/<?=$produtos[$cont_produtos+1]['FOTO'];?>.png' width="<?= $tamanho_produto; ?>" />-->
                        </span>
                    </div>
                    <div class="col-xs-12">
                        <p style="font-weight: bold;"><?php echo $produtos[$cont_produtos+1]['CODIGO'].'-'.$produtos[$cont_produtos+1]['DESCRICAO']; ?></p>
                        <!--<p><?= $produtos[$cont_produtos+1]['DESCRICAO_GRUPO']; ?></p>-->
                        <?php for($i=0; $i<(count($produtos[$cont_produtos+1]['ITENS'])); $i++) { ?>
                            <span style="font-size: <?= $font_size_itens; ?>;"><?= ($produtos[$cont_produtos+1]['ITENS'][$i]['COD_ITEM'].' - '.$produtos[$cont_produtos+1]['ITENS'][$i]['DESCRICAO_PRODUTO']); ?></span><br />
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>

                <div class="invoice-col">
                    <?php if (isset($produtos[$cont_produtos+2]['ITENS'])) { ?>
                    <div class="col-xs-12">
                        <span >
                            <img style="margin-left: <?= $margin_left_foto_prod ?>;" src='<?php echo base_url($produtos[$cont_produtos+2]['FOTO']); ?>' width="<?= $tamanho_produto; ?>" />
                            <!--<img style="margin-left: <?= $margin_left_foto_prod ?>;" src='https://ingasoft.com.br/download/fotos/<?=$produtos[$cont_produtos+2]['FOTO'];?>.png' width="<?= $tamanho_produto; ?>" />-->
                        </span>
                    </div>
                    <div class="col-xs-12">
                        <p style="font-weight: bold;"><?php echo $produtos[$cont_produtos+2]['CODIGO'].'-'.$produtos[$cont_produtos+2]['DESCRICAO']; ?></p>
                        <!--<p><?= $produtos[$cont_produtos+2]['DESCRICAO_GRUPO']; ?></p>-->
                        <?php for($i=0; $i<(count($produtos[$cont_produtos+2]['ITENS'])); $i++) { ?>
                            <span style="font-size: <?= $font_size_itens; ?>;"><?= ($produtos[$cont_produtos+2]['ITENS'][$i]['COD_ITEM'].' - '.$produtos[$cont_produtos+2]['ITENS'][$i]['DESCRICAO_PRODUTO']); ?></span><br />
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>

            </div>

            <div class="row invoice-info" style="<?= $font_size_descricao; ?>">
                <div class="invoice-col">
                    <?php if (isset($produtos[$cont_produtos+3]['ITENS'])) { ?>
                    <div class="col-xs-12">
                        <span >
                            <img style="margin-left: <?= $margin_left_foto_prod ?>;" src='<?php echo base_url($produtos[$cont_produtos+3]['FOTO']); ?>' width="<?= $tamanho_produto; ?>" />
                            <!--<img style="margin-left: <?= $margin_left_foto_prod ?>;" src='https://ingasoft.com.br/download/fotos/<?=$produtos[$cont_produtos+3]['FOTO'];?>.png' width="<?= $tamanho_produto; ?>" />-->
                        </span>
                    </div>
                    <div class="col-xs-12">
                        <p style="font-weight: bold;"><?php echo $produtos[$cont_produtos+3]['CODIGO'].'-'.$produtos[$cont_produtos+3]['DESCRICAO']; ?></p>
                        <!--<p><?= $produtos[$cont_produtos+3]['DESCRICAO_GRUPO']; ?></p>-->
                        <?php for($i=0; $i<(count($produtos[$cont_produtos+3]['ITENS'])); $i++) { ?>
                            <span style="font-size: <?= $font_size_itens; ?>;"><?= ($produtos[$cont_produtos+3]['ITENS'][$i]['COD_ITEM'].' - '.$produtos[$cont_produtos+3]['ITENS'][$i]['DESCRICAO_PRODUTO']); ?></span><br />
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>

                <div class="invoice-col">
                    <?php if (isset($produtos[$cont_produtos+4]['ITENS'])) { ?>
                    <div class="col-xs-12">
                        <span>
                            <img style="margin-left: <?= $margin_left_foto_prod ?>;" src='<?php echo base_url($produtos[$cont_produtos+4]['FOTO']); ?>' width="<?= $tamanho_produto; ?>" />
                            <!--<img style="margin-left: <?= $margin_left_foto_prod ?>;" src='https://ingasoft.com.br/download/fotos/<?=$produtos[$cont_produtos+4]['FOTO'];?>.png' width="<?= $tamanho_produto; ?>" />-->
                        </span>
                    </div>
                    <div class="col-xs-12">
                        <p style="font-weight: bold;"><?php echo $produtos[$cont_produtos+4]['CODIGO'].'-'.$produtos[$cont_produtos+4]['DESCRICAO']; ?></p>
                        <!--<p><?= $produtos[$cont_produtos+4]['DESCRICAO_GRUPO']; ?></p>-->
                        <?php for($i=0; $i<(count($produtos[$cont_produtos+4]['ITENS'])); $i++) { ?>
                            <span style="font-size: <?= $font_size_itens; ?>;"><?= ($produtos[$cont_produtos+4]['ITENS'][$i]['COD_ITEM'].' - '.$produtos[$cont_produtos+4]['ITENS'][$i]['DESCRICAO_PRODUTO']); ?></span><br />
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>

                <div class="invoice-col">
                    <?php if (isset($produtos[$cont_produtos+5]['ITENS'])) { ?>
                    <div class="col-xs-12">
                        <span >
                            <img style="margin-left: <?= $margin_left_foto_prod ?>;" src='<?php echo base_url($produtos[$cont_produtos+5]['FOTO']); ?>' width="<?= $tamanho_produto; ?>" />
                            <!--<img style="margin-left: <?= $margin_left_foto_prod ?>;" src='https://ingasoft.com.br/download/fotos/<?=$produtos[$cont_produtos+5]['FOTO'];?>.png' width="<?= $tamanho_produto; ?>" />-->
                        </span>
                    </div>
                    <div class="col-xs-12">
                        <p style="font-weight: bold;"><?php echo $produtos[$cont_produtos+5]['CODIGO'].'-'.$produtos[$cont_produtos+5]['DESCRICAO']; ?></p>
                        <!--<p><?= $produtos[$cont_produtos+5]['DESCRICAO_GRUPO']; ?></p>-->
                        <?php for($i=0; $i<(count($produtos[$cont_produtos+5]['ITENS'])); $i++) { ?>
                            <span style="font-size: <?= $font_size_itens; ?>;"><?= ($produtos[$cont_produtos+5]['ITENS'][$i]['COD_ITEM'].' - '.$produtos[$cont_produtos+5]['ITENS'][$i]['DESCRICAO_PRODUTO']); ?></span><br />
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>

            </div>

            <div class="row invoice-info" style="<?= $font_size_descricao; ?>">
                <div class="invoice-col">
                    <?php if (isset($produtos[$cont_produtos+6]['ITENS'])) { ?>
                    <div class="col-xs-12">
                        <span >
                            <img style="margin-left: <?= $margin_left_foto_prod ?>;" src='<?php echo base_url($produtos[$cont_produtos+6]['FOTO']); ?>' width="<?= $tamanho_produto; ?>" />
                            <!--<img style="margin-left: <?= $margin_left_foto_prod ?>;" src='https://ingasoft.com.br/download/fotos/<?=$produtos[$cont_produtos+6]['FOTO'];?>.png' width="<?= $tamanho_produto; ?>" />-->
                        </span>
                    </div>
                    <div class="col-xs-12">
                        <p style="font-weight: bold;"><?php echo $produtos[$cont_produtos+6]['CODIGO'].'-'.$produtos[$cont_produtos+6]['DESCRICAO']; ?></p>
                        <!--<p><?= $produtos[$cont_produtos+6]['DESCRICAO_GRUPO']; ?></p>-->
                        <?php for($i=0; $i<(count($produtos[$cont_produtos+6]['ITENS'])); $i++) { ?>
                            <span style="font-size: <?= $font_size_itens; ?>;"><?= ($produtos[$cont_produtos+6]['ITENS'][$i]['COD_ITEM'].' - '.$produtos[$cont_produtos+6]['ITENS'][$i]['DESCRICAO_PRODUTO']); ?></span><br />
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>

                <div class="invoice-col">
                    <?php if (isset($produtos[$cont_produtos+7]['ITENS'])) { ?>
                    <div class="col-xs-12">
                        <span >
                            <img style="margin-left: <?= $margin_left_foto_prod ?>;" src='<?php echo base_url($produtos[$cont_produtos+7]['FOTO']); ?>' width="<?= $tamanho_produto; ?>" />
                            <!--<img style="margin-left: <?= $margin_left_foto_prod ?>;" src='https://ingasoft.com.br/download/fotos/<?=$produtos[$cont_produtos+7]['FOTO'];?>.png' width="<?= $tamanho_produto; ?>" />-->
                        </span>
                    </div>
                    <div class="col-xs-12">
                        <p style="font-weight: bold;"><?php echo $produtos[$cont_produtos+7]['CODIGO'].'-'.$produtos[$cont_produtos+7]['DESCRICAO']; ?></p>
                        <!--<p><?= $produtos[$cont_produtos+7]['DESCRICAO_GRUPO']; ?></p>-->
                        <?php for($i=0; $i<(count($produtos[$cont_produtos+7]['ITENS'])); $i++) { ?>
                            <span style="font-size: <?= $font_size_itens; ?>;"><?= ($produtos[$cont_produtos+7]['ITENS'][$i]['COD_ITEM'].' - '.$produtos[$cont_produtos+7]['ITENS'][$i]['DESCRICAO_PRODUTO']); ?></span><br />
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>

                <div class="invoice-col">
                    <?php if (isset($produtos[$cont_produtos+8]['ITENS'])) { ?>
                        <?php // if ($produtos[$cont_produtos+8]['DESCRICAO_GRUPO'] == $grupo_anterior) { 
//                        $retorna +=1;
                        ?>
                        <div class="col-xs-12">
                            <span >
                                <img style="margin-left: <?= $margin_left_foto_prod ?>;" src='<?php echo base_url($produtos[$cont_produtos+8]['FOTO']); ?>' width="<?= $tamanho_produto; ?>" />
                                <!--<img style="margin-left: <?= $margin_left_foto_prod ?>;" src='https://ingasoft.com.br/download/fotos/<?=$produtos[$cont_produtos+8]['FOTO'];?>.png' width="<?= $tamanho_produto; ?>" />-->
                            </span>
                        </div>
                        <div class="col-xs-12">
                            <p style="font-weight: bold;"><?php echo $produtos[$cont_produtos+8]['CODIGO'].'-'.$produtos[$cont_produtos+8]['DESCRICAO']; ?></p>
                            <!--<p><?= $produtos[$cont_produtos+8]['DESCRICAO_GRUPO']; ?></p>-->
                            <?php for($i=0; $i<(count($produtos[$cont_produtos+8]['ITENS'])); $i++) { ?>
                                <span style="font-size: <?= $font_size_itens; ?>;"><?= ($produtos[$cont_produtos+8]['ITENS'][$i]['COD_ITEM'].' - '.$produtos[$cont_produtos+8]['ITENS'][$i]['DESCRICAO_PRODUTO']); ?></span><br />
                            <?php } ?>
                        </div>
                        <?php // } ?>
                    <?php } ?>
                </div>

            </div>

            <?php 
            $cont_produtos+=9;
            $x+=9; ?>
        </section>
    <?php } ?>    
</body>
</html>