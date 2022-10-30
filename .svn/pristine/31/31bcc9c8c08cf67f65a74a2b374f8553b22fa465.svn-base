<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> <?= VERSAO; ?>
    </div>
    <strong>&copy; 2018-<?= date('Y'); ?> <a href="http://www.ingasoft.com.br" target="_blank">Administrador INGASOFT</a>.</strong> Todos os direitos reservados.
</footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?= base_url('bower_components/jquery/dist/jquery.min.js'); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('bower_components/jquery-ui/jquery-ui.min.js'); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<script src="<?= base_url('bower_components/select2/dist/js/select2.full.min.js'); ?>"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>

<script src="<?= base_url('bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script>

<!-- Sparkline -->
<script src="<?= base_url('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js'); ?>"></script>
<!-- jvectormap -->
<script src="<?= base_url('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
<script src="<?= base_url('plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url('bower_components/jquery-knob/dist/jquery.knob.min.js'); ?>"></script>
<!-- daterangepicker -->
<script src="<?= base_url('bower_components/moment/min/moment.min.js'); ?>"></script>
<script src="<?= base_url('bower_components/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<!-- datepicker -->
<script src="<?= base_url('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
<!-- Slimscroll -->
<script src="<?= base_url('bower_components/jquery-slimscroll/jquery.slimscroll.min.js'); ?>"></script>
<!-- FastClick -->
<script src="<?= base_url('bower_components/fastclick/lib/fastclick.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('dist/js/adminlte.min.js'); ?>"></script>
<script src="<?= base_url('bower_components/jquery.Mask/jquery.mask.min.js'); ?>"></script>

<script type="text/javascript">
document.querySelector('body').addEventListener('keydown', function(event) {
    if (event.keyCode === 27) {
        $('#modal-default').modal('hide');
        $('#modal-default-padrao').modal('hide');
        $('#modal-default-confirme').modal('hide');
        $('#modal-default-confirme-salvar').modal('hide');
        $('#modal-warning').modal('hide');
        $('#modal-success').modal('hide');
        $('#modal-danger').modal('hide');
        $('#modal-relatorio').modal('hide');
        $('#modal-lista-produtos').modal('hide');
        $('#modal-telemarketing').modal('hide');
    }
});

function dialogDefault(msg) {
    $('.alertaDefaulftConfirme').html('<img src="<?php echo base_url('./img/imagens/dialog/icone_pergunta.png') ?>" class="img-response" /> ' + msg);
}

function dialogSuccess(msg) {
    $('.alertaSuccess').html('<img src="<?php echo base_url('./img/imagens/dialog/icone_sucesso.png') ?>" class="img-response" /> ' + msg);
}

function dialogWarning(msg) {
    $('.alertaWarning').html('<img src="<?php echo base_url('./img/imagens/dialog/icone_alerta.png') ?>" class="img-response" /> ' + msg);
}

function dialogDanger(msg) {
    $('.alertaDanger').html('<img src="<?php echo base_url('./img/imagens/dialog/icone_erro.png') ?>" class="img-response" /> ' + msg);
}
</script>