<?php
    session_start();

    if(isset($_SESSION["usuariologado"])) 
        unset($_SESSION["usuariologado"]) 
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Estoque Fácil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Styles -->
  <link rel="stylesheet" type="text/css" media="screen" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="css/jquery.loading.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome-animation.min.css" />
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
  <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
  <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
  
  <!-- Scripts --> 
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>

  <!-- Font Awesome JS -->
  <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/solid.js" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/fontawesome.js"crossorigin="anonymous"></script>

  <script src="js/main.js"></script>
  <script src="js/jquery.loading.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      
    });
  </script>

</head>

<body>
    <!--TELA PRINCIPAL -->
    <div class="container">

        <div class="jumbotron">
            <h1 class="display-4">Seja bem vindo ao Estoque Fácil!</h1>
            <p class="lead">Controle seu estoque de maneira simples e fácil.</p>
            <hr class="my-4">
            <p>Vamos acessar?</p>
        </div>

        <div id="painellogin">
            <form id="formlogin">
                <div class="form-group">
                    <label for="usuario" class="required">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Informe seu usuário" required>
                </div>
                <div class="form-group">
                    <label for="senha" class="required">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Informe sua senha">
                </div>
                <button type="button" onclick="validarCamposLogin()" class="btn btn-primary">Acessar</button>
                
            </form>
        </div>
        
    </div>
    <!--FIM TELA PRINCIPAL -->

</body>

</html>
