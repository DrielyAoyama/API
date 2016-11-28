<!doctype html>
<html lang="pt">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/img/apple-icon.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>ServiceAPI - <?php echo $__env->yieldContent('titulo'); ?></title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link  href="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/css/bootstrap.min.css" rel="stylesheet" />


    <!-- Animation library for notifications   -->
    <link  href="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/css/animate.min.css" rel="stylesheet" />


    <!--  Paper Dashboard core CSS    -->
    <link  href="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/css/paper-dashboard.css" rel="stylesheet" />


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link  href="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/css/demo.css" rel="stylesheet" />


    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link  href="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/css/themify-icons.css" rel="stylesheet" />


</head>
<body>

<div class="wrapper">
	<div class="sidebar" data-background-color="white" data-active-color="danger">

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="<?php echo e(asset('')); ?>" class="simple-text">
                    ServiceAPI
                </a>
            </div>

            <ul class="nav">
                <li  id="MENUPRINCIPALCONTROLLER">
                    <a href="<?php echo e(asset('')); ?>">
                        <i class="ti-pie-chart"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li id="MENUTESTESCONTROLLER">
                    <a href="<?php echo e(asset('testes')); ?>" >
                        <i class="ti-align-justify"></i>
                        <p>Testes</p>
                    </a>
                </li>

            </ul>
    	</div>
    </div>

    <div class="main-panel">
		<nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand"><?php echo $__env->yieldContent('titulo'); ?></a>
                </div>
               <ul class="nav navbar-nav navbar-right">
                        
                        <li>
                            <a href="<?php echo e(asset('usuarios/sair')); ?>">
                                <i class="ti-close"></i>
                                <p>Sair</p>
                            </a>
                        </li>
                    </ul>
            </div>


        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
					<?php echo $__env->yieldContent('conteudo'); ?>		
                </div>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
  
                </nav>
				<div class="copyright pull-right">
                  
                </div>
            </div>
        </footer>

    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/js/bootstrap-checkbox-radio.js"></script>

	<!--  Charts Plugin -->
	<script src="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/js/paper-dashboard.js"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/js/demo.js"></script>
	<script src="<?php echo e(PASTA_PUBLIC); ?>/arquivos/assets/js/custom.js"></script>


</html>



<div class="modal fade" id="mensagem1" role="dialog">
  <div class="modal-dialog modal-sm">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title centro">
          <div id="titulo_msg1"></div>
        </h4>
      </div>
      <div class="modal-body">
        <p><div id="msg_msg1"></div></p>
      </div>
      <div  class="modal-footer" id="btn_msg1">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
        <button  id="btn_confirmar_mensagem1"  type="button" onclick="excluir()" data-dismiss="modal" class="btn btn-primary">Sim</button>
      </div>
    </div>    
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mensagem2" role="dialog">
  <div class="modal-dialog modal-sm">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title centro">
          <div id="titulo_msg2"></div>
        </h4>
      </div>
      <div class="modal-body">
        <p><div id="msg_msg2"></div></p>
      </div>
      <div  class="modal-footer">
        <button  id="btn_voltar_mensagem2" type="button" class="btn btn-danger" data-dismiss="modal">Voltar</button>
      </div>
    </div>    
  </div>
</div>

