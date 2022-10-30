<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cadastrar venda <small class="text-danger"><b class="msgCadastrarClientePelaVenda"></b></small>
            <!--<small>Painel de Controle</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?= base_url('listagemVenda'); ?>"><i class="fa fa-dashboard"></i> Listagem de vendas</a></li>
            <li class="active">Cadastrar venda</li>
        </ol>
    </section>

    <section class="content">
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <!-- Feito essa validação pois quando a url for true, o segmento 2 é o código do cliente, sendo assim automaticamente é buscado os dados do pedido, nesse caso não pode -->
                <?php if ($this->uri->segment(1) == 'cadastrarVendaCliente') {
                    $tipo = '';
                    $disabled = "disabled";
                } else {
                    $tipo = $this->uri->segment(2);
                    $disabled = '';
                } ?>
                    
                <h3 class="box-title">Dados da venda: <b style="color: #3c8dbc;" id="codigo_venda" class="hidden"><?= $tipo; ?></b>. <small class="text-danger"> Todos campos com * serão obrigatórios ser preenchidos.</small></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
<!--                    <div class="col-md-1">
                        <div class="form-group">-->
                            <!--<label>Código</label>-->
                            <input class="hidden" id="estadoCliente" />
                            <!--<input class="form-control" id="email_cliente" />-->
                            <input class="hidden" id="limite_credito" value="" />
                            <input class="hidden" id="limite_disponivel" value="" />
                            <input class="hidden" id="permite_vender_estoque_zerado" value="<?= $this->session->userdata('ONLINE_ESTOQUE'); ?>" />
                            <input class="hidden" id="data_venda" />
                            <input class="hidden" id="data_hora_venda" />
                            <input class="hidden" id="optanteSimplesCliente" />
                            <input class="hidden" id="esto_max_param" value="<?= number_format($this->session->userdata('DESCONTO_MAXIMO'), 2); ?>" />
                            
                            <!-- Serve para realizar a contagem de produtos e inserir somente após todos tiverem sido colocado na grid -->
                            <input class="hidden" id="total_validar_insert" />
                            <!-- /Serve para realizar a contagem de produtos e inserir somente após todos tiverem sido colocado na grid -->
                            
                            <input class="hidden" id="fechar_direto" value="N" />
                            <!-- Estes dois inputs servirá para quando a uri for do cadastro do cliente (cadastrarVendaCliente) -->
                            <input class="hidden" id="cadastrar_pedido_direto_cliente" value="<?= $this->uri->segment(1); ?>" />
                            <input class="hidden" id="codigo_buscar_cliente" value="<?= $this->uri->segment(2); ?>" />
                            <!-- / -->
                            <span class="hidden" id="incluir_alterar"><?= $this->uri->segment(3); ?></span>
                            <input class="form-control hidden" placeholder="Código" id="codigoInterno" value="" disabled/>
                            <input class="hidden" id="tipoFretePadraoParametro" value="<?= $this->session->userdata('FRETE_PADRAO'); ?>" />
                            <input class="hidden" id="precoMinimoPedido" value="<?= $this->session->userdata('PRECO_MINIMO_PEDIDO'); ?>" />
                            <input class="hidden" id="tabelaPrecoMinimoPedido" value="<?= $this->session->userdata('TABELA_PRECO_MINIMO_PEDIDO'); ?>" />
                            <input class="hidden" id="verificaLimiteCredito" value="<?= $this->session->userdata('VERIF_LIMITE_CREDITO'); ?>" />
                            <input class="hidden" id="avisoEstoqueNegativo" value="<?= $this->session->userdata('AVISO_EST_NEGATIVO'); ?>" />
                            <input class="hidden" id="repeticaoItens" value="<?= $this->session->userdata('REPETICAO_ITENS'); ?>" />
                            <input class="hidden" id="onlineObsItem" value="<?= $this->session->userdata('ONLINE_OBS_ITEM'); ?>" />
