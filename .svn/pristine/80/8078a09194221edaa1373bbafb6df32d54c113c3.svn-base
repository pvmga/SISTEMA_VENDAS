<script type="text/javascript">
    $(function () {
//        $.ajax({
//            method: "POST",
//            url: "cliente/listagemTelaClienteAjax",
//            cache: false
//        }).done(function (msg) {
//            console.log(msg);
//        });
        var table = $('#example1').DataTable({
            "ajax": {
                "url": "<?php echo base_url('listagemTelaClienteAjax'); ?>",
                "type": "POST",
                "data": function(data) {
                    data.ativo_inativo = $('#ativo_inativo option:selected').val()
                },
            },
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
                {"data": "codigo"},
                {"data": "razao_social"},
                {"data": "nome_fantasia"},
                {"data": "cidade"},
                {"data": "estado"},
                {"data": "tipo_cliente"},
                {"data": "telemarketing"},
                {"data": "alterar"},
                {"data": "montar_pedido"},
            ]
        });
        
        $('#ativo_inativo').change(function () {
            table.ajax.url('<?php echo base_url('listagemTelaClienteAjax'); ?>').load();
        });

        table.order( [[ 1, 'asc' ]] ).draw();
        
    });
    
    $(function() {
        $('#modalRelatorio').click(function() {
            $('#modal-relatorio').modal('show');
        });
//        $('#gerar').click(function() {
//            
//            var request = $.ajax({
//                url: "<?php echo base_url('listagemTelaVendaAjax'); ?>",
//                method: "POST",
//                    dataType: "json",
//                    data: {
//                        data_venda_inicial: $('#data_venda_relatorio_inicial').val(), 
//                        data_venda_final: $('#data_venda_relatorio_final').val(), 
//                        buscar_parametro: $('#tipo_relatorio_pedidoss option:selected').val()}
//                });
//
//                request.done(function (response) {
//                    console.log(response);
//                });
//
//                request.fail(function (jqXHR, textStatus) {
//                    alert('Error' + textStatus);
//            });
//        });
    });
</script>

</body>
</html>