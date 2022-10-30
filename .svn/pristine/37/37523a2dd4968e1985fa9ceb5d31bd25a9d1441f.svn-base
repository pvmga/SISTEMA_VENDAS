<script type="text/javascript">
    $(function () {
        $('#data_venda_inicial').mask("99/99/9999");
        $('#data_venda_relatorio_inicial').mask("99/99/9999");
        $('#data_venda_final').mask("99/99/9999");
        $('#data_venda_relatorio_final').mask("99/99/9999");
             
//        var request = $.ajax({
//            url: "<?= base_url('listagemTelaVendaAjax'); ?>",
//            method: "POST",
//            data: { 
//                buscar_parametro: 'O',
//                data_venda_inicial: $('#data_venda_inicial').val(),
//                data_venda_final: $('#data_venda_final').val()
//            },
//            dataType: "json"
//        });
//
//        request.done(function (msg) {
//            console.log(msg);                
//        });
//
//        request.fail(function (jqXHR, textStatus) {
//            alert('Erro: ' + jqXHR);
//        });

        var table = $('#example1').DataTable({
            "ajax": {
                "url": "<?php echo base_url('listagemTelaVendaAjax'); ?>",
                "type": "POST",
                "data": function(data) {
                    data.buscar_parametro = $('#tipo_pedidoss option:selected').val(),
                    data.data_venda_inicial = $('#data_venda_inicial').val(),
                    data.data_venda_final = $('#data_venda_final').val()
                }
            },
            "iDisplayLength": 10,
            "cache": true,
            "processing": true,
            "language": {
                "sEmptyTable": "Clique em filtrar e aguarde alguns segundos...",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ Resultados por página",
                "sLoadingRecords": "Carregando ...",
                "sProcessing": "Aguarde, estamos preparando os dados...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisa rápida",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
            "columns": [
                {"data": "cod_venda"},
                {"data": "razao_social"},
                {"data": "data_venda"},
                {"data": "descricao_cond"},
                {"data": "tipo_pagto"},
                //{"data": "transporte"},
                {"data": "total_venda"},
                {"data": "alterar"},
                {"data": "fechar"},
            ]
        });
        $('#tipo_pedidoss').change(function () {
            table.ajax.url('<?php echo base_url('listagemTelaVendaAjax'); ?>').load();
        });
        $('#data_venda_inicial').change(function () {
            table.ajax.url('<?php echo base_url('listagemTelaVendaAjax'); ?>').load();
        });
        $('#data_venda_final').change(function () {
            table.ajax.url('<?php echo base_url('listagemTelaVendaAjax'); ?>').load();
        });
    });
    
    $(function() {
        $('#modalRelatorio').click(function() {
            $('#modal-relatorio').modal('show');
        });
        $('#gerar').click(function() {
            var codigo_cliente_gerador_relatorio = ($('#select2Cliente option:selected').val() === '') ? 0 : $('#select2Cliente option:selected').val();
            var data_venda_relatorio_inicial = ($('#data_venda_relatorio_inicial').val().replace('/', '')).replace('/', '');
            var data_venda_relatorio_final = ($('#data_venda_relatorio_final').val().replace('/', '')).replace('/', '');
            var tipo_relatorio_pedidoss = $('#tipo_relatorio_pedidoss').val();

            window.open("<?= base_url('relatorioVendas') ?>/"+data_venda_relatorio_inicial+"/"+data_venda_relatorio_final+"/"+tipo_relatorio_pedidoss+"/"+codigo_cliente_gerador_relatorio+"/",'_blank');
        });
    });
    // ========== LISTAGEM DE CLIENTE
    listagemCliente();
    function listagemCliente() {
        $(".select2Cliente2").select2({
            ajax: {
                url: "<?php echo base_url("venda/listaClientesAjax") ?>",
                dataType: 'json',
                delay: 700,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Buscar...',
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 3,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        function formatRepo(repo) {
            if (repo.loading) {
                return repo.text;
            }

            var markup = '<div>' + repo.id + ' - ' + repo.razao_social + '</div>';
            return markup;
        }

        function formatRepoSelection(repo) {
            var valor = '';
            if (repo.id !== '') {
                valor = '<div id="gerador_relatorio_razao_social">' + repo.id + ' - ' + repo.razao_social + '</option>';
            } else {
                valor = '<div>Selecione...</div>';
            }
            
            return valor;
        }
    }
    // ========== /LISTAGEM DE CLIENTE
    
    function retornarStatusPedido(codigo_venda) {
//        dialogSuccess('Aguarde, estamos retornando o pedido...');
        dialogDefault('Deseja realmente retornar o pedido: ' + codigo_venda + ' ?');
        $('#modal-default-confirme-salvar').modal('show');
        
        $('#sim_confirma_salvar').click(function() {
                var request = $.ajax({
                url: "<?= base_url('venda/updateVenda'); ?>",
                method: "POST",
                dataType: "json",
                async: false,
                data: { codigo_venda: codigo_venda, tipo_venda: 'V' }
            });

            request.done(function (response) {
               location.href = "<?= base_url('listagemVenda'); ?>"; 
            });

            request.fail(function (jqXHR, textStatus) {
                dialogDanger('Erro ao realizar update no pedido para SITUACAO = "E", erro: ' + jqXHR);
                $('#modal-danger').modal('show');
            });
        });
    }
</script>

</body>
</html>

