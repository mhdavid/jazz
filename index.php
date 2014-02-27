<?php
/*******************************************************************************
@INFORMACOES BASICAS
--------------------------------------------------------------------------------
@CRIACAO.....: 04/04/2013
@AUTOR.......: Adriel Vieira <ahdriel@gmail.com>
@AUTOR.......: Márcio David <marcio.h.david@gmail.com>
@LINGUAGEM...: PHP
@VERSAO......: 1.0
@NOME FISICO.: index.php
@NOME CODIGO.: Overture
@UTILIDADE...: Arquivo de Inicialização do Framework JAZZMVC 1.0
@INTRODUCAO..: JAZZMVC Revision SVN 01
@STATUS......: [X] Construção, [] Operação, [] Manutenção, [] Fora de uso
*******************************************************************************/
$session_name = 'jazz';                             // DEFINE O NOME DA SESSAO.
$secure = false;                                    // DEFINIR COMO TRUE SE UTILIZAR PROTOCOLO HTTPS.
$httponly = true;                                   // SE DEFINIDO COMO TRUE IMPEDE QUE O JAVASCRIPT TENHA ACESSO AO ID DA SESSAO.
ini_set('session.use_only_cookies', 1);             // FORÇA AS SESSOES PARA USAR SOMENTE COOKIES.
$cookieParams = session_get_cookie_params();        // CAPTURA OS PARAMETROS DO COOKIE ATUAL.
session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
session_name($session_name);                        // DEFINE O NOME DA SESSAO PARA O CONJUNTO ACIMA
session_start();                                    // INICIA A SESSAO PHP
session_regenerate_id(true);                        // REGENERA A SESSAO E APAGA A ANTIGA.

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', realpath(dirname(__FILE__)) . DS);
define('APP_DIR', ROOT_DIR .'application' . DS);

require(APP_DIR .'config'.DS.'config.php');


//Rotina inclusão de todos os arquivos no diretório root
foreach (glob(ROOT_DIR.'core'.DS.'*.php') as $arquivo)
{
	require($arquivo);
}

define('BASE_URL', $config['base_url']);

jazz();