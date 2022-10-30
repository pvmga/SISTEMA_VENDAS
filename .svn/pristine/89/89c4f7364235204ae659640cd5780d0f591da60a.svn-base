<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <!--<small>Painel de Controle</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Perfil</li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?= base_url('img/Sem Título-2.jpg'); ?>" alt="User profile picture">

                        <h3 class="profile-username text-center"><?= $this->session->userdata['NOME_VENDEDOR'] ?></h3>

                        <p class="text-muted text-center">Representante</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Vendas Fechadas</b> <a class="pull-right"><span class="orcamentos"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Vendas Abertas</b> <a class="pull-right"><span class="novas_vendas"></span></a>
                            </li>
                            <li class="list-group-item">
                                <b>Vendas / Notas</b> <a class="pull-right"><span class="todas_vendas"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Todos Clientes</b> <a class="pull-right"><span class="todos_clientes"></a>
                            </li>
                        </ul>

                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sobre mim</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-book margin-r-5"></i> E-mail</strong>

                        <p class="text-muted">
                            <?= $this->session->userdata('EMAIL_VENDEDOR'); ?>
                        </p>

                        <hr>

                        <strong><i class="fa fa-map-marker margin-r-5"></i> Localização</strong>

                        <p class="text-muted"><?= $this->session->userdata('CIDADE'); ?>, <?= $this->session->userdata('ESTADO_VENDEDOR'); ?></p>

                        <hr>

<!--                        <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

                        <p>
                            <span class="label label-danger">UI Design</span>
                            <span class="label label-success">Coding</span>
                            <span class="label label-info">Javascript</span>
                            <span class="label label-warning">PHP</span>
                            <span class="label label-primary">Node.js</span>
                        </p>

                        <hr>-->

<!--                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Observações</strong>

                        <p><?= $this->session->userdata('OBSERVACOES'); ?></p>-->
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="settings">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Nome</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName" placeholder="Nome">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Assunto</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName" placeholder="Assunto">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputExperience" class="col-sm-2 control-label">Mensagem</label>

                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputExperience" placeholder="Mensagem"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger btn-enviar-email">Enviar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
</div>