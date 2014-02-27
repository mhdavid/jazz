<?php
// Plugin de Carga de Layout para o PostBear

function loadLayout($name)
	{
		$layout = file_get_contents(ROOT_DIR .'static'. DS .'inc'. DS .'layouts' .DS . strtolower($name) .DS.'layout.html', 'r');
		
		return $layout;
	}

function loadLayoutFiles($name)
	{
		$layout = file_get_contents(ROOT_DIR .'static'. DS .'inc'. DS .'layouts' .DS . strtolower($name) .DS.'layout_files.html', 'r');
		
		return $layout;
	}

function retIcone($icone)
	{
	$documentos= array ('.doc' , 'docx' , 'docm' , '.odt' , '.sxw' , '.lwp' , '.dot' , '.dotx' , '.dotm' , '.ott' , '.stw' , '.mwp' );
	$texto = array ( '.txt', '.rtf', '.log');
	$dados = array ('.xls','.xlsx','.xlsm','.xlsb','.xlam','.ods','.sxc','.123','.csv','.xlt','.xltx','.xltm','.ots','.stc','.12m');
	$apresenta = array ('.ppt', '.pps', 'pptx', 'pptm', 'ppsx', 'ppsm', 'ppam', '.odp', '.sxi', '.prz', '.key', '.pot', 'potx', 'potm', '.otp', '.mas', '.smc', '.sti');
	$codigo = array ('.htm', 'html', '.css', '.jsp', '.xml', '.js', '.cfm', '.php', '.asp');
	$grafico = array ('.gif', '.png', '.bmp', '.psd', '.ai', '.eps', 'tiff', '.tga', '.svg', 'svgz');
	$audio = array ('.mp3','.wav','aiff','.m4a','.aac','.wma');
	$video = array ('.mov', '.avi', '.wmv', 'divx', '.mp4');
	$compacto = array ('.zip', '.cab', '.dmg', '.rar', '.sit', '.tar', '.sqx', '.gz', '.jar', '.arc', '.cdr');
	$imagem = array ('.jpg','jpeg');
	$contato = array ('.vcf','card'); 		

	switch ($icone)
		{
		case in_array ($icone, $documentos):
			$volta = 'wordprocessing' ;
			break;
		case '.pdf':
			$volta = 'pdf' ;
			break;
		case in_array ($icone, $texto):
			$volta = 'text' ;
			break;
		case in_array ($icone, $dados):
			$volta = 'data' ;
			break;
		case in_array ($icone, $apresenta):
			$volta = 'presentation' ;
			break;
		case in_array ($icone, $codigo):
			$volta = 'code' ;
			break;
		case in_array ($icone, $grafico):
			$volta = 'graphic' ;
			break;
		case in_array ($icone, $audio):
			$volta = 'audio' ;
			break;
		case in_array ($icone, $video):
			$volta = 'video' ;
			break;
		case in_array ($icone, $compacto):
			$volta = 'compressed' ;
			break;
		case in_array ($icone, $contato):
			$volta = 'contact' ;
			break;
		case in_array ($icone, $imagem):
			$volta = 'image' ;
			break;
		default:
			$volta = 'default';
			break;
		}

	return $volta;
	}



?>