<!--                        </div>
                    </div>-->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nome/Razão Social <span id="validadorRazaoSocial" style="color: red;">*</span></label> <span onclick="visualizarLimite();" style="cursor: pointer;">Visualizar Limites</span>
                            <select class="form-control select2Cliente" id="cliente_venda" style="width: 100%" <?= $alterarPeiddo; ?> <?= $disabled; ?>>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
<!--                    <div class="col-md-2">
                        <div class="form-group">-->
                            <?php
                            $disabled = '';
                            if ($this->uri->segment(3) != 'F') {
                                $disabled = 'disabled';
                            }
                            ?>
<!--                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Cidade:</label>-->
                            <input class="form-control hidden" placeholder="Cidade" id="cidade" disabled/>
<!--                        </div>
                    </div>-->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Transportadora <span style="color: red;">Padrão <?= $this->session->userdata('TRANSP_PADRAO'); ?></label>
                            <select class="form-control select2Transportadora" style="width: 100%" id="transportadora" <?= $alterarPeiddo; ?>>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Cond. Pagamento <span style="color: red;" id="validadorCondicaoPagamento">Padrão <?= $this->session->userdata('COD_CONDPGTO_PADRAO') . ' | ' . $this->session->userdata('COD_CONDPGTO_PADRAO_PERC'); ?></span></label>
                            <select class="form-control select2CondicaoPagamento" style="width: 100%" id="condicaoPagamento" <?= $alterarPeiddo; ?>>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Tipo Pagamento <span id="validadorTipoPagamento" style="color: red;">*</span></label>
                            <select class="form-control select2TipoPagamento" style="width: 100%" id="tipo_pagamento" <?= $alterarPeiddo; ?>>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Frete</label>
                            <select class="form-control" id="tipo_frete" <?= $alterarPeiddo; ?>>
                                <!--<option name="<?= $this->session->userdata('FRETE_PADRAO'); ?>" value="<?= $this->session->userdata('FRETE_PADRAO'); ?>" selected="selected"><?= $this->session->userdata('FRETE_PADRAO'); ?></option>-->
                                <option name="CIF" value="CIF">CIF</option>
                                <option name="FOB" value="FOB">FOB</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Observação</label>
                            <input class="form-control" placeholder="Observações" name="observacoes" id="observacoes" <?= $alterarPeiddo; ?> value="e" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Interno</label>
                            <input id="codigo_vendedor_interno" value="" hidden="" />
                            <input class="form-control" placeholder="Cod. Vendedor Interno" id="nome_vendedor_interno" value="" disabled="" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Externo</label>
                            <input id="codigo_vendedor_externo" value="" hidden="" />
                            <input class="form-control" placeholder="Cod. Vendedor Externo" id="nome_vendedor_externo" value="" disabled="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Produtos. <small class="text-danger"> Produtos com fundo vermelho está na promoção, produtos com o fundo preto e da cor vermelho está com o estoque zerado.</small></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-info btn-xs" id="visualizarProdutosExcluidos">PRODUTOS À EXCLUIR</button>
                </div>
            </div>
            <div class="box-body">
                <!-- Dados produto - 1 linha-->
                <div class="row">
                    <div class="col-md-2">
                        <label>Tipo Busca <span id="tipoBusca" style="color: red;">*</span></label>
                        <select id="tipo_busca" class="form-control" style="width: 100%;">
                            <option value="string">String</option>
                            <option value="codigo">Código</option>
                            <option value="descricao">Descrição</option>
                            <option value="ref_fabricante">Ref. Fabricante</option>
                        </select>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>Produto <span id="validadorProduto" style="color: red;">*</span></label>
                            <select class="form-control select2Produto" style="width: 100%" id="produto" <?= $alterarPeiddo; ?>>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input class="dadosProduto hidden" id="descricaoProduto" />
                    <input class="dadosProduto hidden" id="codigoProduto">
                    <input class="form-control hidden" id="produtoDeBusca">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Complemento</label>
                            <input type="text" class="form-control" placeholder="Complemento" id="complemento_produto" disabled/>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Peso</label>
                            <input type="text" class="form-control" placeholder="Peso" id="peso_venda" disabled/>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label id="qtde_embalagem">Embalagem</label>
                            <input type="text" class="form-control" placeholder="Peso" id="embalagem_venda" value="1" disabled/>
                        </div>
                    </div>
                    
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Qtde.</label>
                            <input type="number" class="form-control dadosProduto" placeholder="Quantidade" id="quantidade_estoque_digitado" <?= $alterarPeiddo; ?>/>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>(%) Desc.</label>
                            <input type="number" class="form-control dadosProduto" placeholder="Perc. Desconto" id="percDesconto" <?= $disabledPercDesconto; ?> <?= $alterarPeiddo; ?> />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Vlr. Unit.</label>
                            <input type="text" class="form-control dadosProduto" placeholder="Vlr. Unit." id="valor_unitario" <?= $disabledValorUnitario; ?> <?= $alterarPeiddo; ?> />
                            <input hidden="hidden" id="valor_unitario_base"  />
                            <input hidden="hidden" id="preco_base_validacao"  />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                        <label>Adicionar</label>
                            <button type="button" class="btn btn-block btn-primary btn-flat " id="adicionar_produto" <?= $alterarPeiddo; ?>><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Info.</label>
                            <button type="button" class="btn btn-block btn-warning btn-flat" id="fotoProduto" <?= $alterarPeiddo; ?>><i class="fa fa-hand-pointer-o"></i></button>
                        </div>
                    </div>
                    
                    <!--  ATENÇÃO: PARA HABILITAR ESSA FUNCIONALIDADE, TERÁ QUE AJUSTAR A INSERÇÃO DE PEDIDOS QUANDO FOR UM NOVO. 
                    ESTÁ ACONTECENDO QUE A INSERÇÃO É MUITO RAPIDA E NÃO DA TEMPO DE RETORNAR O CODIGO DE VENDA E COM ISSO INSERE VARIOS PEDIDOS IGUAIS. 
                    MINHA SUGESTÃO SERIA ASSIM QUE ABRIR A TELA DE VENDA TRAZER CARREGADO UM CÓDIGO DE VENDA PREENCHIDO -->
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Lista</label>
                            <input class="hidden" id="tipo_busca_lista" value="1"/>
                            <button type="button" class="btn btn-block btn-default btn-flat" id="lista_produtos" <?= $alterarPeiddo; ?>><i class="fa fa-hand-pointer-o"></i></button>
                        </div>
                    </div>
                    
                    <input class="dadosProduto hidden" id="valor_unitario_com_desconto" />
                    <input class="dadosProduto hidden" id="total_liquido" />
                    <input class="dadosProduto hidden" id="valor_st" />
                    <input class="dadosProduto hidden" id="valor_total" />
                    <input class="dadosProduto hidden" id="aliquota_ipi" />
                    <input class="dadosProduto hidden" id="sequencia_produto" />
                    <input class="dadosProduto hidden" id="desc_max" />
                    <input class="dadosProduto hidden" id="esto_max" />
                    <input class="dadosProduto hidden" id="custo_bruto" />
                    <input class="dadosProduto hidden" id="percentual_acrescimo"/>
                    <input class="dadosProduto hidden" id="cod_grupo"/>
                    <input class="dadosProduto hidden" id="table_obs_item"/>
                </div>
                <!-- /Dados produto - 1 linha-->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive" style="overflow: scroll; width: 100%; height: 250px;">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px; background-color: rgb(60, 141, 188); color: white;">Código</th>
                                        <th style="background-color: rgb(60, 141, 188); color: white;">Descrição</th>
                                        <th style="width: 50px; background-color: rgb(60, 141, 188); color: white;">Qtde.</th>
                                        <th style="width: 80px; background-color: rgb(60, 141, 188); color: white;">Vlr. Unit.</th>
                                        <th style="width: 80px; background-color: rgb(60, 141, 188); color: white;">(%)Desc.</th>
                                        <th style="width: 80px; background-color: rgb(60, 141, 188); color: white;">Unit. Liq.</th>
                                        <th style="width: 80px; background-color: rgb(60, 141, 188); color: white;">Total Liq.</th>
                                        <th style="width: 80px; background-color: rgb(60, 141, 188); color: white;">ST/IPI</th>
                                        <th style="width: 80px; background-color: rgb(60, 141, 188); color: white;">Total</th>
                                        <th style="width: 10px; background-color: rgb(60, 141, 188); color: white;">Seq.</th>
                                        <th style="width: 40px; background-color: rgb(60, 141, 188); color: white;"></th>
                                        <th style="width: 40px; background-color: rgb(60, 141, 188); color: white;"></th>
                                        <th class="hidden" style="width: 40px; background-color: rgb(60, 141, 188); color: white;">IPI</th>
                                        <th class="hidden" style="width: 40px; background-color: rgb(60, 141, 188); color: white;">Custo Bruto</th>
                                        <th class="hidden" style="width: 40px; background-color: rgb(60, 141, 188); color: white;">(%)Acresc.</th>
                                        <th class="hidden" style="width: 40px; background-color: rgb(60, 141, 188); color: white;">Grupo</th>
                                        <th style="width: 40px; background-color: rgb(60, 141, 188); color: white;"></th>
                                    </tr>
                                </thead>
                                <tbody id="tabela-produtos">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input class="hidden" id="valor_frete" value="0" />
                    <div class="col-md-2">
                        <p class="text-danger">E-mail Empresa:</p>
                        <input type="text" class="form-control" title="ó será possivel alterar o e-mail após gravar o pedido." value="<?= $this->session->userdata('EMAIL_RESPONSAVEL'); ?>" disabled/>
                    </div>
                    <div class="col-md-2">
                        <p class="text-danger">E-mail Vendedor:</p>
                        <input class="form-control" placeholder="E-mail do cliente" title="Só será possivel alterar o e-mail após gravar o pedido." value="<?= $this->session->userdata('EMAIL_VENDEDOR'); ?>" disabled/>
                    </div>
                    <div class="col-md-2">
                        <p class="text-danger">E-mail Cliente:</p>
                        <input class="form-control" placeholder="E-mail do cliente" id="email_cliente" title="Só será possivel alterar o e-mail após gravar o pedido."/>
                    </div>
                    <div class="col-md-2">
                        <p class="text-danger">Total Produtos:</p>
                        <input type="text" class="form-control" id="valor_total_produtos" value="0" disabled/>
                    </div>
                    <div class="col-md-2">
                        <p class="text-danger">Total ST/IPI:</p>
                        <input type="text" class="form-control" id="valor_total_imposto" value="0" disabled/>
                    </div>
                    <div class="col-md-2">
                        <p class="text-danger">Total Produtos+Imposto:</p>
                        <input type="text" class="form-control" id="valor_total_itens" value="0" disabled/>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-2">
                        <button id="imprimir_pedido" class="btn btn-block btn-flat btn-default"><i class="fa fa-print"></i> Imprimir</button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-block btn-default btn-flat " id="enviar_email" title="Clique neste botão faturar o pedido."><i class="fa fa-spinner"></i> Enviar cópia do pedido</button>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <?php 
                        $hidden = 'hidden';
                        if ($botao != 'Enviar pedido para o caixa' && !isset($desabilitar_botao)) {
                            $hidden = '';
                        } ?>
                        <button type="button" class="btn btn-block btn-success btn-flat fecharPedido <?=$hidden;?>" title="Clique neste botão faturar o pedido.">Enviar pedido para o caixa</button>
                    </div>
                    <div class="col-md-2">
                        <?php if(!isset($desabilitar_botao)) {
                            $color = ($botao == 'Enviar pedido para o caixa') ? 'success' : 'warning'; ?>
                                <button type="button" id="gravarPedido" class="btn btn-block btn-<?= $color; ?> btn-flat"><?php echo $botao; ?></button>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-block btn-danger btn-flat" id="btn-cancelar-pedido">Cancelar</button>
                        <!--<a href="<?= base_url('listagemVenda/'); ?>" class="btn btn-block btn-danger btn-flat">Cancelar</a>-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>