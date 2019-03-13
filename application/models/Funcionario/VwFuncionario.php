<?php

class Model_Funcionario_VwFuncionario extends Zend_Db_Table
{
	protected $_schema  = 'funcionario';
	protected $_name    = 'vw_funcionario';
	protected $_primary = array('id_funcionario');
}