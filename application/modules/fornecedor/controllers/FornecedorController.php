<?php

class Fornecedor_FornecedorController extends App_Controller_Action
{
	public function init()
	{
		$this->idOrganizacao = App_Identity::getOrganizacao();
		$this->grupo = App_Identity::getGrupo();
		$this->idUsuario = App_Identity::getIdUsuario();
		$this->mFornecedor = new Model_Fornecedor_Fornecedor();
		$this->wFornecedor = new Model_Fornecedor_VwFornecedor();
		$this->mFornGrupo = new Model_Fornecedor_FornecedorGrupo();
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
        	    'st_estado'          => $_POST['st_estado'],
        	    'st_logradouro'      => $_POST['st_logradouro'],
        	    'st_complemento'     => $_POST['st_complemento'],
        	    'st_numero'          => $_POST['st_numero'],
        	    'st_bairro'          => $_POST['st_bairro'],
        	    'st_cidade'          => $_POST['st_cidade'],
        	    'st_email'           => $_POST['st_email']
        	);
        	
        	$dtcadastro = date('Y-m-d H:i:s');
        	        	
        	try {
        	    
        	    if(empty($_POST["id_fornecedor"])){

        	        $dados['dt_cadastro']= $dtcadastro;
        	        $rsfornecedor = $this->mFornecedor->insert($dados);
        	            	        
        	        $params = array('id_fornecedor' => $rsfornecedor, 'id_grupo' => $this->grupo, 'id_ativo' => 1);
        	        $rsFornecedorOrg = $this->mFornGrupo->insert($params);
        	        
        	    }else{
        	        
        	        $where = $this->mFornecedor->getAdapter()->quoteInto('id_fornecedor = ?', $_POST["id_fornecedor"]);
        	        $this->mFornecedor->update($dados,$where);
        	                	                	                	        
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
        $rsFornecedor = $this->wFornecedor->fetchAll(array('id_grupo = ?' => $this->grupo), '',30)->toArray();
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
            list($ativo,$id) = explode('@',base64_decode($this->_request->getParam('id')));
            $where = $this->mFornGrupo->getAdapter()->quoteInto(array('id_fornecedor = ?'=> $id , 'id_grupo=?' => $this->grupo));
            
            $ativo = $ativo == 0 ? 1 : 0;
            
            $this->mFornGrupo->update(array('id_ativo'=> $ativo),$where);
            $this->_redirect('fornecedor/fornecedor/listagem');
        }
    }
    
    public function getdadoscadastrados($params)
    {
        $dadospagina = $this->wFornecedor->fetchAll(array('id_fornecedor = ?' => $params, 'id_grupo= ?' => $this->grupo))->toArray();
        return $dadospagina[0];
    }
}