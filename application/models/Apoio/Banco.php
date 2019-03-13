<?php

class Model_Apoio_Banco extends Zend_Db_Table
{
	protected $_schema  = 'apoio';
	protected $_name    = 'banco';
	protected $_primary = array('id_banco');
}