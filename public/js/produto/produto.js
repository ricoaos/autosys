$(document).ready(function(){
		
	$('#num_valor_custo,#num_desp_acessorio,#num_outro_custo').mask('#.##0,00',{reverse:true});
	$('#num_custo_final').attr('readonly',true).css({'background':'#CCC'})
	
	$('#num_valor_custo,#num_desp_acessorio,#num_outro_custo').click(function(){
		$(this).val('');
	});
	
	$('#num_valor_custo,#num_desp_acessorio,#num_outro_custo').change(function(){
		somar();
	});
});
 function somar(){
	 var soma = 0;
	var valor1 = $('#num_valor_custo').val();
	var valor2 = $('#num_desp_acessorio').val();
	var valor3 = $('#num_outro_custo').val();
	
	valor1 = valor1.replace('.', '');﻿﻿
	valor2 = valor2.replace('.', '');
	valor3 = valor3.replace('.', '');
	
	valor1 = valor1.replace(',', '.');
	valor2 = valor2.replace(',', '.');
	valor3 = valor3.replace(',', '.');﻿﻿

	soma = parseFloat(valor1) + parseFloat(valor2) + parseFloat(valor3);
	soma =soma.toFixed(2).replace('.', ',');
	
	$('#num_custo_final').val(soma);
 }
