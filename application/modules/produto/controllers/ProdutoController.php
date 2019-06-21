<?php
class Produto_ProdutoController extends App_Controller_Action
{
	public function init()
	{
		$this->idOrganizacao = App_Identity::getOrganizacao();
		$this->idGrupo = App_Identity::getGrupo();
		$this->idUsuario = App_Identity::getIdUsuario();
		$this->mProduto = new Model_Produto_Produto();
		$this->mEstoque = new Model_Produto_Estoque();
		$this->mEntrada = new Model_Produto_Entrada();
		$this->mEntradaItens = new Model_Produto_EntradaItens();
		
		$this->mVwProduto = new Model_Produto_VwProduto();
		$this->mProdutoFornecedor = new Model_Produto_ProdutoFornecedor();
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
		
		$post = $this->_request->getPost();
		$dtcadastro = date('Y-m-d H:i:s');
		
	    //Realiza a inserção das informações 
		if($this->_request->isPost())
    	{
    	    $dados = array(
    	        'st_nome'             => strtoupper($post["st_nome"]),
    	        'id_grupo_produto'    => $post['id_grupo_produto'],
    	        'id_marca_produto'    => $post['id_marca_produto'],
    	        'id_unimed'           => $post['id_unimed'],
    	        'st_modelo'           => strtoupper($post['st_modelo']),
    	        'st_lote'             => strtoupper($post['st_lote']),
    	        'dt_validade'         => $post['dt_validade'],
    	        'st_comissao'         => $post['st_comissao'],
    	        'id_usuario_cadastro' => $this->idUsuario,
    	        'id_grupo'            => $this->idGrupo
    	    );
    	        	        	        	      
    	    try {
    	           
        	    if(empty($post['id_produto'])){
        	        
        	        $dados['dt_cadastro'] = $dtcadastro;
        	        $rsProduto = $this->mProduto->insert($dados);
        	        
        	        foreach($post['id_fornecedor'] as $values){
        	            $fornecedor['id_produto'] = $rsProduto;
        	            $fornecedor['id_fornecedor'] = $values;
        	            
        	            $rsProdFornecedor = $this->mProdutoFornecedor->insert($fornecedor);
        	        }
        	        
        	        $args = array(
        	            'id_organizacao'      => $this->idOrganizacao,
        	            'id_produto'          => $rsProduto,
        	            'qt_saldo'            => $post['qt_entrada'],
        	            'qt_estoque_minimo'   => $post['qt_estoque_minimo'],
        	            'st_localizacao'      => strtoupper($post['st_localizacao']),
        	        );
        	        
        	        $rsEstoque = $this->mEstoque->insert($args);
        	        
        	        $entrada = array(
        	            'id_fornecedor'      => null,
        	            'id_tipo_pagamento'  => 8,
        	            'cd_nota_fiscal'     => null,
        	            'dt_cadastro'        => $dtcadastro,
        	            'id_organizacao'     => $this->idOrganizacao,
        	            'id_usuario_cadastro'=> $this->idUsuario,
        	            'id_tipo_entrada'    => 1,
        	            'vl_total'           => null
        	            
        	        );
        	        
        	        $rsEntrada = $this->mEntrada->insert($entrada);
        	        
        	        $entrada_itens  = array(
        	            'id_produto'         => $rsProduto,
        	            'id_entrada'         => $rsEntrada,
        	            'qt_entrada'         => $post['qt_entrada'],
        	            'num_valor_custo'    => $post['num_valor_custo'],
        	            'num_valor_venda'    => $post['num_valor_venda'],
        	            'num_desp_acessorio' => $post['num_desp_acessorio'],
        	            'st_margem_lucro'    => (int)$post['st_margem_lucro'],
        	            'num_outro_custo'    => $post['num_outro_custo'],
        	            'num_custo_final'    => $post['num_custo_final'],
        	            'id_usuario_cadastro'=> $this->idUsuario,
        	            'dt_cadastro'        => $dtcadastro
        	        );
        	        
        	        $entrada_itens = $this->mEntradaItens->insert($entrada_itens);
        	                	        
        	    }else{
        	        
        	        $where = $this->mProduto->getAdapter()->quoteInto('id_produto = ?', $post["id_produto"]);
        	        $this->mProduto->update($dados, $where);
        	        
        	        $args = array(
        	            'qt_estoque_minimo'   => $post['qt_estoque_minimo'],
        	            'st_localizacao'      => strtoupper($post['st_localizacao']),
        	            'qt_saldo'            => $post['qt_entrada'],
        	            'id_usuario_cadastro' => $this->idUsuario
        	        );
        	        
        	        $whereEstoque = $this->mEstoque->getAdapter()->quoteInto('id_estoque = ?', $post["id_estoque"]);
        	        $this->mEstoque->update($args, $whereEstoque);
        	        
        	        $entrada  = array(
        	            'qt_entrada'         => $post['qt_entrada'],
        	            'num_valor_custo'    => $post['num_valor_custo'],
        	            'num_valor_venda'    => $post['num_valor_venda'],
        	            'num_desp_acessorio' => $post['num_desp_acessorio'],
        	            'st_margem_lucro'    => (int)$post['st_margem_lucro'],
        	            'num_outro_custo'    => $post['num_outro_custo'],
        	            'num_custo_final'    => $post['num_custo_final'],
        	            'id_usuario_cadastro'=> $this->idUsuario
        	        );
        	        
        	        $whereEstoqueEntrada = $this->mEstoqueEntrada->getAdapter()->quoteInto('id_estoque_entrada = ?', $post["id_estoque_entrada"]);
        	        $this->mEstoqueEntrada->update($entrada, $whereEstoqueEntrada);
        	        
        	        $rsProduto = $post['id_produto'];
        	    }
        	    
        	   /* $getdados = self::getdadoscadastrados($rsProduto);
        	    $this->view->dadospagina = $getdados;*/

        	    $msg=2;
        	    
    	    } catch (Zend_Db_Exception $e) {
    	        $e->rollBack();
    	        $msg= $e->getMessage();
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
	    $rsProduto = $this->mProduto->fetchAll()->toArray();
	    $this->view->rsProduto = $rsProduto;
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
	    $dadospagina = $this->mVwProduto->fetchAll(array('id_produto = ?' => $params))->toArray();
	    return $dadospagina[0];
	}
}