$(document).ready(function(){
	
	$("#vl_salario").mask('#.##0,00',{reverse:true});
	$("#st_cpf").mask('999.999.999-99');
	$("#st_fonecontato").mask('(99)99999-9999');
	$("#dt_nascimento, #dt_admissao").mask('99/99/9999');
	$("#st_cep").mask('99.999-999');
	
	$("#wrapper_booth").hide();
          
    $("#foto").click(function(){
    	photobooth();
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
    
	$("#st_cpf").change(function(){
		
		var cpf = $(this).val().replace(/\D/g,"");
		
		if(!ValidarCPF(cpf)){
			$('#modalVal').modal();
			$("#st_cpf").val('');
			return;
		};
	});
	
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
    
$("#st_cpf").change(function(){
		
		var cpf = $(this).val().replace(/\D/g,"");
		
		if(!ValidarCPF(cpf)){
			$('#modalVal').modal();
			$("#st_cpf").val('');
			return;
		};

        $.ajax({
        	url: baseUrl+'/cliente/cliente/getclientebycpf',
        	data: 'cpf='+cpf,
            dataType: 'json',
            type:"POST",
            success: function(response){
            	
            	var objResult = response.result;
            	var linha = '';
            	
            	if(objResult != ''){
            		
            		linha += '<div class="panel-body">';
            		linha += '<table class="table table-striped table-hover table-fixed-layout non-responsive">';
            		linha += '<tbody>';
            		
	            	$.each(objResult, function(i, item){
	            		var imagem = item.id_foto != 1 ? baseUrl+'/assets/img/user.png' : baseUrl+'/img/fotos/usuario/'+item.id_pessoa+'.png';
	            		var url = baseUrl+'/cliente/cliente/index/id_similar/'+btoa(item.dt_nascimento+'@'+item.id_pessoa);
	            		var nascimento = item.dt_nascimento != null ? item.dt_nascimento.substring(8,10)+'/'+item.dt_nascimento.substring(5,7)+'/'+item.dt_nascimento.substring(0,4) : '';
	            		linha += '<tr>';
	            		linha +=   '<td class="email-subject input-mini" >';
	            		linha +=   		'<a href="'+url+'"><img width="50" class="chat-avatar" src="'+imagem+'"></a><br/>';
	            		linha +=   		'<label class="checkbox">'+item.id_pessoa+'</label>';
	            		linha +=   '</td>';
	            		linha +=   	'<td class="email-subject">';
	            		linha +=        '<span class="help-block">Paciente</span>';
	            		linha +=   		'<label class="checkbox">'+item.st_nome+'</label>';
         				linha +=   '</td>';
	            		linha +=   	'<td class="email-subject">';
	            		linha +=        '<span class="help-block">CPF</span>';
	            		linha +=   		'<label class="checkbox">'+item.st_cpf+'</label>';
         				linha +=   '</td>';
	            		linha +=   	'<td class="email-subject">';
	            		linha +=        '<span class="help-block">Data Nascimento</span>';
	            		linha +=   		'<label class="checkbox">'+nascimento+'</label>';
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
	            	
	            	$("#RegCpf").html(linha);            		
            		$('#modalCPF').modal();
            		$("#st_cpf").val('').focus();
            	}
            }
        });
	});
	
});