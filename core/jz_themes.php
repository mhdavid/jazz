<?php
/*******************************************************************************
@INFORMACOES BASICAS
--------------------------------------------------------------------------------
@CRIACAO.....: 19/07/2013
@AUTOR.......: Márcio David <marcio.h.david@gmail.com>
@LINGUAGEM...: PHP
@VERSAO......: 1.0
@NOME FISICO.: jz_themes.php
@NOME CODIGO.: Picasso
@UTILIDADE...: Funções de Ajustes de Temas Visuais do Bootstrap
@INTRODUCAO..: JAZZMVC Revision SVN 103
@STATUS......: [X] Construção, [] Operação, [] Manutenção, [] Fora de uso
*******************************************************************************/

function changeTheme($theme='default')
	{
	$_SESSION['tema']=$theme;
	}

