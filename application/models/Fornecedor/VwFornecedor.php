<?php

class Model_Fornecedor_VwFornecedor extends Zend_Db_Table
{
    protected $_schema = 'fornecedor';
    protected $_name   = 'vw_fornecedor';
    protected $_primary = array('id_fornecedor');
}