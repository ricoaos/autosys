$(document).ready(function(){
	
	$("#st_placa").mask('aaa-9999');
	$("#st_km").mask('999.999');

	$("#id_marca_veiculo").change(function(){
		getmodelo($(this).val());

	});
         
});

function addCliente(){
	$("#modalCliente").modal();
}

function getmodelo(marca){
	$.ajax({
		url: baseUrl+'/apoio/marca/getmodelomarca',
		data: 'id_marca_veiculo='+marca,
        dataType: 'json',
        type:"POST",
		success: function(response){

			linha=''; 	
			var select ='<option value=""></option>';

			$.each(response.result, function(i, item){
				select +='<option value="'+item.id_modelo_marca_veiculo+'">'+item.st_nome+'</option>';
			});
			
			$('#id_modelo_marca_veiculo').html(select);
		}
	});

}
