<?php

class Model_Pessoa_Pessoa extends Zend_Db_Table
{
	protected $_schema  = 'pessoa';
	protected $_name    = 'pessoa';
	protected $_primary = array('id_pessoa');
}