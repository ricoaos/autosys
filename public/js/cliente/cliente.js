$(document).ready(function(){
	
	$("#st_cep").mask('99.999-999');
	$("#dt_nascimento").mask('99/99/9999');
	$("#wrapper_booth").hide();
          
    $("#foto").click(function(){
    	photobooth();
    });
    
    if($("#id_cliente").val() != ''){
    	$("#addVeiculo").show();
    }else{
    	$("#addVeiculo").hide();
    }
   
    //Realiza a busca de nomes similares ao digitado.
    $("#st_nome").change(function(){    	
    	$.ajax({
        	url: baseUrl+'/cliente/cliente/getregistrosimilar',
        	data: 'nome='+$("#st_nome").val(),
            dataType: 'json',
            type:"POST",
            success: function(response){
				
            	var objResult = response.result;
            	var linha= "";
            	
            	if(objResult != ''){
            		           		
            		linha += '<div class="panel-body">';
            		linha += '<table class="table table-striped table-hover table-fixed-layout non-responsive">';
            		linha += '<tbody>';
            		            		
            		$.each(objResult, function(i, item){
	            		var imagem = item.id_foto != 1 ? baseUrl+'/assets/img/user.png' : baseUrl+'/img/fotos/usuario/'+item.id_pessoa+'.png';
	            		var url = baseUrl+'/cliente/cliente/index/id_similar/'+btoa(item.dt_nascimento+'@'+item.id_pessoa);
	            		linha += '<tr>';
	            		linha +=   '<td class="email-subject input-mini">';
	            		linha +=   		'<a href="'+url+'"><img width="50" class="chat-avatar" src="'+imagem+'"></a>';
	            		linha +=   '</td>';
	            		linha +=   	'<td class="email-subject input-mini">';
	            		linha +=        '<span class="help-block">Registro</span>';
	            		linha +=   		'<label class="checkbox">'+item.id_pessoa+'</label>';
         				linha +=   '</td>';
	            		linha +=   	'<td class="email-subject">';
	            		linha +=        '<span class="help-block">Cliente</span>';
	            		linha +=   		'<label class="checkbox">'+item.st_nome+'</label>';
         				linha +=   '</td>';
	            		linha +=   	'<td class="email-subject">';
	            		linha +=        '<span class="help-block">CPF</span>';
	            		linha +=   		'<label class="checkbox">'+item.st_cpf+'</label>';
         				linha +=   '</td>';
	            		linha +=   	'<td class="email-subject">';
	            		linha +=        '<span class="help-block">Data Nascimento</span>';
	            		linha +=   		'<label class="checkbox">'+item.dt_nascimento+'</label>';
         				linha +=   '</td>';
         				linha +=   	'<td class="email-subject">';
         				linha +=        '<span class="help-block">Cadastrado em</span>';
	            		linha +=   		'<label class="checkbox">'+item.dt_cadastro+'</label>';
         				linha +=   '</td>';
	            		linha += '</tr>';
					});
	            	
	            	linha += '</tbody>';		
	            	linha += '</table>';
	            	linha += '<div>';
	            	
					$("#RegSimilar").html(linha);
					$("#modalSimilar").modal();
            	}
            }
        });
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
        $("#st_logradouro,#st_bairro,#st_cidade,#st_estado,#st_tipo_logradouro,#st_numero,#st_complemento").val('');
        $("#st_cep").val('');
    });
	
	$("#dt_nascimento").change(function(){
		dateValidate($(this).val(),'dt_nascimento');
	});
       
    $("#btnLimpar").click(function(){
    	window.location.href = baseUrl+'/cliente/cliente/index';
    });
    
    $(".cpfCnpj").unmask();
    
	$(".cpfCnpj").focusout(function() {
		$(".cpfCnpj").unmask();
		
		var tamanho = $(".cpfCnpj").val().replace(/\D/g, '').length;
		
		if(tamanho > 0){
		
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
				url: baseUrl+'/cliente/cliente/getclientebycpf',
		    	data: 'cpf='+$(".cpfCnpj").val(),
		        dataType: 'json',
		        type:"POST",
		        success: function(response){
		        	$("#addVeiculo").show();
		        	var objResult = response.result;
		        	
		        	if(objResult != ''){            		
			        	$.each(objResult, function(i, item){
			        		
			        		console.log(item);
			        		var imagem = item.id_foto != 1 ? baseUrl+'/assets/img/user.png' : baseUrl+'/img/fotos/usuario/'+item.id_pessoa+'.png';
			        		var nascimento = item.dt_nascimento != null ? item.dt_nascimento.substring(8,10)+'/'+item.dt_nascimento.substring(5,7)+'/'+item.dt_nascimento.substring(0,4) : '';
			        		$("#foto").attr('src', imagem);
			        		$("#id_cliente").val(item.id_cliente);			        		
			        		item.id_ativo == 1 ? $('input[type=checkbox][name=id_ativo]').attr('checked',true).parent('.icheckbox_flat-blue').addClass("checked") : null;		        		
			        		$("#id_tipo_pessoa").val(item.id_tipo_pessoa);
			        		$("#st_nome").val(item.st_nome);
			        		$("#st_email").val(item.st_email);
			        		$("#st_fonecontato").val(item.st_fonecontato);
			        		$("#dt_nascimento").val(nascimento);
			        		$('input[type=radio][name=st_sexo][value*='+item.st_sexo+']').attr('checked',true).parent('.iradio_flat-blue').addClass("checked");		        		
			        		$("#st_cep").val(item.st_cep);
			        		$("#st_logradouro").val(item.st_logradouro);
			        		$("#st_complemento").val(item.st_complemento);
			        		$("#st_numero").val(item.st_numero);
			        		$("#st_bairro").val(item.st_bairro);
			        		$("#st_cidade").val(item.st_cidade);
			        		$("#st_estado").val(item.st_estado);
			        		$("#ds_observacao").val(item.ds_observacao);
			        	});
		        	}	        	
		        }
			 });
		}
	});
	
	$(".cpfCnpj").focusin(function() {
		$(".cpfCnpj").unmask();
	});
});