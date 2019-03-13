<?php

class Model_Apoio_ContaBanco extends Zend_Db_Table
{
	protected $_schema  = 'apoio';
	protected $_name    = 'conta_banco';
	protected $_primary = array('id_conta_banco');
}