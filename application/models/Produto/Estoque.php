<?php

class Model_Produto_Estoque extends Zend_Db_Table
{
    protected $_schema  = 'produto';
    protected $_name    = 'estoque';
    protected $_primary = array('id_organizacao','id_produto');
}