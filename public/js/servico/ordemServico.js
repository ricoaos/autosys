$(document).ready(function(){
	
	addProduto();
	
	$('#vl_total,#vl_total_servico,#vl_desconto,#vl_total_produto').mask('#.##0,00',{reverse:true});
	$('#vl_total,#vl_total_servico,#vl_total_produto').attr('readonly',true).css({'background':'#CCC'})
	
	var t = $('#tb_produto').DataTable({
		paging:   false,
		bFilter: false, 
		bInfo: false
	});
	
	$("#addProduto").click(function(){
		alert('Estou funcionando');
		
	});
       
});

function addProduto(){
	$("#tb_produto").append(
		"<tbody>"+
	        "<tr>"+
    	        "<td><input type='text' class='form-control' id='produto[id_produto][]' name='produto[id_produto][]' /></td>"+
    	        "<td><input type='text' class='form-control' id='produto[vl_unit][]' name='produto[vl_unit][]'/></td>"+
    	        "<td><input type='text' class='form-control' id='produto[st_quant][]' name='produto[st_quant][]'/></td>"+
    	        "<td><input type='text' class='form-control' id='vl_subtotal[]' name='produto[vl_subtotal][]'/></td>"+
    	        "<td><button class='btn btn-danger' type='button' onclick='removeProduto(this)'><i class='fa-remove'></i></button></td>"+
	        "</tr>"+
        "</tbody>"
	 );
}

function removeProduto(item){
	
	var tr = $(item).closest('tr');
	alert(tr);
    tr.fadeOut(400, function() {
      tr.remove();  
    });

    return false;
}
