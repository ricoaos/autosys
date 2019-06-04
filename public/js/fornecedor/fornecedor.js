$(document).ready(function(){
	

	$("#st_cep").mask('99.999-999');
	
	$(".cpfCnpj").unmask();
	  $(".cpfCnpj").focusout(function() {
	    $(".cpfCnpj").unmask();
	    var tamanho = $(".cpfCnpj").val().replace(/\D/g, '').length;
	    if (tamanho == 11) {
	      $(".cpfCnpj").mask("999.999.999-99");
	    } else if (tamanho == 14) {
	      $(".cpfCnpj").mask("99.999.999/9999-99");
	    }
	  });
	  $(".cpfCnpj").focusin(function() {
	    $(".cpfCnpj").unmask();
	  });
	
	
			
	$("#st_cep").change(function(){
		var cep = $(this).val().replace(/\D/g,"");
		$.ajax({
			url : 'https://viacep.com.br/ws/'+cep+'/json/',
	        dataType: 'json',
	        success: function(response){
	        	var objResult = response;
	            if(objResult.resultado != 0){
	                $("#st_numero,#st_complemento").attr('readonly',false).css({'background':'#FFF'});
	                $('#st_logradouro').val(objResult.logradouro);
	                $('#st_bairro').val(objResult.bairro);
	                $('#st_cidade').val(objResult.localidade);
	                $('#st_estado').val(objResult.uf);
	                $("#id_municipio").val(objResult.ibge);
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