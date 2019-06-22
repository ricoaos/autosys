<?php

class Model_Produto_EntradaItens extends Zend_Db_Table
{
    protected $_schema  = 'produto';
    protected $_name    = 'entrada_itens';
    protected $_primary = array('id_entrada', 'id_produto,');
}