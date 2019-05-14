<?php

class Model_Produto_ProdutoFornecedor extends Zend_Db_Table
{
    protected $_schema  = 'produto';
    protected $_name    = 'produto_fornecedor';
    protected $_primary = array('id_produto','id_fornecedor');
}