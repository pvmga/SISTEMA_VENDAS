<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Visualizar Comissões
            <!--<small>Painel de Controle</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <!--<li><a href="<?= base_url('listagemCliente'); ?>"><i class="fa fa-dashboard"></i> Listagem de clientes</a></li>-->
            <li class="active">Visualizar comissões</li>
        </ol>
    </section>
    
    <section class="content">
        <?php
        if (count($comissao) > 0) {
            foreach ($comissao as $mes => $file) {
                if ($file['arquivo'] != '') { ?>
                    <button class="btn btn-flat btn-primary" type="button" style="margin-bottom:10px;" onclick="window.open('<?php echo $file['arquivo']; ?>?l=<?php echo date('dmyhis'); ?>')">Comiss&otilde;es do m&ecirc;s <?php echo $file['mes']; ?></button>
                    <?php
                }
            }
        } else {
            echo 'Não existe comissões calculadas';
        }
        ?>
    </section>

</div>