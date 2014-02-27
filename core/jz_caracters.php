<?php
/*******************************************************************************
@INFORMACOES BASICAS
--------------------------------------------------------------------------------
@CRIACAO.....: 18/04/2013
@AUTOR.......: Adriel Vieira <ahdriel@gmail.com>
@AUTOR.......: Márcio David <marcio.h.david@gmail.com>
@LINGUAGEM...: PHP
@VERSAO......: 1.0
@NOME FISICO.: jz_caracters.php
@NOME CODIGO.: Janitor
@UTILIDADE...: Funções de Tratamento de Textos do Framework JAZZMVC 1.0
@INTRODUCAO..: JAZZMVC Revision SVN 30
@STATUS......: [X] Construção, [] Operação, [] Manutenção, [] Fora de uso
*******************************************************************************/

function charCode($texto)
	{
      $substituir = array(
      '/À/' => '&#192;',
      '/Á/' => '&#193;',
      '/Â/' => '&#194;',
      '/Ã/' => '&#195;',
      '/Ä/' => '&#196;',
      '/Å/' => '&#197;',
      '/Æ/' => '&#198;',
      '/Ç/' => '&#199;',
      '/È/' => '&#200;',
      '/É/' => '&#201;',
      '/Ê/' => '&#202;',
      '/Ë/' => '&#203;',
      '/Ì/' => '&#204;',
      '/Í/' => '&#205;',
      '/Î/' => '&#206;',
      '/Ï/' => '&#207;',
      '/Ð/' => '&#208;',
      '/Ñ/' => '&#209;',
      '/Ò/' => '&#210;',
      '/Ó/' => '&#211;',
      '/Ô/' => '&#212;',
      '/Õ/' => '&#213;',
      '/Ö/' => '&#214;',
      '/Ù/' => '&#217;',
      '/Ú/' => '&#218;',
      '/Û/' => '&#219;',
      '/Ü/' => '&#220;',
      '/Ý/' => '&#221;',
      '/à/' => '&#224;',
      '/á/' => '&#225;',
      '/â/' => '&#226;',
      '/ã/' => '&#227;',
      '/ä/' => '&#228;',
      '/å/' => '&#229;',
      '/ç/' => '&#231;',
      '/è/' => '&#232;',
      '/é/' => '&#233;',
      '/ê/' => '&#234;',
      '/ë/' => '&#235;',
      '/ì/' => '&#236;',
      '/í/' => '&#237;',
      '/î/' => '&#238;',
      '/ï/' => '&#239;',      
      '/ñ/' => '&#241;',
      '/ò/' => '&#242;',
      '/ó/' => '&#243;',
      '/ô/' => '&#244;',
      '/õ/' => '&#245;',
      '/ö/' => '&#246;',
      '/ù/' => '&#249;',
      '/ú/' => '&#250;',
      '/û/' => '&#251;',
      '/ü/' => '&#252;',
      '/ý/' => '&#253;',
            );
      $texto = preg_replace(array_keys($substituir), array_values($substituir), $texto);
	return $texto;	
	}

function cleanHtmlMSWord($html)
      {
      // Remove todas as tags de FONT e SPAN, e todos os atributos de classe e estilo.
      // Projetado para se limpar o HTML do MSWord
      
      $tag_find=array('xml','style');
      $tt=1;
      foreach ($tag_find as $tag)
            {
            do 
                  {
                  $tt=preg_match('/<'.$tag.'.*?>(.*?)<\/'.$tag.'>/is', $html, $h1);             
                  if (isset($h1[0]))
                        {
                        $html=str_replace($h1[0],'',$html);
                        }
                  }
            while ($tt==1);
            }
      $html = ereg_replace("<(/)?(font|span|del|ins|o|w|m|!|style|xml|ovwxp)[^>]*>","",$html);
      $html = ereg_replace("<([^>]*)(class|lang|style|size|face)=(\"[^\"]*\"|'[^']*'|[^>]+)([^>]*)>","<\\1>",$html);
      $html = ereg_replace("<([^>]*)(class|lang|style|size|face)=(\"[^\"]*\"|'[^']*'|[^>]+)([^>]*)>","<\\1>",$html);
      return $html;
      }

function nameFileUpload($string)
      {
      // pegando a extensao do arquivo
      $partes  = explode(".", $string);
      $extensao      = $partes[count($partes)-1];  
      // somente o nome do arquivo
      $nome    = preg_replace('/\.[^.]*$/', '', $string);      
      // removendo simbolos, acentos etc
      $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýýþÿŔŕ?';
      $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuuyybyRr-';
      $nome = strtr($nome, utf8_decode($a), $b);
      $nome = str_replace(".","-",$nome);
      $nome = preg_replace( "/[^0-9a-zA-Z\.]+/",'-',$nome);
      return utf8_decode(strtolower($nome.".".$extensao));
      }

 function isowt($string)
      {
      $retun=iconv('iso-8859-1','utf-8',$string);
      return $return;
      }