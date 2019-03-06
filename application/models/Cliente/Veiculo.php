<?php

class Model_Cliente_Veiculo extends Zend_Db_Table
{
	protected $_schema  = 'cliente';
	protected $_name    = 'veiculo';
	protected $_primary = array('id_veiculo');
}