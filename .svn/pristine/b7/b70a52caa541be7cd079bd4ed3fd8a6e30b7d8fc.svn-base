<div class="modal modal-default fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Informações técnicas</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <p id="foto_produto_zoom"></p>
                    </div>
                    <div class="col-md-4">
                        <p><b>Grupo/SubGrupo: </b><span id="grupo_subgrupo"></span></p>
                        <p><b>Peso: </b><span id="peso"></span></p>
                        <p><b>Unidade: </b><span id="unidade"></span></p>
                        <p><b>Quantidade em Estoque: </b><span id="quantidade_em_estoque"></span></p>
                        <p><b>Complemento: </b><span id="complemento"></span></p>
                        <p><b>Ref. Fabricante: </b><span id="fabricante"></span></p>
                        <p><b>Obs. Cadastro: </b><span id="obs_cadastro"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><b>(E-commerce)Detalhes: </b><span id="detalhes"></span></p>
                        <p><b>(E-commerce)Informações Técnicas: </b><span id="inf_tecnicas"></span></p>
                        <p><b>(E-commerce)Garantia: </b><span id="garantia"></span></p>
                        <p><b>(E-commerce)Observações: </b><span id="observacoes_ecommerce"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal modal-default fade" id="modal-obs-item">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Observações produto</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2">
                        <input class="form-control" value="" id="obs_codigo_produto" disabled />
                        <input id="obs_sequencia_produto" hidden />
                    </div>
                    <div class="col-md-10">
                        <input class="form-control" placeholder="Descricao produto" value="" id="obs_descricao_produto" disabled />
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <input class="form-control" placeholder="Observação item" value="" id="obs_item" maxlength="150" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="alterar_obs_item" onclick="alterar_obs_item();">Alterar obs</button>
                <button type="button" class="btn btn-default" id="fechar_obg_item" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal modal-default fade" id="modal-default-padrao">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-warning" style="color: white;">Clique uma única vez para retirar-lo da exclusão.</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="background-color: rgb(60, 141, 188); color: white;">Codigo</th>
                            <th style="background-color: rgb(60, 141, 188); color: white;">Descricao</th>
                            <th style="background-color: rgb(60, 141, 188); color: white;">Quantidade</th>
                            <th style="background-color: rgb(60, 141, 188); color: white;">Valor</th>
                        </tr>
                    <thead>
                    <tbody id="texto-informacao">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-primary" id="excluir">Excluir</button>-->
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal modal-warning fade" id="modal-warning">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p class="alertaWarning"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal" id="fecharWarning">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal modal-success fade" id="modal-success">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-refresh fa-spin"></i></h4>
            </div>
            <div class="modal-body">
                <p class="alertaSuccess"></p>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal modal-danger fade" id="modal-danger">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p class="alertaDanger"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal modal-default fade" id="modal-default-confirme" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: white">
                <h4 class="modal-title modal-titulo"></h4>
            </div>
            <div class="modal-body">
                <p class="alertaDefaulftConfirme"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="sim_confirma">Sim</button>
                <button type="button" class="btn btn-default" id="nao_confirma" data-dismiss="modal">Não</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal modal-default fade" id="modal-default-confirme-salvar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modal-titulo">Confirmação de operação.</h4>
            </div>
            <div class="modal-body">
                <p class="alertaDefaulftConfirme"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="sim_confirma_salvar">Sim</button>
                <button type="button" class="btn btn-default" id="nao_confirma_salvar" data-dismiss="modal">Não</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal modal-default fade" id="modal-default-confirme-impressao">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modal-titulo"></h4>
            </div>
            <div class="modal-body">
                <p class="alertaDefaulftConfirme"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="sim_confirma-impressao">Sim</button>
                <button type="button" class="btn btn-default" id="nao_confirma-impressao" data-dismiss="modal">Não</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php
$ocultarCliente = '';
$ocultarVenda = '';
if ($this->uri->segment(1) == 'listagemVenda') {
    $ocultarCliente = 'hidden';
} else if ($this->uri->segment(1) == 'listagemCliente') {
    $ocultarVenda = 'hidden';
}
?>

