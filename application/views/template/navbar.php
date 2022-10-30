<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<!--<body class="hold-transition skin-blue sidebar-mini">-->
<div class="wrapper">
<header class="main-header">
    <!-- Logo -->
    <a href="<?= base_url('dashboard'); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b><?php echo substr($this->session->userdata('NOME_FANTASIA'), 0, 2); ?></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b><?= $this->session->userdata('NOME_FANTASIA'); ?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!--<img src="<?php echo base_url('img/Sem Título-2.jpg'); ?>" class="user-image" alt="User Image">-->
                        <span class="hidden-xs"><b><?php echo  $this->session->userdata('COD_EMPRESA').'-'.$this->session->userdata('NOME_FANTASIA'); ?></b></span>
                    </a>
                </li>

                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning"><?php echo count(isset($novidades)); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="header">Você tem notificações</li>
                        <li>
                            <ul class="menu">
                                <?php
                                if (isset($novidades)){
                                    foreach ($novidades as $novidade) { ?>
                                        <li><!-- start message -->
                                            <a href="#" title="<?php echo ucfirst(strtolower($novidade['descricao'])); ?>">
                                                <div class="pull-left">
                                                    <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                                </div>
                                                <h4>
                                                    <?php echo ucwords(strtolower($novidade['nome'])) . ' | V.: ' . $novidade['versao']; 
                                                    $data = date_create($novidade['data_cadastro']);
                                                    ?>
                                                    <small><i class="fa fa-clock-o"></i> <?php echo date_format($data, 'd/m/Y'); ?></small>
                                                </h4>
                                                <p><?php echo substr(ucfirst(strtolower($novidade['descricao'])), 0, 35); ?>...</p>
                                            </a>
                                        </li>
                                    <?php }
                                }?>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">Ver todos</a></li>
                    </ul>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!--<img src="<?php echo base_url('img/Sem Título-2.jpg'); ?>" class="user-image" alt="User Image">-->
                        <span class="hidden-xs"><?= $this->session->userdata()['NOME'] ?></span> <i class="fa fa-angle-double-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo base_url('img/Sem Título-2.jpg'); ?>" class="img-circle" alt="User Image">

                            <p>
                                <?= $this->session->userdata()['NOME_VENDEDOR'] ?> - Representante
                                <small><?= date('m/d/Y'); ?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
<!--                            <div class="pull-left">
                                <a href="<?= base_url('perfilUsuario'); ?>" class="btn btn-default btn-flat">Perfil</a>
                            </div>-->
                            <div class="pull-right">
                                <a href="<?= base_url('logout'); ?>" class="btn btn-default btn-flat">Sair</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
<!--                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>-->
            </ul>
        </div>
    </nav>
</header>