<?php

class Model_Produto_VwEntrada extends Zend_Db_Table
{
    protected $_schema  = 'produto';
    protected $_name    = 'vw_entrada';
    protected $_primary = array('id_produto');
}