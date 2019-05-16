<?php

class Model_Produto_VwProduto extends Zend_Db_Table
{
    protected $_schema  = 'produto';
    protected $_name    = 'vw_produto';
    protected $_primary = array('id_produto');
}