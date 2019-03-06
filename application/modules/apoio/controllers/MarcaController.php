<?php

class Apoio_MarcaController extends App_Controller_Action
{
	public function getmodelomarcaAction(){

		if($this->_request->isPost())
    	{
    		$marca = $this->_request->getPost();
    		$mModeloMarca = new Model_Apoio_ModeloMarcaVeiculo();
			$rows = $mModeloMarca->fetchAll(array('id_marca_veiculo = ?'=> $marca))->toArray();
    		$this->_helper->layout->disableLayout();
            $this->getHelper('viewRenderer')->setNoRender();
            $this->getResponse()->setBody(json_encode(array('result' => $rows)));
    	}
	}
}