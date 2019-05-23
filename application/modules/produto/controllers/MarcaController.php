<?php
class Produto_MarcaController extends App_Controller_Action
{
    public function init()
    {
        $this->idOrganizacao = App_Identity::getOrganizacao();
        $this->idUsuario = App_Identity::getIdUsuario();
        $this->mMarcaProduto = new Model_Produto_MarcaProduto();
    }
    
    public function indexAction()
    {
        //Busca as informações cadastradas
        if($this->_request->getParam('id'))
        {
            list($date,$id) = explode('@',base64_decode($this->_request->getParam('id')));
            $args = self::getdadoscadastrados($id);
            $this->view->dadospagina = $args;
        }
        
        $post = $this->_request->getPost();
               
        //Realiza a inserção das informações
        if($this->_request->isPost())
        {
   
            try {
                $dados = array('st_nome'=>strtoupper($post["st_nome"]));
                
                if(empty($post['id_marca_produto'])){
                    
                    
                    $rsMarcaProduto = $this->mMarcaProduto->insert($dados);

                }else{
                    
                    $where = $this->mMarcaProduto->getAdapter()->quoteInto('id_marca_produto = ?', $post["id_marca_produto"]);
                    $this->mMarcaProduto->update($dados, $where);
                  
                    $rsMarcaProduto = $post['id_marca_produto'];
                }
                
                $getdados = self::getdadoscadastrados($rsMarcaProduto);
                $this->view->dadospagina = $getdados;
                
                $msg=2;
                
            } catch (Zend_Db_Exception $e) {
                $e->rollBack();
                $msg= $e->getMessage();
            }
            
            $this->view->msg = $msg;
        }
        
    }
    
    /**
     *
     * Enter description here ...
     */
    public function listagemAction()
    {
        $rsMarcaProduto = $this->mMarcaProduto->fetchAll()->toArray();
        $this->view->rsMarcaProduto = $rsMarcaProduto;
    }
    
    /**
     *
     * @param unknown $params
     * @return string
     */
    public function getdadoscadastrados($params)
    {
        $dadospagina = $this->mMarcaProduto->fetchAll(array('id_marca_produto = ?' => $params))->toArray();
        return $dadospagina[0];
    }
}