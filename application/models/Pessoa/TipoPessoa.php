<?php

class Model_Pessoa_TipoPessoa extends Zend_Db_Table
{
	protected $_schema  = 'pessoa';
	protected $_name    = 'tipo_pessoa';
	protected $_primary = array('id_tipo_pessoa');
}