 <?php

class Dashboard extends Controller
{
	function index()
	{	

		
		$this->model = $this->loadModel('Main_model');
		$svn->helper = $this->loadHelper('phpsvnclient');
		$this->helper_reg = $this->loadHelper('register');
		/*$arr = $this->model->loadPermission($_SESSION['user_id']);
		$arrMenu = $this->model->loadPermissionModule($_SESSION['user_id']);*/
		$template = $this->loadView('dashboard');
		changeTheme($this->helper_reg->getRegistro('configTema',$_SESSION['user_id']));
		
		$svn= new phpsvnclient();
		$svn->setRepository('https://moe.cav.udesc.br/svn/postbear20/','marcio','marcio');
		$versao=$svn->getVersion();
		//$template->permissions($_SESSION['arr'],$_SESSION['arrMenu']);
		$template->set('usuario',$_SESSION['nome']);
		$template->set('setor',$_SESSION['setor']);
		$template->set('centro',$_SESSION['centro']);
		$template->set('versao',$versao);
		$template->set('grupo', $this->model->getGroups($_SESSION['id_grupo']));
		$template->set('email',$_SESSION['email']);
		$template->set('tema',$_SESSION['tema']);
		$template->set('ultimoupdate',$_SESSION['lastupdate']);
		$template->set('listaMensagens',$this->model->listaMensagens('2'));
		$footerLoad=file_get_contents(ROOT_DIR.'static/inc/footer.php');

		//$template->set('FOOTER',$footerLoad);
		//print_r(svn_log ('https://moe.cav.udesc.br/jazzmvc/' , 1, 92));
		
		$template->render();
	}

}