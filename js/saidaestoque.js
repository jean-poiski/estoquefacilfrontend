var saidasList = [];
var idSaidaEstoq = "";

function telaSaidaEstoq(id) {

    produtosSaida = [];
    produtoSelecionado = null;

    $(`produto-selecionadogridProdutoSaida`).text(`Nenhum produto selecionado`)

    montaGridSelecionaProdutos("gridProdutoSaida", []);

    if(id == undefined) {
        idSaidaEstoq = "";
        document.forms["formsaida"].reset();

        elemento("saidaProduto").focus();
    } else {
        idSaidaEstoq = id;
    }

    $("#modalSaidaEstoqs").modal("toggle");
}

function buscarSaidaEstoqs(){

    mostraLoading("painelsaidas", "Estamos localizando as Saídas no estoque");

    $.ajax({
        type: "GET",
        url: getUrlWS("estoque/saida"),
        success: function(res){

            console.log(res);
            
            saidasList = [];

            fechaLoading("painelsaidas");

            if(res.empty || res.content.length <= 0) {
                mostraToastAviso('Nenhuma saída encontrada');
            } else {
                for(var prop in res.content) {
                    saidasList.push(res.content[prop]);
                }
            }
            
            montaGridSaidaEstoqs();
        },
        error: function(err){
            
            saidasList = [];
            montaGridSaidaEstoqs();
            
            fechaLoading("painelsaidas");

            mostraToastErro((res.message ? res.message : 'Erro ao realizar a consulta'));
            console.error(err);

        },
        dataType: "json",
        contentType : "application/json"
      });		
}

function salvarSaidaEstoq() {

    mostraLoading('formsaida', "Estamos registrando a saida no estoque");
    
    dados = getFormData("formsaida");
    dados["valor"] = new Number(dados["valor"]);
    dados["quantidade"] = new Number(dados["quantidade"]);
    dados["produto"] = produtoSelecionado;

    $.ajax({
        type: "POST",
        url: getUrlWS("estoque/saida/"+idSaidaEstoq),
        data: JSON.stringify(dados),
        success: function(res){

            fechaLoading("formsaida");

            console.log(res);

            telaSaidaEstoq();
            buscarSaidaEstoqs();
        },
        error: function(err){
            
            fechaLoading("formsaida");

            var mensagemErro = 'Erro ao salvar a saída';

            if(err.responseJSON && err.responseJSON.message)
                mensagemErro = err.responseJSON.message;

            mostraToastErro(mensagemErro);
            console.error(err);
        },
        dataType: "json",
        contentType : "application/json"
    });    
    
}

function apagarSaidaEstoq(idSaidaEstoq) {

    mostraLoading('painelsaida', "Estamos apagando seu saida");
    
    $.ajax({
        type: "DELETE",
        url: getUrlWS("estoque/saida/"+idSaidaEstoq),
        success: function(res){

            fechaLoading("painelsaida");

            buscarSaidaEstoqs();
        },
        error: function(err){
            
            fechaLoading("painelsaida");

            if(err.responseJSON && err.responseJSON.message) {
                mensagemErro = err.responseJSON.message;
                mostraToastErro(mensagemErro);
                console.error(err);
            } else
                buscarSaidaEstoqs();

        },
        dataType: "json",
        contentType : "application/json"
    });    
    
}

function montaGridSaidaEstoqs(){
 
    $("#gridSaidaEstoque").jsGrid({
        width: "100%",
        height: "530",
 
        inserting: false,
        editing: false,
        sorting: true,
        paging: false,
        noDataContent: "Nenhuma saida no estoque",
        data: saidasList,
        rowClick: function(row) {

            var apagar = confirm("Deseja a saida no estoque "+row.item.id+"?");

            if(apagar) {
                apagarSaidaEstoq(row.item.id);
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
                    return "<span title='Apagar Saída do estoque'>Apagar</span>"
                },
                itemTemplate: function(value, item) { 
                    return '<i class="fas fa-trash-alt"></i>';
                }
            }
        ]
    });
}