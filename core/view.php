<?php
/*******************************************************************************
@INFORMACOES BASICAS
--------------------------------------------------------------------------------
@CRIACAO.....: 10/04/2013
@AUTOR.......: Adriel Vieira <ahdriel@gmail.com>
@AUTOR.......: Márcio David <marcio.h.david@gmail.com>
@LINGUAGEM...: PHP
@VERSAO......: 1.3
@NOME FISICO.: view.php
@NOME CODIGO.: Eagle Eye
@UTILIDADE...: Classe de Renderização de Views do Framework JAZZMVC 1.0
@INTRODUCAO..: JAZZMVC Revision SVN 02
@STATUS......: [X] Construção, [] Operação, [] Manutenção, [] Fora de uso
*******************************************************************************/

class View {

	private $data = array();
	private $template;
	private $option;

	public function __construct($template)
	{
		global $config;
		global $env;
		$this->config=$config;

		if($env['module'] == 'error')
			{
			$path = ROOT_DIR . 'core' . DS . 'error' . DS . 'views' . DS;
			}
		else
			{
			if($config['login_enable'] && !login_check())
				{
					$path = ROOT_DIR . 'core' . DS . 'login' . DS . 'views' . DS;
				}
				else
				{
				 $path = APP_DIR . 'modules' . DS . $env['module'] . DS . 'views' . DS;
				}
			}

		if(!file_exists($path.$template.'.php'))
			{
			Jazz::Error(404);
			}
		else
			{
			$this->template = $path.$template.'.php';
			}
	}

	public function permissions($arr,$arrMenu,$arrCtrl)
	{
		foreach($arr as $array)
		{
			$this->setPermission($array['module'],$array['controller'],$array['function'],$array['status']);
		}

		foreach($arrMenu as $arrayMenu)
		{
			$this->setPermissionMenu($arrayMenu['module'],$arrayMenu['status']);
		}

		foreach($arrCtrl as $arrayCtrl)
		{
			$this->setPermissionCtrl($arrayCtrl['controller'],$arrayCtrl['status']);
		}
	}

	public function set($var, $val)
	{
		$this->data[$var] = $val;
	}

