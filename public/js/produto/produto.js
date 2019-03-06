$(document).ready(function(){
		
	$('#num_valor_custo,#num_desp_acessorio,#num_outro_custo,#num_custo_final').mask('#.##0,00',{reverse:true});
	
	$('#num_valor_custo').change(function(){
		$('#num_custo_final').val($(this).val());
	});
	
	$('#num_desp_acessorio').change(function(){
		var valor = parseInt($(this).val()) + parseInt($('#num_custo_final').val());
		$('#num_custo_final').val(valor);
	});
	
	$('#num_outro_custo').change(function(){
		var valor = parseInt($(this).val()) + parseInt($('#num_custo_final').val());
		$('#num_custo_final').val(valor);
	});
	
	$('#num_valor_custo').change(function(){
		$('#num_custo_final').val($(this).val());
	});
	
	$('#num_valor_custo').change(function(){
		$('#num_custo_final').val($(this).val());
	});
});