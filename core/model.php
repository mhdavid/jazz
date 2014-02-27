<?php
/*******************************************************************************
@INFORMACOES BASICAS
--------------------------------------------------------------------------------
@CRIACAO.....: 10/04/2013
@AUTOR.......: Adriel Vieira <ahdriel@gmail.com>
@AUTOR.......: Márcio David <marcio.h.david@gmail.com>
@LINGUAGEM...: PHP
@VERSAO......: 1.0
@NOME FISICO.: model.php
@NOME CODIGO.: Crawford
@UTILIDADE...: Classe de Models do Framework JAZZMVC 1.0
@INTRODUCAO..: JAZZMVC Revision SVN 02
@STATUS......: [X] Construção, [] Operação, [] Manutenção, [] Fora de uso
*******************************************************************************/

class Model {

	protected $db;

	public function __construct()
	{
		$this->db = Db::init();
	}

	public function escapeString($string)
	{
		return mysql_real_escape_string($string);
	}

	public function escapeArray($array)
	{
	    array_walk_recursive($array, create_function('&$v', '$v = mysql_real_escape_string($v);'));
		return $array;
	}

	public function loadHelper($name)
	{
		require(APP_DIR .'helpers'. DS . strtolower($name) .'.php');
		$helper = new $name;
		return $helper;
	}

}