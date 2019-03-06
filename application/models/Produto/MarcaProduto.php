<?php

class Model_Produto_MarcaProduto extends Zend_Db_Table
{
	protected $_schema  = 'produto';
	protected $_name    = 'marca_produto';
	protected $_primary = array('id_marca_produto');
}