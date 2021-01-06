<?php
class Sistema_MenuController extends App_Controller_Action
{
	public function init()
	{
	    $this->idGrupo = App_Identity::getGrupo();
	}

	/**
	 * 
	 * @throws Exception
	 */
	public function indexAction()
	{
		
	}
	
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function listagemAction()
	{
	    $rsCliente = $this->mVcliente->fetchAll(array('id_grupo = ?' => $this->idGrupo), '',30)->toArray();
		$this->view->rsClientes = $rsCliente;
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
		    $where = $this->mClienteCrupo->getAdapter()->quoteInto(array('id_cliente = ?'=> $id , 'id_grupo=?' => $this->idGrupo));
		    $ativo = $ativo == 0 ? 1 : 0;
		    
		    $this->mClienteCrupo->update(array('id_ativo'=> $ativo),$where);
			$this->_redirect('cliente/cliente/listagem');
		}
	}
	
		/**
	 * 
	 * @param unknown $params
	 * @return string
	 */
	public function getdadoscadastrados($params)
	{
	    $dadospagina = $this->mVcliente->fetchAll(array('id_cliente = ?' => $params))->toArray();
		list($YY,$mm,$dd) = explode('-',$dadospagina[0]["dt_nascimento"]);
	    $dadospagina[0]["dt_nascimento"] = $dd.'/'.$mm.'/'.$YY;
		return $dadospagina[0];
	}
}