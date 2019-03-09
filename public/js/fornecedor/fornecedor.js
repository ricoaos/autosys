$(document).ready(function(){
	
	$("#st_cpf_cnpj").mask('99.999.999/9999-99');
	$("#st_fone1,#st_fone2,#st_fone3").mask('(99)99999-9999');
	$("#st_cep").mask('99.999-999');
		
	$("#st_cep").change(function(){
		var cep = $(this).val().replace(/\D/g,"");
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
	                $("#st_cep").val('').focus();
	            }
	        },
		    error: function (request, status, erro) {
		    	alert(request.responseText);
		        alert("Problema ocorrido: " + status + "\nDescição: " + erro);
		        alert("Informações da requisição: \n" + request.getAllResponseHeaders());
		    }
		 });
	});
	
	$("#st_cep").click(function(){
        $("#st_logradouro,#st_bairro,#st_cidade,#st_estado,#st_tipo_logradouro").val('');
        $("#st_cep").val('');
    });
	
});