	public function menu()
	{
		global $config;
		$this->data['menu'] = '';
		$drop=0;
		foreach(glob(APP_DIR.'modules'.DS.'*') as $modulo)
		{
			//Define o nome do primeiro menu, se estiver no config seta esse, senão seta o nome do módulo com a primeira letra em maiúsculo.
			$drop++;
			$modOrig=$nome = basename($modulo);
			$nome = (isset($config['module_name'][$nome])) ? $config['module_name'][$nome] : ucfirst($nome);

			$aceMod=false;
			if ($config['permission_enable'])
				{
				$aceMod=$this->getPermissionMenu($modOrig);
				}
			else
				{
				$aceMod=true;
				}
			//$aceMod=$this->getPermissionMod($nome);
			if ($aceMod)
			{
				$this->data['menu'].='<li class="dropdown">'."\n\t".'<a href="#" class="dropdown-toggle" id="drop'.$drop.'" role="button" data-toggle="dropdown" >'.$nome.'<b class="caret"></b></a>'."\n\t".'<ul id="menu'.$drop.'" class="dropdown-menu" role="menu" aria-labelledby="drop4">'."\n\t";
			
	           	foreach(glob($modulo.DS.'*.php') as $controller)
	           	{
					$functionMatch = array();
					preg_match_all('/function[\s\n]+(\S+)[\s\n]*\(|#(.*)#/', file_get_contents($controller), $functionMatch);
					array_shift($functionMatch);
					$nome = ($functionMatch[1][0] != '') ? $functionMatch[1][0] : ucfirst(basename($controller, ".php"));
					array_shift($functionMatch[1]);

	                $functionMatch[1][count($functionMatch[1])] = '';
	                $countValidFunction=0;
	                foreach ($functionMatch[0] as $func)
	                {
	                	if(substr($func, 0, 1)!='_' && substr($func, 0, 1) != '') $countValidFunction++;
	                }
	               	if($functionMatch[0][0] == '')
	               	{
	               		array_shift($functionMatch[0]);
	               		array_shift($functionMatch[1]);
	               	}
	                if($countValidFunction == 1)
	                {
	                	$module = basename(dirname($controller));
						$file = basename($controller, ".php");
	                	$function = (substr($functionMatch[0][0], 0, 1) != '_') ? $functionMatch[0][0] : $functionMatch[0][1];
	                	$ace=false;
	                	if ($config['permission_enable'])
							{
							//$ace=$this->getPermission($module,$file,$function);
							$ace=$this->getPermissionCtrl($file);
							//echo $file. ' ' .$ace=$this->getPermissionCtrl($file);
							}
						else
							{
							$ace=true;	
							}
						/*$function = $function;*/
						//$nome = ($function == '') ? ucwords($function) : $function;
						
						if ($ace)
							{
	                		$this->data['menu'].='<li><a href="'.BASE_URL.$module.'/'.$file.'/'.$function.'" tabindex="-1">'.$nome.'</a></li>'."\n\t";
	                		}
	                	//$this->data['menu'].='<li><a href="'.BASE_URL.$module.'/'.$file.'/'.$function.'" tabindex="-1">'.$nome.'</a></li>'."\n\t";
	                }
	                else
	                {
	                	$module = basename(dirname($controller));
						$file = basename($controller, ".php");
	                 	$aceCtrl=false;
	                 	if ($config['permission_enable'])
						 	{
						 	$aceCtrl=$this->getPermissionCtrl($file);
						 	}
						else
						 	{
							$aceCtrl=true;	
						 	}

	                	if ($aceCtrl)
	                	{
		                	$this->data['menu'].='<li oscar class="dropdown-submenu"><a href="#" tabindex="-1">'.$nome.'</a><ul class="dropdown-menu">'."\n\t";
		                
							for($i = 0; $i < count($functionMatch[0]); $i++)
							{
								if($functionMatch[0][$i] != '' && $functionMatch[0][$i][0] != '_')
								{
									$ace=false;
									if ($config['permission_enable'])
										{
										$ace=$this->getPermission($module,$file,$functionMatch[0][$i]);																}
									else
										{
										$ace=true;	
										}
										
									$function = $functionMatch[0][$i];
									$nome = ($functionMatch[1][$i] == '') ? ucwords($functionMatch[0][$i]) : $functionMatch[1][$i];
									if ($ace)
									{
										$aceCtrl=$this->getPermissionCtrl($file);
										$this->data['menu'].='<li role="presentation"><a href="'.BASE_URL.$module.'/'.$file.'/'.$function.'" role="menuitem" tabindex="-1">'.$nome.'</a></li>'."\n\t";
									}
								}
							}
							$this->data['menu'].='</ul></li>';
						}
						
					}
	           	}//Fim foreach arquivo php controller
	        $this->data['menu'].='</ul></li>';
			}
		}//Fim foreach módulo

	}

	public function gettemplate($temp)
	{
		$content = file_get_contents($temp);
		preg_match_all('/\{\{\b(.*?)\}\}/', $content, $matches);
		$matches = $matches[1];
		while(count($matches) != 0)
		{
			foreach ($matches as $match)
			{
				$finder='{{'.$match.'}}';
				preg_match_all('/\(\b(.*?)\)/', $match, $params);
				$params = $params[1];
				if(count($params) > 0)
				{
					$params = $params[0];
					$function = str_replace('('.$params.')', '', $match);
					switch ($function) 
					{
						case 'INC_STATIC':
					
							$content = str_replace('{{'.$match.'}}', file_get_contents(ROOT_DIR.'static/inc/'.$params.'.php'), $content);
							break;					
					
						default:
							echo 'não reconhecido.';
							break;
					}
					$content = str_replace($finder, 'include do'.$params, $content);
				}
				else
				{
					if($match == 'MENU')
					{
						$this->menu();
						$content = str_replace($finder, $this->data['menu'], $content);
					}
					if($match == 'THEME')
						{
						if(!isset($_SESSION['tema']))
							{
							$_SESSION['tema']=$this->config['theme'];
							}
						elseif(($_SESSION['tema'])=='')
							{
							$_SESSION['tema']=$this->config['theme'];
							}
						$content = str_replace($finder, 'theme/'.$_SESSION['tema'].'/bootstrap.min.css', $content);
						}

					if($match == 'THEME_RESPONSIVE')
						{
						if(isset($_SESSION['tema']))
							{
							$_SESSION['tema']=$this->config['theme'];
							}
						$content = str_replace($finder, 'theme/'.$_SESSION['tema'].'/bootstrap-responsive.min.css', $content);
						}


					if($match == 'THEME_NAME')
						{
						$content = str_replace($finder,$_SESSION['tema'], $content);
						}


					if($match == 'APP_NAME')
					{
						$content = str_replace($finder, $this->config['application_name'], $content);
					}


					if (!isset($this->data[$match]))
					{
						$replace=charCode('#'.$match.'# <- KEY Não Reconhecida. ');
					}
					else
					{
						$this->data[$match];
						$replace=charCode($this->data[$match]);
					}
					
				$content = str_replace($finder, $replace, $content);
				}
			}
			preg_match_all('/\{\{\b(.*?)\}\}/', $content, $matches);
			$matches = $matches[1];
		}
		echo charCode($content);
	}

