function getLogradouro(cep){
	var cep = $('#st_cep').val().replace(/\D/g,"");
	
    $.ajax({
        url : 'http://cep.republicavirtual.com.br/web_cep.php?cep='+cep+'&formato=json',
        dataType: 'json',
        success: function(response){
        	
        	var objResult = response;

            if(objResult.resultado != 0){
                $("#st_numero,#st_complemento").attr('readonly',false).css({'background':'#FFF'});
                $('#st_logradouro').val(objResult.logradouro);
                $('#st_bairro').val(objResult.bairro);
                $('#st_cidade').val(objResult.cidade);
                $('#st_estado').val(objResult.uf);
                $("#st_tipo_logradouro").val(objResult.tipo_logradouro);
                //$("#id_municipio").val(objResult.municipio);
                $("#st_numero").focus();
            }else{
                alert(objResult.resultado_txt);
            }
        },
	    error: function (request, status, erro) {
	    	alert(request.responseText);
	        alert("Problema ocorrido: " + status + "\nDescição: " + erro);
	        //Abaixo está listando os header do conteudo que você requisitou, só para confirmar se você setou os header e dataType corretos
	        alert("Informações da requisição: \n" + request.getAllResponseHeaders());
	    },
	    complete: function (jqXHR, textStatus) {
	        alert("Chegou ao fim: : " + textStatus);
	        //Exibindo o valor que você obeteve e repassou para o confirmationValue
	        //Exibindo o valor que você obeteve e repassou para o confirmationValue
	        alert("Confirmation value: " + confirmationValue);
	    }
   });
}