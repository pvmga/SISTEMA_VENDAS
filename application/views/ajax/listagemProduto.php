<script type="text/javascript">
    $(function () {
        
        $('#data_venda_inicial').mask("99/99/9999");
        $('#data_venda_final').mask("99/99/9999");
        
        var table = $('#example1').DataTable({
            "ajax": {
                "url": "<?php echo base_url('listagemTelaProdutoAjax'); ?>",
                "type": "POST",
                "data": function(data) {
                    data.data_venda_inicial = $('#data_venda_inicial').val(),
                    data.data_venda_final = $('#data_venda_final').val()
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
                {"data": "descricao"},
                {"data": "grupo"},
                {"data": "estoqueatual"},
                {"data": "reservado"},
                {"data": "disponivel"},
                {"data": "preco_venda_a"},
                {"data": "perc_desc"},
                {"data": "quantidade_vendida"},
                {"data": "visualizar"},
            ]
        });
        
//        if ($('#tipo_ordenacao').val() === 'lista_mais_vendidos') {
            table.order( [[ 6, 'desc' ]] ).draw();
//        } else {
//            table.order( [[ 1, 'asc' ]] ).draw();
//        }
        
        $('#data_venda_inicial').change(function () {
            table.ajax.url('<?php echo base_url('listagemTelaProdutoAjax'); ?>').load();
        });
        $('#data_venda_final').change(function () {
            table.ajax.url('<?php echo base_url('listagemTelaProdutoAjax'); ?>').load();
        });
        
        $('#gerar_lista').click(function () {
            var grupo = $("#grupo option:selected").val();
            var subgrupo = $("#subgrupo option:selected").val();
            var preco = $("#preco option:selected").val();
            var optante = $("#optante option:selected").val();
            var promocional = $("#promocional option:selected").val();
            var estado = $("#estado option:selected").val();
            var foto = $("#foto option:selected").val();
            var vis = $("#tipo_visualizacao option:selected").val();
            
            dialogWarning('Aguarde, estamos gerando...');
            $('#modal-warning').modal('show');
            $('#modal-warning').unbind("click");
            if ($("#tipo_lista option:selected").val() === 'C') {
                if (grupo === '') {
                    grupo = 0;
                }
                if (subgrupo === '') {
                    subgrupo = 0;
                }

                $.post( "<?= base_url('listapdf'); ?>", {grupo: grupo, subgrupo: subgrupo, visualizacao: vis})
                .done(function( data ) {
                    console.log(data);
                    window.open("<?php echo base_url('downloadPdf') ?>/",'_blank');
                    $('#modal-warning').modal('hide');
                }).fail(function() {
                    $('#modal-warning').modal('hide');
                    dialogDanger('Foi impossivel adicionar o produto na tabela, está faltando os parametros de cliente.');
                    $('#modal-danger').modal('show');
                });
            } else if ($("#tipo_lista option:selected").val() === 'L') {

                $.post("<?= base_url('catalogoProdutos'); ?>", {grupos: grupo, precos: preco, optante: optante, promocional: promocional, estados: estado, subgrupos: subgrupo, foto: foto}, function (data) {
                    console.log(data);
                    $('#modal-warning').modal('hide');
                }).fail(function() {
                    $('#modal-warning').modal('hide');
                    dialogDanger('Foi impossivel adicionar o produto na tabela, está faltando os parametros de cliente.');
                    $('#modal-danger').modal('show');
                });
            } else {
                if (grupo === '') {
                    grupo = 0;
                }
                if (subgrupo === '') {
                    subgrupo = 0;
                }

                setTimeout(function() {
                    $('#modal-warning').modal('hide');
                }, 500);
                window.open("<?= base_url('listaPrecoGrupo') ?>/"+grupo+"/"+subgrupo+"/",'_blank');
            }
        });
        
    });

    function visualizarInformacoesProduto(codigo_produto) {
        var request = $.ajax({
            url: "<?= base_url('venda/recuperarFotoProduto'); ?>",
            method: "GET",
            dataType: "json",
            data: {
                q: codigo_produto,
            }
        });

        request.done(function (response) {
//            console.log(response);
            $('#modal-default').modal('show');
            if (response.items[0].foto_produto === '') {
                $("#foto_produto_zoom").html("<img id='foto_produto_zoom' src='<?php echo base_url('./img/image.jpg') ?>' class='img-responsive' />");
            } else if (typeof response.items[0].foto_produto !== 'undefined') {
                $("#foto_produto_zoom").html("<img id='foto_produto_zoom' src='data:image/jpge;base64,"+response.items[0].foto_produto+"' class='img-responsive' />");
            }
            document.querySelector('#grupo_subgrupo').textContent = response.items[0].grupo;
            document.querySelector('#peso').textContent = response.items[0].peso;
            document.querySelector('#unidade').textContent = response.items[0].unidade;
            document.querySelector('#quantidade_em_estoque').textContent = response.items[0].estoqueatual;
            document.querySelector('#complemento').textContent = response.items[0].complemento;
            document.querySelector('#fabricante').textContent = response.items[0].fabricante;
            document.querySelector('#obs_cadastro').textContent = response.items[0].obs_cadastro;
            
            document.querySelector('#detalhes').textContent = response.items[0].detalhes;
            document.querySelector('#inf_tecnicas').textContent = response.items[0].inf_tecnicas;
            document.querySelector('#garantia').textContent = response.items[0].garantia;
            document.querySelector('#observacoes_ecommerce').textContent = response.items[0].observacoes;
        });

        request.fail(function (jqXHR, textStatus) {
            dialogDanger('Foi impossivel buscar foto do produto. Tente novamente. $("informacao_tecnica").click, erro: ' + jqXHR);
            $('#modal-danger').modal('show');
        });
    }

    $('#tipo_lista').change(function() {
        if ($("#tipo_lista option:selected").val() === 'C') {
            $('.grupo').removeClass('hidden');
            $('.subgrupo').removeClass('hidden');
            $('.btn_download').addClass('hidden');
            $('.btn_download_catalogo').removeClass('hidden');
            
            
            $('.estado').addClass('hidden');
            $('.optante').addClass('hidden');
            $('.foto').addClass('hidden');
            $('.promocional').addClass('hidden');
        } else if ($("#tipo_lista option:selected").val() === 'L') {
            $('.grupo').removeClass('hidden');
            $('.subgrupo').removeClass('hidden');
            $('.btn_download').removeClass('hidden');
            $('.btn_download_catalogo').addClass('hidden');

            $('.estado').removeClass('hidden');
            $('.optante').removeClass('hidden');
            $('.foto').removeClass('hidden');
            $('.promocional').removeClass('hidden');
        } else {
//            $('.grupo').addClass('hidden');
//            $('.subgrupo').addClass('hidden');
            
            $('.btn_download').addClass('hidden');
            $('.btn_download_catalogo').addClass('hidden');

            $('.estado').addClass('hidden');
            $('.optante').addClass('hidden');
            $('.foto').addClass('hidden');
            $('.promocional').addClass('hidden');
        }
    });
</script>

</body>
</html>