	public function render()
	{
		$this->set('BASE_URL', BASE_URL);
		extract($this->data);
		ob_start();	
		if (isset($_SESSION['arr']) AND isset($_SESSION['arrMenu']))
			{	
			$this->permissions($_SESSION['arr'],$_SESSION['arrMenu'],$_SESSION['arrCtrl']);
			}
		$this->gettemplate($this->template);
		echo ob_get_clean();
	}

	public function setPermission($mod,$ctr,$opt,$status)
		{
		//echo $mod.','.$ctr.','.$opt.','.'1'.'<br>';
		$this->option[$mod][$ctr][$opt]=$status;
		}

	public function setPermissionMenu($mod,$status)
		{
		//echo $mod.','.$ctr.','.$opt.','.'1'.'<br>';
		$this->optionMenu[$mod]=$status;
		}

	public function setPermissionCtrl($ctrl,$status)
		{
		//echo $mod.','.$ctr.','.$opt.','.'1'.'<br>';
		$this->optionCtrl[$ctrl]=$status;
		}

	private function getPermission($mod,$ctr,$opt)
		{
		if (isset($this->option[$mod][$ctr][$opt]))
			{
			return $this->option[$mod][$ctr][$opt];
			}
		else
			{
			return FALSE;
			}
		}

	private function getPermissionMenu($mod)
		{
		if (isset($this->optionMenu[$mod]))
			{
			return $this->optionMenu[$mod];
			}
		else
			{
			return FALSE;
			}
		}

	private function getPermissionCtrl($ctrl)
		{
		if (isset($this->optionCtrl[$ctrl]))
			{
			return $this->optionCtrl[$ctrl];
			}
		else
			{
			return FALSE;
			}
		}

