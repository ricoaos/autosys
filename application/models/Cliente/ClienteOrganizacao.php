<?php

class Model_Cliente_ClienteOrganizacao extends Zend_Db_Table
{
	protected $_schema  = 'cliente';
	protected $_name    = 'cliente_organizacao';
	protected $_primary = array('id_cliente','id_organizacao');
}