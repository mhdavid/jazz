<?php
/*******************************************************************************
@INFORMACOES BASICAS
--------------------------------------------------------------------------------
@CRIACAO.....: 10/04/2013
@AUTOR.......: Adriel Vieira <ahdriel@gmail.com>
@AUTOR.......: Márcio David <marcio.h.david@gmail.com>
@LINGUAGEM...: PHP
@VERSAO......: 1.0
@NOME FISICO.: jazz.php
@NOME CODIGO.: Take Five
@UTILIDADE...: Conjunto de Funções de Inicialização do Framework JAZZMVC 1.0
@INTRODUCAO..: JAZZMVC Revision SVN 02
@STATUS......: [X] Construção, [] Operação, [] Manutenção, [] Fora de uso
*******************************************************************************/

function login_check()
	{
	
	// Check if all session variables are set
	$db = Db::init();
	if(isset($_SESSION['user_id'], $_SESSION['login'], $_SESSION['login_string']))
		{
	   	$user_id = $_SESSION['user_id'];
	   	$login_string = $_SESSION['login_string'];
	  	$username = $_SESSION['login'];
		$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
	 	
	 	if ($username=='@master')
	 		{
	 			return true;
	 		}

	   	//if ($stmt = $db->prepare("SELECT password FROM users WHERE id = ? LIMIT 1"))
	   	if ($stmt = $db->prepare("SELECT matricula FROM usuarios WHERE id_usuario = ? LIMIT 1"))
	   		{ 
	      	$stmt->execute(array($user_id)); // Execute the prepared query.
	         if($stmt->rowCount() == 1)
	         	{ // If the user exists
	       		while($data = $stmt->fetch())
	       			{
	       			$login = $data['matricula'];
	       			}
	       		//$login_check = hash('sha512', $password.$user_browser);
	       		$login_check = hash('sha512', $login.$user_browser);
	       		if($login_check == $login_string)
	       			{
	           		// Logged In!!!!

	           		return true;
	       			}
	       		else
	       			{
	           		// Not logged in
	           		return false;
	       			}
	       		}
	       	else
	       		{
	           	// Not logged in
	           	return false;
	       		}
	   		}
	   	else
	   		{
	       	// Not logged in
	       	return false;
	   		}
	 	}
	else
		{
	  	// Not logged in
	   	return false;
		}
	}

function permission_check($module, $controller, $action)
{
	global $config;
	if ($config['permission_enable'])
		{
		if($controller == 'user')
			{
			return true;
			}
		elseif(isset($_SESSION['user_id']))
			{
			$db = Db::init();
			$stmt = $db->prepare('SELECT status FROM groups_permissions A, post_users B, post_users_groups C WHERE B.id_post_user = ? AND A.id_post_group = B.id_post_group AND C.id_post_group = A.id_post_group AND A.module = ? AND A.controller = ? AND A.function = ?');
			$stmt->execute(array($_SESSION['user_id'], $module, $controller, $action));
			$row = $stmt->fetch();
			return $row['status'];
			}
		else
			{
			return true;
			}
		}
	else
		{
		return true;
		}
}



function jazz()
	{
	global $config;
    global $env;
    // Set our defaults
    $module = $config['default_module'];
    $env['module'] = $module;
    $controller = $config['default_controller'];
    $action = 'index';
    $url = '';
	
	require_once(ROOT_DIR.'core'.DS.'error'.DS.'main.php');
	// Get request url and script url
	$request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
	$script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';
    	
	// Get our url path and trim the / of the left and the right
	if($request_url != $script_url) $url = trim(preg_replace('/'.str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');
    
	// Split the url into segments
	$segments = explode('/', $url);
	
	// Do our default checks
	if(isset($segments[0]) && $segments[0] != '') 
		{
		$module = $segments[0];
		$env['module'] = $segments[0];
		}
	if(isset($segments[1]) && $segments[1] != '') $controller = $segments[1];
	if(isset($segments[2]) && $segments[2] != '') $action = $segments[2];

	// Get our controller file
    $path = APP_DIR . 'modules/' . $module .'/'. $controller . '.php';

    if(isset($segments[0]) && $segments[0] == 'login')
		{
		$path = ROOT_DIR . 'core' . DS . 'login' . DS . 'user.php';
		$controller = 'user';
		$action = 'login';
		}

	if(isset($segments[0]) && $segments[0] == 'logout')
		{
		$path = ROOT_DIR . 'core' . DS . 'login' . DS . 'user.php';
		$controller = 'user';
		$action = 'logout';
		}

	if(isset($segments[0]) && $segments[0] == 'loginaction')
		{
		$path = ROOT_DIR . 'core' . DS . 'login' . DS . 'user.php';
		$controller = 'user';
		$action = 'loginaction';
		}

	if(isset($segments[0]) && $segments[0] == 'loginactionLdap')
		{
		$path = ROOT_DIR . 'core' . DS . 'login' . DS . 'user.php';
		$controller = 'user';
		$action = 'loginactionLdap';
		}

	if(file_exists($path))
		{
        require_once($path);
		}
	else
		{
	        Jazz::Error(404);
		}
    
    // Check the action exists
    if(!method_exists($controller, $action))
    	{
        	Jazz::Error(300);
    	}

    if(!permission_check($module, $controller, $action))
	{
		//Sem permissão
		$controller = $config['error_controller'];
        $env['module'] = $controller;
        require_once(ROOT_DIR . 'core' . DS . $controller .DS. 'main.php');
        $action = 'index';
       	Jazz::Error(600);
	}
	/*
	if($action[0] == '_')
		{
        $controller = $config['error_controller'];
        $env['module'] = $controller;
        require_once(APP_DIR . 'modules'.DS .$controller .DS. 'main.php');
        $action = 'index';
        $env['error'] = '600';
    	}	
	*/
	if($config['login_enable'] && $controller != 'user')
		{
		if(!login_check())
			{
			header('Location: '.BASE_URL.'login');
			die();
			}
		}

	if($controller == 'user' && login_check() && $action != "logout")
		{
			header('Location: '.BASE_URL);
			die();
		}
	
	$obj = new $controller;
    die(call_user_func_array(array($obj, $action), array_slice($segments, 3)));
	}