	public function _getPermissoesEdit()
			{
				global $config;
		$this->data['menu'] = '';
		$drop=0;
		foreach(glob(APP_DIR.'modules'.DS.'*') as $modulo)
		{
			//Define o nome do primeiro menu, se estiver no config seta esse, senão seta o nome do módulo com a primeira letra em maiúsculo.
			$drop++;
			$mdl=$nome = basename($modulo);
			$nome = (isset($config['module_name'][$nome])) ? $config['module_name'][$nome] : ucfirst($nome);
			$check='';
			$wck=$this->getPermissionMenu($mdl);
			if ($wck)			
				{
					$check='checked';
				}
			$rotulo='class="label"';
			
			//$this->data['menu'].='<li>'."\n\t".'<a href="#">'.$nome.'</a>'."\n\t".'<ul>'."\n\t";
			$this->data['menu'].='<li>'."\n\t".'<label class="checkbox"><input type="checkbox" name="module[]" value="'.$nome.'" id="'.$nome.'" '.$check.'>&nbsp;<b '.$rotulo.'>&nbsp;'.$nome.'&nbsp;</b></label>'."\n\t".'<ul>'."\n\t";
			$baseCC=$nome;
			$rotulo='';
           	foreach(glob($modulo.DS.'*.php') as $controller)
           	{
				$functionMatch = array();
				preg_match_all('/function[\s\n]+(\S+)[\s\n]*\(|#(.*)#/', file_get_contents($controller), $functionMatch);
				array_shift($functionMatch);
				$nome = ($functionMatch[1][0] != '') ? $functionMatch[1][0] : ucfirst(basename($controller, ".php"));
				array_shift($functionMatch[1]);

                $functionMatch[1][count($functionMatch[1])] = '';
                $countValidFunction=0;
                foreach ($functionMatch[0] as $func)
              	  {
                	//if(substr($func, 0, 1)!='_' && substr($func, 0, 1) != '') $countValidFunction++;
                	if(substr($func, 0, 1) != '') $countValidFunction++;
              	  }
               	if($functionMatch[0][0] == '')
               		{
               		array_shift($functionMatch[0]);
               		array_shift($functionMatch[1]);
               		}
                if($countValidFunction == 1)
               		{
                	$module = basename(dirname($controller));
					$ctrl=$file = basename($controller, ".php");
                	$func=$function = (substr($functionMatch[0][0], 0, 1) != '_') ? $functionMatch[0][0] : $functionMatch[0][1];
                	/*$ace=false;
					$ace=$this->getPermission($module,$file,$function);
					$function = $function;
					$nome = ($function == '') ? ucwords($function) : $function;
					if ($ace)
						{
                		$this->data['menu'].='<li><a href="'.BASE_URL.$module.'/'.$file.'/'.$function.'" tabindex="-1">'.$nome.'</a></li>'."\n\t";
                		}*/

/*
                	$this->data['menu'].='<li><label class="checkbox"><input type="checkbox" name="controller[]" value="'.$nome.'" id="index" class="'.$baseCC.'"><b>&nbsp;'.$nome.'&nbsp;</b></label></li>'."\n\t";
*/
                	$check=$rotulo='';
					$wck=$this->getPermission($module, $ctrl, $func);
					if ($wck)			
						{
							$check='checked';
						}
					if ($config['default_module']==$module AND $config['default_controller']==$ctrl)
						{
							$check='checked disabled';
							$rotulo='class="btn-danger"';
							$this->data['menu'].='<input type="hidden" name="controller[]" value="'.$mdl.'|'.$ctrl.'|'.$func.'">'."\n\t";
						}

		            $this->data['menu'].='<li><label class="checkbox"><input type="checkbox" name="controller[]" value="'.$mdl.'|'.$ctrl.'|'.$func.'" id="index" class="'.$baseCC.'" '.$check.'><b '.$rotulo.'>&nbsp;'.$nome.'&nbsp;</b></label></li>'."\n\t";
		            $rotulo='';
                	}
                else
                	{
                	$module = basename(dirname($controller));
					$ctrl=$file = basename($controller, ".php");
					$check='';
					//$wck=$this->getPermissionCtrl($ctrl);
					$wck=$this->getPermission($module, $ctrl, $func);
					if ($wck)			
						{
							$check='checked';
						}
                	$this->data['menu'].='<li><label class="checkbox"><input type="checkbox" name="controller[]" value="'.$mdl.'|'.$ctrl.'|'.$func.'"  disabled '.$check.'><b>&nbsp;'.$nome.'&nbsp;</b></label><ul>'."\n\t";

	                
					for($i = 0; $i < count($functionMatch[0]); $i++)
						{
						//if($functionMatch[0][$i] != '' && $functionMatch[0][$i][0] != '_')
						if($functionMatch[0][$i] != ''&& $functionMatch[0][$i][1] != '_' && $functionMatch[0][$i][0] != 'index')
							{
							$ace=true;
							//$ace=false;
							//$ace=$this->getPermission($module,$file,$functionMatch[0][$i]);
							$func=$function = $functionMatch[0][$i];
							if($functionMatch[0][$i][0] == '_')
								{
								$ccks='*';
								}
							else
								{
								$ccks='';
								}
							$nome = ($functionMatch[1][$i] == '') ? ucwords($functionMatch[0][$i]) : $functionMatch[1][$i];
							if ($ace)
								{
								$check='';
								//$wck=$this->getPermissionCtrl($ctrl);
								$wck=$this->getPermission($module, $ctrl, $func);
								if ($wck)			
									{
										$check='checked';
									}
								$this->data['menu'].='<li><label class="checkbox"><input type="checkbox" name="controller[]" value="'.$mdl.'|'.$ctrl.'|'.$func.'" '.$check.' />&nbsp;'.$nome.$ccks.'</label></li>'."\n\t";
								}
							}
						}
					$this->data['menu'].='</ul></li>'."\n\t";
					}
           		}//Fim foreach arquivo php controller
			$this->data['menu'].='</ul></li>'."\n\t";
			}//Fim foreach módulo
			return $this->data['menu'];
		}
}