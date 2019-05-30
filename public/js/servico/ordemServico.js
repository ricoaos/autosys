$(document).ready(function(){
		
	$('#vl_total,#vl_total_servico,#vl_desconto,#vl_total_produto').mask('#.##0,00',{reverse:true});
	$('#vl_total,#vl_total_servico,#vl_total_produto,#vl_subtotal_prod,#vl_subtotal_serv').attr('readonly',true).css({'background':'#CCC'})
	
});

function addProduto(){
	$("#tb_produto").append(
		"<tbody>"+
	        "<tr>"+
    	        "<td>" +
    	        "<input type='text' class='form-control' id='nm_produto_prod' name='produto[nm_produto][]' />" +
    	        "<input type='hidden' class='form-control' id='nm_produto_prod2' name='produto[nm_produto2][]' />" +
    	        "</td>"+
    	        "<td><input type='text' class='form-control' id='vl_unit_prod' name='produto[vl_unit][]'/></td>"+
    	        "<td><input type='text' class='form-control' id='st_quant_prod' name='produto[st_quant][]'/></td>"+
    	        "<td><input type='text' class='form-control' id='vl_subtotal_prod' name='produto[vl_subtotal][]'/></td>"+
    	        "<td><button class='btn btn-danger' type='button' onclick='remove(this)'><i class='fa-remove'></i></button></td>"+
	        "</tr>"+
        "</tbody>"
	 );
}

function addServico(){
	alert('cheguei');
	$("#tb_Servico").append(
		"<tbody>"+
	        "<tr>"+
    	        "<td><input type='text' class='form-control' id='nm_servico_serv' name='servico[nm_servico][]' /></td>"+
    	        "<td><input type='text' class='form-control' id='vl_unit_serv' name='servico[vl_unit][]'/></td>"+
    	        "<td><input type='text' class='form-control' id='st_quant_serv' name='servico[st_quant][]'/></td>"+
    	        "<td><input type='text' class='form-control' id='vl_subtotal_serv' name='servico[vl_subtotal][]'/></td>"+
    	        "<td><button class='btn btn-danger' type='button' onclick='remove(this)'><i class='fa-remove'></i></button></td>"+
	        "</tr>"+
        "</tbody>"
	 );
}

function remove(item){
	
	var tr = $(item).closest('tr');
    tr.fadeOut(400, function() {
      tr.remove();  
    });

    return false;
}
