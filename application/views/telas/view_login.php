
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?= base_url('bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url('bower_components/font-awesome/css/font-awesome.min.css'); ?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?= base_url('bower_components/Ionicons/css/ionicons.min.css'); ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('dist/css/AdminLTE.min.css'); ?>">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= base_url('plugins/iCheck/square/blue.css'); ?>">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <link rel="shortcut icon" href="https://ingasoft.com.br/images/ico/inga.png"/>
        <link rel="apple-touch-icon" href="https://ingasoft.com.br/images/ico/inga.png"/>
        <link rel="apple-touch-icon" sizes="72x72" href="http://ingasoft.com.br/images/ico/inga.png"/>
        <link rel="apple-touch-icon" sizes="114x114" href="https://ingasoft.com.br/images/ico/inga.png"/>
        <script>
            var URL = "<?= base_url(); ?>"
        </script>
    </head>
    <!--<body class="hold-transition login-page">-->
    <body class="">
        <div class="modal modal-default fade" id="modal-default">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #3c8dbc; color: white">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>Escolher filial de acesso</b></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Filial:</label>
                                <select id="empresaAcesso" class="form-control" style="width: 100%;">
                                    <option value="">Selecione uma empresa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-validar-entrar-sistema" class="btn btn-primary pull-right" data-dismiss="modal">Entrar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal modal-success fade" id="modal-success">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-refresh fa-spin"></i></h4>
                    </div>
                    <div class="modal-body">
                        <p>Logado com sucesso !</p>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="row" style="background-color: #367fa9;">
            <div class="col-md-12">
                <div class="btn">
                    <img width="300" height="70" class="img-responsive" src="<?= base_url('img/logo-inga.png'); ?>" />
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="container">
                <div class="col-md-6" style="margin-top: 50px;">
                    <img class="img-responsive" src="data:image/jpge;base64,<?= base64_encode($parametros[0]['LOGOMARCA']); ?>" />
                </div>
                <!--<div class="col-md-6 login-page" style="margin-top: 100px; background-color: #d2d6de">-->
                <div class="col-md-5" style="margin-top: 50px; border: 1px solid #d2d6de">
                    <div class="login-box">
                        <div class="login-logo">
                            <a href="<?= base_url('login'); ?>"><b><i>SISTEMA ONLINE</i></b></a>
                        </div>
                        <!-- /.login-logo -->
                        <div class="login-box-body">
                            <p class="login-box-msg">Faça login para iniciar sua sessão</p>
                            <div class="form-group has-error erro hidden">
                                <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> Usuário/senha inválido ou sem permissão para acessar empresa!</label>
                            </div>

                            <div class="form-group has-feedback validaUsuario">
                                <input type="email" name="usuario" class="form-control" placeholder="Usuário">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback validaSenha">
                                <input type="password" name="senha" class="form-control" placeholder="Senha">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="row">
                                <div class="col-xs-8">
                                </div>
                                <!-- /.col -->
                                <div class="col-xs-4">
                                    <a href="#" class="btn btn-primary btn-block btn-flat" id="entrarSistema">Validar</a>
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery 3 -->
        <script src="<?= base_url('bower_components/jquery/dist/jquery.min.js'); ?>"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?= base_url('bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>