<div class="modal modal-default fade" id="modal-relatorio">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title modal-titulo">Gerador de relatório</h4>
            </div>
            <div class="modal-body">
                <div class="row <?= $ocultarVenda; ?>">
                    <!--                    <div class="col-md-3">
                                            <label>Em desenvolvimento...</label>
                                        </div>-->
                    <?php
                    $data_inicial = date('dmY', strtotime('-1 month'));
                    if ($this->uri->segment('3') == 'O' || $this->uri->segment('3') == 'N' || $this->uri->segment('3') == 'S') {
                        $data_inicial = '';
                    }
                    ?>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nome/Razão Social:</label>
                            <select class="form-control select2Cliente2" id="select2Cliente" style="width: 100%">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <label>Dt. Venda Inicial:</label>
                        <input class="form-control" id="data_venda_relatorio_inicial" placeholder="Data Inicial: 08/12/2018" value="<?= $data_inicial; ?>" maxlength="10">
                    </div>
                    <div class="col-md-2">
                        <label>Dt. Venda Final:</label>
                        <input class="form-control" id="data_venda_relatorio_final" placeholder="Data Inicial: 08/12/2018" value="<?= date('dmY'); ?>" maxlength="10">
                    </div>
                    <div class="col-md-3">
                        <label>Situação Pedido:</label>
                        <select id="tipo_relatorio_pedidoss" class="form-control" style="width: 100%;">
                            <option value="O">ORÇAMENTO</option>
                            <option value="N">PEDIDOS EM ABERTOS</option>
                            <option value="S">PEDIDOS FATURADOS</option>
                            <option value="H">HISTÓRICO(Ped. Cancelado)</option>
                        </select>
                    </div>
                </div>
                <div class="row <?= $ocultarCliente; ?>">
                    <div class="col-md-3">
                        <label>Em desenvolvimento...</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!--<a href="<?= base_url('relatorioVendas'); ?>" target="_blank" class="btn btn-primary">Gerar</a>-->
                <button type="button" class="btn btn-primary" id="gerar">Gerar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal modal-default fade" id="modal-lista-produtos">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title modal-titulo">Lista produtos - <span> VALOR DO PRODUTO NÃO CONTEMPLA IMPOSTO. </span></h4>
            </div>
            
            <div class="modal-body table-responsive" style="overflow: scroll; width: 100%; height: 400px;">
                <table id="example" class="table table-bordered table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th style="background-color: #3c8dbc; color: white; width: 10px;">Código</th>
                            <th style="background-color: #3c8dbc; color: white;">Descrição</th>
                            <!--<th style="background-color: #3c8dbc; color: white; width: 10px;">Estoque</th>-->
                            <!--<th style="background-color: #3c8dbc; color: white; width: 10px;">Reservado</th>-->
                            <th style="background-color: #3c8dbc; color: white; width: 10px;">Estq. Disponivel</th>
                            <th style="background-color: #3c8dbc; color: white; width: 10px;">Vlr. Unit.</th>
                            <th style="background-color: #3c8dbc; color: white; width: 10px;">(%)Acresc.</th>
                            <th style="background-color: #3c8dbc; color: white; width: 10px;">(%)Desc.</th>
                            <th style="background-color: #3c8dbc; color: white; width: 10px;">Total S/Imposto</th>
                            <th style="background-color: #3c8dbc; color: white; width: 10px;">Complemento</th>
                            <th style="background-color: #3c8dbc; color: white; width: 10px;">Quantidade</th>
                        </tr>
                    </thead>
                    <tbody class="lista_produtos">
                    </tbody>
                </table>
            </div>
            <table class="hidden lista_produtos_adicionar">
            </table>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary lista_adicionar_produtos">F2 - Adicionar produtos</button>
                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>-->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal modal-default fade" id="modal-telemarketing">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title modal-titulo">Cadastrar telemarketing</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Id: <span style="color: red;">*</span></label>
                            <input class="form-control" id="codigo_telemarketing" value="" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Dt. Contato: <span style="color: red;">*</span></label>
                            <input class="form-control" id="data_telemarketing_contato" placeholder="Data Contato: 08/12/2019" value="" maxlength="10">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Dt. Próximo Contato: <span style="color: red;">*</span></label>
                            <input class="form-control" id="data_telemarketing_proximo_contato" placeholder="Próximo Contato: 08/12/2019" value="" maxlength="10">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Contato: <span style="color: red;">*</span></label>
                            <input class="form-control" id="contato_telemarketing" placeholder="Nome do contato..." maxlength="50" style="text-transform: uppercase">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Usuário/Vendedor: <span style="color: red;">*</span></label>
                            <input class="hidden" id="vendedor_telemarketing" value="<?php echo $this->session->userdata('VENDEDOR') ?>"/>
                            <input class="form-control" placeholder="Nome do contato..." value="<?php echo $this->session->userdata('VENDEDOR') . ' - ' . $this->session->userdata('NOME'); ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Observação: </label>
                            <textarea class="form-control" name="observacao_telemarketing" cols="40" rows="5" placeholder="Observação" name="observacao_telemarketing" id="observacao_telemarketing" style="text-transform: uppercase"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Motivos: </label>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="C" checked="">
                                            Contato
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="T">
                                            Troca/Devolução
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios3" value="R">
                                            Reclamação
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios4" value="F">
                                            Financeiro
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios5" value="S">
                                            Sugestão
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios6" value="O">
                                            Outros
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
<!--                    <div class="col-md-2">
                        
                    </div>-->
                </div>
                <div class="row">
                    <div class="col-md-6 checkbox">
                        <label>
                            <input type="checkbox" name="check_retorno_efetuado" id="check_retorno_efetuado" />Retorno - EFETUADO
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="gravarTelemarketing">Salvar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>