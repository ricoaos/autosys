<?php

class Model_Produto_Produto extends Zend_Db_Table
{
    protected $_schema  = 'produto';
    protected $_name    = 'produto';
    protected $_primary = array('id_produto');
}