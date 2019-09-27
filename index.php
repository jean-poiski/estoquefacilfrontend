<?php
    session_start();

    if(!isset($_SESSION["usuariologado"])) {
        header("Location: login.php");
        die();
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Estoque Fácil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
  <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

  <script src="js/main.js"></script>
  <script src="js/jquery.loading.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      
    });
  </script>

</head>

<body>
    <div class="jumbotron">

    </div>

    <!--TELA PRINCIPAL -->
    <div class="container">

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
            <a class="nav-link active" id="pills-produto-tab" data-toggle="pill" href="#pills-produto" role="tab" aria-controls="pills-produto" aria-selected="true">Produtos</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" id="pills-estoque-tab" data-toggle="pill" href="#pills-estoque" role="tab" aria-controls="pills-estoque" aria-selected="false">Controle do Estoque</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" id="pills-vendas-tab" data-toggle="pill" href="#pills-vendas" role="tab" aria-controls="pills-vendas" aria-selected="false">Vendas</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" id="pills-despesas-tab" data-toggle="pill" href="#pills-despesas" role="tab" aria-controls="pills-despesas" aria-selected="false">Despesas</a>
            </li>
        </ul>
        <!--
            
        <div class="col-md-12 col-sm-6">
          <div class="alert alert-danger fade show" role="alert">
            Campos marcados com <span class="required"></span> são obrigatórios <i class="far fa-smile-wink"></i>
          </div>
        </div>
        -->
      

        <div class="col-md-12 col-sm-6">

          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-produto" role="tabpanel" aria-labelledby="pills-produto-tab">
            </div>

            <div class="tab-pane fade" id="pills-estoque" role="tabpanel" aria-labelledby="pills-despesas-tab">

              <div class="row">
                <div class="col-md-12 col-sm-6">
                
                </div>              
              </div>

              <div class="row">
                <div class="col-md-12 col-sm-6">
                  <button type="button" class="btn btn-secondary" onclick="trocarGuias('pills-produto-tab')"> <i class="fas fa-angle-left"></i> Voltar </button>
                  <button type="button" class="btn btn-secondary float-right" onclick="trocarGuias('pills-vendas-tab')"> Próximo <i class="fas fa-angle-right"></i> </button>
                </div>
              </div>

            </div>

            <div class="tab-pane fade" id="pills-vendas" role="tabpanel" aria-labelledby="pills-vendas-tab">

            </div>
            <div class="tab-pane fade" id="pills-despesas" role="tabpanel" aria-labelledby="pills-despesas-tab">
              
            </div>
          </div>

        </div>
    </div>

    <!--FIM TELA PRINCIPAL -->



<!-- MODAL DE LOGIN -->
<div class="modal fade" id="modalHistoricos" tabindex="-1" role="dialog" aria-labelledby="modalHistoricosTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalHistoricosTitle">Histórico do Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body container-fluid" style="max-width: 100%; overflow-x: auto;">

        <div id="gridHistoricos"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>    

</body>

</html>
