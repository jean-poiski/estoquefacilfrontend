<?php
    session_start();

    if(!isset($_SESSION["usuariologado"])) {
        header("Location: login.php");
        die();
    }

    function retornarTitulo() {
      $usuarioTitulo = $_SESSION["usuariologado"];

      /*$meioDia = date('Y-m-d') . ' 12:00:00' ;
      $horaNoite = date('Y-m-d') . ' 18:00:00';
      
      $dataAtual = date('Y-m-d H:i:s');
      if(strtotime($dataAtual) >= strtotime($horaNoite))
        return "Boa noite $usuarioTitulo";

      if(strtotime($dataAtual) >= strtotime($meioDia))
        return "Boa tarde $usuarioTitulo";*/

      return "Olá $usuarioTitulo";
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
  <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/solid.js" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/fontawesome.js" crossorigin="anonymous"></script>

  <script src="js/main.js"></script>
  <script src="js/despesas.js"></script>
  <script src="js/produtos.js"></script>
  <script src="js/entradaestoque.js"></script>
  <script src="js/saidaestoque.js"></script>
  <script src="js/jquery.loading.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      montaGridProdutos();
      montaGridDespesas();
      montaGridEntradaEstoqs();
      montaGridSaidaEstoqs();
      montaGridSelecionaProdutos('gridProdutoEntrada', []);
      montaGridSelecionaProdutos('gridProdutoSaida', []);

      $('#valor-desp').inputmask({
        alias: 'numeric', 
        allowMinus: false,  
        digits: 2, 
        max: 999.99
      });

      $('#valor-produto').inputmask({
        alias: 'numeric', 
        allowMinus: false,  
        digits: 2, 
        max: 999.99
      });

      $('#valor-entrada').inputmask({
        alias: 'numeric', 
        allowMinus: false,  
        digits: 2, 
        max: 999.99
      });

      $('#valor-saida').inputmask({
        alias: 'numeric', 
        allowMinus: false,  
        digits: 2, 
        max: 999.99
      });


    });
  </script>

</head>

<body>

    <!--TELA PRINCIPAL -->
    <div class="container">
      <div class="jumbotron">
        <h1 class="display-4">Estoque Fácil!</h1>
        <p class="lead"><?php echo retornarTitulo(); ?> <button type="button" class="btn btn-info btn-sm float-right" onclick="navegarPara('login.php')">Sair do Sistema</button></p>
        <hr class="my-4">
        
      </div>

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

              <div id="painelprodutos">
                <div class="form-group row">
                  <div class="col-md-12 col-sm-6">
                    <button type="button" class="btn btn-primary" onclick="buscarProdutos()"><i class="fas fa-search"></i> Atualizar Lista</button>
                    <button type="button" class="btn btn-primary" onclick="telaProduto()"><i class="fas fa-bacon"></i> Cadastrar Produto</button>
                  </div>
                </div>

                <div class="row pt-0 mt-0">
                  <div class="col-md-12 col-sm-6 text-center">
                    <div id="gridProdutos"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="pills-estoque" role="tabpanel" aria-labelledby="pills-estoque-tab">
              

              <ul class="nav nav-pills mb-3" id="pills-entradasaida" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="pills-entradaestoque-tab" data-toggle="pill" href="#pills-entradaestoque" role="tab" aria-controls="pills-entradaestoque" aria-selected="true">Entrada</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="pills-saidaestoque-tab" data-toggle="pill" href="#pills-saidaestoque" role="tab" aria-controls="pills-saidaestoque" aria-selected="false">Saída</a>
                </li>
              </ul>
              
              <div class="tab-content" id="pills-tabContentEntradaSaida">

                <div class="tab-pane fade show active" id="pills-entradaestoque" role="tabpanel" aria-labelledby="pills-entradaestoque-tab">

                  <div id="painelentradas">
                    <div class="form-group row">
                      <div class="col-md-12 col-sm-6">
                        <button type="button" class="btn btn-primary" onclick="buscarEntradaEstoqs()"><i class="fas fa-search-dollar"></i> Atualizar Lista</button>
                        <button type="button" class="btn btn-primary" onclick="telaEntradaEstoq()"><i class="fas fa-plus"></i></i> Registrar Entrada</button>
                      </div>
                    </div>

                    <div class="row pt-0 mt-0">
                      <div class="col-md-12 col-sm-6 text-center">
                        <div id="gridEntradaEstoque"></div>
                      </div>
                    </div>
                  </div>
                </div>  

                <div class="tab-pane fade" id="pills-saidaestoque" role="tabpanel" aria-labelledby="pills-saidaestoque-tab">


                  <div id="painelsaidas">
                    <div class="form-group row">
                      <div class="col-md-12 col-sm-6">
                        <button type="button" class="btn btn-primary" onclick="buscarSaidaEstoqs()"><i class="fas fa-search-dollar"></i> Atualizar Lista</button>
                        <button type="button" class="btn btn-primary" onclick="telaSaidaEstoq()"><i class="fas fa-plus"></i></i> Registrar Saída</button>
                      </div>
                    </div>

                    <div class="row pt-0 mt-0">
                      <div class="col-md-12 col-sm-6 text-center">
                        <div id="gridSaidaEstoque"></div>
                      </div>
                    </div>
                  </div>

                 
                </div>
              
              </div>



            </div>

            <div class="tab-pane fade" id="pills-vendas" role="tabpanel" aria-labelledby="pills-vendas-tab">
              <p>EM BREVE</p>
            </div>

            <!-- GUIA DESPESAS -->
            <div class="tab-pane fade" id="pills-despesas" role="tabpanel" aria-labelledby="pills-despesas-tab">

              <div id="paineldespesas">
                <div class="form-group row">
                  <div class="col-md-12 col-sm-6">
                    <button type="button" class="btn btn-primary" onclick="buscarDespesas()"><i class="fas fa-search-dollar"></i> Atualizar Lista</button>
                    <button type="button" class="btn btn-primary" onclick="telaDespesa()"><i class="fas fa-money-bill-wave"></i> Cadastrar Despesa</button>
                  </div>
                </div>

                <div class="row pt-0 mt-0">
                  <div class="col-md-12 col-sm-6 text-center">
                    <div id="gridDespesas"></div>
                  </div>
                </div>
              </div>


            </div>

          </div>

        </div>
    </div>

    <!--FIM TELA PRINCIPAL -->



