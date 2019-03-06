/*
 * Realiza a busca do logradouro conforme o cep informado
 */
function getLogradouro(cep){
	var cep = $('#st_cep').val().replace(/\D/g,"");
    $.ajax({
        url : 'http://cep.republicavirtual.com.br/web_cep.php?cep='+cep+'&formato=json',
        dataType: 'json',
        type:"POST",
        success: function(response){
        	
        	var objResult = response;
        	
            if(objResult != ''){
                $("#st_numero,#st_complemento").attr('readonly',false).css({'background':'#FFF'});
                $('#st_logradouro').val(objResult.logradouro);
                $('#st_bairro').val(objResult.bairro);
                $('#st_cidade').val(objResult.cidade);
                $('#st_estado').val(objResult.uf);
                $("#st_tipo_logradouro").val(objResult.tipo_logradouro);
                //$("#id_municipio").val(objResult.municipio);
                $("#st_numero").focus();
            }else{
                alert("Cep inválido");
            }
        }
   });
}