<?php

class Model_Produto_EstoqueSaida extends Zend_Db_Table
{
    protected $_schema  = 'produto';
    protected $_name    = 'estoque_saida';
    protected $_primary = array('id_estoque_saida');
}