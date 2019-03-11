<?php

class Model_Apoio_ModeloMarcaVeiculo extends Zend_Db_Table
{
	protected $_schema  = 'apoio';
	protected $_name    = 'modelo_marca_veiculo';
	protected $_primary = array('id_modelo_marca_veiculo','id_marca_veiculo');
}