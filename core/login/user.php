<?php

class User extends Controller {

	function __construct()
	{
		$this->model = $this->loadModel('user_model');
	}

	public function loadModel($name)
	{
		global $env;
		require(ROOT_DIR . 'core' . DS . 'login' . DS . $name . '.php');

		$model = new $name;
		return $model;
	}

	public function login()
	{
		$defmsg='
		<div class="alert alert-info">
Utilize seu usuário e senha do Expresso para utilizar o Sigecom 3.0.<hr/>
Não possui acesso ao Expresso? Solicite-o através do email <a href="mailto:seinfra.setic@udesc.br" title="E-mail do SEINFRA">seinfra.setic@udesc.br</a> ou<br/>ramal direto 5488183.
		</div>';
		$template = $this->loadView('main');
		$template->set('msg_login',$defmsg);
		$jqmsg='
		<div class="alert in alert-block fade alert-error">
  			
  		<strong>Erro></strong> Usuário ou Senha não Conferem.</div>
';
		if (isset($_SESSION['erro_login']))
			{
			$template->set('msg_login',$jqmsg);
			$_SESSION['erro_login']=false;
			}
		$template->render();
	}

	function loginaction()
	{
		$this->model->loginaction();
	}

	function loginactionLdap()
	{
		$this->model->loginactionLdap();
	}

	function logout()
	{
		$this->model->logoutaction();
	}
}