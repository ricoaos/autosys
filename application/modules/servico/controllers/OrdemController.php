<?php
class Servico_OrdemController extends App_Controller_Action
{
	public function init()
	{
		$this->idOrganizacao = App_Identity::getOrganizacao();
	}

	/**
	 * 
	 * @throws Exception
	 */
	public function indexAction()
	{
		
	    
	    if (!empty($_POST)){
	        Zend_Debug::dump($_POST);
	    }
	    
	    $mCliente = new Model_Cliente_VwCliente();
	    $rsCliente = $mCliente->fetchAll(array('id_organizacao = ?' => $this->idOrganizacao), '',30)->toArray();
	    $this->view->rsCliente = $rsCliente;
	    
	    $mFuncionario = new Model_Funcionario_VwFuncionario();
	    $rsFuncionario = $mFuncionario->fetchAll(array('id_organizacao = ?' => $this->idOrganizacao), '',30)->toArray();
	    $this->view->rsFuncionario = $rsFuncionario;  
	    
	    $mProduto = new Model_Produto_VwProduto();
	    $rsProduto = $mProduto->fetchAll()->toArray();
	    $this->view->rsProduto = $rsProduto;
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function listagemAction()
	{
	
	}
		
	/**
	 * 
	 * Enter description here ...
	 */
	public function inativarregistroAction()
	{

	}
		
	/**
	 * 
	 * @param unknown $params
	 * @return string
	 */
	public function getdadoscadastrados($params)
	{

	}
}