<html lang="pt"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="96x96" href="{{PASTA_PUBLIC}}/arquivos/assets/img/favicon.png">
    

    <title>@yield('titulo')</title>

    <!-- Bootstrap core CSS -->
   <link  href="{{PASTA_PUBLIC}}/arquivos/assets/css/bootstrap.min.css" rel="stylesheet" />
   <link  href="{{PASTA_PUBLIC}}/arquivos/assets/css/signin.css" rel="stylesheet" />


    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

  </head>

  <body cz-shortcut-listen="true">

    <div class="container">

    <div class="form-signin">
        <h2 class="form-signin-heading">Login</h2>
        <label for="inputEmail" class="sr-only">Email</label>
        <input type="text" id="txtemail" class="form-control" placeholder="Email" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" id="txtsenha" class="form-control" placeholder="Senha" required="">
        <!-- <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div> -->
        <button class="btn btn-lg btn-primary btn-block" onclick="logar()">Entrar</button>
    </div>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <!--   Core JS Files   -->
    <script src="{{PASTA_PUBLIC}}/arquivos/assets/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="{{PASTA_PUBLIC}}/arquivos/assets/js/bootstrap.min.js" type="text/javascript"></script>

</html>



</body></html>

