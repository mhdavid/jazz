<?php
#Configurações#
class ConfigPost extends Controller
{

	function __construct()
		{
		$this->model = $this->loadModel('Main_model');
		$this->helper_reg = $this->loadHelper('Register');
		}

	function index()
		{
		#Servidor de E-mail#
		$template = $this->loadView('configView');
		
		

		$template->set('host', $this->helper_reg->getRegistro('configMail', 'SMTPHost'));
		$template->set('porta',$this->helper_reg->getRegistro('configMail','SMTPPort'));
		

		if ($this->helper_reg->getRegistro('configMail', 'Autenticar')=='Sim')	
			{
			$autenticar='checked';
			}	
		else
			{
			$autenticar='';	
			}
		if ($this->helper_reg->getRegistro('configMail','SSL')=='Sim')	
			{
			$ssl='checked';
			}	
		else
			{
			$ssl='';	
			}
		$template->set('autenticar', $autenticar);
		$template->set('ssl', $ssl);
		$template->set('emailOrigem',$this->helper_reg->getRegistro('configMail', 'EmailOrigem'));
		$template->set('remetenteOrigem',$this->helper_reg->getRegistro('configMail', 'RemetenteOrigem'));
		$template->set('senhaEmail',$this->helper_reg->getRegistro('configMail', 'SenhaEmail'));
		$template->render();
		}

	function _setConfig()
		{
		#Configurar Servidor E-mail#
		$template = $this->loadView('postConclusoes');
		$data='';
		$falha = array ('SMTP Host'=>false, 'SMTP Porta'=>false, 'Autenticar'=>false, 'SSL'=>false, 'Senha Email'=>false, 'E-mail Origem'=>false, 'Remetente Origem'=>false, 'SMTP Host'=>false);

		$falha['SMTP Host']=$this->helper_reg->setRegistro('configMail','SMTPHost', $_POST['smtpHost'] );
		$falha['SMTP porta']=$this->helper_reg->setRegistro('configMail','SMTPPort', $_POST['smtpPort'] );
		if (isset($_POST['autenticar']))
			{
			$autenticar='Sim';
		
			}
		else
			{
			$autenticar='Nao';
			}

		$falha['Autenticar']=$this->helper_reg->setRegistro('configMail','Autenticar', $autenticar );	

		if (isset($_POST['ssl']))
			{
			$ssl='Sim';
			$falha['SSL']=$this->helper_reg->setRegistro('configMail','SSL', $ssl );
			}
		

		if (isset($_POST['senhaEmail']))
			{
			$falha['Senha Email']=$this->helper_reg->setRegistro('configMail','SenhaEmail', $_POST['senhaEmail']);
			}
		
		
		
		$falha['Email Origem']=$this->helper_reg->setRegistro('configMail','EmailOrigem', $_POST['emailOrigem'] );
		$falha['Remetente Origem']=$this->helper_reg->setRegistro('configMail','RemetenteOrigem', $_POST['remetenteOrigem'] );
		$template->set('msgInfo', 'Configurações Concluídas');
		$template->set('acao', 'Compor Uma Mensagem');

		foreach ($falha as $key => $value)
			{
			if (isset($falha[$key]))
				{
				if ($falha[$key])
					{
					$data.='<div class="alert alert-success"><b>'.$key.'</b> Configurada com sucesso.</div>';	
					}			
				else
					{
					$data.='<div class="alert alert-error">Erro <b>'.$key.'</b></div>';
					}
				}
			}
		

		$template->set('msgRetorno', $data);
		$template->render();	
		}

	function avisos()
	{
	$template = $this->loadView('avisosView');
	$template->set('avisoNao', $this->helper_reg->getRegistro('configAviso','avisoNao'));
	$template->set('avisoSim', $this->helper_reg->getRegistro('configAviso','avisoSim'));
	$template->set('avisoInstitucional', $this->helper_reg->getRegistro('configAviso','avisoInstitucional'));
	$template->render();
	}

	function _setAvisos()
	{
	#Configurar Avisos#
	$template = $this->loadView('postConclusoes');

	$data='';
	$template->set('msgInfo', 'Configurações de Avisos Concluídas');
	$template->set('acao', 'Compor Uma Mensagem');
	
	$falha['avisoNao']=$this->helper_reg->setRegistro('configAviso','avisoNao', $_POST['avisoNao'] );
	$falha['avisoSim']=$this->helper_reg->setRegistro('configAviso','avisoSim', $_POST['avisoSim'] );
	$falha['avisoInstitucional']=$this->helper_reg->setRegistro('configAviso','avisoInstitucional', $_POST['avisoInstitucional'] );

	$aviso['avisoSim']="Aviso Responder";
	$aviso['avisoNao']="Aviso Não Responder";
	$aviso['avisoInstitucional']="Aviso Institucional";
	foreach ($falha as $key => $value)
		{
		if (isset($falha[$key]))
			{
			if ($falha[$key])
				{
				$data.='<div class="alert alert-success"><b>'.$aviso[$key].'</b> Configurada com sucesso.</div>';	
				}			
			else
				{
				$data.='<div class="alert alert-error">Erro <b>'.$aviso[$key].'</b></div>';
				}
			}
		}
	$template->set('msgRetorno', $data);
	$template->render();
	}


	function temas()
		{
		#Configurar Temas#
		$template = $this->loadView('temasView');
		$pastas=$arquivos=$temas='';
		// pega o endereço do diretório
		$diretorio = 'static/css/theme/'; 
		//$diretorio = getcwd();
		// abre o diretório
		$ponteiro  = opendir($diretorio);
		// monta os vetores com os itens encontrados na pasta
		while ($nome_itens = readdir($ponteiro))
			{
		    $itens[] = $nome_itens;
			}

		sort($itens);
		// percorre o vetor para fazer a separacao entre arquivos e pastas 
		foreach ($itens as $listar)
			{
		  	if ($listar!="." && $listar!=".." && $listar!="img")
		   		{ 
		   		$select='';
		   		if ($listar==$_SESSION['tema'])
		   			{
		   				$select='selected';
		   			}
				$temas.='<option value="'.$listar.'" '.$select.' class="temas">'.$listar.'</option>'."\n"; 
		   		}
			}

		$template->set('temasDisponiveis', $temas);
		$template->render();
		}

		function _setTemas()
		{
		#Salvar Temas#
		$this->helper_reg->setRegistro('configTema',$_SESSION['user_id'],$_POST['tema']);
		$_SESSION['tema']=$_POST['tema'];
		$this->temas();
		}

	

}