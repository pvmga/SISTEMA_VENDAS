<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cadastrar clientes
            <!--<small>Painel de Controle</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?= base_url('listagemCliente'); ?>"><i class="fa fa-dashboard"></i> Listagem de clientes</a></li>
            <li class="active">Cadastrar clientes</li>
        </ol>
    </section>

    <section class="content">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <input class="hidden" id="telemarketing_uri" value="<?= $this->uri->segment(1); ?>" />
                <?php 
                $active_tab_dados = '';
                $active_tab_tele = '';
                if ($this->uri->segment(1) == 'telemarketing') {
                    $active_tab_tele = 'active';
                } else {
                    $active_tab_dados = 'active';
                }?>
                <li class="<?= $active_tab_dados; ?>"><a href="#tab_1" data-toggle="tab">Dados</a></li>
                <li><a href="#tab_2" data-toggle="tab" id="financeiro" >Financeiro<span style="color: red;">*</span></a></li>
                <li class="<?= $active_tab_tele; ?>"><a href="#tab_3" data-toggle="tab" id="telemarketing" >Telemarketing<span style="color: red;">*</span></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane <?= $active_tab_dados; ?>" id="tab_1">
                    <!--<div class="box box-primary">-->
                    <div class="box-header with-border">
                        <div class="col-md-10">
                            <h3 class="box-title">Dados do cliente.<small class="text-danger"> Todos campos com * serão obrigatórios ser preenchidos.</small></h3>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>Código</label>
                                    <input class="form-control" placeholder="Código" id="codigoInterno" value="<?= $this->uri->segment(2) ?>" disabled/>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tipo de Cadastro: </label>
                                    <select class="form-control" id="tipoPessoa" autofocus="">
                                        <option value="J">Pessoa Jurídica</option>
                                        <option value="F">Pessoa Física</option>
                                        <option value="R">Produtor Rural</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 cnpj">
                                <div class="form-group">
                                    <label>CNPJ: <span id="validadorCNPJ" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="CNPJ" name="cnpj" id="cnpj"/>
                                </div>
                            </div>
                            <div class="col-md-2 cpf">
                                <div class="form-group">
                                    <label>CPF: <span id="validadorCPF" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="CPF" name="cpf" id="cpf"/>
                                </div>
                            </div>
                            <div class="col-md-2 cpf-produtor">
                                <div class="form-group">
                                    <label>CPF: <span id="validadorCPFPRODUTOR" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="CPF" name="cpf-produtor" id="cpf-produtor"/>
                                </div>
                            </div>
                            <div class="col-md-2 inscricao">
                                <div class="form-group">
                                    <label>Inscrição: <span id="validadorINSCRICAO" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Inscrição" name="inscricao" id="inscricao" />
                                </div>
                            </div>
                            <div class="col-md-2 rg">
                                <div class="form-group">
                                    <label>RG: <span id="validadorRG" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="RG" name="rg" id="rg" style="text-transform: uppercase"/>
                                </div>
                            </div>
                            <div class="col-md-2 inscricao-produtor">
                                <div class="form-group">
                                    <label>Inscrição: <span id="validadorINSCRICAOPRODUTOR" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Inscrição" name="inscricao-produtor" id="inscricao-produtor" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Limite de Crédito: </label>
                                    <input class="form-control" placeholder="" id="limite_credito" value="" disabled/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Limite Disponível: </label>
                                    <input class="form-control" placeholder=""id="limite_disponivel" value="" disabled/>
                                </div>
                            </div>
                        </div>

                        <div class="row"> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nome / Razão Social: <span id="validadorRAZAO" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Nome / Razão Social" name="razao_social" id="razao_social" maxlength="50" style="text-transform: uppercase"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nome Fantasia / Apelido: <span id="validadorFANTASIA" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Nome Fantasia / Apelido" name="nome_fantasia" id="nome_fantasia" maxlength="50" style="text-transform: uppercase"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>CEP: <span id="validadorCEP" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="CEP" id="cep" name="cep" id="cep"/>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Endereço: <span id="validadorENDERECO" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Endereço" name="endereco" id="endereco" maxlength="40" style="text-transform: uppercase"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Número: <span id="validadorNUMERO" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="N°" name="numero" id="numero"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Complemento: </label>
                                    <input class="form-control" placeholder="Complemento" name="complemento" id="complemento" style="text-transform: uppercase"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Bairro: <span id="validadorBAIRRO" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Bairro" name="bairro" id="bairro" maxlength="40" style="text-transform: uppercase"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Cidade: <span id="validadorCIDADE" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Cidade" name="cidade" id="cidade" maxlength="40" style="text-transform: uppercase"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>UF: <span id="validadorUF" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="UF" name="uf" id="uf"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Telefone: <span id="validadorTELEFONE_FIXO" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Telefone" name="telefone_fixo" id="telefone_fixo"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Celular: </label>
                                    <input class="form-control" placeholder="Celular" name="telefone_celular" id="telefone_celular"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Fax: </label>
                                    <input class="form-control" placeholder="Fax" name="fax" id="fax"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Contato: <span id="validadorCONTATO" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Contato" name="contato" id="contato" maxlength="40" style="text-transform: uppercase"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Website: </label>
                                    <input class="form-control" placeholder="Website" name="website" id="website" maxlength="50" style="text-transform: uppercase"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Email: <span id="validadorEMAIL" style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Email" name="email" id="email" style="text-transform: uppercase"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <!--<label>Transportadora Preferencial: <span id="validadorTRANSPORTADORA" style="color: red;">*</span></label>-->
                                    <label>Transportadora Preferencial: </label>
                                    <select class="form-control js-example-data-ajax" id="transportadora" autofocus="">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Vendedor interno: <span id="validadorVENDEDOR_INTERNO" style="color: red;">*</span></label>
                                    <select class="form-control js-vendedor-interno" id="vendedorInterno" autofocus="">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Vendedor Externo</label>
                                    <input class="hidden" id="vendedor" value="<?php echo $this->session->userdata('VENDEDOR') ?>"/>
                                    <input class="form-control" value="<?php echo $this->session->userdata('VENDEDOR') . ' - ' . $this->session->userdata('NOME'); ?>" disabled/>
                                </div>
                            </div>
                            <div class="col-md-12" hidden>
                                <div class="form-group">
                                    <label>Observação: </label>
                                    <textarea class="form-control" name="observacao" cols="40" rows="5" placeholder="Observação" name="observacao" id="observacao" style="text-transform: uppercase"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--</div>-->
                </div>
                <?php if ($this->session->userdata['ONLINE_CAD_CLIENTES'] == 'S') { ?>
                <div class="tab-pane" id="tab_2">
                    <div class="box-header with-border">
                        <div class="col-md-10">
                            <h3 class="box-title">Dados do cliente.<small class="text-danger"> Financeiro.</small></h3>
                        </div>

<!--                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control pull-right" placeholder="Pesquisar">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>-->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">N° Documento</th>
                                    <th style="width: 10%;">Ref. Venda</th>
                                    <th>Tipo</th>
                                    <th>Data Venc./Pag.</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody id="tabela_financeiro">
                            <tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <?php } ?>
                <div class="tab-pane <?= $active_tab_tele; ?>" id="tab_3">
                    <div class="box-header with-border">
                        <div class="col-md-10">
                            <h3 class="box-title">Dados do cliente.<small class="text-danger"> Telemarketing.</small></h3>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="btnIncluirTelemarketing" class="btn btn-block btn-success btn-flat" onclick="teste();">Novo Telemarketing</button>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Dt. Contato</th>
                                    <th style="width: 10%;">Contato</th>
                                    <th>Próx. Retorno</th>
                                    <th>Retorno</th>
                                    <th>Motivo</th>
                                </tr>
                            </thead>
                            <tbody id="tabela_telemarketing">
                            <tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <br />
                    <div class="col-md-6"></div>
                    <div class="col-md-2"></div>
                    <?php if ($this->session->userdata['ONLINE_CAD_CLIENTES'] == 'S') { ?>
                        <div class="col-md-2">
                            <button type="button" id="btnGravar" class="btn btn-block btn-success btn-flat">Gravar</button>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-2"></div>
                    <?php } ?>
                    <div class="col-md-2">
                        <a href="<?= base_url('listagemCliente'); ?>" class="btn btn-block btn-danger btn-flat">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SELECT2 EXAMPLE -->

    </section>

</div>