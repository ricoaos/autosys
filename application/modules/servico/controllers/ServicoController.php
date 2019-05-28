<?php
class Servico_ServicoController extends App_Controller_Action
{
	public function init()
	{
		$this->idOrganizacao = App_Identity::getOrganizacao();
		$this->idUsuario = App_Identity::getIdUsuario();
		$this->mServico = new Model_Produto_Servico();
	}

	/**
	 * 
	 * @throws Exception
	 */
	public function indexAction()
	{
	    if($this->_request->getParam('id'))
	    {
	        list($date,$id) = explode('@',base64_decode($this->_request->getParam('id')));
	        $args = self::getdadoscadastrados($id);
	        $this->view->dadospagina = $args;
	    }
	    
	    $post = $this->_request->getPost();
	    
	    //Realiza a inserção das informações
	    if($this->_request->isPost())
	    {
	        
	        try {
	            $post["st_nome"] = strtoupper($post["st_nome"]);
	            $post["id_usuario_cadastro"] = $this->idUsuario;
	            $post["dt_cadastro"] = date('Y-m-d H:i:s');
	            $post['id_ativo'] = 1;
	            
	            if(empty($post['id_servico'])){
	                
	                $rsServico = $this->mServico->insert($post);
	                
	            }else{
	                $post['id_ativo'] = empty($post['id_ativo'])? 0 : $post['id_ativo'];
	                $where = $this->mServico->getAdapter()->quoteInto('id_servico = ?', $post["id_servico"]);
	                $this->mServico->update($post, $where);
	                
	                $rsServico = $post['id_servico'];
	            }
	            
	            $getdados = self::getdadoscadastrados($rsServico);
	            $this->view->dadospagina = $getdados;
	            
	            $msg=2;
	            
	        } catch (Zend_Db_Exception $e) {
	            $e->rollBack();
	            $msg= $e->getMessage();
	        }
	        
	        $this->view->msg = $msg;
	    }
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function listagemAction()
	{
	    $rsServico = $this->mServico->fetchAll()->toArray();
	    $this->view->rsServico = $rsServico;
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
	        $where = $this->mServico->getAdapter()->quoteInto('id_servico = ?', $id );
	        $this->mServico->update(array('id_ativo'=> 0),$where);
	        $this->_redirect('servico/servico/listagem');
	    }
	}
		
	/**
	 * 
	 * @param unknown $params
	 * @return string
	 */
	public function getdadoscadastrados($params)
	{
	    $dadospagina = $this->mServico->fetchAll(array('id_servico = ?' => $params))->toArray();
	    return $dadospagina[0];
	}
}