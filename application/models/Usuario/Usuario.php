<?php

class Model_Usuario_Usuario extends Zend_Db_Table
{
    protected $_schema  = 'usuario';
    protected $_name    = 'usuario';
    protected $_primary = array('id_usuario');

	/**
	 * @param unknown $sUser
	 * @param unknown $sPassword
	 * @return boolean
	 */
    public function logar($sUser, $sPassword)
    {
        if (!$sUser || !$sPassword) {
            return 1;
        }

        //$filtro = 'md5(?)';
        $oAuthAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter(), 'usuario.usuario', 'st_usuario', 'st_senha');
        $oAuthAdapter->setIdentity($sUser);
        $oAuthAdapter->setCredential($sPassword);

        $oAuth   = Zend_Auth::getInstance();
        $oResult = $oAuth->authenticate($oAuthAdapter);
        
        // limpa o identity porque ele é gerado pelo método gravarIdentity
        $oAuth->clearIdentity();

        if ($oResult->isValid()) {
            $rowObject  = $oAuthAdapter->getResultRowObject(null, array('st_senha'));

            if($rowObject->id_ativo == false){
            	return 3;
            }
            
           // Zend_Debug::dump($rowObject);die;
            $idOrganizacao = $rowObject->id_organizacao_atual;
            if(!empty($idOrganizacao))
            {
	            $this->gravarIdentity($idOrganizacao, $rowObject->id_usuario);
	            return 0;
	            
            }else{
            	
            	return 2;
            }
        }
        return 1;
    }

    /**
     * 
     */
    public function deslogar()
    {
        Zend_Auth::getInstance()->clearIdentity();

        $aclSessao = new Zend_Session_Namespace('acl');
        $aclSessao->unsetAll();
    }

    /**
     * @param unknown $idOrganizacao
     * @param unknown $idUsuario
     */
    public function gravarIdentity($idOrganizacao, $idUsuario)
    {        
        $row = $this->fetchRow(array('id_usuario = ?' => $idUsuario));
        
        $mGrupo = new Model_Grupo_Grupo();
        $rowGrupo = $mGrupo->fetchRow(array('id_grupo=?'=> $row->id_grupo));
        
        
        $mOrganizacao = new Model_Organizacao_Organizacao();
        $rowOrganizacao = $mOrganizacao->fetchRow(array('id_organizacao=?'=> $idOrganizacao));
        
        $identity = (object) $row->toArray();
        $identity->grupo = (object) $rowGrupo->toArray();
        $identity->organizacao    = (object) $rowOrganizacao->toArray();

        unset($identity->st_senha);

        $oAuth = Zend_Auth::getInstance();
        $oAuth->clearIdentity();
        $oAuth->getStorage()->write($identity);
    }
}