<?php

class Model_Produto_EstoqueEntrada extends Zend_Db_Table
{
    protected $_schema  = 'produto';
    protected $_name    = 'estoque_entrada';
    protected $_primary = array('id_estoque_entrada');
}