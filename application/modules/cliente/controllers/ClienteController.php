<?php
class Cliente_ClienteController extends App_Controller_Action
{
	public function init()
	{
		$this->idOrganizacao = App_Identity::getOrganizacao();
	}

	/**
	 * 
	 * @throws Exception
	 */
	public function indexAction()
	{
		//Busca as informações cadastradas
	    if($this->_request->getParam('id'))
	    {
			list($date,$id) = explode('@',base64_decode($this->_request->getParam('id')));
			$args = self::getdadoscadastrados($id);
			
			if(!empty($args["st_foto"])){	             
			    file_put_contents(APPLICATION_PATH . '/../public/img/fotos/usuario/'.$args['id_pessoa'].".png", base64_decode($args["st_foto"]));
			}
			
			$this->view->dadospagina = $args;
		}
		
		if($this->_request->getParam('id_similar'))
		{
		    list($date,$id_pessoa) = explode('@',base64_decode($this->_request->getParam('id_similar')));
		    $args = self::getdadospessoa($id_pessoa);
		    
		    if(!empty($args["st_foto"])){
		        file_put_contents(APPLICATION_PATH . '/../public/img/fotos/usuario/'.$id_pessoa.".png", base64_decode($args["st_foto"]));
		    }
		    
		    $this->view->dadospagina = $args;
		}
		
		$mTipoPessoa = new Model_Pessoa_TipoPessoa();
		$rsTipoPessoa = $mTipoPessoa->fetchAll()->toArray();
		$this->view->tipoPessoa = $rsTipoPessoa;
		
	    //Realiza a inserção das informações 
		if($this->_request->isPost())
    	{
    	    $mPessoa = new Model_Pessoa_Pessoa();
			$mCliente = new Model_Cliente_Cliente();
			$mClienteOrg = new Model_Cliente_ClienteOrganizacao();
    		$post = $this->_request->getPost();
    		$dtcadastro = date('Y-m-d H:i:s');
			list($dd,$mm,$YY) = explode('/',$post["dt_nascimento"]);
			
			if(!empty($post["imagem"])){
                list($tipo,$conteudo) = explode(",", $post["imagem"]);
			}
			
    		$dados = array(
				'st_cpf'            => preg_replace('/\D+/', '', $post["st_cpf"]),
				'st_nome'           => strtoupper($post["st_nome"]),
    			'st_nome_sondex'    => soundex($post["st_nome"]),
    			'st_nome_metaphone' => metaphone($post["st_nome"]),
				'dt_nascimento'     => $YY.'-'.$mm.'-'.$dd,
				'id_foto'           => !empty($post["imagem"]) ? 1 : (!empty($post['id_foto'])? $post['id_foto'] : null),
				'st_sexo'           => $post['st_sexo'],
				'st_email'          => $post['st_email'],
                'id_tipo_pessoa'    => $post['id_tipo_pessoa'],
				'st_fonecontato'    => preg_replace('/\D+/', '', $post["st_fonecontato"]),
				'st_foto'           => !empty($post["imagem"]) ? $conteudo : (!empty($post['imagem'])? $post['imagem'] : null),
    		    'st_cep'            => preg_replace('/\D+/', '', $post["st_cep"]),
    		    'st_tipo_logradouro' => $post['st_tipo_logradouro'],
    		    'st_estado'          => $post['st_estado'],
    		    'st_logradouro'      => $post['st_logradouro'],
    		    'st_complemento'     => $post['st_complemento'],
    		    'st_numero'          => $post['st_numero'],
    		    'st_bairro'          => $post['st_bairro'],
    		    'st_cidade'          => $post['st_cidade'],
			);
    		  		
    		try {
    			
    		    if(empty($post["id_cliente"])){
    		        
    		        if(empty($post["id_pessoa"])){ 
    					$dados['dt_cadastro']= $dtcadastro;
    					$rspessoa = $mPessoa->insert($dados);
    		        }else{
    		            $rspessoa = $post["id_pessoa"];
    		        }
										
					$args = array('id_pessoa'     => $rspessoa,
					              'id_ativo'      => 1,
        					      'ds_observacao' => $post['ds_observacao'],
        					      'dt_cadastro'   => $dtcadastro);
					$rsCliente = $mCliente->insert($args);
					
					$params = array('id_cliente' => $rsCliente, 'id_organizacao' => $this->idOrganizacao);
					$rsClienteOrg = $mClienteOrg->insert($params); 
					
    		    }else{
    		        
    		        $where = $mPessoa->getAdapter()->quoteInto('id_pessoa = ?', $post["id_pessoa"]);
    		        $mPessoa->update($dados,$where);
    		        
    		        $args = array(
    		            'id_ativo'      => empty($post['id_ativo'])? 0 : $post['id_ativo'],
    		            'ds_observacao' => $post['ds_observacao']);
    		        
    		        $where2 = $mCliente->getAdapter()->quoteInto('id_cliente = ?', $post['id_cliente']);
    		        $mCliente->update($args,$where2);
    		        
    		        $rsCliente = $post["id_cliente"];
    		    }
    		    				
    		    $getdados = self::getdadoscadastrados($rsCliente);
    			$this->view->dadospagina = $getdados;

				//Realiza o decode da imagem e grava no diretorio informado
				if(!empty($post["imagem"])){	             
				    $idFoto = empty($post["id_pessoa"]) ? $rspessoa : $post["id_pessoa"];
					if(!file_put_contents(APPLICATION_PATH . '/../public/img/fotos/usuario/'.$idFoto.".png", base64_decode($getdados["st_foto"]))){
						throw new Exception(1);
					}
				}

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
	    $mCliente = new Model_Cliente_VwCliente();
	    $rsCliente = $mCliente->fetchAll(array('id_organizacao = ?' => $this->idOrganizacao), '',30)->toArray();
		$this->view->rsPacientes = $rsCliente;
	}
		
	/**
	 * 
	 * Enter description here ...
	 */
	public function inativarregistroAction()
	{
		if($this->_request->getParam('id'))
		{
			list($date,$id) = explode('@',base64_decode($this->_request->getParam('id')));
			$mPaciente = new Model_Cliente_Cliente();
			$where = $mPaciente->getAdapter()->quoteInto('id_cliente = ?', $id );
			$mPaciente->update(array('id_ativo'=> 0),$where);
			$this->_redirect('cliente/cliente/listagem');
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function getclientebycpfAction()
	{
		if($this->_request->isPost())
    	{
    	    $cpf = $this->_request->getPost();
    	    
    	    $mCliente = new Model_Cliente_VwCliente();
    	    $rsCpf = $mCliente->fetchAll(array('st_cpf = ?'=> $cpf))->toArray();
    	    
    		$this->_helper->layout->disableLayout();
            $this->getHelper('viewRenderer')->setNoRender();
            $this->getResponse()->setBody(json_encode(array('result' => $rsCpf)));
    	}
	}
	
	/**
	 * 
	 *
	 */
	public function getregistrosimilarAction()
	{
		if($this->_request->isPost())
		{
			$string = $this->_request->getPost();
			$mPessoa = new Model_Pessoa_Pessoa();
			$rows = $mPessoa->fetchAll(array('st_nome_sondex=?'=>soundex($string['nome'])))->toArray();
			$a = metaphone($string['nome']);
			$result = array();
			foreach ($rows as $dados){
				$b = metaphone($dados['st_nome']);
				similar_text($a,$b,$percent);
				if($percent > 85){
				    if(isset($dados["dt_nascimento"]))list($YY,$mm,$dd) = explode('-',$dados["dt_nascimento"]);
					$result[] = array(
						'id_foto'       => $dados['id_foto'],
						'id_pessoa'     => $dados['id_pessoa'],
						'st_nome'       => $dados['st_nome'],
						'dt_nascimento' => isset($dados["dt_nascimento"]) ? $dd.'/'.$mm.'/'.$YY : '',
					    'dt_cadastro'   => substr($dados['dt_cadastro'],8,2).'/'.substr($dados['dt_cadastro'],5,2).'/'.substr($dados['dt_cadastro'],0,4),
					    'st_cpf'        => !empty($dados['st_cpf']) ? substr($dados['st_cpf'],0,3).'.'.substr($dados['st_cpf'],3,3).'.'.substr($dados['st_cpf'],6,3).'-'.substr($dados['st_cpf'],9) : ''
					);
				}
			}
			
			$this->_helper->layout->disableLayout();
			$this->getHelper('viewRenderer')->setNoRender();
            $this->getResponse()->setBody(json_encode(array('result' => $result)));
		}
	}
	
	public function getdadospessoa($params)
	{
	    $mPessoa = new Model_Pessoa_Pessoa();
	    $dadospagina = $mPessoa->fetchAll(array('id_pessoa = ?' => $params))->toArray();
	    list($YY,$mm,$dd) = explode('-',$dadospagina[0]["dt_nascimento"]);
	    $dadospagina[0]["dt_nascimento"] = $dd.'/'.$mm.'/'.$YY;
	    $dadospagina[0]["id_cliente"] = null;
	    $dadospagina[0]["ds_observacao"] = null;
	    $dadospagina[0]["id_ativo"] = null;
	    return $dadospagina[0];
	}
	
	/**
	 * 
	 * @param unknown $params
	 * @return string
	 */
	public function getdadoscadastrados($params)
	{
	    $mCliente = new Model_Cliente_VwCliente();
	    $dadospagina = $mCliente->fetchAll(array('id_cliente = ?' => $params))->toArray();
		list($YY,$mm,$dd) = explode('-',$dadospagina[0]["dt_nascimento"]);
	    $dadospagina[0]["dt_nascimento"] = $dd.'/'.$mm.'/'.$YY;
		return $dadospagina[0];
	}
}