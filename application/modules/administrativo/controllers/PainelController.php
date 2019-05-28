<?php

class Administrativo_PainelController extends App_Controller_Action
{
    public function init()
    {
        $this->idOrganizacao = App_Identity::getOrganizacao();
    }
    
    public function indexAction()
    {
        $mProdutos = new Model_Produto_Produto();
        $rsProduto = self::getcount($mProdutos);
        $this->view->rsProduto = $rsProduto;
        
        $mCliente = new Model_Cliente_VwCliente();
        $rsCliente = self::getcount($mCliente,1);
        $this->view->rsCliente = $rsCliente; 
        
    }
    
    public function getcount($params, $where=null)
    {
        $select = $params->select();
        $select->from($params,array('count(*) as count'));
        if($where == 1){
        
            $select->where('id_organizacao = ?' , $this->idOrganizacao);
        
        }
        $rows = $params->fetchAll($select);
        return($rows[0]);
    }
}