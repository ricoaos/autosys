$(document).ready(function(){
	
	$("#st_cpf_cnpj").mask('99.999.999/9999-99');
	$("#st_fone1,#st_fone2,#st_fone3").mask('(99)99999-9999');
	$("#st_cep").mask('99.999-999');
		
	$("#st_cep").change(function(){
		 getLogradouro($("#st_cep").val());
	});
	
	$("#st_cep").click(function(){
        $("#st_logradouro,#st_bairro,#st_cidade,#st_estado,#st_tipo_logradouro").val('');
        $("#st_cep").val('');
    });
	
});