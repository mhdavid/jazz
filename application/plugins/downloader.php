<?php
/*******************************************************************************
@INFORMACOES BASICAS
--------------------------------------------------------------------------------
@CRIACAO.....: 17/07/2013
@AUTOR.......: M�rcio David <marcio.h.david@gmail.com>
@LINGUAGEM...: PHP
@VERSAO......: 1.0
@NOME FISICO.: downloader.php
@NOME CODIGO.: File Falls
@UTILIDADE...: Plugin de Download de Arquivos com Registro em Base Dados
@INTRODUCAO..: PostBear 2.0 Alpha 1.8.102
@STATUS......: [X] Constru��o, [] Opera��o, [] Manuten��o, [] Fora de uso
*******************************************************************************/

include ('../config/config.php');

$link = mysql_connect($config['db_host'],$config['db_username'],$config['db_password']);
if (!$link) {
    die('Not connected : ' . mysql_error());
}

$db_selected = mysql_select_db($config['db_name'],  $link);
if (!$db_selected) {
    die ('Base N�o Encontrada : ' . mysql_error());
}

$ref=$_GET['ref'];

echo $path = '../../static/upload/';
echo '<br><br>';
echo $sql="
	SELECT *
	FROM post_uploads
	WHERE hash_file='$ref'
	";

$dado=mysql_fetch_array(mysql_query($sql));


//$path = '../'.$_SESSION['PATH_SITE'].$_SESSION['PATH_UPLOAD_DOCS'].$xxxx;

$arquivo=$dado['hash_file'];

$download=$dado['name_file'];

echo '<br><br>';
$file=$path.$arquivo.$dado['extensao'];

echo '<a href="'.$file.'">'.$file.'</a>';

if (file_exists($file))
	{
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
	header("Content-disposition: attachment; filename=".$download);
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
	}
else
	{
	echo '<script>';
	echo 'alert("Arquivo N�o Existe no Reposit�rio!")';
	echo '</script>';
	//echo '<meta http-equiv="refresh" content="0;url='.$_SESSION['URL_SITE'].'"> ';
	}



?>