<!-- MODAL DE DESPESA -->
<div class="modal fade" id="modalDespesas" tabindex="-1" role="dialog" aria-labelledby="modalDespesasTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDespesasTitle">Nova Despesa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body container-fluid" style="max-width: 100%; overflow-x: auto;">

      <form id="formdespesa">
        
        <div class="form-group">
            <label for="descricao-desp" class="required">Descrição</label>
            <input type="text" class="form-control" id="descricao-desp" name="descricao" placeholder="Descrição da despesa" required>
        </div>
        <div class="form-group">
            <label for="valor-desp" class="required">Valor</label>
            <input type="text" class="form-control numeric" id="valor-desp" name="valor" placeholder="Valor da despesa">
            <input type="hidden" id="usuario-inc-desp" name="usuarioInclusao" value="<?php echo $_SESSION["usuariologado"]; ?>">
        </div>

        <div class="form-group">
          <label for="obs-desp">Observações</label>
          <textarea class="form-control" id="obs-desp" name="observacoes" rows="3"></textarea>
        </div>        
              
      </form>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="salvarDespesa()">Salvar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>    



<!-- MODAL DE PRODUTO -->
<div class="modal fade" id="modalProdutos" tabindex="-1" role="dialog" aria-labelledby="modalProdutosTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalProdutosTitle">Novo Produto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body container-fluid" style="max-width: 100%; overflow-x: auto;">

      <form id="formproduto">
        
        <div class="form-group">
            <label for="descricao-produto" class="required">Descrição</label>
            <input type="text" class="form-control" id="descricao-produto" name="descricao" placeholder="Descrição da produto" required>
            <input type="hidden" id="usuario-inc-desp" name="usuarioInclusao" value="<?php echo $_SESSION["usuariologado"]; ?>">
        </div>

        <div class="form-group">
            <label for="codigobarra-produto" class="required">Código de Barras</label>
            <input type="text" class="form-control" id="codigobarra-produto" name="codigoBarras" placeholder="Código de barras" required>
        </div>
        <div class="form-group">
            <label for="valor-produto" class="required">Valor</label>
            <input type="text" class="form-control numeric" id="valor-produto" name="valor" placeholder="Valor do Produto">
        </div>

        <div class="form-group">
          <label for="embalagem-produto">Embalagem</label>
          <select class="form-control" id="embalagem-produto" name="tipoEmbalagem">
            <option value="UNIDADE">Unidade</option>
            <option value="PESO">Peso</option>
            <option value="CAIXA">Caixa</option>
          </select>
        </div>        

        <div class="form-group">
          <label for="categoria-produto">Categoria</label>
          <select class="form-control" id="embalagem-produto" name="tipoProduto">
            <option value="ALIMENTO">Alimento</option>
            <option value="BEBIDA">Bebida</option>
            <option value="EQUIPAMENTO">Equipamento</option>
            <option value="OUTROS">Outros</option>
          </select>
        </div>        

        <div class="form-group">
          <label for="obs-produto">Observações</label>
          <textarea class="form-control" id="obs-produto" name="observacoes" rows="3"></textarea>
        </div>        

              
      </form>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="salvarProduto()">Salvar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>    




