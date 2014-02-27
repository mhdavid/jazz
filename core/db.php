<?php
/*******************************************************************************
@INFORMACOES BASICAS
--------------------------------------------------------------------------------
@CRIACAO.....: 10/04/2013
@AUTOR.......: Adriel Vieira <ahdriel@gmail.com>
@AUTOR.......: Márcio David <marcio.h.david@gmail.com>
@LINGUAGEM...: PHP
@VERSAO......: 1.0
@NOME FISICO.: db.php
@NOME CODIGO.: Data
@UTILIDADE...: Classe de Conexão com Base de Dados Via ADO do Framework JAZZMVC 1.0
@INTRODUCAO..: JAZZMVC Revision SVN 02
@STATUS......: [X] Construção, [] Operação, [] Manutenção, [] Fora de uso
*******************************************************************************/

class Db
{
	private static $db;
	
	public static function init()
	{
		if(!self::$db)
		{
			global $config;
			try
			{
				$dsn = 'mysql:host='.$config['db_host'].';dbname='.$config['db_name'].';charset= ISO-8859-1';
				//$dsn = 'mysql:host='.$config['db_host'].';dbname='.$config['db_name'].';charset=UTF-8';
				self::$db = new LoggedPDO($dsn, $config['db_username'], $config['db_password']);
				self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

			}
			catch (PDOException $e)
			{
				die('Connection error: ' . $e->getMessage());
			}
		}
		return self::$db;
	}
}