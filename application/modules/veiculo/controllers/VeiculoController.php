<?php

class Veiculo_VeiculoController extends App_Controller_Action
{
	public function init()
	{
		$this->idOrganizacao = App_Identity::getOrganizacao();
		$this->grupo = App_Identity::getGrupo();
		$this->idUsuario = App_Identity::getIdUsuario();
		$this->mVeiculo = new Model_Cliente_Veiculo();
	}
	
    public function indexAction()
    {        
    	if($this->_request->getParam('id'))
    	{
    		list($date,$id) = explode('@',base64_decode($this->_request->getParam('id')));
    		$this->view->dadospagina = self::getdadoscadastrados($id);
    	}
    	
    	if($this->_request->isPost())
    	{
    	    $dados = array(
    	        "id_cliente"               => $_POST['id_cliente'],
    	        "st_placa"                 => strtoupper($_POST['st_placa']),
    	        "num_ano"                  => $_POST['num_ano'],
    	        "st_km"                    => $_POST['st_km'],
    	        "id_combustivel"           => $_POST['id_combustivel'],
    	        "id_marca_veiculo"         => $_POST['id_marca_veiculo'],
    	        "id_modelo_marca_veiculo"  => $_POST['id_modelo_marca_veiculo'],
    	        "id_cor"                   => $_POST['id_cor'],
    	        "st_chassi"                => $_POST['st_chassi'],
    	        "ds_observacao"            => $_POST['ds_observacao'],
    	        "id_organizacao"           => $this->idOrganizacao
    	    );
    	    
    		try {
        		if(empty($_POST['id_veiculo'])){
        		    
        		    $dados['dt_cadastro'] = date('Y-m-d H:i:s');
        		    if(!$rsVeiculo = $this->mVeiculo->insert($dados)){
        		        throw new Exception("Error ao gravar");
        		    }
        		    
        		}else{
        		    $rsVeiculo = $_POST['id_veiculo'];
        		    $where = $this->mVeiculo->getAdapter()->quoteInto('id_veiculo = ?', $rsVeiculo);
        		    $this->mVeiculo->update($dados,$where);
        		}
        		        		
        		$this->view->dadospagina = self::getdadoscadastrados($rsVeiculo);
        		
        		$msg=2;
        		
    		} catch (Zend_Db_Exception $e) {
    		    $msg= $e->getMessage();
    		}
    		
    		$this->view->msg = $msg;
		}

		$mCliente = new Model_Cliente_VwCliente();
    	$rsCliente = $mCliente->fetchAll(array('id_organizacao = ?' => $this->idOrganizacao), '',30)->toArray();
    	$this->view->rsCliente = $rsCliente;
		    	
    	$mCombustivel = new Model_Apoio_Combustivel();
    	$rsCombustivel = $mCombustivel->fetchAll()->toArray();
		$this->view->rsCombustivel = $rsCombustivel;
		
		$mMarcaVeiculo = new Model_Apoio_MarcaVeiculo();
    	$rsMarcaVeiculo = $mMarcaVeiculo->fetchAll()->toArray();
    	$this->view->rsMarcaVeiculo = $rsMarcaVeiculo;
		
		$mCor = new Model_Apoio_Cor();
    	$rsCor = $mCor->fetchAll()->toArray();
    	$this->view->rsCor = $rsCor;
    }
        
    /**
     *
     * Enter description here ...
     */
    public function listagemAction()
    {
        $VwVeiculo = new Model_Cliente_VwVeiculo();
        $rsVeiculo = $VwVeiculo->fetchAll(array('id_organizacao = ?' => $this->idOrganizacao), '',30 )->toArray();
    	$this->view->rsVeiculo = $rsVeiculo;
    }
    
    /**
     *
     * @param unknown $params
     * @return string
     */
    public function getdadoscadastrados($params)
    {
    	$dadospagina = $this->mVeiculo->fetchAll(array('id_veiculo = ?' => $params))->toArray();
    	return $dadospagina[0];
    }
}