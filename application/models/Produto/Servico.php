<?php

class Model_Produto_Servico extends Zend_Db_Table
{
    protected $_schema  = 'produto';
    protected $_name    = 'servico';
    protected $_primary = array('id_servico');
}