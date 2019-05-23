<?php

class Fornecedor_FornecedorController extends App_Controller_Action
{
	public function init()
	{
		$this->idOrganizacao = App_Identity::getOrganizacao();
		$this->grupo = App_Identity::getGrupo();
		$this->idUsuario = App_Identity::getIdUsuario();
		$this->mFornecedor = new Model_Fornecedor_Fornecedor();
	}
	
    public function indexAction()
    {        
    	if($this->_request->getParam('id'))
    	{
    		list($date,$id) = explode('@',base64_decode($this->_request->getParam('id')));
    		$args = self::getdadoscadastrados($id);
    		$this->view->dadospagina = $args;
    	}
    	
    	if($this->_request->isPost())
    	{
    	
        	$dados = array(
        	    'id_tipo_pessoa'     => $_POST['id_tipo_pessoa'],
        	    'st_nome'            => strtoupper($_POST["st_nome"]),
        	    'st_cpf_cnpj'        => $_POST["st_cpf_cnpj"],
        	    'st_fone1'           => $_POST["st_fone1"],
        	    'st_fone2'           => $_POST["st_fone2"],
        	    'st_fone3'           => $_POST["st_fone3"],
        	    'st_cep'             => preg_replace('/\D+/', '', $_POST["st_cep"]),
        	    'st_tipo_logradouro' => $_POST['st_tipo_logradouro'],
        	    'st_estado'          => $_POST['st_estado'],
        	    'st_logradouro'      => $_POST['st_logradouro'],
        	    'st_complemento'     => $_POST['st_complemento'],
        	    'st_numero'          => $_POST['st_numero'],
        	    'st_bairro'          => $_POST['st_bairro'],
        	    'st_cidade'          => $_POST['st_cidade'],
        	    'id_ativo'           => 1,
        	    'st_email'           => $_POST['st_email']
        	);
        	
        	$dtcadastro = date('Y-m-d H:i:s');
        	        	
        	try {
        	    
        	    if(empty($_POST["id_fornecedor"])){
        	        
        	        $dados['dt_cadastro']= $dtcadastro;
        	        $rsfornecedor = $this->mFornecedor->insert($dados);
        	            	        
        	        $mFornecedorOrg = new Model_Fornecedor_FornecedorOrganizacao();
        	        $params = array('id_fornecedor' => $rsfornecedor, 'id_organizacao' => $this->idOrganizacao);
        	        $rsFornecedorOrg = $mFornecedorOrg->insert($params);
        	        
        	    }else{
        	        
        	        $where = $this->mFornecedor->getAdapter()->quoteInto('id_fornecedor = ?', $_POST["id_fornecedor"]);
        	        $this->mFornecedor->update($dados,$where);
        	        
        	        $args = array(
        	            'id_ativo'      => $_POST['id_ativo']);
        	        
        	        
        	        $rsfornecedor = $_POST["id_fornecedor"];
        	    }
        	    
        	    $getdados = self::getdadoscadastrados($rsfornecedor);
        	    $this->view->dadospagina = $getdados;
        	    
        	    $msg=2;
        	    
        	} catch (Zend_Db_Exception $e) {
        	    $e->rollBack();
        	    $msg= $e->getMessage();
        	}
        	
        	$this->view->msg = $msg; 
    	}
    	
    	$mTipoPessoa = new Model_Pessoa_TipoPessoa();
    	$rsTipoPessoa = $mTipoPessoa->fetchAll()->toArray();
    	$this->view->tipoPessoa = $rsTipoPessoa;
    	
    	$mTipoLogradouro = new Model_Apoio_TipoLogradouro();
    	$rsTipoLogradouro = $mTipoLogradouro->fetchAll()->toArray();
    	$this->view->TipoLogradouro = $rsTipoLogradouro;
    }
    

    public function listagemAction()
    {
    	$rsFornecedor = $this->mFornecedor->fetchAll()->toArray();
    	$this->view->rsFornecedor = $rsFornecedor;
    }
    
    /**
     *
     * Enter description here ...
     */
    public function inativarregistroAction()
    {
        if($this->_request->getParam('id'))
        {
            list($date,$id) = explode('@',base64_decode($this->_request->getParam('id')));
            $where = $this->mFornecedor->getAdapter()->quoteInto('id_fornecedor = ?', $id );
            $this->mFornecedor->update(array('id_ativo'=> 0),$where);
            $this->_redirect('fornecedor/fornecedor/listagem');
        }
    }
    
    public function getdadoscadastrados($params)
    {
        $dadospagina = $this->mFornecedor->fetchAll(array('id_fornecedor = ?' => $params))->toArray();
        return $dadospagina[0];
    }
}