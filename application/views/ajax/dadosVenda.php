<script type="text/javascript">

    $(function () {

        var terminado = 0;

        if ($('#cadastrar_pedido_direto_cliente').val() === 'cadastrarVendaCliente') {
            document.querySelector('.msgCadastrarClientePelaVenda').textContent = '- ***APÓS A INSERÇÃO DE UM PRODUTO O PEDIDO ESTARÁ SALVO***';
        }

        if ($('#cadastrar_pedido_direto_cliente').val() === 'alterarVenda' || $('#cadastrar_pedido_direto_cliente').val() === 'cadastrarVendaCliente') {
            $('#codigo_venda').removeClass('hidden');
        }

        if (document.querySelector('#codigo_venda').textContent === '') {
            gerarCodigoVenda();
        } else {
            console.log('N° de venda preenchido.');
        }

//        $('#tipoFretePadraoParametro').val();
//        console.log($('#tipoFretePadraoParametro').val());
        if($('#tipoFretePadraoParametro').val() === 'CIF') {
            $("#tipo_frete option[name=CIF]").attr('selected', true);
        } else if ($('#tipoFretePadraoParametro').val() === 'FOB'){
            $("#tipo_frete option[name=FOB]").attr('selected', true);
        }

        function gerarCodigoVenda() {
            var request = $.ajax({
                url: "<?= base_url('gerarCodigoVenda'); ?>",
                method: "GET",
                dataType: "json"
            });

            request.done(function (res) {
                document.querySelector('#codigo_venda').textContent = res.GEN_VALUE;
            });

            request.fail(function (jqXHR, textStatus) {
                alert('Erro: ' + jqXHR);
            });
        }

        preencherMascara();
        function preencherMascara() {
//            $("#valor_unitario").mask("###9,999" , { reverse:true});
            $("#valor_unitario").mask("99999,999");
            $("#percDesconto").mask("99.99");
            $("#valor_frete").mask("99,99");
        }

        function listagemCliente() {
            $(".select2Cliente").select2({
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
//                var markup = '<option value="' + repo.id + '">' + repo.id + ' - ' + repo.razao_social + '</option>';

                return markup;
            }

            function formatRepoSelection(repo) {
                $("#codigoInterno").val(repo.id);
                $("#limite_credito").val(repo.limite_credito);
                $("#limite_disponivel").val(repo.limite_credito);
                $("#cidade").val(repo.cidade);
                $("#observacoes").val(repo.obs_cadastro);
                $("#estadoCliente").val(repo.estado);
                $("#optanteSimplesCliente").val(repo.optante_simples);
                $("#email_cliente").val(repo.email);
                $("#codigo_vendedor_interno").val(repo.codigo_vendedor_interno);
                $("#codigo_vendedor_externo").val(repo.codigo_vendedor_externo);
                if (typeof repo.nome_vendedor_externo !== 'undefined') {
                    $("#nome_vendedor_interno").val(repo.codigo_vendedor_interno + ' - ' + repo.nome_vendedor_interno);
                    $("#nome_vendedor_externo").val(repo.codigo_vendedor_externo + ' - ' + repo.nome_vendedor_externo);
                }

//                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
//                    return '<div id="alterado_cliente">' + repo.id + ' - ' + repo.razao_social + '</div>';
//                }
                return '<div id="alterado_cliente">' + repo.id + ' - ' + repo.razao_social + '</div>';

            }

//            $(".select2Cliente").select2('open');
        }

        function listagemTransportadora() {
            $(".select2Transportadora").select2({
                ajax: {
                    url: "<?php echo base_url("venda/listaTransportadoraAjax") ?>",
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
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            function formatRepo(repo) {
                if (repo.loading) {
                    return repo.text;
                }

                var markup = '<div>' + repo.id + ' - ' + repo.nome_fantasia + '</div>';
//                var markup = '<option value="' + repo.id + '">' + repo.id + ' - ' + repo.nome_fantasia + '</option>';

                return markup;
            }

            function formatRepoSelection(repo) {
//                return '<option value="' + repo.id + '" id="alterado_transportadora">' + repo.id + ' - ' + repo.nome_fantasia + '</option>';
                return '<div id="alterado_transportadora">' + repo.id + ' - ' + repo.nome_fantasia + '</div>';
            }

        }

        function listagemCondiacaoPagamento() {
            $(".select2CondicaoPagamento").select2({
                ajax: {
                    url: "<?php echo base_url("venda/listaCondicaoPagamentoAjax") ?>",
                    dataType: 'json',
                    delay: 0,
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
                minimumInputLength: 0,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            function formatRepo(repo) {
                if (repo.loading) {
                    return repo.text;
                }

                var markup = '<div>' + repo.id + ' - ' + repo.descricao + '</div>';
//                var markup = '<option value="' + repo.id + '">' + repo.id + ' - ' + repo.descricao + '</option>';

                return markup;
            }

            function formatRepoSelection(repo) {
                return '<div id="alterado_condicaoPagamento">' + repo.id + ' - ' + repo.descricao + '</div>';
            }
        }

        function listagemTipoPagamento() {
            $(".select2TipoPagamento").select2({
                ajax: {
                    url: "<?php echo base_url("venda/listaTipoPagamentoAjax") ?>",
                    dataType: 'json',
                    delay: 0,
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
                minimumInputLength: 0,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            function formatRepo(repo) {
                if (repo.loading) {
                    return repo.text;
                }

                var markup = '<div>' + repo.codigo + ' - ' + repo.descricao + '</div>';
//                var markup = '<option value="' + repo.id + '">' + repo.codigo + ' - ' + repo.descricao + '</option>';

                return markup;
            }

            function formatRepoSelection(repo) {
                return '<div id="alterado_tipo_pagamento">' + repo.codigo + ' - ' + repo.descricao + '</div>';
            }
        }

        function listagemProduto() { 
            $(".select2Produto").select2({
                ajax: {
                    url: "<?php echo base_url("listaProdutoAjax") ?>",
                    dataType: 'json',
                    delay: 700,
                    data: function (params) {
                        var queryParams = {
                            q: params.term,
                            page: params.page,
                            estado: $("#estadoCliente").val(),
                            optante: $("#optanteSimplesCliente").val(),
                            codigoInternoCliente: $("#codigoInterno").val(),
                            cod_condicao_pagamento: $("#condicaoPagamento option:selected").val(),
                            tipo_busca: $("#tipo_busca option:selected").val(),
                        };
                        return queryParams;
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
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            function formatRepo(repo) {
                if (repo.loading) {
                    return repo.text;
                }

                pintar = 'font-size: 15px; font-weight: bold;';
                if (repo.percentual !== '') {
                    pintar += 'color:white; background-color: #e74c3c;';
                }

                if (repo.estoqueatual <= 0) {
                    pintar += 'color: #e74c3c; background-color: #2c3e50;';
                }

                var markup = '<div style="'+pintar+'">' + repo.id + ' - ' + repo.descricao + ' -----VLR.+IMP.: ' + repo.preco_st + ' -----ESTOQ: ' + repo.estoqueatual + '</div>'

                $('#produtoDeBusca').val($('.select2-search__field').val());

                return markup;
            }

            function formatRepoSelection(repo) {
                $("#codigoProduto").val(repo.id);
                $("#descricaoProduto").val(repo.descricao);
                $("#aliquota_ipi").val(repo.aliquota_ipi);
                $("#percDesconto").val(repo.percentual);
                $("#desc_max").val(repo.percentual);
                $("#esto_max").val(repo.estoqueatual);
                $("#custo_bruto").val(repo.custo_bruto);
                $("#peso_venda").val(repo.peso);
                $("#complemento_produto").val(repo.complemento);
                
                $('#sequencia_produto').val('');

//                $("#valor_unitario").val(repo.preco_venda_a);
                $("#valor_unitario").val(repo.preco_original);
                $("#valor_unitario_base").val(repo.preco_original);
                $("#preco_base_validacao").val(repo.preco_base_validacao);
                $("#percentual_acrescimo").val(repo.percentual_acrescimo);

                $('#cod_grupo').val(repo.cod_grupo);
                $('#embalagem_venda').val(repo.embalagem_venda);

                $("#foto_produto_zoom").html("<img id='foto_produto_zoom' src='<?php echo base_url('./img/image.jpg') ?>' class='img-responsive' />");

                if ($('#avisoEstoqueNegativo').val() === 'S') {
                    if (repo.estoqueatual <= 0) {
                        dialogWarning('Atualmente o estoque deste produto é '+repo.estoqueatual+'. Deseja continuar ? Clique em fechar.');
                        $('#modal-warning').modal('show');
                    }
                }

                pintar = 'font-size: 15px; font-weight: bold;';
                if (repo.percentual !== '' && typeof repo.percentual !== 'undefined') {
                    pintar += 'color:white; background-color: #e74c3c';
                }

                return '<div class="alteradoProduto" style="'+pintar+'">' + repo.id + ' - ' + repo.descricao + ' -----VLR.+IMP.: ' + repo.preco_st + ' -----ESTOQ: ' + repo.estoqueatual + '</div>';
            }
        }

        // validação realizada se baseando no estoque digitado com o estoque atual.
        $('#quantidade_estoque_digitado').change(function() {
            var divisao = String ($('#quantidade_estoque_digitado').val() / $('#embalagem_venda').val());
            var divSplit = divisao.split(".");
            document.getElementById('qtde_embalagem').style.color = '';
            if (divSplit.length == 1) {
                if ($('#permite_vender_estoque_zerado').val() === 'S') {
                    var response = buscarEstoqueReservado($("#codigoProduto").val());
                    var disponivel = parseFloat($("#esto_max").val().replace('.', '')) - parseFloat(response.replace(',', ''));
                    if ($('#avisoEstoqueNegativo').val() === 'S') {
                        if (disponivel < $('#quantidade_estoque_digitado').val()) {
                            dialogWarning('Estoque Disponivel: ' + disponivel + ' - Estoque Digitado: ' + $('#quantidade_estoque_digitado').val());
                            $('#modal-warning').modal('show');
                        }
                    }
                }
                $('#adicionar_produto').removeAttr('disabled');
            } else {
                $('#quantidade_estoque_digitado').focus();
                document.getElementById('qtde_embalagem').style.color = 'red';
//                document.getElementsByClassName()
                console.log('Quantidade de embalagem: ' + $('#embalagem_venda').val());
                $('#adicionar_produto').attr('disabled', true);
            }

        });
        // validação realizada se baseando no estoque digitado com o estoque disponivel para venda retirado 
        function buscarEstoqueReservado(codigo) {
            var data = '';
            var request = $.ajax({
                url: "<?= base_url('estoqueDisponivel'); ?>",
                method: "GET",
                dataType: "json",
                async: false,
                data: { codigo_produto:  codigo}
            });

            request.done(function (response) {
                data = response;
            });

            request.fail(function (jqXHR, textStatus) {
                dialogDanger('Erro ao realizar consulta do estoque disponivel, erro: ' + jqXHR);
                $('#modal-danger').modal('show');
            });
            return data;
        }

        //============ PARA BAIXO COMEÇA A PARTE DE INSERÇÃO, ALTERAÇÃO E EXCLUSÃO.=============
        var codigo_venda = document.querySelector("#codigo_venda").textContent;
        if (codigo_venda !== '') {
            preencherCampos();
        } else if ($('#cadastrar_pedido_direto_cliente').val() === 'cadastrarVendaCliente') { 
            var request = $.ajax({
                url: "<?= base_url('getByIdClienteDados'); ?>",
                method: "GET",
                data: { codigo_cliente: $('#codigo_buscar_cliente').val() },
                dataType: "json"
            });

            request.done(function (msg) {
                $('#modal-success').modal('hide');
//                console.log(msg);
                informacoesVenda(msg.DADOS);
            });

            request.fail(function (jqXHR, textStatus) {
                $('#modal-success').modal('hide');
                dialogDanger('Não foi possivel retornar dados cliente $(#cadastrar_pedido_direto_cliente), entre em contato com o suporte ou tente novamente. Erro: ' + textStatus + ' ' + jqXHR);
                $('#modal-danger').modal('show');
            });
        }
        $('#adicionar_produto').click(function () {
            // para prevenir que o usuário não irá pressionar duas vezes.
            $('#adicionar_produto').attr('disabled', true);

            $('#total_validar_insert').val(1);

//           $("#percDesconto").val(($("#percDesconto").val()).replace('.', ','));

            if ($('#quantidade_estoque_digitado').val() === '0' || $('#quantidade_estoque_digitado').val() === '') {
                $('#quantidade_estoque_digitado').focus();
                return false;
            }

            if ($('#percDesconto').val() === '') {
                $('#percDesconto').val('0');
            }

            // CASO O PARAMETRO ESTEJA IGUAL A 'S' AUTOMATICAMENTE O SISTEMA CONSIDERARÁ VALIDAÇÃO EM CIMA DE PREÇOS TAMBÉM.
            if ($('#precoMinimoPedido').val() == 'N') {
                var total_desconto = verificarDesconto();
                if (total_desconto === '0') {
                    $('#percDesconto').focus();
                    return false;
                }
            } else {
                verificarDesconto();
            }
            
            if ($("#valor_unitario").val() === '' || $("#valor_unitario").val() === '0') {
                dialogWarning('Não será possível adicionar produto com valor zerado ou em branco.');
                $('#adicionar_produto').removeAttr('disabled');
                $('#modal-warning').modal('show');
            } else if ($('#quantidade_estoque_digitado').val() === '' || $('#quantidade_estoque_digitado').val() === 0) {
                dialogWarning('Não será possível adicionar produto com estoque zerado ou em branco.');
                $('#adicionar_produto').removeAttr('disabled');
                $('#modal-warning').modal('show');
            } else {
                // validar estoque;
                if ($('#permite_vender_estoque_zerado').val() === 'S') {
                    adicionar_produto();
                } else {
                    var response = buscarEstoqueReservado($("#codigoProduto").val());
                    validarEstoque(response);
                }
            }
        });
        
        function validarEstoque(response) {
            $('#adicionar_produto').removeAttr('disabled');
            var disponivel = parseFloat($("#esto_max").val().replace('.', '')) - parseFloat(response.replace(',', ''));
            if (parseFloat(response.replace(',', '')) >= parseFloat($("#esto_max").val().replace('.', ''))) {
                $('#quantidade_estoque_digitado').focus();
                dialogWarning('Reservado é maior ou igual, não poderá ser vendido. <br /><b>Reservado:</b> ' + response.replace(',', '') + '<br /> <b>Atual:</b> ' + $("#esto_max").val().replace('.', '') + '<br /> <b>Disponivel:</b> ' + (disponivel));
                $('#modal-warning').modal('show');
                //return false;                    

            } else if (parseFloat($('#quantidade_estoque_digitado').val()) > parseFloat(disponivel)) {
                $('#quantidade_estoque_digitado').focus();
                dialogWarning('Quantidade digitada maior que o disponivel. <br /><b>Reservado:</b> ' + response.replace(',', '') + '<br /> <b>Atual:</b> ' + $("#esto_max").val().replace('.', '') + '<br /> <b>Disponivel:</b> ' + (disponivel));
                $('#modal-warning').modal('show');
                //return false;

            } else {
//                console.log('Pode vender. Reservado: ' + response.replace(',', '') + ' - Atual: ' + $("#esto_max").val().replace('.', '') + ' - Disponivel: ' + (disponivel));
                adicionar_produto();
            }
        }
        
        function verificarDesconto() {
            var valor_digitado_input = $('#valor_unitario').val().replace(',', '.');
            var valor_backup = $('#valor_unitario_base').val().replace(',', '.');

            var desc_max = $("#desc_max").val().replace(',', '.');
            var esto_max_param = $('#esto_max_param').val().replace(',', '.');
            
            var divisao = (100 - ((valor_digitado_input / valor_backup) * 100)).toFixed(2);
//            console.log(valor_digitado_input,valor_backup);
            var percDesconto = $('#percDesconto').val().replace(',', '.');
            var total_desconto = (parseFloat(divisao) + parseFloat(percDesconto)).toFixed(2);
            
            console.log('total_desconto: '+ total_desconto ,'desc_max: '+ desc_max,'desc_max_param: '+ esto_max_param);

            if ($('#precoMinimoPedido').val() == 'N') {
                if (desc_max !== '0.00' || esto_max_param !== '0.00') {
                    if (total_desconto > desc_max) {
                        console.log(total_desconto, esto_max_param);
                        if (total_desconto > esto_max_param) {
                            return msgDesconto(total_desconto);
                        }
                    }
                } else {
                    console.log('Desconto produto ou parametro é zero, não será verificado desconto digitado !');
                }
            } else {
                var preco_base_validacao = $('#preco_base_validacao').val().replace(',', '.');
                var data = 0;
                if (valor_digitado_input < preco_base_validacao) {
                    data = 1;
                }
                
                if (percDesconto > 0) {
                    valor_digitado_input = ((valor_digitado_input - (valor_digitado_input * (percDesconto / 100))));
                    if (valor_digitado_input < preco_base_validacao) {
                        data = 1;
                    }
                }
                if (data == 1) {
                    alert('valor digitado menor que a base | ' + valor_digitado_input + ' < ' + preco_base_validacao);
                }
//                console.log(valor_digitado_input, preco_base_validacao);
//                return 0;
            }
        }

        function msgDesconto(total_desconto) {
            dialogDanger('Desconto ultrapassou o limite. Total digitado: ' + total_desconto + ' - Produto: ' + $('#desc_max').val() + ' - Parametro ' + $("#esto_max_param").val());
            $('#adicionar_produto').removeAttr('disabled');
            $('#modal-danger').modal('show');
            return '0';
        }

        /* BLOCO LISTA DE PRODUTO*/
        $('#lista_produtos').click(function() {
            // limpar a lista de produtos
            $('.lista_produtos_adicionar').html('');
            setTimeout(function() {
                $('#tipo_busca_lista').val(0);
                tableListaDeProdutos.ajax.url('<?= base_url('listaProdutoTelaDeLista'); ?>').load();
            }, 200);

            $('#modal-lista-produtos').modal('show');
        });
        $('.lista_adicionar_produtos').click(function() {
            chamaAdicionarProdutos();
        });

        function chamaAdicionarProdutos() {
            $('#modal-lista-produtos').modal('hide');
            var listaCodigosProdutos = document.querySelectorAll('.lista_produtos_adicionar tr td.codigo_produto_lista_novo');
            var listaQuantidadeDigitada = document.querySelectorAll('.lista_produtos_adicionar tr td.quantidade_digitada_lista_novo');
            var listaPercentualDesconto = document.querySelectorAll('.lista_produtos_adicionar tr td.percentual_desconto_lista_novo');
            
            if (listaCodigosProdutos.length > 0) {
                dialogSuccess('Aguarde, estamos inserindo os produtos...');
                $('#modal-success').modal('show');
                $('#modal-success').unbind("click");
            }
            setTimeout(function() {
                for (var i=0; i<listaCodigosProdutos.length; i++) {
                    $('#total_validar_insert').val(listaCodigosProdutos.length);
                    if (listaQuantidadeDigitada[i].textContent > 0 && listaQuantidadeDigitada[i].textContent !== '') {
    //                    console.log(listaCodigosProdutos[i].textContent,listaQuantidadeDigitada[i].value);
                        $('.dadosProduto').val('');
    //                    console.log(listaCodigosProdutos[i].textContent);
                        buscaProdutos(listaCodigosProdutos[i].textContent, listaQuantidadeDigitada[i].textContent, listaPercentualDesconto[i].textContent);
                    }
                }
            }, 500)
        }

        if ($('#cadastrar_pedido_direto_cliente').val() === 'cadastrarVendaCliente') {
            if ($("#verificaLimiteCredito").val() === 'S') {
                setTimeout(function() {
                    visualizarLimite();
                }, 500);
            }
//            var largura = screen.width;
//            if( largura >= 767 ) {  
//                $('#tipo_busca_lista').val(0);
//                $('#modal-lista-produtos').modal('show');
//            }
        }

        var tableListaDeProdutos = $('#example').DataTable({
            "ajax": {
                "url": "<?= base_url('listaProdutoTelaDeLista'); ?>",
                "type": "POST",
                "data": function(data) {
                    data.buscar = $('#tipo_busca_lista').val(),
                    data.condicao_pagamento = $('#condicaoPagamento option:selected').val()
                },
            },
//            "bPaginate": false,
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
//                {"data": "estoqueatual"},
//                {"data": "reservado"},
                {"data": "disponivel"},
                {"data": "preco_venda_a"},
                {"data": "acrescimo"},
                {"data": "desconto"},
                {"data": "total_sem_impostos"},
                {"data": "complemento"},
                {"data": "input"},
            ]
        });
        /* /BLOCO LISTA DE PRODUTO*/

        var produtos = [];
        $('#condicaoPagamento').change(function(event) {
            event.preventDefault();
            var produtosTr = document.querySelectorAll('.produtos');
            
            if (produtosTr.length > 0) {
                dialogSuccess('Aguarde, estamos atualizando os preços...');
                $('#modal-success').modal('show');
                $('#modal-success').unbind("click");
            }
            setTimeout(function() {
                for (var i=0; i<produtosTr.length; i++) {
                    $('.dadosProduto').val('');

                    $('#total_validar_insert').val(produtosTr.length);
    //                console.log(terminado, produtosTr.length);                

                    var produtosCodigo = document.querySelectorAll('.produtos td.codigo_produto_table')[i].textContent;
                    var produtosQuantidadeDigitada = document.querySelectorAll('.produtos td.quantidade_estoque_digitado_table')[i].textContent;
                    var perc_desconto_table = document.querySelectorAll('.produtos td.perc_desconto_table')[i].textContent.replace('%', '');
                    buscaProdutos(produtosCodigo, produtosQuantidadeDigitada, (perc_desconto_table).replace(',', '.'));
                }
            }, 500);
        });

        function buscaProdutos(produtosCodigo, produtosQuantidadeDigitada, perc_desconto_table) {
            var request = $.ajax({
                url: "<?= base_url('listaProdutoAjax'); ?>",
                method: "GET",
                dataType: "json",
//                async: false,
                data: {
                    q: produtosCodigo,
                    page: 1,
                    estado: $("#estadoCliente").val(),
                    optante: $("#optanteSimplesCliente").val(),
                    codigoInternoCliente: $("#codigoInterno").val(),
                    cod_condicao_pagamento: $("#condicaoPagamento option:selected").val(),
                    em_massa: 'N',
                }
            });

            request.done(function (response) {
//                console.log(response);
                if (response !== false) {
                    var repo = response.items[0];
                    $("#codigoProduto").val(repo.id);
                    $("#descricaoProduto").val(repo.descricao);
                    $("#aliquota_ipi").val(repo.aliquota_ipi);
                    $("#percDesconto").val(perc_desconto_table);
                    $("#desc_max").val(repo.percentual);
                    $("#esto_max").val(repo.estoqueatual);
                    $("#custo_bruto").val(repo.custo_bruto);
                    $("#peso_venda").val(repo.peso);
                    $("#valor_unitario").val(repo.preco_original);
                    $('#quantidade_estoque_digitado').val(produtosQuantidadeDigitada);
                    $("#percentual_acrescimo").val(repo.percentual_acrescimo);
                    $("#cod_grupo").val(repo.cod_grupo);
                    //console.log($("#percDesconto").val());
                    adicionar_produto('recalc');
                } else {
                    produtos[produtosCodigo] = {codigo: produtosCodigo};
                    console.log(produtos);
                }
            });

            request.fail(function (jqXHR, textStatus) {
                $('#modal-success').modal('hide');
                dialogDanger('Foi impossivel adicionar o produto na tabela, está faltando os parametros de cliente, erro: ' + jqXHR);
                $('#modal-danger').modal('show');
            });
        }
        
        function adicionar_produto(recalc) {
            // remover produto caso já exista na tabela.
            // tem que ficar a cima do addProdutoTabela por que após remover a linha do produto, lá no metodo pego somente o que está com .produtos, desse modo exclui o item que sera removido a baixo.
            if ($('#repeticaoItens').val() === 'N' || recalc == 'recalc') {
                var produtosTrCodigo = document.querySelectorAll('.produtos td.codigo_produto_table');
                var produtosTr = document.querySelectorAll('.produtos');
                for (var i=0; i<produtosTrCodigo.length; i++) {
//                    console.log($('#codigoProduto').val(), produtosTrCodigo[i].textContent, $('#codigoProduto').val() === produtosTrCodigo[i].textContent, produtosTr[i]);
                    if ($('#codigoProduto').val() === produtosTrCodigo[i].textContent) {
                        var total_liquido_table = document.querySelectorAll('.produtos td.total_liquido_table')[i];
                        var valor_total_unit = total_liquido_table.textContent;
                        var valor_total_imposto = document.querySelectorAll('.produtos td.valor_st_table')[i].textContent;
                        // caso o produto a ser inserido existir na tabela de removação não podemos recalcular, pois o sistema é configurado para assim que clicar no botão de remover produto já realizar os calculos de remoção.
                        var remover_estes_produtos = document.querySelectorAll('.remover_estes_produtos');
                        if (remover_estes_produtos.length > 0) {
                            for (var x=0; x<remover_estes_produtos.length; x++) {
                                if ($('#codigoProduto').val() !== remover_estes_produtos[x].id) {
                                    totalizarProdutos(valor_total_unit, valor_total_imposto, 'EXCLUIR');
                                } else {
                                    console.log('Sim, o produto de inserção é igual o excluido. Não recalcular.');                            
                                }
                            }
                        } else {
                            console.log('Não existe produtos a ser removidos, recalcular sistema');
                            totalizarProdutos(valor_total_unit, valor_total_imposto, 'EXCLUIR');
                        }

//                            console.log('Opa! Existe produto igual, vou deletar o primeiro e manter o segundo. Codigo: ' + produtosTrCodigo[i].textContent);
                        // necessário remover após os calculos para o mesmo encontrar os valores corretos na tabela.
                        produtosTr[i].remove();
                    }
                }
            } else {
                // pra quando permitir repetir deverá validar a sequencia também.
                if ($('#sequencia_produto').val() !== '') {
                    var produtosTrCodigo = document.querySelectorAll('.produtos td.codigo_produto_table');
                    var produtosTrSequencia = document.querySelectorAll('.produtos td.sequencia_produto');
                    var produtosTrT = document.querySelectorAll('.produtos');
                    var codigoAltOuInset = $('#codigoProduto').val()+'-'+$('#sequencia_produto').val();
                    for (var i=0; i<produtosTrCodigo.length; i++) {
                        if (codigoAltOuInset === produtosTrCodigo[i].textContent+'-'+produtosTrSequencia[i].textContent) {                            
                            var total_liquido_table = document.querySelectorAll('.produtos td.total_liquido_table')[i];
                            var valor_total_unit = total_liquido_table.textContent;
                            var valor_total_imposto = document.querySelectorAll('.produtos td.valor_st_table')[i].textContent;
                            
                            totalizarProdutos(valor_total_unit, valor_total_imposto, 'EXCLUIR');
                            
                            produtosTrT[i].remove();
                        }
                    }
//                    return false;
                }
            }
             
            var dados = {
                q: $('#codigoProduto').val(),
                estado: $("#estadoCliente").val(),
                optante: $("#optanteSimplesCliente").val(),
                valor_unitario: $("#valor_unitario").val(),
                quantidade_digitada: $('#quantidade_estoque_digitado').val(),
                perc_desconto: $('#percDesconto').val(),
                codigoInternoCliente: $("#codigoInterno").val(),
                aliquota_ipi: $("#aliquota_ipi").val(),
                custo_bruto: $("#custo_bruto").val(),
                acrescimo: $("#percentual_acrescimo").val(),
            };
            addProdutoTabela(dados);
        }

        function addProdutoTabela(dados) {
            var request = $.ajax({
                url: "<?= base_url('addProdutoTabela'); ?>",
                method: "GET",
                dataType: "json",
                async: false,
                data: dados
            });

            request.done(function (response) {
//                console.log(response);
                $('#valor_unitario_com_desconto').val(response['valor_unitario_com_desconto']);
                $('#total_liquido').val(response['total_liquido']);
                $('#valor_st').val(response['valor_imposto']);
                $('#valor_total').val(response['total']);
                $('#aliquota_ipi').val(response['aliquota_ipi']);
                $('#custo_bruto').val(response['custo_bruto']);
//                $('#table_obs_item').val($('#obs_item').val());

                var teste = document.querySelectorAll('.produtos td.sequencia_produto');
                var produtosTrCodigo = $(teste).get(-1);
                var sequencia = 0;
                if (typeof produtosTrCodigo === 'undefined') {
                    sequencia = 1;
                } else {
                    sequencia = parseInt(produtosTrCodigo.innerHTML) + 1;
                }
                $('#sequencia_produto').val(sequencia);

                // para prevenir que o usuário não irá pressionar duas vezes.
                $('#adicionar_produto').removeAttr('disabled');
                add();
            });

            request.fail(function (jqXHR, textStatus) {
                dialogDanger('Foi impossivel adicionar o produto na tabela, está faltando os parametros de cliente, erro: ' + jqXHR);
                $('#modal-danger').modal('show');
            });
        }

        function preencherCampos() {
            var tipo_orc = document.querySelector('#incluir_alterar').textContent;

            dialogSuccess('Aguarde, buscando os dados do pedido...');
            $('#modal-success').modal('show');
            $('#modal-success').unbind("click");

            var request = $.ajax({
                url: "<?= base_url('buscarDadosPedido'); ?>",
                method: "GET",
                data: { numero_pedido: codigo_venda, tipo_orc: tipo_orc },
                dataType: "json"
            });

            request.done(function (msg) {
                $('#modal-success').modal('hide');
                informacoesVenda(msg.DADOS);
                informacoesItens(msg.ITENS);
//                console.log(msg.DADOS);
            });

            request.fail(function (jqXHR, textStatus) {
                $('#modal-success').modal('hide');
                dialogDanger('Não foi possivel realizar a alteração, entre em contato com o suporte ou tente novamente. Erro: ' + textStatus + ' ' + jqXHR);
                $('#modal-danger').modal('show');
            });

        }

        function informacoesVenda(dadosPedido) {
            $('#codigoInterno').val(dadosPedido.CODIGO_CLIENTE);

            if (dadosPedido.LIMITE_CREDITO === null) {
                $("#limite_credito").val(0);
                $("#limite_disponivel").val(0);
            } else {
                $("#limite_credito").val(dadosPedido.LIMITE_CREDITO);
                $("#limite_disponivel").val(dadosPedido.LIMITE_DISPONIVEL);
            }
            $("#cidade").val(dadosPedido.CIDADE);

            // Utilizado desta forma para se adequar ao formato do select2
            $("#cliente_venda option:selected").val(dadosPedido.CODIGO_CLIENTE);
            $("#alterado_cliente").text(dadosPedido.CODIGO_CLIENTE + ' - ' + dadosPedido.RAZAO_SOCIAL);

            if (typeof dadosPedido.CODIGO_TRANSPORTADORA !== 'undefined' && dadosPedido.CODIGO_TRANSPORTADORA !== null) {
                $("#transportadora option:selected").val(dadosPedido.CODIGO_TRANSPORTADORA);
                $("#alterado_transportadora").text(dadosPedido.CODIGO_TRANSPORTADORA + ' - ' + dadosPedido.RAZAO_SOCIAL_TRANSPORTADORA);
            } else {
                select2ValorInicialTransportadora();
            }

            if (typeof dadosPedido.CODIGO_CONDICAO_PAGAMENTO !== 'undefined') {
                $("#condicaoPagamento option:selected").val(dadosPedido.CODIGO_CONDICAO_PAGAMENTO);
                $("#alterado_condicaoPagamento").text(dadosPedido.CODIGO_CONDICAO_PAGAMENTO + ' - ' + dadosPedido.DESCRICAO_CONDICAO_PAGAMENTO);
            }

            if (typeof dadosPedido.CODIGO_TIPO_PAGAMENTO !== 'undefined') {
                $("#tipo_pagamento option:selected").val(dadosPedido.SIGLA);
                $("#alterado_tipo_pagamento").text(dadosPedido.CODIGO_TIPO_PAGAMENTO + ' - ' + dadosPedido.DESCRICAO_TIPO_PAGAMENTO);
            }

            if(dadosPedido.TRANSPORTE === 'CIF') {
                $("#tipo_frete option[name=CIF]").attr('selected', true);
            } else if (dadosPedido.TRANSPORTE === 'FOB'){
                $("#tipo_frete option[name=FOB]").attr('selected', true);
            }

            $('#codigo_vendedor_interno').val(dadosPedido.CODIGO_VENDEDOR);
            $('#nome_vendedor_interno').val(dadosPedido.CODIGO_VENDEDOR + ' - ' + dadosPedido.NOME_VENDEDOR_INTERNO);
            $('#codigo_vendedor_externo').val(dadosPedido.VENDEDOR_EXTERNO);
            $('#nome_vendedor_externo').val(dadosPedido.VENDEDOR_EXTERNO + ' - ' + dadosPedido.NOME_VENDEDOR_EXTERNO);

            $("#observacoes").val(dadosPedido.OBS_COMP);

            $("#estadoCliente").val(dadosPedido.ESTADO);
            $("#optanteSimplesCliente").val(dadosPedido.OPTANTE_SIMPLES);

            $('#email_cliente').val(dadosPedido.EMAIL);
            $('#data_venda').val(dadosPedido.DATA_VENDA);
            $('#data_hora_venda').val(dadosPedido.DATA_HORA_VENDA);

            if (dadosPedido.FRETE !== '.00000') {
                $('#valor_frete').val(dadosPedido.FRETE);
                $('#valor_frete').val($('#valor_frete').val().replace('.', ','));
            }
        }

        function informacoesItens(itensPedido) {
            for (var i=0; i<itensPedido.length; i++) {
                produto = '';
                var produto = {
                    descricao: itensPedido[i]['descricao'],
                    codigo: itensPedido[i]['cod_prod'],
                    quantidade: itensPedido[i]['quantidade'],
                    percentual_desconto: itensPedido[i]['percentual_desconto'],
                    valor_unitario: itensPedido[i]['valor_unit'],
                    valor_unitario_com_desconto: itensPedido[i]['valor_unitario_com_desconto'],
                    total_liquido: itensPedido[i]['total_liquido'],
                    valor_st: itensPedido[i]['valor_imposto'],
                    valor_total: itensPedido[i]['total'],
                    aliquota_ipi: itensPedido[i]['aliquota_ipi'],
                    sequencia_produtos: itensPedido[i]['sequencia_produto'],
                    custo_bruto: itensPedido[i]['custo_bruto'],
                    percentual_acrescimo: itensPedido[i]['acrescimo'],
                    cod_grupo: itensPedido[i]['cod_grupo'],
                    obs_item_table: itensPedido[i]['obs_item_table'],
                }
                adicionarProdutoTabela(produto);
            }
        }

        // para adicionar uma nova coluna a tabela de itens do pedido começa por aqui.
        function add() {
            var form = document.querySelectorAll(".dadosProduto");
            var dadosProduto = obterDadosProduto(form);

            adicionarProdutoTabela(dadosProduto);
            $('.dadosProduto').val('');

            $('#quantidade_estoque_digitado').val('');
            // salvar pedido após adicionar o produto na tabela.
            terminado += 1;
//            console.log(terminado, $('#total_validar_insert').val());
            if (terminado == $('#total_validar_insert').val()) {
                $('#modal-success').modal('hide');

                terminado = 0;
                $('#total_validar_insert').val(0);

                // Abrir input de digitar campo.
                $(".select2Produto").select2('open');

                // Setar null no campo.
                $('.select2Produto').val(null).trigger('change');

                $('.select2-search__field').val($('#produtoDeBusca').val()).trigger('change');
                // Inicializar valores padrão no campo de select.
                select2ValorInicialProduto();
                colher();
            }
        }

        function obterDadosProduto(form) {
            // serve apenas para preencher o campo de desconto com 0, pois na estrutura atual sem isto, irá ficar em branco.
            if (form['3'].value === '') {
                $('#percDesconto').val(0);
            }
            var produto = {
                descricao: form['0'].value, // descricao
                codigo: form['1'].value, // codigo
                quantidade: form['2'].value, // quantidade
                percentual_desconto: form['3'].value, // percentual_desconto
                valor_unitario: form['4'].value, // valor unitario
                valor_unitario_com_desconto: form['5'].value, // valor_unitario_com_desconto
                total_liquido: form['6'].value, // total_liquido
                valor_st: form['7'].value, // valor_st
                valor_total: form['8'].value, // valor_total,
                aliquota_ipi: form['9'].value, // aliquota_ipi,
                custo_bruto: form['13'].value, // custo_bruto
                percentual_acrescimo: form['14'].value, // percentual_acrescimo
                cod_grupo: form['15'].value, // percentual_acrescimo
                sequencia_produtos: form['10'].value, // sequencia_produto
                obs_item_table: form['16'].value, // obs_item
            }
            return produto;
        }

        function adicionarProdutoTabela(dadosProduto) {
            var produtoTr = montaTr(dadosProduto);            
            var tabela = document.querySelector("#tabela-produtos");

            tabela.appendChild(produtoTr);
//            console.log(dadosProduto);
            
            var desabilitadoObsItem = '';
            var btnVisualizarProdutoTitulo = 'Visualizar observação...';
            if ($('#onlineObsItem').val() === 'N') {
                desabilitadoObsItem = ' disabled';
                btnVisualizarProdutoTitulo = 'Não será possivel visualizar observação, qualquer dúvida entrar em contato com suporte.';
            }
            
            //toda vez que alterar ou acrescentar algo na class alterar_... será necessario mexer também no appendChild que cria os botões.
            $(".alterar_" + dadosProduto.codigo+'-'+dadosProduto.sequencia_produtos).html('<button title="Alterar produto..." onclick="alterarProduto('+dadosProduto.codigo+','+dadosProduto.quantidade+','+(dadosProduto.percentual_desconto).replace(',','.')+','+dadosProduto.sequencia_produtos+');" class="btn btn-warning btn-flat fa fa-pencil botao_alterar" <?php echo $alterarPeiddo; ?> ><span class="hidden btn_alterar">'+dadosProduto.codigo+'<span></button>');
            $(".excluir_" + dadosProduto.codigo+'-'+dadosProduto.sequencia_produtos).html('<button title="Excluir produto..." onclick="excluirProduto('+dadosProduto.codigo+','+dadosProduto.sequencia_produtos+');" class="btn btn-danger btn-flat fa fa-remove botao_excluir" <?php echo $alterarPeiddo; ?>><span class="hidden btn_alterar">'+dadosProduto.codigo+'<span></button>');
            $(".visualizar_obs_" + dadosProduto.codigo+'-'+dadosProduto.sequencia_produtos).html('<button title="'+btnVisualizarProdutoTitulo+'" onclick="visualizarObservacaoItem('+dadosProduto.codigo+','+dadosProduto.sequencia_produtos+');" class="btn btn-info btn-flat fa fa-search-plus botao_visualizar_obs_item" <?php echo $alterarPeiddo; ?> '+desabilitadoObsItem+'><span class="hidden btn_alterar">'+dadosProduto.codigo+'<span></button>');
            totalizarProdutos(dadosProduto);
        }

        function montaTr(dadosProduto) {
            var produtoTr = document.createElement("tr");

            produtoTr.classList.add("produtos");
            produtoTr.setAttribute('id', dadosProduto.codigo);
//            produtoTr.setAttribute('id', dadosProduto.codigo+'-'+dadosProduto.sequencia_produtos);

            // Ordem de inserção na tabela de itens da venda.
            produtoTr.appendChild(montaTd(dadosProduto.codigo, "codigo_produto_table"));
            produtoTr.appendChild(montaTd(dadosProduto.descricao, "descricao_produto_table"));
            produtoTr.appendChild(montaTd(dadosProduto.quantidade, "quantidade_estoque_digitado_table"));
            produtoTr.appendChild(montaTd('R$' + dadosProduto.valor_unitario, "valor_unitario"));
            produtoTr.appendChild(montaTd(dadosProduto.percentual_desconto + '%', "perc_desconto_table"));
            produtoTr.appendChild(montaTd('R$' + dadosProduto.valor_unitario_com_desconto, "valor_unitario_com_desconto_table"));
            produtoTr.appendChild(montaTd('R$' + dadosProduto.total_liquido, "total_liquido_table"));
            produtoTr.appendChild(montaTd('R$' + dadosProduto.valor_st, "valor_st_table"));
            produtoTr.appendChild(montaTd('R$' + dadosProduto.valor_total, "valor_total_table"));

            produtoTr.appendChild(montaTd(dadosProduto.sequencia_produtos, "sequencia_produto"));

            // botão alterar
            produtoTr.appendChild(montaTd('' ,"alterar_" + dadosProduto.codigo+'-'+dadosProduto.sequencia_produtos));
            produtoTr.appendChild(montaTd('' ,"excluir_" + dadosProduto.codigo+'-'+dadosProduto.sequencia_produtos));

            produtoTr.appendChild(montaTd(dadosProduto.aliquota_ipi + '%', "hidden"));
            produtoTr.appendChild(montaTd(dadosProduto.custo_bruto, "hidden"));
            produtoTr.appendChild(montaTd(dadosProduto.percentual_acrescimo, "hidden"));
            produtoTr.appendChild(montaTd(dadosProduto.cod_grupo, "hidden"));

            produtoTr.appendChild(montaTd('' ,"visualizar_obs_" + dadosProduto.codigo+'-'+dadosProduto.sequencia_produtos));
            produtoTr.appendChild(montaTd(dadosProduto.obs_item_table, "hidden"));
            return produtoTr;
        }

        function montaTd(dado, id) {
            var td = document.createElement("td");
            td.textContent = dado;
            td.classList.add(id);

            return td;
        }

        function colherDados(finalizar) {
            var produtos = document.querySelectorAll('.produtos');
            var prod = [];
            for (var i=0; i<produtos.length; i++) {
                items = produtos[i].querySelectorAll('.produtos td');
                prod[i] = {
                    "codigo": items[0].textContent,
                    "descricao_produto_table": items[1].textContent,
                    "quantidade_digitada": items[2].textContent,
                    "valor_unitario": items[3].textContent,
                    "percentual_desconto": items[4].textContent,
                    "valor_unitario_com_desconto": items[5].textContent,
                    "valor_total_liquido": items[6].textContent,
                    "valor_st_ipi": items[7].textContent,
                    "total_produto": items[8].textContent,
                    "sequencia_produto": items[9].textContent,
                    "aliquota_ipi": items[12].textContent,
                    "custo_bruto": items[13].textContent, // tipo preço depende do par_cash
                    "percentual_acrescimo": items[14].textContent,
                    "cod_grupo": items[15].textContent,
                    "obs_item_table": items[17].textContent,
                };
//                console.log(items[9].textContent);
            }
//            console.log(JSON.stringify(prod));
            inserir(JSON.stringify(prod), finalizar);

        }

        $('#modal-default-confirme').click(function() {

            $('.fecharPedido').attr('disabled', true);
            $('#gravarPedido').attr('disabled', true);
            $('#btn-cancelar-pedido').attr('disabled', true);
        });

        function inserir(produtos, finalizar) {        
            var finalizar_pedido = 'N';
            //É PARA SOMENTE ENVIAR O E-MAIL SEM NECESSIDADE DE PASSAR POR AQUI.
            if (finalizar !== 'ENVIAR_SO_O_EMAIL' && finalizar !== 'APENAS_SALVAR_IMPRIMIR') {
                // PARA SINALIZAR QUE É PRA FECHAR PEDIDO
                var gravar_ou_fechar = document.querySelector('#gravarPedido').textContent;
                var online = navigator.onLine; // se existe conexão true
                if (online) {
                    if (gravar_ou_fechar === 'Enviar pedido para o caixa' || $('#fechar_direto').val() === 'S') {
                        finalizar_pedido = 'S';
                        dialogSuccess('Aguarde, estamos fechando o pedido...');
                    } else {
                        dialogSuccess('Aguarde, estamos gravando o pedido...');
                    }
                } else {
                    alert('Não será possivel gravar o pedido, não foi possivel verificar a conexão com internet.');
                }
            }
//            console.log(finalizar_pedido, finalizar);
            
            var dadosVenda = [{
                "codigo_cliente": $("#codigoInterno").val(),
                "transportadora": $("#transportadora option:selected").val(),
                "condicaoPagamento": $("#condicaoPagamento option:selected").val(),
                "tipo_pagamento": $("#tipo_pagamento option:selected").val(),
                "tipo_frete": $("#tipo_frete option:selected").val(),
                "codigo_venda": document.querySelector('#codigo_venda').textContent,
                "observacoes": $("#observacoes").val(),
                "finalizar_pedido": finalizar_pedido,
                "email_cliente": $("#email_cliente").val(),
                "codigo_vendedor_interno": $("#codigo_vendedor_interno").val(),
                "codigo_e_nome_clie": document.querySelector('#alterado_cliente').textContent,
                "data_venda": $("#data_venda").val(),
                "data_hora_venda": $("#data_hora_venda").val(),
                "valor_frete": $("#valor_frete").val(),
                "valor_total_itens": $('#valor_total_itens').val(),
                "codigo_e_descricao_condicao_pagamento": document.querySelector('#alterado_condicaoPagamento').textContent,
                "codigo_e_alterado_tipo_pagamento": document.querySelector('#alterado_tipo_pagamento').textContent,
                "valor_total_produtos": $('#valor_total_produtos').val(),
                "valor_total_imposto": $('#valor_total_imposto').val(),
                "codigo_e_alterado_transportadora": document.querySelector('#alterado_transportadora').textContent,
                "cidade_cliente": $("#cidade").val()
            }];

            // para saber quando fazer todo o processo de finalizar pedido
            if (finalizar === 'FINALIZAR') {
                $('#modal-success').modal('show');
                $('#modal-success').unbind("click");
            }

            var request = $.ajax({
                url: "<?= base_url('inserirPedido'); ?>",
                method: "POST",
                dataType: "json",
//                async: false,
                data: {itens: produtos, dadosVenda: dadosVenda}
            });

            request.done(function (res) {
                //console.log(res, finalizar);
                if (finalizar === 'APENAS_SALVAR_IMPRIMIR') {
                    geraImpressao(res, 'S');
                    return false;
                }
                if (finalizar === 'ENVIAR_SO_O_EMAIL') {
                    setTimeout(function() {
                        requestEnviarEmail(res, finalizar);
                    }, 200);
                } else {
                    $('#modal-success').modal('hide');
                    if (res !== 'EXISTE_PEDIDO_VENDA') {
                        //para saber quando fazer todo o processo de finalizar pedido
                        if (finalizar !== 'FINALIZAR') {
                            console.log('Opa! Dados salvo com sucesso. !== FINALIZAR');
                            $('#modal-success').modal('hide');
                            document.querySelector('#codigo_venda').textContent = res.COD_VENDA;
                        } else {
                            if (res['VENDA'] === false || res['ITENS_VENDA'][0] === false) {
                                console.log('Opa! Gerou um erro inesperado.');
                                $('#modal-success').modal('hide');
                                $('#modal-danger').modal('show');
                                document.querySelector('.alertaDanger').textContent = '';
                                $('.alertaDanger').append(
                                    '<p>\n\
                                        <b>\n\
                                            ERROS:\n\
                                        </b>\n\
                                    </p>\n\
                                    <p>\n\
                                        PRODUTO SEM CUSTO BRUTO: '+res['PRODUTOS_SEM_CUSTO']+'\n\
                                    </p>\n\
                                    <p>\n\
                                        VENDA: '+res['VENDA']+'\n\
                                    </p>\n\
                                    <p>\n\
                                        ITENS: '+res['ITENS_VENDA']+'\n\
                                    </p>');
                                return false;
                            } else {
                                console.log('Opa! Dados salvo com sucesso. == FINALIZAR');
                                if ($('#cadastrar_pedido_direto_cliente').val() === 'cadastrarVendaCliente' || $('#cadastrar_pedido_direto_cliente').val() === 'cadastrarCliente') {
                                    geraImpressao(res);
                                } else {
                                    setTimeout(function() {
                                        enviarEmail(res);
                                    }, 200);
                                }
                            }
                        }
                    } else {
//                        alert('Não se preocupe, seu pedido já foi enviado.');
                        location.href = "<?= base_url('listagemVenda'); ?>";
                    }
                }
            });

            request.fail(function (jqXHR, textStatus) {
                $('#modal-success').modal('hide');
                $('.alertaDanger').html('<img src="<?php echo base_url('./img/imagens/dialog/icone_erro.png') ?>" class="img-response" /> Foi impossivel adicionar o pedido. ' + jqXHR + ' - ' + textStatus);
                $('#modal-danger').modal('show');
            });
        }
        
        function geraImpressao(res, imprime_direto = 'N') {
            var param = '';
            if ($('#fechar_direto').val() === 'S') {
                param = 'V';
            } else {
                param = 'A';
            }
            if (imprime_direto == 'N') {
                document.querySelector('.modal-titulo').textContent = 'Imprimir ou salvar pedido';
                dialogDefault('Deseja imprimir ou salvar uma cópia do pedido ?');
                $('#modal-default-confirme-impressao').modal('show');
                $('#sim_confirma-impressao').click(function() {
                    $('#modal-default-confirme-impressao').modal('hide');
                    
                    window.open("<?php echo base_url('impressao') ?>/"+res['COD_VENDA']+"/"+param,'_blank');
                    setTimeout(function() {
                        enviarEmail(res);
                    }, 200);
                });
                $('#nao_confirma-impressao').click(function() {
                    $('#modal-default-confirme-impressao').modal('hide');
                    setTimeout(function() {
                        enviarEmail(res);
                    }, 200);
                });
            } else {
                removerClassTodosButtons();
                setTimeout(function() {
                    window.open("<?php echo base_url('impressao') ?>/"+res['COD_VENDA']+"/"+param,'_blank');
                }, 200);
            }
        }
        
        function enviarEmail(dados) {
            document.querySelector('.modal-titulo').textContent = 'Envio de e-mail';
            dialogDefault('Deseja enviar uma cópia do pedido para o e-mail: <b><h4>' + dados['EMAIL_CLIENTE'] + '</h4></b>');
            $('#modal-default-confirme').modal('show');

            $('#nao_confirma').click(function() {
                location.href = "<?= base_url('listagemVenda'); ?>";
            });

            $('#sim_confirma').click(function() {
                $('#sim_confirma').attr('disabled', true);
                $('#nao_confirma').attr('disabled', true);
                dialogDefault('Aguarde, estamos enviando uma cópia do pedido...');

                requestEnviarEmail(dados);
            });
        }

        function requestEnviarEmail(dados, finalizar) {
            var request = $.ajax({
                url: "<?= base_url('enviarEmail'); ?>",
                method: "POST",
                dataType: "json",
                data: {dados: JSON.stringify(dados)}
            });

            request.done(function (res) {
                if (finalizar === 'ENVIAR_SO_O_EMAIL') {
                    removerClassTodosButtons();
                    if (res === '0') {
                        alert('Falhou o envio. Tente novamente ou entre em contato com o suporte!');
                    } else {
                        alert('E-mail enviado...');
                    }
                } else {
                    $('#modal-default-confirme').modal('hide');
                    if (res === '1') {
                        location.href = "<?= base_url('listagemVenda'); ?>";
                    } else if (res === '2') {
                        dialogWarning('Pedido salvo ou enviado para o sistema local, entretanto, o E-mail do cliente está incorreto. Não foi possível enviar cópia.');
                        $('#modal-warning').modal('show');
                    } else {
                        dialogWarning('Pedido salvo ou enviado para o sistema local, entretanto, não será possivel enviar e-mail, cheque os parametros.');
                        $('#modal-warning').modal('show');
                    }
                    $('#fecharWarning').click(function() {
                        location.href = "<?= base_url('listagemVenda'); ?>";
                    });
                }
            });

            request.fail(function (jqXHR, textStatus) {
                removerClassTodosButtons();
                dialogDanger('Foi impossivel enviar e-mail do pedido. ' + jqXHR + ' - ' + textStatus);
                $('#modal-danger').modal('show');
            }); 
        }

        function removerClassTodosButtons() {
            $('.fa-spinner').removeClass('fa-spin');
            $('#enviar_email').removeAttr('disabled');
            $('.fecharPedido').removeAttr('disabled');
            $('#gravarPedido').removeAttr('disabled');
            $('#adicionar_produto').removeAttr('disabled');
            $('#fotoProduto').removeAttr('disabled');
            $('#lista_produtos').removeAttr('disabled');
            $('#btn-cancelar-pedido').removeAttr('disabled');
        }

        function removerProduto(todos, finalizar = 'FINALIZAR') {
            var codigo_venda = document.querySelector('#codigo_venda').textContent;

            var prod = [];
            for (var i=0; i<todos.length; i++) {
                prod[i] = {
                    "codigo_produto": todos[i].querySelectorAll('.produtos td.codigo_produto_table')[0].textContent,
                    "sequencia_produto": todos[i].querySelectorAll('.produtos td.sequencia_produto')[0].textContent,
                };
            }

            var request = $.ajax({
                url: "<?= base_url('excluirProdutos'); ?>",
                method: "POST",
                dataType: "json",
//                async: false,
                data: {produtos: JSON.stringify(prod), codigo_venda: codigo_venda}
            });

            request.done(function (response) {
                // necessário remover a class pois se permanecer o sistema irá inserir novamente os mesmos produtos que foram removidos através do método colherDados();
                $('tr').remove('.remover_estes_produtos');
                colherDados(finalizar);
                
            });

            request.fail(function (jqXHR, textStatus) {
                dialogDanger('Foi impossivel remover o produto do pedido, erro: '+ jqXHR);
                $('#gravarPedido').removeAttr('disabled');
                $('.fecharPedido').removeAttr('disabled');
                $('#modal-danger').modal('show');
            });
        }

        function validadarDados(validar) {
            document.querySelector(validar).textContent = 'Campo obrigatório*';
        }

        function tipo_pagamento() {
            var tipo_pagamento = $('#tipo_pagamento option:selected').val();

            if (tipo_pagamento === '') {
                $(".select2TipoPagamento").select2('open');
                validadarDados('#validadorTipoPagamento');
                return false;
            }
        }
        function condicao_pagamento() {
            var condicao_pagamento = $('#condicaoPagamento option:selected').val();

            if (condicao_pagamento === '') {
                $(".select2CondicaoPagamento ").select2('open');
                validadarDados('#validadorCondicaoPagamento');
                return false;
            }
        }

        $("#gravarPedido").click(function() {
            if (condicao_pagamento() !== false) {
                if (tipo_pagamento() !== false) {
                    // para prevenir que o usuário não irá pressionar duas vezes. 
                    $('#gravarPedido').attr('disabled', true);
                    $('#fechar_direto').val('N');
                    colher('FINALIZAR');
                }
            }
        });

        $('.fecharPedido').click(function() {
            if (condicao_pagamento() !== false) {
                if (tipo_pagamento() !== false) {
                    // para prevenir que o usuário não irá pressionar duas vezes. 
                    $('.fecharPedido').attr('disabled', true);
                    $('#fechar_direto').val('S');
                    colher('FINALIZAR');
                }
            }
        });
        
        $('#imprimir_pedido').click(function() {
            var tipo = document.querySelector('#incluir_alterar').textContent;
            if (tipo === 'V') {
                colherDados('APENAS_SALVAR_IMPRIMIR');
            } else {
                colher('APENAS_SALVAR_IMPRIMIR');
            }
        });
        
        $('#enviar_email').click(function() {
            $('.fa-spinner').addClass('fa-spin');
            $('#enviar_email').attr('disabled', true);
            $('.fecharPedido').attr('disabled', true);
            $('#gravarPedido').attr('disabled', true);
            $('#adicionar_produto').attr('disabled', true);
            $('#fotoProduto').attr('disabled', true);
            $('#lista_produtos').attr('disabled', true);
            var tipo = document.querySelector('#incluir_alterar').textContent;
            if (tipo === 'V') {
                colherDados('ENVIAR_SO_O_EMAIL');
            } else {
                colher('ENVIAR_SO_O_EMAIL');
            }
        });

        function colher(finalizar) {

            var todos = document.querySelectorAll(".remover_estes_produtos");
            if (todos.length > 0) {
                if (finalizar === 'FINALIZAR' || finalizar === 'APENAS_SALVAR_IMPRIMIR' || finalizar === 'ENVIAR_SO_O_EMAIL') {
                    dialogDefault('Encontramos produtos à serem removidos, confirma a remoção ? <br /> - Para consultar os produtos à serem removidos, clique em "Não" e depois clique no botão "PRODUTOS À EXCLUIR"');
                    $("#modal-default-confirme").modal('show');
                    $("#sim_confirma").click(function() {
                        $("#modal-default-confirme").modal('hide');
                        // além de remover o produto irá salvar o pedido com as novas informações
                        setTimeout(function() {
                            removerProduto(todos, finalizar);
                        }, 100);
                    });
                    $("#nao_confirma").click(function() {
                        setTimeout(function() {
                            $('#gravarPedido').removeAttr('disabled');
                            $('#btn-cancelar-pedido').removeAttr('disabled');
                            $('.fecharPedido').removeAttr('disabled');
                        }, 100);
                    });
                } else {
                    // irá salvar o pedido
                    confirmaColherDados(finalizar);
                }
            } else {
                // irá salvar o pedido
                confirmaColherDados(finalizar);
            }
        }

        function confirmaColherDados(finalizar) {
            if (finalizar === 'FINALIZAR') {
                if (confirm('Confirma ?')) {     
                    colherDados(finalizar);
                } else {
                    $('#gravarPedido').removeAttr('disabled');
                    $('.fecharPedido').removeAttr('disabled');
                }
//                dialogDefault('Confirma ?');
//                $("#modal-default-confirme-salvar").modal('show');
//                $("#sim_confirma_salvar").click(function() {
//                    $("#modal-default-confirme-salvar").modal('hide');
//                    setTimeout(function() {
//                        // irá salvar o pedido
//                        colherDados(finalizar);
//                    }, 100);
//                });
            } else {
                // irá salvar o pedido
                colherDados(finalizar);
            }
        }

        /* COMBOBOX DE LISTAGEM DE CLIENTE EM AJAX*/
        listagemCliente();

        /* COMBOBOX DE LISTAGEM DE TRANSPORTADORA EM AJAX*/
        listagemTransportadora();

        /* COMBOBOX DE LISTAGEM DE PRODUTO EM AJAX*/
        listagemProduto();

        /* COMBOBOX DE LISTAGEM DE CONDIÇÃO DE PAGAMENTO EM AJAX*/
        listagemCondiacaoPagamento();

        /* COMBOBOX DE LISTAGEM DE TIPO DE PAGAMENTO EM AJAX*/
        listagemTipoPagamento();

//        var incluir_alterar = document.querySelector('#incluir_alterar').textContent;
//        if (incluir_alterar === '') {
//            $("#cliente_venda").change(function () {
//                $(".select2Transportadora").select2('open');
//            });
//
//            $("#transportadora").change(function () {
//                $(".select2CondicaoPagamento").select2('open');
//            });
//
//            $("#condicaoPagamento").change(function () {
//                $(".select2TipoPagamento").select2('open');
//            });
//
//            $("#observacoes").blur(function () {
//                $(".select2Produto").select2('open');
//            });
//        }

        $("#fotoProduto").click(function () {
            
            if ($('#codigoProduto').val() === '') {
                alert('Escolha um produto para visualizar os dados...');
                return false;
            }
            
            var request = $.ajax({
                url: "<?= base_url('recuperarFotoProduto'); ?>",
                method: "GET",
                dataType: "json",
                data: { q: $('#codigoProduto').val() }
            });

            request.done(function (response) {
//                console.log(response);
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
                $('#modal-default').modal('show');
            });

            request.fail(function (jqXHR, textStatus) {
                dialogDanger('Foi impossivel buscar foto do produto. Tente novamente. $("informacao_tecnica").click, erro: ' + jqXHR);
                $('#modal-danger').modal('show');
            });
        });

        function select2ValorInicial() {
            $("#alterado_tipo_pagamento").text('Selecione...');
        }

        function select2ValorInicialProduto() {
            $(".alteradoProduto").text('Selecione...');
        }

        function select2ValorInicialCliente() {
            $("#alterado_cliente").text('Selecione...');
        }

        function select2ValorInicialTransportadora() {
            $("#alterado_transportadora").text('Selecione...');
        }

        function select2ValorInicialCondicaoPagamento() {
            $("#alterado_condicaoPagamento").text('Selecione...');
        }

        select2ValorInicial();

        select2ValorInicialProduto();

        select2ValorInicialCliente();

        select2ValorInicialTransportadora();

        select2ValorInicialCondicaoPagamento();
        
        document.querySelector('body').addEventListener('keydown', function(event) {
            if (event.keyCode === 113) {
                chamaAdicionarProdutos();
            }

            if (event.keyCode === 116) {
                event.returnValue = false;
                window.status = "We have disabled F5";

                var quantidade_pedidos = retornarQuantidadeProdutos();

                if (quantidade_pedidos > 0) {
                    var msg = 'Anote o número deste pedido: ' + document.querySelector('#codigo_venda').textContent;
                } else {
                    var msg = 'Não será possivel pressionar F5 para atualizar pagina, isto resultará em perder os dados.';
                }

                alert(msg);

            }
        });
    });

//    $('#valor_frete').blur(function() {
//        var valor_frete = $('#valor_frete').val().replace(',', '.');
//        var valor_total = $('#valor_total_itens').val().replace(',', '.');
//        
//        var teste = parseFloat(valor_frete) + parseFloat(valor_total);
//        $('#valor_total_itens').val(teste)
//        
//    });

    // function de calcular totalização de produtos (+ e -)
    function totalizarProdutos(dadosProduto, totalImposto = 0, tipo = 'INCLUIR') {
//        console.log(dadosProduto);
        // === TOTALIZAÇÃO DE PRODUTOS
        var valor_anterior_imposto = $('#valor_total_imposto').val().replace(',','.');
        var valor_anterior_produtos = $('#valor_total_produtos').val().replace(',', '.');

        var novo_valor = '';
        var novo_valor_imposto = '';

        if (tipo === 'INCLUIR') {
            // incluir valor quando buscado os itens do banco
            novo_valor_imposto = (dadosProduto['valor_st'].replace('.','')).replace(',', '.');
            novo_valor_liquido = dadosProduto['total_liquido'].replace(',', '.');

            var novo_produtos = parseFloat(novo_valor_liquido) + parseFloat(valor_anterior_produtos);
            var novo_imposto = parseFloat(novo_valor_imposto) + parseFloat(valor_anterior_imposto);
//            console.log(novo_valor_liquido, valor_anterior_produtos);

        } else if (tipo === 'EXCLUIR'){
            // excluir valor do produto excluido
            novo_valor = dadosProduto.replace(',','.');
            novo_valor_imposto = (totalImposto.replace('.','')).replace(',', '.');

            var novo_produtos = parseFloat(valor_anterior_produtos) - parseFloat(novo_valor.substr(2));
            var novo_imposto = parseFloat(valor_anterior_imposto) - parseFloat(novo_valor_imposto.substr(2));
        } else if (tipo === 'VOLTAR') {
            // voltar valor excluido
            novo_valor = dadosProduto.replace(',','.');
            novo_valor_imposto = (totalImposto.replace('.','')).replace(',', '.');

            var novo_produtos = parseFloat(valor_anterior_produtos) + parseFloat(novo_valor.substr(2));
            var novo_imposto = parseFloat(valor_anterior_imposto) + parseFloat(novo_valor_imposto.substr(2));
        }
        // total produtos + impostos
        var novo = novo_produtos + novo_imposto;

        $('#valor_total_itens').val(novo.toFixed(2));
        $('#valor_total_imposto').val(novo_imposto.toFixed(2));
        $('#valor_total_produtos').val(novo_produtos.toFixed(2));

        var teste = $('#valor_total_itens').val().replace('.',',');
        var teste2 = $('#valor_total_imposto').val().replace('.',',');
        var teste3 = $('#valor_total_produtos').val().replace('.',',');

        $('#valor_total_itens').val(teste);
        $('#valor_total_imposto').val(teste2);
        $('#valor_total_produtos').val(teste3);
    }

    function visualizarObservacaoItem(codigo, sequencia) {
        var request = $.ajax({
            url: "<?= base_url('visualizarObsItemPedido'); ?>",
            method: "GET",
            dataType: "json",
            data: {
                codigo: codigo,
                sequencia: sequencia,
                tipo_orc: document.querySelector('#incluir_alterar').textContent,
                numero_pedido: document.querySelector('#codigo_venda').textContent,
            }
        });

        request.done(function (res) {
            $('#obs_codigo_produto').val(codigo);
            $('#obs_sequencia_produto').val(sequencia);
            $('#obs_descricao_produto').val(res[0].DESCRICAO);
            $('#alterar_obs_item').removeAttr('disabled');
            $('#obs_item').val(res[0].OBSERVACAO);
            $('#modal-obs-item').modal('show');
        });

        request.fail(function (jqXHR, textStatus) {
            dialogDanger('Não conseguimos visualizar a observação produto, erro: ' + jqXHR);
            $('#modal-danger').modal('show');
        });
    }
    
    function alterar_obs_item() {
        console.log($('#obs_codigo_produto').val(), $('#obs_sequencia_produto').val());
        var request = $.ajax({
            url: "<?= base_url('alterarObsItemPedido'); ?>",
            method: "POST",
            dataType: "json",
            data: {
                codigo: $('#obs_codigo_produto').val(),
                sequencia: $('#obs_sequencia_produto').val(),
                numero_pedido: document.querySelector('#codigo_venda').textContent,
                observacao: $('#obs_item').val(),
            }
        });

        request.done(function (res) {
            if (res === true) {
                alert('Observação alterada com sucesso!');
                var produtosTr = document.querySelectorAll(".produtos");
                for (var i=0; i<produtosTr.length; i++) {
                    if (produtosTr[i].id == $('#obs_codigo_produto').val()) {
                        var produtosTd = document.querySelectorAll(".produtos td");
                        produtosTd[17].textContent = $('#obs_item').val();
                    }
                }
            }
            $('#modal-obs-item').modal('hide');
        });

        request.fail(function (jqXHR, textStatus) {
            dialogDanger('Não conseguimos alterar a observação produto, erro: ' + jqXHR);
            $('#modal-danger').modal('show');
        });
    }
    
    function excluirProduto(codigo, sequencia) {
        // serve para marcar produto com uma classe de remover
        var produtosTr = document.querySelectorAll('.produtos');
        var produtoRemover = codigo+'-'+sequencia;
        
        if (produtosTr.length > 1) {
            for (var i=0; i<produtosTr.length; i++) {
                var produtoRemoverTr = produtosTr[i].id+'-'+parseInt(produtosTr[i].childNodes[9].innerHTML);
                if (produtoRemover == produtoRemoverTr) {
                    // excluir valor do total
                    var valor_total_unit = document.querySelectorAll('.produtos td.total_liquido_table')[i].textContent;
                    var valor_total_imposto = document.querySelectorAll('.produtos td.valor_st_table')[i].textContent;
                    totalizarProdutos(valor_total_unit, valor_total_imposto, 'EXCLUIR')

                    produtosTr[i].className = "produtos hidden remover_estes_produtos";
                }
            }
        } else {
            dialogWarning('Existe apenas 1 produto no pedido, não será possivel excluir. Neste caso clique em "Cancelar".');
            $('#modal-warning').modal('show');
        }

    }
    
    $('#visualizarProdutosExcluidos').click(function() {
        var todos = document.querySelectorAll(".remover_estes_produtos");
        $('#texto-informacao').html('');
        for (var i=0; i<todos.length; i++) {
            var codigo_produto_sequencia = todos[i].querySelectorAll('.produtos td.codigo_produto_table')[0].textContent;
            var sequencia_produto = todos[i].querySelectorAll('.produtos td.sequencia_produto')[0].textContent;
            var descricao_produto = todos[i].querySelectorAll('.produtos td.descricao_produto_table')[0].textContent;
            var quantidade_estoque_digitado_table = todos[i].querySelectorAll('.produtos td.quantidade_estoque_digitado_table')[0].textContent;
            var valor_total_produto = todos[i].querySelectorAll('.produtos td.valor_total_table')[0].textContent;

            $('#texto-informacao').append(
                '<tr onclick="tr_produtos_removidos('+codigo_produto_sequencia+','+sequencia_produto+');" class="tr_produto_removidos" id="'+codigo_produto_sequencia+'-'+sequencia_produto+'" >\n\
                    <td>'+codigo_produto_sequencia+'-'+sequencia_produto+'</td>\n\
                    <td>'+descricao_produto+'</td>\n\
                    <td>'+quantidade_estoque_digitado_table+'</td>\n\
                    <td>'+valor_total_produto+'</td>\n\
                </tr>'
            );
        }
        $('#modal-default-padrao').modal('show');
    });

    function tr_produtos_removidos(cod_tr_remover, cod_seq_tr_remover) {

        var produtosTr = document.querySelectorAll('.produtos');
        var produtosTrSeq = document.querySelectorAll('.produtos td.sequencia_produto');
        var produtos_tr_removido = document.querySelectorAll('.tr_produto_removidos');
//        var resultado = cod_tr_remover;
        var resultado = cod_tr_remover+'-'+cod_seq_tr_remover;

        for (var i=0; i<produtosTr.length; i++) {
//            console.log(resultado, produtosTr[i].id);
            if (resultado == produtosTr[i].id+'-'+produtosTrSeq[i].textContent) {
                // retira da marcação de removido na tabela
                produtosTr[i].classList = "produtos";
                for (var x=0; x<produtos_tr_removido.length; x++) {
                    if (produtosTr[i].id+'-'+produtosTrSeq[i].textContent == produtos_tr_removido[x].id) {
                        // retira da marcação de removido no modal
                        produtos_tr_removido[x].classList = "tr_produto_removidos hidden";
                    }
                }
                // incluir valor novamente.
//                var valor_total_produto = document.querySelectorAll('.produtos td.valor_total_table')[i].textContent;
                var valor_total_produto = document.querySelectorAll('.produtos td.total_liquido_table')[i].textContent;
                var valor_total_imposto = document.querySelectorAll('.produtos td.valor_st_table')[i].textContent;
                totalizarProdutos(valor_total_produto, valor_total_imposto, 'VOLTAR');
            }
        }
    }

    function alterarProduto(codigo, quantidade, percentual_desconto, sequencia) {
        buscaProduto(codigo, quantidade, percentual_desconto, sequencia);
        $('#quantidade_estoque_digitado').focus();
    }

    function buscaProduto(codigo, quantidade, percentual_desconto, sequencia) {
        //var percentual_desconto_produto = (JSON.stringify(percentual_desconto)).replace('.',',');
        var request = $.ajax({
            url: "<?= base_url('listaProdutoAjax'); ?>",
            method: "GET",
            dataType: "json",
            data: {
                q: codigo,
                page: 1,
                estado: $("#estadoCliente").val(),
                optante: $("#optanteSimplesCliente").val(),
                codigoInternoCliente: $("#codigoInterno").val(),
                cod_condicao_pagamento: $("#condicaoPagamento option:selected").val(),
                em_massa: 'N',
            }
        });

        request.done(function (response) {
            var repo = response.items[0];
//            console.log(repo);
            $("#codigoProduto").val(repo.id);
            $("#descricaoProduto").val(repo.descricao);
            $("#aliquota_ipi").val(repo.aliquota_ipi);
            $("#percDesconto").val(percentual_desconto);
            $("#desc_max").val(repo.percentual);
            $("#esto_max").val(repo.estoqueatual);
            $("#custo_bruto").val(repo.custo_bruto); // tipo preço depende do par_cash
            $("#preco_base_validacao").val(repo.preco_base_validacao);
            $("#peso_venda").val(repo.peso);
            $("#valor_unitario").val(repo.preco_original);
            $("#valor_unitario_base").val(repo.preco_original);
            $('#quantidade_estoque_digitado').val(quantidade);
            $("#percentual_acrescimo").val(repo.percentual_acrescimo);
            $("#cod_grupo").val(repo.cod_grupo);
            $("#complemento_produto").val(repo.complemento);
            
            $("#embalagem_venda").val(repo.embalagem_venda);
            $('#sequencia_produto').val(sequencia);

            $(".alteradoProduto").text(repo.id + ' - ' + repo.descricao);
        });

        request.fail(function (jqXHR, textStatus) {
            dialogDanger('Foi impossivel adicionar o produto na tabela, está faltando os parametros de cliente, erro: ' + jqXHR);
            $('#modal-danger').modal('show');
        });
    }

    function retornarQuantidadeProdutos() {
        return document.querySelectorAll('.produtos').length;
    }

    $('#btn-cancelar-pedido').click(function() {
        if (retornarQuantidadeProdutos() > 0) {
            var codigo_venda = document.querySelector('#codigo_venda').textContent;
            var incluir_alterar = document.querySelector('#incluir_alterar').textContent;
            if (incluir_alterar !== 'V') {
                if (confirm('Encontramos ' + retornarQuantidadeProdutos() + ' item(s) no pedido. Para consultar pedidos cancelados, utilize o filtro: HISTÓRICO (Ped. Cancelado). Deseja realmente cancelar o pedido '+codigo_venda+' ?')) {
                    var request = $.ajax({
                        url: "<?= base_url('venda/updateVenda'); ?>",
                        method: "POST",
                        dataType: "json",
                        async: false,
                        data: { codigo_venda: codigo_venda, tipo_venda: 'C' }
                    });

                    request.done(function (response) {
                       location.href = "<?= base_url('listagemVenda'); ?>"; 
                    });

                    request.fail(function (jqXHR, textStatus) {
                        dialogDanger('Erro ao realizar update no pedido para SITUACAO = "E", erro: ' + jqXHR);
                        $('#modal-danger').modal('show');
                    });
                } else {
                    console.log('Não');
                }
            } else {
                location.href = "<?= base_url('listagemVenda'); ?>"; 
            }
        } else {
            location.href = "<?= base_url('listagemVenda'); ?>"; 
        }
    });

    function produtosParaAdicionar(codigo, quantidade_digitada, percentual_desconto, quantidade_disponivel, embalagem_venda) {        
        var listaCodigosProdutos = document.querySelectorAll('.lista_produtos_adicionar tr td.codigo_produto_lista_novo');
        var listaTrRemover = document.querySelectorAll('.lista_produtos_adicionar tr');

        var divisao = String (quantidade_digitada / embalagem_venda);
        var divSplit = divisao.split(".");
        if (divSplit.length == 1) {
            for (var i=0; i<listaCodigosProdutos.length; i++) {
                if (listaCodigosProdutos[i].textContent == codigo) {
                    listaTrRemover[i].remove();
                    console.log('Removido para adicionar outra quantidade.');
                }
            }
            if (quantidade_digitada > quantidade_disponivel && $('#permite_vender_estoque_zerado').val() === 'N') {
                alert('Quantidade digitada maior que a disponivel, nao será possivel adicionar. Quantidade digitada: ' + quantidade_digitada + ' - Quantidade disponivel: ' + quantidade_disponivel);
            } else {
                if (quantidade_digitada > 0) {
                    $('.lista_produtos_adicionar').append(
                                '<tr>\n\
                                    <td class="codigo_produto_lista_novo">' + codigo + '</td>\n\
                                    <td class="quantidade_digitada_lista_novo">' + quantidade_digitada + '</td>\n\
                                    <td class="percentual_desconto_lista_novo">' + percentual_desconto + '</td>\n\
                                </tr>');
                }
            }
        } else {
            alert('Quantidade de embalagem: ' + embalagem_venda + '. Não será incluso o produto com este valor digitado.');
        }
    }
    
    function visualizarLimite() {
        var request = $.ajax({
            url: "<?= base_url('getByIdClienteDados'); ?>",
            method: "GET",
            data: { codigo_cliente: $('.select2Cliente').val() },
            dataType: "json"
        });

        request.done(function (msg) {
//            console.log(msg);
            alert('Limite crédito: R$ ' + msg.DADOS.LIMITE_CREDITO + '\nLimite disponpivel: R$ ' + msg.DADOS[0].LIMITE_DISPONIVEL);
        });

        request.fail(function (jqXHR, textStatus) {
            $('#modal-success').modal('hide');
            dialogDanger('Não foi possivel retornar dados cliente $(#cadastrar_pedido_direto_cliente), entre em contato com o suporte ou tente novamente. Erro: ' + textStatus + ' ' + jqXHR);
            $('#modal-danger').modal('show');
        });
    }
</script>

</body>
</html>