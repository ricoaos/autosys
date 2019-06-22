<?php

class Model_Produto_Entrada extends Zend_Db_Table
{
    protected $_schema  = 'produto';
    protected $_name    = 'entrada';
    protected $_primary = array('id_entrada');
}