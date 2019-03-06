<?php

class Model_Fornecedor_FornecedorOrganizacao extends Zend_Db_Table
{
	protected $_schema  = 'fornecedor';
	protected $_name    = 'fornecedor_organizacao';
	protected $_primary = array('id_fornecedor','id_organizacao');
}