<?php
class Produto_ProdutoController extends App_Controller_Action
{
	public function init()
	{
		$this->idOrganizacao = App_Identity::getOrganizacao();
	}

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
    	    
    	    array(18) {
    	        ["id_fornecedor"] => array(1) {
    	            [0] => string(1) "3"
    	        }
    	        ["st_nome"] => string(5) "teste"
    	        ["id_grupo_produto"] => string(1) "1"
    	        ["id_unimed"] => string(1) "1"
    	        ["id_marca_produto"] => string(1) "2"
    	        ["st_modelo"] => string(5) "12132"
    	        ["st_lote"] => string(9) "113231213"
    	        ["dt_validade"] => string(7) "01/2020"
    	        ["qt_estoque_minimo"] => string(1) "4"
    	        ["qt_saldo"] => string(0) ""
    	        ["st_localizacao"] => string(2) "a3"
    	        ["num_valor_custo"] => string(6) "100,00"
    	        ["num_valor_venda"] => string(6) "190,00"
    	        ["num_desp_acessorio"] => string(4) "0,00"
    	        ["st_lucro"] => string(5) "90,00"
    	        ["num_outro_custo"] => string(4) "0,00"
    	        ["st_comissao"] => string(1) "1"
    	        ["num_custo_final"] => string(6) "100,00"
    	    }
    		
			
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
		
		$mFornecedor = new Model_Fornecedor_Fornecedor();
		$rFornecedor = $mFornecedor->fetchAll()->toArray();
		$this->view->fornecedor = $rFornecedor;
		
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