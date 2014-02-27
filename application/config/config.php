<?php 
/****************************************************************************************************************************
@INFORMACOES BASICAS
-----------------------------------------------------------------------------------------------------------------------------
@CRIACAO.....: 10/04/2013
@AUTOR.......: Adriel Vieira <ahdriel@gmail.com>
@AUTOR.......: Márcio David <marcio.h.david@gmail.com>
@LINGUAGEM...: PHP
@VERSAO......: 1.0
@NOME FISICO.: config.php
@NOME CODIGO.: Opus
@UTILIDADE...: Arquivo de Configuração do Framework JAZZMVC 1.0
@INTRODUCAO..: JAZZMVC Revision SVN 02
@STATUS......: [X] Construção, [] Operação, [] Manutenção, [] Fora de uso
*****************************************************************************************************************************/

/********* CONFIG DA URL BASE ***********************************************************************************************/
$config['base_url'] = 'http://sigecom_jazz.cav.udesc.br/'; 	   	// URL base incluindo a barra no final (e.g. http://localhost/)

/********* CONFIG DA BASE DE DADOS ******************************************************************************************/
$config['db_host'] = 'localhost'; 					       	// Base de Dados : Host (e.g. localhost)
$config['db_name'] = 'sigecom_edit'; 					       	//      ""       : Nome  (ex. BDados)
$config['db_username'] = 'sigecomjazz'; 				     	//      ""       : Usuário (ex. root)
$config['db_password'] = 'coelho'; 				       	//      ""       : Senha

/********* CONFIG DO MÉTODO DE LOGIN ****************************************************************************************/
/********* Requer configuração correta da base de dados *********************************************************************/

$config['permission_enable'] = false;                		// Habilita Conferência de Permissões de Acesso
$config['login_enable'] = true;                     		// Habilita Login Obrigatório
$config['login_field_login'] = '';                   		// Nome do Campo que Contém o Login do Usuário no BDB
$config['login_field_password'] = '';               		// Nome do Campo que Contém o Password do Usuário no BDB
$config['login_field_id'] = '';                      		// Nome do Campo que Contém o ID do Usuário no BD
$config['login_field_salt'] = '';                    		// Nome do Campo que Contém o SALT do Usuário no BD


/********* DEFINICOES DOS ALIASES DOS MODULOS ATIVOS ************************************************************************/
/*
$config['module_name']['destinatarios'] = "Contatos";
$config['module_name']['sobre'] = "Créditos";
$config['module_name']['postbear'] = "Sistema";

/********* DEFINICOES DOS MODULOS DE INICIALIZAÇÃO PADRÃO *******************************************************************/
$config['default_module'] = 'sigecom';
$config['default_controller'] = 'dashboard';
$config['error_controller'] = 'error';

/********* DEFINICOES DO TEMA DO BOOTSTRAP **********************************************************************************/
 $config['theme']='default'; 
# $config['theme']='superhero'; 
# $config['theme']='united'; 
# $config['theme']='cyborg'; 

/********* DEFINICOES DIVERSAS **********************************************************************************************/
$config['application_name']='SIGECOM 3.0 Alpha 0.0.1';

/****************************************************************************************************************************/
