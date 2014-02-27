<?php
/*******************************************************************************
@INFORMACOES BASICAS
--------------------------------------------------------------------------------
@CRIACAO.....: 10/04/2013
@AUTOR.......: Adriel Vieira <ahdriel@gmail.com>
@AUTOR.......: Márcio David <marcio.h.david@gmail.com>
@LINGUAGEM...: PHP
@VERSAO......: 1.0
@NOME FISICO.: controller.php
@NOME CODIGO.: Piper
@UTILIDADE...: Classe de Controle do Framework JAZZMVC 1.0
@INTRODUCAO..: JAZZMVC Revision SVN 02
@STATUS......: [X] Construção, [] Operação, [] Manutenção, [] Fora de uso
*******************************************************************************/

class Controller {
	
	public function loadModel($name)
	{
		global $env;
		require(APP_DIR . 'modules' . DS . $env['module'] . DS . 'models' . DS . strtolower($name) .'.php');
		$model = new $name;
		return $model;
	}
	
	public function loadView($name)
	{
		$view = new View($name);
		return $view;
	}
	
	public function loadPlugin($name)
	{
		require(APP_DIR .'plugins' . DS . strtolower($name) .'.php');
	}
	
	public function loadHelper($name)
	{
		require(APP_DIR .'helpers'. DS . strtolower($name) .'.php');
		$helper = new $name;
		return $helper;
	}

	
    
}