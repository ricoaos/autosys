$(document).ready(function(){
	

	$("#st_cep").mask('99.999-999');
	
	$(".cpfCnpj").unmask();
	$(".cpfCnpj").focusout(function() {
		$(".cpfCnpj").unmask();
		
		var tamanho = $(".cpfCnpj").val().replace(/\D/g, '').length;
		
		if (tamanho == 11) {
			
			if(!ValidarCPF($(".cpfCnpj").val())){
				$('#modalVal').modal();
				$(".cpfCnpj").val('').focus();
				return;
			};
			
			$(".cpfCnpj").mask("999.999.999-99");
			$("#id_tipo_pessoa").select2("val", "1");
			
		} else if (tamanho == 14) {
			
			if(!ValidaCNPJ($(".cpfCnpj").val())){
				$('#modalVal').modal();
				$(".cpfCnpj").val('').focus();
				return;
			};
			
			$(".cpfCnpj").mask("99.999.999/9999-99");
			$("#id_tipo_pessoa").select2("val", "2");
	    }
		
		$.ajax({
			url: baseUrl+'/fornecedor/fornecedor/getfornecedorbycnpj',
	    	data: 'st_cpf_cnpj='+$(".cpfCnpj").val(),
	        dataType: 'json',
	        type:"POST",
	        success: function(response){
	        	var objResult = response.result;
	        	
	        	if(objResult != ''){
	        		
		        	$.each(objResult, function(i, item){
		        		$("#id_fornecedor").val(item.id_fornecedor);
		        		$("#id_ativo").val(item.id_ativo);
		        		$("#id_tipo_pessoa").val(item.id_tipo_pessoa);
		        		$("#st_nome").val(item.st_nome);
		        		$("#st_email").val(item.st_email);
		        		$("#st_fone1").val(item.st_fone1);
		        		$("#st_fone2").val(item.st_fone2);
		        		$("#st_fone3").val(item.st_fone3);
		        		$("#st_cep").val(item.st_cep);
		        		$("#st_logradouro").val(item.st_logradouro);
		        		$("#st_complemento").val(item.st_complemento);
		        		$("#st_numero").val(item.st_numero);
		        		$("#st_bairro").val(item.st_bairro);
		        		$("#st_cidade").val(item.st_cidade);
		        		$("#st_estado").val(item.st_estado);
		        	});
	        	}	        	
	        }
		 });
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
