<?php

class Model_Cliente_VwVeiculo extends Zend_Db_Table
{
    protected $_schema = 'cliente';
    protected $_name   = 'vw_veiculo';
    protected $_primary = array('id_veiculo');
}