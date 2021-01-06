$(document).ready(function(){
		
	$('#vl_total,#vl_total_servico,#vl_desconto,#vl_total_produto').mask('#.##0,00',{reverse:true}).val('0,00');
	$('#vl_total,#vl_total_servico,#vl_total_produto,#vl_subtotal_prod,#vl_subtotal_serv').attr('readonly',true).css({'background':'#CCC'}).val('0,00');
	var d = new Date();
	dataHora = (d.toLocaleString()); 
	$('#dt_os').mask('99/99/9999').val(dataHora);
	
	$('#vl_desconto').change(function(){
		calculoValorTotal();
	});
});

function addProduto(){
		
	var checks = $('input[name="produtoCheck"]:checked'); 
	var valor = $('#vl_total_produto').val();

	for(var i=0; i<checks.length; i++){
		
		var str = $(checks[i]).val();
	    var array = str.split('&');
	    	    
	    $("#tb_produto").append(
	    	"<tbody>"+
		        "<tr>"+
	    	        "<td><span name='teste' id='teste'>"+array[0]+"</span><input type='hidden' id='id_produto[]' name='id_produto[]' value="+array[1]+"></td>"+
	    	        "<td><span>"+array[2]+"</span></td>"+
	    	        "<td><span>1</span></td>"+
	    	        "<td><span>"+array[2]+"</span></td>"+
	    	        "<td><button class='btn btn-danger' type='button' onclick='remove(this,"+array[2].replace(/\./g, "").replace(",", ".")+")'><i class='fa-remove'></i></button></td>"+
		        "</tr>"+
	        "</tbody>"
	    );
	    
	    $('input[name="produtoCheck"]').prop("checked", false);
	    
	    var preco = array[2].replace(/\./g, "").replace(",", ".");
	    var valor = ((parseFloat(valor)+parseFloat(preco))).toFixed(2);
	    var preco = 0;
	};
	
	$('#vl_total_produto').val(valor.replace(".", ","));
	$('#modalProdutos').modal('hide');
	calculoValorTotal();
}

function addServico(){
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

function remove(item,valor){

	var tr = $(item).closest('tr');
    tr.fadeOut(400, function() {
      tr.remove();  
    });
    
    var preco = $('#vl_total_produto').val().replace(/\./g, "").replace(",", ".");    
    var valor = valor >= preco ?((parseFloat(valor)-parseFloat(preco))).toFixed(2) : ((parseFloat(preco)-parseFloat(valor))).toFixed(2) ;
    $('#vl_total_produto').val(valor.replace(".", ","));
    calculoValorTotal();

    return false;
}

function calculoValorTotal(){
	var soma = 0;
	var valor1 = $('#vl_total_produto').val();
	var valor2 = $('#vl_total_servico').val();
	var valor3 = $('#vl_desconto').val();
	
	valor1 = valor1.replace('.', '');﻿﻿
	valor2 = valor2.replace('.', '');
	valor3 = valor3.replace('.', '');
	
	valor1 = valor1.replace(',', '.');
	valor2 = valor2.replace(',', '.');
	valor3 = valor3.replace(',', '.');﻿﻿
	
	soma = parseFloat(valor1) + parseFloat(valor2) - parseFloat(valor3);
	soma =soma.toFixed(2).replace('.', ',');
	
	$('#vl_total').val(soma);
	
}
