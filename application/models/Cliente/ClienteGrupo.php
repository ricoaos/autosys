<?php

class Model_Cliente_ClienteGrupo extends Zend_Db_Table
{
	protected $_schema  = 'cliente';
	protected $_name    = 'cliente_grupo';
	protected $_primary = array('id_cliente','id_grupo');
}