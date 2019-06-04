<?php

class Model_Fornecedor_FornecedorGrupo extends Zend_Db_Table
{
	protected $_schema  = 'fornecedor';
	protected $_name    = 'fornecedor_grupo';
	protected $_primary = array('id_fornecedor','id_grupo ');
}