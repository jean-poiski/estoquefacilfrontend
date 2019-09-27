
var pedidos = [];
var historicos = [];

function elemento( el ){
	return document.getElementById( el );
}

function isEmpty(obj) {
    return (obj == undefined || obj == null || obj == "");
}

function mostraToastAviso(mensagem) {
    mostraToast(mensagem, "warning");
}

function mostraToastErro(mensagem) {
    mostraToast(mensagem, "error");
}

function mostraToast(mensagem, tipo="success") {
    toastr[tipo](mensagem);
}


function validarCamposLogin(){
    var formValido = true;

    formValido = document.forms["formlogin"].checkValidity();

    if(formValido)
        efetuarLogin();
    else
        mostraToastAviso("Você preencheu seu usuário e sua senha?");

    return formValido;
}

function mostraLoading(painel, mensagem) {
    $(`#${painel}`).loading({
        message: `<i class="fa fa-dolly faa-passing animated"></i> ${mensagem}`
    });
}

function fechaLoading(painel) {
    $(`#${painel}`).loading('toggle');
}

function efetuarLogin() {

    mostraLoading('painellogin', "Acessando sistema...");

    $.ajax({
        type: "POST",
        url: "http://localhost:8080/usuario/logar/",
        data: JSON.stringify(getFormData("formlogin")),
        success: function(res){

            fechaLoading("painellogin");

            $.ajax({
                type: "POST",
                url: "./confirmalogin.php",
                data: JSON.stringify(getFormData("formlogin")),
                success: function(res){
                    window.location.href = "http://localhost:8081/estoquefacilfrontend/index.php";
                },
                error: function(err){
                    console.error(err);
                },
                dataType: "json",
                contentType : "application/json"
              });	            


        },
        error: function(err){
            
            fechaLoading("painellogin");

            var mensagemErro = 'Erro ao logar contate o administrador';

            if(err.responseJSON && err.responseJSON.message)
                mensagemErro = err.responseJSON.message;

            mostraToastErro(mensagemErro);
            console.error(err);
        },
        dataType: "json",
        contentType : "application/json"
      });    
}


function mostrarGridPedidos(){
 
    $("#jsGrid").jsGrid({
        width: "100%",
        height: "100%",
 
        inserting: false,
        editing: false,
        sorting: true,
        paging: false,
        noDataContent: "Nenhuma encomenda encontrada",
        data: pedidos,
        rowClick: function(row) {
            
            $("#modalHistoricos").modal("toggle");

            $("#gridHistoricos").jsGrid("loadData", {documentos: row.item.minuta});

        },
        fields: [
            { name: "minuta", type: "text", width: 50, title : "Minuta" },
            { 
                name: "", 
                type: "text", 
                width: 150, 
                title: "CT-e",
                itemTemplate: function(value, item) {
                    return item.cte_numero + "-" +item.cte_serie;
                }
            },
            { 
                name: "", 
                title: "Ver", 
                width: 30,
                headerTemplate: function() {
                    return "<span title='Ver histórico de eventos'>Ver</span>"
                },
                itemTemplate: function(value, item) { 
                    return '<i class="fas fa-search-plus"></i>';
                }
            }
        ]
    });
}

function mostrarGridHistoricos(){

    $("#gridHistoricos").jsGrid({
        width: "780",
        height: "300",

        inserting: false,
        editing: false,
        sorting: true,
        paging: false,
        noDataContent: "Nenhuma evento encontrado neste documento",
        loadMessage: "Aguarde, carregando eventos...",
 
        controller: {
            loadData: function(filter) {
                return $.ajax({
                    type: "POST",
                    url: "control/findevents.php",
                    data: JSON.stringify(filter),
                    success: function(res){
                    },
                    error: function(err){
                        mostraToastErro((res.message ? res.message : 'Erro ao realizar a consulta'));
                        console.error(err);
                    },
                    dataType: "json",
                    contentType : "application/json"
                  });	
            }
        },
 
        fields: [
            { 
                name: "data", 
                type: "text", 
                width: 17, 
                title: "Data",
                itemTemplate: function(value, item)  {
                    return new Date(value).toLocaleDateString();
                }
            },
            { name: "hora", type: "text", width: 10, title: "Hora" },
            { name: "evento", type: "text", width: 50, title: "Evento" },
            { name: "obs", type: "text", width: 50, title: "Observações" }
        ]
    });
}



