var despesasList = [];
var idDespesa = "";

function telaDespesa(id) {

    if(id == undefined) {
        idDespesa = "";
        elemento("descricao-desp").value = "";
        elemento("valor-desp").value = "";
        elemento("obs-desp").value = "";

    } else {
        idDespesa = id;
    }

    $("#modalDespesas").modal("toggle");
}

function buscarDespesas(){

    mostraLoading("paineldespesas", "Estamos localizando suas despesas");

    $.ajax({
        type: "GET",
        url: getUrlWS("despesa"),
        success: function(res){

            console.log(res);
            
            despesasList = [];

            fechaLoading("paineldespesas");

            if(res.empty || res.content.length <= 0) {
                mostraToastAviso('Nenhuma despesa encontrada');
            } else {
                for(var prop in res.content) {
                    despesasList.push(res.content[prop]);
                }
            }
            
            montaGridDespesas();
        },
        error: function(err){
            
            despesasList = [];
            montaGridDespesas();
            
            fechaLoading("paineldespesas");

            mostraToastErro((res.message ? res.message : 'Erro ao realizar a consulta'));
            console.error(err);

        },
        dataType: "json",
        contentType : "application/json"
      });		
}

function salvarDespesa() {

    mostraLoading('formdespesa', "Estamos cadastrando seu usuário");
    
    $.ajax({
        type: "POST",
        url: getUrlWS("despesa/"+idDespesa),
        data: JSON.stringify(getFormData("formdespesa")),
        success: function(res){

            fechaLoading("formdespesa");

            console.log(res);

            telaDespesa();
            buscarDespesas();
        },
        error: function(err){
            
            fechaLoading("formdespesa");

            var mensagemErro = 'Erro ao salvar a desepesa';

            if(err.responseJSON && err.responseJSON.message)
                mensagemErro = err.responseJSON.message;

            mostraToastErro(mensagemErro);
            console.error(err);
        },
        dataType: "json",
        contentType : "application/json"
    });    
    
}

function montaGridDespesas(){
 
    $("#gridDespesas").jsGrid({
        width: "100%",
        height: "530",
 
        inserting: false,
        editing: false,
        sorting: true,
        paging: false,
        noDataContent: "Nenhuma despesa encontrada",
        data: despesasList,
        rowClick: function(row) {

            console.log(row);

            elemento("descricao-desp").value = row.item.descricao;
            elemento("valor-desp").value = row.item.valor;
            elemento("obs-desp").value = row.item.observacoes;

            telaDespesa(row.item.id);
        },
        fields: [
            { name: "id", type: "text", width: 15, title : "Código" },
            { name: "descricao", type: "text", width: 50, title : "Descrição" },
            { name: "valor", type: "text", width: 50, title : "Valor" },
            { 
                name: "dataInclusao", type: "text", width: 50, title : "Data de Inclusão",
                itemTemplate: function(value, item)  {
                    return new Date(value).toLocaleDateString();
                }
            },
            { 
                name: "", 
                title: "Editar", 
                width: 30,
                headerTemplate: function() {
                    return "<span title='Editar Despesa'>Editar</span>"
                },
                itemTemplate: function(value, item) { 
                    return '<i class="fas fa-pen"></i>';
                }
            }
        ]
    });
}