<!-- MODAL DE ENTRADA NO ESTOQUE -->
<div class="modal fade" id="modalEntradaEstoqs" tabindex="-1" role="dialog" aria-labelledby="modalEntradaEstoqsTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEntradaEstoqsTitle">Nova Entrada no Estoque</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body container-fluid" style="max-width: 100%; overflow-x: auto;">

      <form id="formentrada">
        
        <div class="form-group">
          <input type="hidden" id="usuario-inc-desp" name="usuarioInclusao" value="<?php echo $_SESSION["usuariologado"]; ?>">
        </div>

        <div class="form-group">
            <label for="entradaProdutdo" class="required">Produto</label>
            <input type="text" class="form-control" id="entradaProduto" placeholder="Pesquise pelo Código de barras ou Descrição do Produto" onkeypress="return buscaProdutoSimples(event);" required>
            <div id="painelprodutosentrada">
              <div class="row pt-0 mt-0">
                <div class="col-md-12 col-sm-6 text-center">
                  <div id="gridProdutoEntrada"></div>
                </div>
              </div>
            </div>
            <small id="selecao-produto-entrada" class="form-text text-muted"><div id="produto-selecionadogridProdutoEntrada">Nenhum produto selecionado</div></small>
        </div>
        
        <div class="form-group">
          <label for="qtd-entrada" class="required">Quantidade</label>
          <input type="number" class="form-control" id="qtd-entrada" name="quantidade" placeholder="Quantidade">
        </div>
        <div class="form-group">
          <label for="valor-entrada" class="required">Valor</label>
          <input type="text" class="form-control numeric" id="valor-entrada" name="valor" placeholder="Valor Unitário">
        </div>

      </form>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="salvarEntradaEstoq()">Salvar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>   

<!-- MODAL DE SAIDA NO ESTOQUE -->
<div class="modal fade" id="modalSaidaEstoqs" tabindex="-1" role="dialog" aria-labelledby="modalSaidaEstoqsTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalSaidaEstoqsTitle">Nova Saída no Estoque</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body container-fluid" style="max-width: 100%; overflow-x: auto;">

      <form id="formsaida">
        
        <div class="form-group">
          <input type="hidden" id="usuario-inc-desp" name="usuarioInclusao" value="<?php echo $_SESSION["usuariologado"]; ?>">
        </div>

        <div class="form-group">
            <label for="saidaProdutdo" class="required">Produto</label>
            <input type="text" class="form-control" id="saidaProduto" placeholder="Pesquise pelo Código de barras ou Descrição do Produto" onkeypress="return buscaProdutoSimples(event);" required>
            <div id="painelprodutosaida">
              <div class="row pt-0 mt-0">
                <div class="col-md-12 col-sm-6 text-center">
                  <div id="gridProdutoSaida"></div>
                </div>
              </div>
            </div>
            <small id="selecao-produto-saida" class="form-text text-muted"><div id="produto-selecionadogridProdutoSaida">Nenhum produto selecionado</div></small>
        </div>
        
        <div class="form-group">
          <label for="qtd-saida" class="required">Quantidade</label>
          <input type="number" class="form-control" id="qtd-saida" name="quantidade" placeholder="Quantidade">
        </div>
        <div class="form-group">
          <label for="valor-saida" class="required">Valor</label>
          <input type="text" class="form-control numeric" id="valor-saida" name="valor" placeholder="Valor Unitário">
        </div>

      </form>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="salvarSaidaEstoq()">Salvar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>   


</body>

</html>