function consultarTrackings(){

    $('#painelcompleto').loading({
        message: '<i class="fa fa-dolly faa-passing animated"></i> Estamos localizando suas encomendas'
    });


    $.ajax({
        type: "POST",
        url: "control/findtracking.php",
        data: JSON.stringify(getFormData()),
        success: function(res){

            pedidos = [];

            $('#painelcompleto').loading('toggle');

            if(!res.status) {
                mostraToastAviso((res.message ? res.message : 'Nenhuma encomenda encontrada'));
            } else if(res.dados.length <= 0) {
                mostraToastAviso('Nenhuma encomenda encontrada');
            } else {
                for(var prop in res.dados) {
                    pedidos.push(res.dados[prop]);
                }
            }
            
            mostrarGridPedidos();
        },
        error: function(err){
            
            pedidos = [];
            mostrarGridPedidos();
            
            $('#painelcompleto').loading('toggle');

            mostraToastErro((res.message ? res.message : 'Erro ao realizar a consulta'));
            console.error(err);

        },
        dataType: "json",
        contentType : "application/json"
      });		
}

function getFormData(idForm){
    var unindexed_array = $(`#${idForm}`).serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        
        indexed_array[n['name']] = n['value'];

    });


    return indexed_array;
}

function validarCamposForm(){
    var formValido = true;

    $("#campos-obrigatorios").removeClass('show');

    if(isEmpty(elemento("cliente").value)) {
        $('#cliente').attr('title', 'Campo obrigatório').tooltip("show");
        formValido = false;
    }

    if(isEmpty(elemento("documento").value)) {
        $('#documento').attr('title', 'Campo obrigatório').tooltip("show");
        formValido = false;
    }
        
    /*if(isEmpty(elemento("verificador").value)) {
        $('#verificador').attr('title', 'Campo obrigatório').tooltip("show");
        formValido = false;
    }*/

    if(!formValido) {
        setTimeout(() => {
            $('#cliente').attr('title', '').tooltip('hide');
            $('#documento').attr('title', '').tooltip('hide');
            //$('#verificador').attr('title', '').tooltip('hide');

            setTimeout(() =>{
                $('#cliente').attr('title', '').tooltip('dispose');
                $('#documento').attr('title', '').tooltip('dispose');
                //$('#verificador').attr('title', '').tooltip('dispose');
            }, 500);

        }, 3000);

    } else {
        consultarTrackings();
    }
        

    return formValido;
}

function validaCPFCNPJ() {
    var valor = elemento("cliente").value;

    if(isEmpty(valor))
        return false;
    
    switch (valor.length) {
        case 11:
            validaCPF(elemento("cliente"))
            break;
        case 14:
            validaCNPJ(elemento("cliente"));
            break;
        default:
            $('#cliente').attr('title', 'CPF ou CPNJ inválido :(').tooltip('show');
            elemento("cliente").focus();
            break;
    }
}

//Verifica se CPF é válido
function validaCPF(campoCPF) {

    $('#'+campoCPF.id).attr('title', '').tooltip('dispose');

    if((campoCPF.value != undefined && campoCPF.value != null && campoCPF.value != "") && (!TestaCPF(campoCPF.value))) {
        $('#'+campoCPF.id).attr('title', 'CPF inválido :(').tooltip('show');
        campoCPF.focus();
    }
}

//Verifica se CNPJ é válido
function validaCNPJ(campoCNPJ) {

    $('#'+campoCNPJ.id).attr('title', '').tooltip('dispose');

    if((campoCNPJ.value != undefined && campoCNPJ.value != null && campoCNPJ.value != "") && (!TestaCNPJ(campoCNPJ.value))) {
        $('#'+campoCNPJ.id).attr('title', 'CNPJ inválido :(').tooltip('show');
        campoCNPJ.focus();
    }
}

function TestaCPF(strCPF) {
    var Soma;
    var Resto;
    Soma = 0;   
    
    while(strCPF.indexOf(".") > 0)
        strCPF = strCPF.replace(".","");

    strCPF = strCPF.replace("-","");

    if (strCPF == "00000000000")
        return false;
    
    for (i=1; i<=9; i++)
        Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i); 
        
    Resto = (Soma * 10) % 11;
    if ((Resto == 10) || (Resto == 11)) 
	    Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) )
	    return false;
    Soma = 0;
    
    for (i = 1; i <= 10; i++)
       Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;
    
    if ((Resto == 10) || (Resto == 11)) 
	    Resto = 0;
    
    if (Resto != parseInt(strCPF.substring(10, 11) ) )
        return false;
    return true;
}

function TestaCNPJ(cnpj) {
 
    cnpj = cnpj.replace(/[^\d]+/g,'');
 
    if(cnpj == '') return false;
     
    if (cnpj.length != 14)
        return false;
 
    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || 
        cnpj == "11111111111111" || 
        cnpj == "22222222222222" || 
        cnpj == "33333333333333" || 
        cnpj == "44444444444444" || 
        cnpj == "55555555555555" || 
        cnpj == "66666666666666" || 
        cnpj == "77777777777777" || 
        cnpj == "88888888888888" || 
        cnpj == "99999999999999")
        return false;
         
    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          return false;
           
    return true;
    
}


/* Máscaras ER */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}

//Onload principal
window.onload = function(){
}