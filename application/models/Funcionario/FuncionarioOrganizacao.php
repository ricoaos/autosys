<?php

class Model_Funcionario_FuncionarioOrganizacao extends Zend_Db_Table
{
	protected $_schema  = 'funcionario';
	protected $_name    = 'funcionario_organizacao';
	protected $_primary = array('id_funcionario','id_organizacao');
}