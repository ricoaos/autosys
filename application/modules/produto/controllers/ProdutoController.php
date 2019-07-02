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
		$this->mProdutoFornecedor = new Model_Produto_ProdutoFornecedor();
		$this->mVwProduto = new Model_Produto_VwProduto();
		$this->mVwEntrada = new Model_Produto_VwEntrada();
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
    	    
    	   /* $dados['dt_cadastro'] = $dtcadastro;
    	    $rsProduto = $this->mProduto->insert($dados);
    	    
    	    foreach($post['id_fornecedor'] as $values){
    	        $fornecedor['id_produto'] = $rsProduto;
    	        $fornecedor['id_fornecedor'] = $values;
    	        $rsProdFornecedor = $this->mProdutoFornecedor->insert($fornecedor);
    	    }
    	    
    	    $args = array(
    	        'id_organizacao'      => $this->idOrganizacao,
    	        'id_produto'          => $rsProduto,
    	        'qt_saldo'            => empty($post['qt_entrada']) ? null : $post['qt_entrada'],
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
    	        'qt_entrada'         => empty($post['qt_entrada']) ? 0 : $post['qt_entrada'],
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
    	    
    	    Zend_Debug::dump($entrada_itens);die;*/
    	        	        	        	      
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
        	            'qt_saldo'            => empty($post['qt_entrada']) ? null : $post['qt_entrada'],
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
        	            'qt_entrada'         => empty($post['qt_entrada']) ? null : $post['qt_entrada'],
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
        	        
        	        $rsEstoque = $this->mEstoque->fetchAll(array('id_produto = ?' => $post['id_produto'], 'id_organizacao = ?' => $this->idOrganizacao))->toArray();
        	        
        	        if(empty($rsEstoque)){
        	            $args = array(
        	                'id_organizacao'      => $this->idOrganizacao,
        	                'id_produto'          => $post['id_produto'],
        	                'qt_saldo'            => $post['qt_entrada'],
        	                'qt_estoque_minimo'   => $post['qt_estoque_minimo'],
        	                'st_localizacao'      => strtoupper($post['st_localizacao']),
        	            );
        	            $rsEstoque = $this->mEstoque->insert($args);
        	        }else{
        	            $args = array(
        	                'qt_estoque_minimo'   => $post['qt_estoque_minimo'],
        	                'st_localizacao'      => strtoupper($post['st_localizacao']),
        	                'qt_saldo'            => $post['qt_entrada']
        	            );
        	            
        	            $where = $this->mEstoque->getAdapter()->quoteInto('id_produto=?', $post['id_produto']);
        	            $where = $this->mEstoque->getAdapter()->quoteInto('id_organizacao=?', $this->idOrganizacao);
        	            $rsEstoque = $this->mEstoque->update($args, $where);
        	        }
        	        
        	       /* $args = array(
        	            'id_organizacao'      => $this->idOrganizacao,
        	            'id_produto'          => $rsProduto,
        	            'qt_saldo'            => $post['qt_entrada'],
        	            'qt_estoque_minimo'   => $post['qt_estoque_minimo'],
        	            'st_localizacao'      => strtoupper($post['st_localizacao']),
        	        );
        	        $rsEstoque = $this->mEstoque->insert($args);
        	        
        	        $args = array(
        	            'qt_estoque_minimo'   => $post['qt_estoque_minimo'],
        	            'st_localizacao'      => strtoupper($post['st_localizacao']),
        	            'qt_saldo'            => $post['qt_entrada']
        	        );
        	        
        	        $whereEstoque = $this->mEstoque->getAdapter()->quoteInto(array('id_produto = ?' => $post['id_produto'],'id_organizacao = ?' => $this->idOrganizacao));
        	        $this->mEstoque->update($args, $whereEstoque);
        	        
        	       /* $entrada  = array(
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
        	        $this->mEstoqueEntrada->update($entrada, $whereEstoqueEntrada);*/
        	        
        	        $rsProduto = $post['id_produto'];
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
			
	/*
	 * @param unknown $params
	 * @return string
	 */
	public function getdadoscadastrados($params)
	{
	    $dadosproduto = $this->mVwProduto->fetchAll(array('id_produto = ?' => $params))->toArray();
	    $dadosestoque = $this->mEstoque->fetchAll(array('id_produto = ?' => $params, 'id_organizacao = ?' => $this->idOrganizacao))->toArray();
	    $dadosentrada = $this->mVwEntrada->fetchAll(array('id_produto = ?' => $params, 'id_organizacao = ?' => $this->idOrganizacao))->toArray();
	    $dadosfornecedor = $this->mProdutoFornecedor->fetchAll(array('id_produto = ?' => $params))->toArray();
	    	    
	    $dadospagina = array(
	        "id_produto" => $dadosproduto[0]["id_produto"],
	        "st_nome" => $dadosproduto[0]["st_nome"],
	        "id_grupo_produto" => $dadosproduto[0]["id_grupo_produto"],
	        "nm_categoria" => $dadosproduto[0]["nm_categoria"],
	        "id_marca_produto" => $dadosproduto[0]["id_marca_produto"],
	        "nm_marca" => $dadosproduto[0]["nm_marca"],
	        "id_unimed" => $dadosproduto[0]["id_unimed"],
	        "nm_unimed" => $dadosproduto[0]["nm_unimed"],
	        "cod_unimed" => $dadosproduto[0]["cod_unimed"],
	        "st_modelo" => $dadosproduto[0]["st_modelo"],
	        "st_lote" => $dadosproduto[0]["st_lote"],
	        "dt_validade" => $dadosproduto[0]["dt_validade"],
	        "st_comissao" => $dadosproduto[0]["st_comissao"],
	        "dt_cadastro_prod" => $dadosproduto[0]["dt_cadastro_prod"],
	        "id_usuario_cadastro" => $dadosproduto[0]["id_usuario_cadastro"],
	        "qt_saldo" => !empty($dadosestoque)? $dadosestoque[0]["qt_saldo"] : null,
	        "qt_estoque_minimo" => !empty($dadosestoque)? $dadosestoque[0]["qt_estoque_minimo"] : null,
	        "st_localizacao" => !empty($dadosestoque)? $dadosestoque[0]["st_localizacao"] : null,
	        "id_entrada" => !empty($dadosentrada)? $dadosentrada[0]["id_entrada"] : null,
	        "id_fornecedor" => !empty($dadosentrada)? $dadosentrada[0]["id_fornecedor"] : null,
	        "id_tipo_pagamento" => !empty($dadosentrada)? $dadosentrada[0]["id_tipo_pagamento"] : null,
	        "cd_nota_fiscal" => !empty($dadosentrada)? $dadosentrada[0]["cd_nota_fiscal"] : null,
	        "id_organizacao" => !empty($dadosentrada)? $dadosentrada[0]["id_organizacao"] : null,
	        "id_usuario_cadastro" => !empty($dadosentrada)? $dadosentrada[0]["id_usuario_cadastro"] : null,
	        "id_tipo_entrada" => !empty($dadosentrada)? $dadosentrada[0]["id_tipo_entrada"] : null,
	        "vl_total" => !empty($dadosentrada)? $dadosentrada[0]["vl_total"] : null,
	        "dt_cadastro" => !empty($dadosentrada)? $dadosentrada[0]["dt_cadastro"] : null,
	        "id_produto" => !empty($dadosentrada)? $dadosentrada[0]["id_produto"] : null,
	        "qt_entrada" => !empty($dadosentrada)? $dadosentrada[0]["qt_entrada"] : null,
	        "num_valor_custo" => !empty($dadosentrada)? $dadosentrada[0]["num_valor_custo"] : null,
	        "num_desp_acessorio" => !empty($dadosentrada)? $dadosentrada[0]["num_desp_acessorio"] : null,
	        "num_outro_custo" => !empty($dadosentrada)? $dadosentrada[0]["num_outro_custo"] : null,
	        "num_custo_final" => !empty($dadosentrada)? $dadosentrada[0]["num_custo_final"] : null,
	        "num_valor_venda" => !empty($dadosentrada)? $dadosentrada[0]["num_valor_venda"] : null,
	        "st_margem_lucro" => !empty($dadosentrada)? $dadosentrada[0]["st_margem_lucro"] : null
	    );
	    
	    foreach($dadosfornecedor as $values){
	        $dadospagina["id_fornecedor"][] = $values["id_fornecedor"];
	    }
	    
	    //Zend_Debug::dump($dadospagina);die;
	    return $dadospagina;
	}
}