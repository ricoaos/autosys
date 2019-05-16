$(document).ready(function(){
		
	$('#num_valor_custo,#num_desp_acessorio,#num_outro_custo,#num_valor_venda').mask('#.##0,00',{reverse:true});
	$('#dt_validade').mask('99/9999')
	$('#num_custo_final,#qt_saldo').attr('readonly',true).css({'background':'#CCC'})
	
	$('#num_valor_custo,#num_desp_acessorio,#num_outro_custo').click(function(){
		$(this).val('');
	});
	
	$('#num_valor_custo,#num_desp_acessorio,#num_outro_custo').change(function(){
		somar();
	});
	
	$('#num_valor_venda').change(function(){
		
		var porcentagem = 0;
		var valor1 = $('#num_custo_final').val();
		var valor2 = $('#num_valor_venda').val();
		
		valor1 = valor1.replace('.', '');﻿﻿
		valor2 = valor2.replace('.', '');
		
		valor1 = valor1.replace(',', '.');
		valor2 = valor2.replace(',', '.');
		
		porcentagem = ((parseFloat(valor2)-parseFloat(valor1))*100)/parseFloat(valor1);
		porcentagem = porcentagem.toFixed(2).replace('.', ',');
		$('#st_margem_lucro').val(porcentagem);	
	});
	
	$('#st_margem_lucro').change(function(){
		
		var porcentagem = 0;
		var valor1 = $('#num_custo_final').val();
		var valor2 = $('#st_margem_lucro').val();
		
		valor1 = valor1.replace('.', '');﻿﻿
		valor2 = valor2.replace('.', '');
		
		valor1 = valor1.replace(',', '.');
		valor2 = valor2.replace(',', '.');
		
		porcentagem = parseFloat(valor1) + (valor2*valor1)/100;
		porcentagem = porcentagem.toFixed(2).replace('.', ',');
		$('#num_valor_venda').val(porcentagem);	
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
