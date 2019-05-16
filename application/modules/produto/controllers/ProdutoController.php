<?php
class Produto_ProdutoController extends App_Controller_Action
{
	public function init()
	{
		$this->idOrganizacao = App_Identity::getOrganizacao();
		$this->idUsuario = App_Identity::getIdUsuario();
		$this->mProduto = new Model_Produto_Produto();
		$this->mEstoque = new Model_Produto_Estoque();
		$this->mEstoqueEntrada = new Model_Produto_EstoqueEntrada();
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
    	        'id_usuario_cadastro' => $this->idUsuario
    	    );
    	      
    	    try {
    	    
        	    if(empty($post['id_produto'])){
        	        
        	        $dados['dt_cadastro'] = $dtcadastro;
        	        $rsProduto = $this->mProduto->insert($dados);
        	        
        	        $args = array(
        	            'id_produto' => $rsProduto,
        	            'qt_estoque_minimo'   => $post['qt_estoque_minimo'],
        	            'st_localizacao'      => strtoupper($post['st_localizacao']),
        	            'qt_saldo'            => $post['qt_entrada'],
        	            'id_usuario_cadastro' => $this->idUsuario
        	        );
        	        
        	        $rsEstoque = $this->mEstoque->insert($args);
        	        
        	        $entrada  = array(
        	            'id_estoque'         => $rsEstoque,
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
        	        
        	        $rsEntrada = $this->mEstoqueEntrada->insert($entrada);
        	        
        	        foreach($post['id_fornecedor'] as $values){
        	            $fornecedor = array(
        	                'id_produto' => $rsProduto,
        	                'id_fornecedor' => $values
        	            );
        	            $rsProdFornecedor = $this->mProdutoFornecedor->insert($fornecedor);
        	        }
        	        
        	    }else{
        	        
        	        $where = $this->mProduto->getAdapter()->quoteInto('id_produto = ?', $post["id_produto"]);
        	        $this->mProduto->update($dados, $where);
        	    }
        	    
        	    $getdados = self::getdadoscadastrados($rsProduto);
        	    $this->view->dadospagina = $getdados;

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
	    $rsProduto = $this->mVwProduto->fetchAll()->toArray();
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