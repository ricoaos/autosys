<?php
class Produto_ProdutoController extends App_Controller_Action
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
		//Busca as informações cadastradas
	    if($this->_request->getParam('id'))
	    {
			list($date,$id) = explode('@',base64_decode($this->_request->getParam('id')));
			$args = self::getdadoscadastrados($id);
			$this->view->dadospagina = $args;
		}

	    //Realiza a inserção das informações 
		if($this->_request->isPost())
    	{
    	    
			
    		
			
    		$this->view->msg = $msg;
		}
		
		$mGrupoProduto = new Model_Produto_GrupoProduto();
		$rGrupoProduto = $mGrupoProduto->fetchAll()->toArray();
		$this->view->grupoProduto = $rGrupoProduto;	
		
		$mUnimed = new Model_Apoio_Unimed();
		$rUnimed = $mUnimed->fetchAll()->toArray();
		$this->view->unimed = $rUnimed;	
		
		$mMarcaProduto = new Model_Produto_MarcaProduto();
		$rMarcaProduto = $mMarcaProduto->fetchAll()->toArray();
		$this->view->marcaProduto = $rMarcaProduto;
		
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
		if($this->_request->getParam('id'))
		{
			
			$this->_redirect('corporativo/cliente/listagem');
		}
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