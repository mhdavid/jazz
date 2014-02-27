<?php
/*******************************************************************************
@INFORMACOES BASICAS
--------------------------------------------------------------------------------
@CRIACAO.....: 10/04/2013
@AUTOR.......: Adriel Vieira <ahdriel@gmail.com>
@AUTOR.......: Márcio David <marcio.h.david@gmail.com>
@LINGUAGEM...: PHP
@VERSAO......: 1.0
@NOME FISICO.: error.php
@NOME CODIGO.: Crasso
@UTILIDADE...: Classe de Tratamento de Erros do Framework JAZZMVC 1.0
@INTRODUCAO..: JAZZMVC Revision SVN 02
*******************************************************************************/

class Jazz extends Controller
    {
	private static $greeting = 'Erro ';
    private static $initialized = false;

    private static function initialize()
        {
        if (self::$initialized)
        	return;

        self::$initialized = true;
        }

    public static function Error($codError)
        {
        global $env;
        $env['module'] = "error";
        $template = self::loadView('errorDisplay');
      	self::initialize();
       	self::$greeting .= $codError;
        //self::$greeting;
            
        switch ($codError)
            {
            case 300:
                $msg="Método Não Existente";
                break;
            case 301:
                $msg="Requisição Inválida";
                break;
            case 404:
                $msg="Arquivo Não Encontrado";
                break;
            case 600:
                $msg="Permissão Negada";
                break;
            case 601:
                $msg="Permissão Não Encontrada Para Esse Usuário";
                break;
            case 602:
                $msg="Permissão Não Encontrada Para Esse Usuário";
                break;
            case 700:
                $msg="Parâmetro Esperado Não Presente!";
                break;
            
            default:

                $msg="Erro Não Reconhecido";
                break;
            }

            $template->set('ID_ERROR',$codError);
            $template->set('MSG_ERROR',$msg);
            $template->render();
            die;
        }
    }