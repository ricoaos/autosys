<?php

class Model_Produto_GrupoProduto extends Zend_Db_Table
{
	protected $_schema  = 'produto';
	protected $_name    = 'grupo_produto';
	protected $_primary = array('id_grupo_produto');
}