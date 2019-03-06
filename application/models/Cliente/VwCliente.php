<?php

class Model_Cliente_VwCliente extends Zend_Db_Table
{
    protected $_schema = 'cliente';
    protected $_name   = 'vw_cliente';
    protected $_primary = array('id_cliente');
}