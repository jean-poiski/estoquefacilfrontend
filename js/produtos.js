var produtosList = [];
var idProduto = "";

var produtosEntrada = [];
var produtosSaida = [];
var produtoSelecionado = null;

function telaProduto(id) {

    if(id == undefined) {
        idProduto = "";
        document.forms["formproduto"].reset();

    } else {
        idProduto = id;
    }

    $("#modalProdutos").modal("toggle");
}

function buscarProdutos(){

    mostraLoading("painelprodutos", "Estamos localizando seus Produtos");

    $.ajax({
        type: "GET",
        url: getUrlWS("produto"),
        success: function(res){

            console.log(res);
            
            produtosList = [];

            fechaLoading("painelprodutos");

            if(res.empty || res.content.length <= 0) {
                mostraToastAviso('Nenhum produto encontrado');
            } else {
                for(var prop in res.content) {
                    produtosList.push(res.content[prop]);
                }
            }
            
            montaGridProdutos();
        },
        error: function(err){
            
            produtosList = [];
            montaGridProdutos();
            
            fechaLoading("painelprodutos");

            mostraToastErro((res.message ? res.message : 'Erro ao realizar a consulta'));
            console.error(err);

        },
        dataType: "json",
        contentType : "application/json"
      });		
}

function salvarProduto() {

    mostraLoading('formproduto', "Estamos cadastrando seu produto");
    
    $.ajax({
        type: "POST",
        url: getUrlWS("produto/"+idProduto),
        data: JSON.stringify(getFormData("formproduto")),
        success: function(res){

            fechaLoading("formproduto");

            console.log(res);

            telaProduto();
            buscarProdutos();
        },
        error: function(err){
            
            fechaLoading("formproduto");

            var mensagemErro = 'Erro ao salvar o produto';

            if(err.responseJSON && err.responseJSON.message)
                mensagemErro = err.responseJSON.message;

            mostraToastErro(mensagemErro);
            console.error(err);
        },
        dataType: "json",
        contentType : "application/json"
    });    
    
}

function apagarProduto(idProduto) {

    mostraLoading('painelproduto', "Estamos apagando seu produto");
    
    $.ajax({
        type: "DELETE",
        url: getUrlWS("produto/"+idProduto),
        success: function(res){

            fechaLoading("painelproduto");

            buscarProdutos();
        },
        error: function(err){
            
            fechaLoading("painelproduto");

            if(err.responseJSON && err.responseJSON.message) {
                mensagemErro = err.responseJSON.message;
                mostraToastErro(mensagemErro);
                console.error(err);
            } else
                buscarProdutos();

        },
        dataType: "json",
        contentType : "application/json"
    });    
    
}

function montaGridProdutos(){
 
    $("#gridProdutos").jsGrid({
        width: "100%",
        height: "530",
 
        inserting: false,
        editing: false,
        sorting: true,
        paging: false,
        noDataContent: "Nenhum produto encontrado",
        data: produtosList,
        rowClick: function(row) {

            console.log(row);

            var apagar = confirm("Deseja apagar o produto "+row.item.descricao+"?");

            if(apagar) {
                apagarProduto(row.item.id);
            }
        },
        fields: [
            { name: "id", type: "text", width: 15, title : "Código" },
            { name: "descricao", type: "text", width: 50, title : "Descrição" },
            { 
                name: "dataInclusao", type: "text", width: 50, title : "Data de Inclusão",
                itemTemplate: function(value, item)  {
                    return new Date(value).toLocaleDateString();
                }
            },
            { 
                name: "", 
                title: "Apagar", 
                width: 30,
                headerTemplate: function() {
                    return "<span title='Apagar Produto'>Apagar</span>"
                },
                itemTemplate: function(value, item) { 
                    return '<i class="fas fa-trash-alt"></i>';
                }
            }
        ]
    });
}

function montaGridSelecionaProdutos(idLista, listaProdutos){
 
    $(`#${idLista}`).jsGrid({
        width: "100%",
        height: "130",
 
        inserting: false,
        editing: false,
        sorting: true,
        selecting:true,
        paging: false,
        noDataContent: "Nenhum produto encontrado",
        data: listaProdutos,
        rowClick: function(args) {
            produtoSelecionado = args.item;
            $(`#produto-selecionado${idLista}`).text(`Produto selecionado: ${args.item.id} - ${args.item.descricao}`);
        },        
        fields: [
            { name: "id", type: "text", width: 15, title : "Código" },
            { name: "descricao", type: "text", width: 50, title : "Descrição" }
        ]
    });
}

function buscaProdutoSimples(event){
    if(event.keyCode == 13) {
        buscarProdutosCodBarrasDescricao(event.path[0].id);
    }
}

function buscarProdutosCodBarrasDescricao(campo) {
    
    var bProdutosEntrada = (campo == "entradaProduto");
    
    idLista = (bProdutosEntrada ? "gridProdutoEntrada" : "gridProdutoSaida");
    idLoading = (bProdutosEntrada ? "painelprodutosentrada" : "painelprodutosaida");

    mostraLoading(idLoading, "Procurando produtos");
    
    $.ajax({
        type: "GET",
        url: getUrlWS("produto/buscaDsCdBarra/"+elemento(campo).value),
        success: function(res){
            
            produtosEntrada = [];
            produtosSaida = [];

            fechaLoading(idLoading);

            if(!res || res.length <= 0) {
                mostraToastAviso('Nenhum produto encontrado');
            } else {
                for(var prop in res) {
                    if(bProdutosEntrada)
                        produtosEntrada.push(res[prop]);
                    else
                        produtosSaida.push(res[prop]);
                }
            }
            
            montaGridSelecionaProdutos(idLista, (bProdutosEntrada ? produtosEntrada : produtosSaida));
        },
        error: function(err){
            
            produtosEntrada = [];
            produtosSaida = [];

            montaGridSelecionaProdutos(idLista, [])
            
            fechaLoading(idLoading);

            mostraToastErro((res.message ? res.message : 'Erro ao realizar a consulta'));
            console.error(err);

        },
        dataType: "json",
        contentType : "application/json"
      });
}