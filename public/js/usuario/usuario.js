$(document).ready(function(){
	
	
    $("#btnLimpar").click(function(){
    	window.location.href = baseUrl+'/usuario/usuario/index';
    });

	
	
	$("#btnAddPerfil").click(function(){
		
		$.ajax({
			url: baseUrl+'/usuario/usuario/acesso',
			data: $("#formPerfil").serialize(),
			dataType: 'json',
	        type:"POST",
			success:function(response){	
				alert(response.result);
			}
		});
	});
});

function excluirRegistro(org,user){
		
	$.ajax({
		url: baseUrl+'/usuario/usuario/deleteperfil',
		data: 'organizacao='+org+'&usuario='+user,
		dataType: 'json',
        type:"POST",
		success:function(response){	
			alert("Registro Deletado");
		}
	});
	
}