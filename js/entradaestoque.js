var entradasList = [];
var idEntradaEstoq = "";

function telaEntradaEstoq(id) {

    produtosEntrada = [];
    produtoSelecionado = null;

    $(`produto-selecionadogridProdutoEntrada`).text(`Nenhum produto selecionado`)

    montaGridSelecionaProdutos("gridProdutoEntrada", []);

    if(id == undefined) {
        idEntradaEstoq = "";
        document.forms["formentrada"].reset();

        elemento("entradaProduto").focus();
    } else {
        idEntradaEstoq = id;
    }

    $("#modalEntradaEstoqs").modal("toggle");
}

function buscarEntradaEstoqs(){

    mostraLoading("painelentradas", "Estamos localizando as Entradas no estoque");

    $.ajax({
        type: "GET",
        url: getUrlWS("estoque/entrada"),
        success: function(res){

            console.log(res);
            
            entradasList = [];

            fechaLoading("painelentradas");

            if(res.empty || res.content.length <= 0) {
                mostraToastAviso('Nenhum entrada encontrado');
            } else {
                for(var prop in res.content) {
                    entradasList.push(res.content[prop]);
                }
            }
            
            montaGridEntradaEstoqs();
        },
        error: function(err){
            
            entradasList = [];
            montaGridEntradaEstoqs();
            
            fechaLoading("painelentradas");

            mostraToastErro((res.message ? res.message : 'Erro ao realizar a consulta'));
            console.error(err);

        },
        dataType: "json",
        contentType : "application/json"
      });		
}

function salvarEntradaEstoq() {

    mostraLoading('formentrada', "Estamos registrando a entrada no estoque");
    
    dados = getFormData("formentrada");
    dados["valor"] = new Number(dados["valor"]);
    dados["quantidade"] = new Number(dados["quantidade"]);
    dados["produto"] = produtoSelecionado;

    $.ajax({
        type: "POST",
        url: getUrlWS("estoque/entrada/"+idEntradaEstoq),
        data: JSON.stringify(dados),
        success: function(res){

            fechaLoading("formentrada");

            console.log(res);

            telaEntradaEstoq();
            buscarEntradaEstoqs();
        },
        error: function(err){
            
            fechaLoading("formentrada");

            var mensagemErro = 'Erro ao salvar o entrada';

            if(err.responseJSON && err.responseJSON.message)
                mensagemErro = err.responseJSON.message;

            mostraToastErro(mensagemErro);
            console.error(err);
        },
        dataType: "json",
        contentType : "application/json"
    });    
    
}

function apagarEntradaEstoq(idEntradaEstoq) {

    mostraLoading('painelentrada', "Estamos apagando seu entrada");
    
    $.ajax({
        type: "DELETE",
        url: getUrlWS("estoque/entrada/"+idEntradaEstoq),
        success: function(res){

            fechaLoading("painelentrada");

            buscarEntradaEstoqs();
        },
        error: function(err){
            
            fechaLoading("painelentrada");

            if(err.responseJSON && err.responseJSON.message) {
                mensagemErro = err.responseJSON.message;
                mostraToastErro(mensagemErro);
                console.error(err);
            } else
                buscarEntradaEstoqs();

        },
        dataType: "json",
        contentType : "application/json"
    });    
    
}

function montaGridEntradaEstoqs(){
 
    $("#gridEntradaEstoque").jsGrid({
        width: "100%",
        height: "530",
 
        inserting: false,
        editing: false,
        sorting: true,
        paging: false,
        noDataContent: "Nenhuma entrada no estoque",
        data: entradasList,
        rowClick: function(row) {

            var apagar = confirm("Deseja a entrada no estoque "+row.item.id+"?");

            if(apagar) {
                apagarEntradaEstoq(row.item.id);
            }
        },
        fields: [
            { name: "id", type: "text", width: 15, title : "Código" },
            { 
                name: "produto", type: "text", width: 50, title : "Produto",
                itemTemplate: function(value, item)  {
                    return item.produto.descricao;
                }

            },
            { name: "quantidade", type: "text", width: 15, title : "Qtd." },
            { name: "valor", type: "text", width: 25, title : "Valor Unitário" },
            { 
                name: "valorTotal", type: "text", width: 25, title : "Total",
                itemTemplate: function(value, item)  {
                    return value.toFixed(2);
                }

            },
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
                    return "<span title='Apagar Entrada do estoque'>Apagar</span>"
                },
                itemTemplate: function(value, item) { 
                    return '<i class="fas fa-trash-alt"></i>';
                }
            }
        ]
    });
}