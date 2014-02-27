<?php
	class Usuarios extends Controller 
	{
		function __construct()
		{
			$this->model = $this->loadModel('usuarios_model');
			$this->helper_reg = $this->loadHelper('Register');
		}
		
		function _registrar()
		{
			//$salt = uniqid(rand(0,10000));
			//$this->model->register( $_POST['inputNome'], $_POST['inputEmail'], $_POST['inputLogin'], $_POST['inputSenha'], $_POST['inputGrupo'], $salt);
		$this->model->register( $_POST['inputNome'], $_POST['inputCpf'], $_POST['inputMatricula'], $_POST['inputEmail'], $_POST['inputSetor'], $_POST['inputGrupo'], $_POST['inputCentro']);
		}

		function grupos()
			{
			$template = $this->loadView('gruposView');
			$data=$this->model->listGroups();
			$template->set('grupos', $data[0]);
			$template->set('jquery', $data[1]);
			$template->set('objeto', 'Grupo');
			$template->set('artigoObjeto', 'o');
			$template->render();
			}

		function _novoGrupo()
			{
			#Novo Grupo de Usuários#
			$template = $this->loadView('gruposPropriedadesView');
			$template->set('grupos', $this->model->listGroups());
			$template->set('btn', 'Criar');
			$template->set('nome_grupo', '');
			$template->set('desc_grupo', '');
			$template->set('acao', '_criarGrupo');
			$template->set('permissoes', $template->_getPermissoesEdit());
			$template->render();
			}

		function _editarGrupo($id_grupo)
			{
			#Editar Grupo de Usuários#
			

			$data = $this->model->getDataGroups($id_grupo);
			$template = $this->loadView('gruposPropriedadesView');
			$template->set('btn', 'Editar');
			$template->set('nome_grupo', $data['name']);
			$template->set('desc_grupo', $data['descr']);
			$template->set('acao', '_upgradeGrupo/'.$id_grupo);

			// Recuperando Permissões do Grupo Selecionado
			$this->model->loadGroupPermission($id_grupo);
			$this->model->loadGroupPermissionModule($id_grupo);
			$this->model->loadGroupPermissionController($id_grupo);
			
			$template->permissions($_SESSION['arr'],$_SESSION['arrMenu'],$_SESSION['arrCtrl']);
			$template->set('permissoes', $template->_getPermissoesEdit());
			
			// Restaurando Permissões do Grupo Corrente
			$this->model->loadGroupPermission($_SESSION['id_grupo']);
			$this->model->loadGroupPermissionModule($_SESSION['id_grupo']);
			$this->model->loadGroupPermissionController($_SESSION['id_grupo']);
			$template->permissions($_SESSION['arr'],$_SESSION['arrMenu'],$_SESSION['arrCtrl']);
			$template->render();
			}


		function _criarGrupo()
			{
			#Salvar Grupo de Usuários#
			$idGrpoCriado=$this->model->registerGroup($_POST['nome_grupo'],$_POST['desc_grupo']);
				
			$template = $this->loadView('postConclusoes');
			$template->set('msgInfo','Criação de Grupo de Usuários');
			if ($idGrpoCriado)				{
				$template->set('msgRetorno','<div class="alert alert-success">Grupo <b>'.$_POST['nome_grupo'].'</b> Criado com sucesso.</div>');
				}
			else
				{
				$template->set('msgRetorno','<div class="alert alert-error">Erro ao criar o Grupo <b>'.$_POST['nome_grupo'].'</b></div>');
				}
			$template->set('acao','Concluir');
	
			$template->render();
			}

		function _upgradeGrupo($id_grupo)
			{
			$ret=$this->model->updateGroup($id_grupo);
				
			$template = $this->loadView('postConclusoes');
			$template->set('msgInfo','Edição de Grupo de Usuários');
			if ($ret)				{
				$template->set('msgRetorno','<div class="alert alert-success">Grupo <b>'.$_POST['nome_grupo'].'</b> Foi alterado com sucesso.</div>');
				}
			else
				{
				$template->set('msgRetorno','<div class="alert alert-error">Erro ao Editar o Grupo <b>'.$_POST['nome_grupo'].'</b></div>');
				}
			$template->set('acao','Concluir');
	
			$template->render();
			}

		function buscaLdap($id_grupo='')
			{
			#Busca em LDAP#
			$template = $this->loadView('buscaldap');
			$template->set('id_grupo',$id_grupo);
			$template->render();
			}

		function _buscaLdap($id_grupo='')
			{
			#Listar LDAP#
			$this->loadHelper('ldap');
			$l = new LDAP();
    		$l->conectar();
    		$retorno=$l->buscar($_POST['inputMatCPF'], '');
    		$l->desconectar();
    		//$l->listarEntradas() ;
    		//echo $l->usuarioldap();
    		$userLDAP= $l->usuarioldap();
    		$template = $this->loadView('registrar');
    		$template->set('nome',$userLDAP[0]['cn'][0]);
			$template->set('email',$userLDAP[0]['mail'][0]);
			$template->set('cpf',$userLDAP[0]['cpf'][0]);
			$template->set('matricula',$userLDAP[0]['uid'][0]);
			$template->set('centro',$userLDAP[0]['ou'][0]);
			$template->set('setor',$userLDAP[0]['departmentnumber'][0]);
			
			if ($id_grupo=='')
				{
				$template->set('grupos', $this->model->getGroups());
				}
			else
				{
				$ret='<option value="'.$id_grupo.'">'.$this->model->getGroupName($id_grupo).'</option>';
				$template->set('grupos',$ret);
				}

			$template->render();


			//$salt = uniqid(rand(0,10000));
			//$this->model->register( $_POST['inputNome'], $_POST['inputEmail'], $_POST['inputLogin'], $_POST['inputSenha'], $_POST['inputGrupo'], $salt);
			}


		function _configGrupo($id_grupo)
			{
			$dataf='';
			$dir= ROOT_DIR.'static'.DS.'inc'.DS.'layouts'.DS;
			$folder=opendir($dir);
			while($itemName=readdir($folder))
			{
				$itens[]=$itemName;
			}
			sort ($itens);
			foreach ($itens as $ls) 
				{
				if ($ls!="." && $ls!="..")
					{
					if (is_dir($dir.$ls))
						{
						$rs=$this->helper_reg->getRegistro('configLayoutGrupo_'.$id_grupo,$ls);
						$chk= $rs!='' ? 'checked' :'';

						$dataf.='<label class="checkbox">
						<input name="layout[]" value="'.$ls.'" type="checkbox" '.$chk.'>&nbsp;<i class="fa fa-tag"></i/>&nbsp;&nbsp;'.$ls.'
          </label>';
						}
					}
				}
			$template=$this->loadView('configGrupoView');
			$template->set('grupoUsuarios',$this->model->getGroupName($id_grupo));
			$template->set('id_grupo',$id_grupo);

			$rs=$this->helper_reg->getRegistro('configTipoListaGrupo_'.$id_grupo,'privada');
			$template->set('privada', $rs == 'sim' ? 'checked' : '');

			$rs=$this->helper_reg->getRegistro('configTipoListaGrupo_'.$id_grupo,'restrita');
			$template->set('restrita', $rs == 'sim' ? 'checked' : '');

			$rs=$this->helper_reg->getRegistro('configTipoListaGrupo_'.$id_grupo,'publica');
			$template->set('publica', $rs == 'sim' ? 'checked' : '');

			$rs=$this->helper_reg->getRegistro('configTipoListaGrupo_'.$id_grupo,'global');
			$template->set('global', $rs == 'sim' ? 'checked' : '');

			$template->set('layouts',$dataf);

			$rs=$this->helper_reg->getRegistro('nomeAlternativo_'.$id_grupo,'remetente_1');
			$template->set('remetenteAlternativo1',$rs != '' ? $rs : '');

			$rs=$this->helper_reg->getRegistro('nomeAlternativo_'.$id_grupo,'remetente_2');
			$template->set('remetenteAlternativo2',$rs != '' ? $rs : '');

			$rs=$this->helper_reg->getRegistro('nomeAlternativo_'.$id_grupo,'remetente_3');
			$template->set('remetenteAlternativo3',$rs != '' ? $rs : '');

			$rs=$this->helper_reg->getRegistro('permitirMultiplosRemetentes',$id_grupo);
			$template->set('permissao', $rs == 'sim' ? 'checked' : '');
			$template->set('habilitaMR', $rs == 'sim' ? '' : 'disabled');
			
			$template->render();
			}

		

		function _setConfigGrupos($id_grupo)
			{
			$this->helper_reg->eraseRegistro('configTipoListaGrupo_'.$id_grupo);
			$this->helper_reg->eraseRegistro('configLayoutGrupo_'.$id_grupo);
			$this->helper_reg->eraseRegistro('nomeAlternativo_'.$id_grupo);
			$data='';
			$template=$this->loadView('postConclusoes');
			$tipoLista = $_POST['tipoLista'];
			
			foreach ($tipoLista as $key => $value)
				{
				$grava=$this->helper_reg->setRegistro('configTipoListaGrupo_'.$id_grupo, $tipoLista[$key], 'sim');
				if($grava)
					{
					$data.='<div class="alert alert-success">Tipo de lista <b>'.$tipoLista[$key].'</b> foi configurada com sucesso.</div>';	
					}			
				else
					{
					$data.='<div class="alert alert-error">Erro ao configurar tipo de lista <b>'.$tipoLista[$key].'</b></div>';
					}
				}

			$lay=$_POST['layout'];
			foreach ($lay as $key => $value)
				{
				if (!$this->helper_reg->setRegistro('configLayoutGrupo_'.$id_grupo, $lay[$key], 'sim'))
					{
					$data.='<div class="alert alert-error">Erro ao configurar layout <b>'.$lay[$key].'</b></div>';
					}			
				else
					{
					$data.='<div class="alert alert-success">Layout <b>'.$lay[$key].'</b> foi configurada com sucesso.</div>';
					}
				}

			$permitir='nao';
			if(isset($_POST['permitir']))
				{
				$permitir=$_POST['permitir'];

				for ($remet=1;$remet<=3;$remet++)
					{
				
					if (!$this->helper_reg->setRegistro('nomeAlternativo_'.$id_grupo, 'remetente_'.$remet, $_POST['remetAlter_'.$remet]))
						{
						$data.='<div class="alert alert-error">Erro ao configurar nome alternativo <b>'.$_POST['remetAlter_'.$remet].'</b></div>';
						}			
					else
						{
						$data.='<div class="alert alert-success">Nome alternativo <b>'.$_POST['remetAlter_'.$remet].'</b> foi configurado com sucesso.</div>';	
						}
					}
				}

			if ($this->helper_reg->setRegistro('permitirMultiplosRemetentes',$id_grupo, $permitir));
			
			$data.='<div class="alert alert-success">Permissão de multiplos remetentes foi configurada como <b>"'.$permitir.'</b>" foi configurado com sucesso.</div>';	

			$template->set('msgInfo','Concluíndo Configurações de Grupo de Usuários');
			$template->set('acao','Concluír');
			$template->set('msgRetorno',$data);
			$template->render();
			}

			function _excluirGrupoUsuarios($id_grupo)
			{
				$nome=$this->model->getGroupName($id_grupo);
				$ret=$this->model->deleteGroup($id_grupo);
				$template = $this->loadView('postConclusoes');
				$template->set('msgInfo','Excluir de Grupo de Usuários');
				if ($ret)				{
					$template->set('msgRetorno','<div class="alert alert-success">Grupo <b>'.$nome.'</b> Foi excluído com sucesso.</div>');
					}
				else
					{
					$template->set('msgRetorno','<div class="alert alert-error">Erro ao Excluir o Grupo <b>'.$nome.'</b></div>');
					}
				$template->set('acao','Concluir');
		
				$template->render();	
			}

		
	}