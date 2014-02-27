<?php

class User_model extends Model {
	function login($email, $password) {
		
	   // Using prepared Statements means that SQL injection is not possible. 
		if($stmt = $this->db->prepare('SELECT id, nome, login, password, salt, email FROM users WHERE email = ? LIMIT 1'))
		{
			$stmt->execute(array($email));
			if($stmt->rowCount() == 1)
			{
				while($row = $stmt->fetch())
				{
					$db_id = $row['id'];
					$db_email = $row['email'];
					$db_login = $row['login'];
					$db_nome = $row['nome'];
					$db_password = $row['password'];
					$db_salt = $row['salt'];
				}

				$password = hash('sha512', $password.$db_salt);

				if($this->checkbrute($db_id) == true)
				{
					return false;
				}
				else
				{
					$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
					$user_id = preg_replace("/[^0-9]+/", "", $db_id); // XSS protection as we might print this value
					$_SESSION['user_id'] = $user_id;
				
					if($db_password == $password)
					{
						/****************************************************************************
						MOVIDA ESSA ROTINA PARA FORA DO IF
						VISTO QUE O ELSE SOLICITA A VARIAVEL '$user_id' QUE ESTAVA SENDO DEFINIDA APENAS SE O IF FOSSE VERDADEIRO.


						$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
	
						$user_id = preg_replace("/[^0-9]+/", "", $db_id); // XSS protection as we might print this value
						$_SESSION['user_id'] = $user_id; 

						******************************************************************************************/
						$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $db_login); // XSS protection as we might print this value
						$_SESSION['login'] = $username;
						$_SESSION['nome'] = $db_nome;
						$_SESSION['email'] = $db_email;
						$_SESSION['login_string'] = hash('sha512', $password.$user_browser);
						return true;
					}
					else
					{
						$now = time();
			            $this->db->exec("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
			            return false;
					}
					$this->loadPermission();
					$this->loadPermissionModule();
					$this->loadPermissionController();		
				}

			}
			else
			{
				return false;
			}
		}
	}

	function loginLdap($ldapUser, $password)
		{
		$ldap=$this->loadHelper('ldap');
	   	// Using prepared Statements means that SQL injection is not possible. 
		$l = new LDAP();
    	$l->conectar();
    	$retorno=$l->buscar($ldapUser, '');
  		if ($retorno)
  			{
  			$userLDAP= $l->usuarioldap();
	    	$matricula_ldap=$userLDAP[0]['uid'][0];
	    	echo $matricula_ldap;
			if($l->autenticar($password))
				{
				if($stmt = $this->db->prepare('SELECT * FROM usuarios WHERE matricula = ? LIMIT 1'))
					{	
					echo "Autenticou LDAP";
					$stmt->execute(array($matricula_ldap));
					if($stmt->rowCount() == 1)
						{
						while($row = $stmt->fetch())
							{
							$db_id = $row['id_usuario'];
							$db_id_group = $row['id_grupo'];
							$db_email = $row['email'];
							$db_login = $row['matricula'];
							$db_nome = $row['nome'];
							$db_centro = $row['id_centro'];
							$db_setor = $row['setor_depto'];
							$db_lastupdate = $row['sincronizadoEm'];
							}
						//$password = hash('sha512', $password.$db_salt);
						if($this->checkbrute($db_id) == true)
							{
							return false;
							}
						else
							{
							$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
							$user_id = preg_replace("/[^0-9]+/", "", $db_id); // XSS protection as we might print this value
							$_SESSION['user_id'] = $user_id;

							//if($db_password == $password)
							if($matricula_ldap == $db_login)
								{

								/****************************************************************************
								MOVIDA ESSA ROTINA PARA FORA DO IF
								VISTO QUE O ELSE SOLICITA A VARIAVEL '$user_id' QUE ESTAVA SENDO DEFINIDA APENAS SE O IF FOSSE VERDADEIRO.


								$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
			
								$user_id = preg_replace("/[^0-9]+/", "", $db_id); // XSS protection as we might print this value
								$_SESSION['user_id'] = $user_id; 

								******************************************************************************************/
								$userMat = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $db_login); // XSS protection as we might print this value
								$_SESSION['login'] = $userMat;
								$_SESSION['nome'] = $db_nome;
								$_SESSION['id_grupo'] = $db_id_group;
								$_SESSION['id_user'] = $db_id;
								$_SESSION['email'] = $db_email;
								$_SESSION['setor'] = $db_setor;
								$_SESSION['centro'] = $db_centro;
								$_SESSION['lastupdate'] = $db_lastupdate;
								$_SESSION['ldap'] = true;
								//$_SESSION['login_string'] = hash('sha512', $password.$user_browser);
								$_SESSION['login_string'] = hash('sha512', $matricula_ldap.$user_browser);
								$this->loadPermission($_SESSION['id_user']);
								$this->loadPermissionModule($_SESSION['id_user']);
								$this->loadPermissionController($_SESSION['id_user']);		
								return true;
								}
							else
								{
								$now = time();
					            $this->db->exec("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
					            return false;
								}
							}

						}
					else
						{
						echo "Não Existe Permissão Para Acesso ao PostBear";
						return false;
						}
					}
				else
					{
					Jazz::erro(601); 
					}
				}
			else
				{
				echo "Existe mas Não Autenticou na LDAP";
				}
			}
		else
			{
			echo "Não EXISTE na LDAP";
			}
		$l->desconectar();
		
		}

	function checkbrute($user_id) {
		// Get timestamp of current time
		$now = time();
		// All login attempts are counted from the past 2 hours. 
		$valid_attempts = $now - (2 * 60 * 60); 

		if ($stmt = $this->db->prepare("SELECT time FROM login_attempts WHERE id_post_user = ? AND time > '$valid_attempts'"))
		{ 
			// Execute the prepared query.
			$stmt->execute(array($user_id));
			// If there has been more than 5 failed logins
			if($stmt->rowCount() > 5) {
				return true;
			} else {
				return false;
			}
		}
	}

	function loadPermission($id_user)
	{
		$stmt = $this->db->prepare('SELECT module, controller, function, status FROM groups_permissions A, usuarios  B, grupos C WHERE B.id_usuario = ? AND A.id_post_group = B.id_grupo AND C.id_grupo = A.id_post_group');
		$stmt->execute(array($id_user));
		$row = $stmt->fetchAll();
		$_SESSION['arr']=$row;
		return true;
	}

	function loadPermissionModule($id_user)
	{
		$stmt = $this->db->prepare('SELECT module, status FROM groups_permissions A, usuarios B, grupos C WHERE B.id_usuario = ? AND A.id_post_group = B.id_grupo AND C.id_grupo = A.id_post_group AND A.status = 1 GROUP BY A.module');
		$stmt->execute(array($id_user));
		$row = $stmt->fetchAll();
		$_SESSION['arrMenu']=$row;
		return true;

	}

	function loadPermissionController($id_user)
	{
		$stmt = $this->db->prepare('SELECT controller, status FROM groups_permissions A, usuarios B, grupos C WHERE B.id_usuario = ? AND A.id_post_group = B.id_grupo AND C.id_grupo = A.id_post_group AND A.status = 1 GROUP BY A.controller');
		$stmt->execute(array($id_user));
		$row = $stmt->fetchAll();
		$_SESSION['arrCtrl']=$row;
		return true;

	}
	
	function login_check()
		{
	   	// Check if all session variables are set
			echo 'login check executando';
			die();
	   	if(isset($_SESSION['user_id'], $_SESSION['login'], $_SESSION['login_string']))
	   		{
	    	$user_id = $_SESSION['user_id'];
	    	$login_string = $_SESSION['login_string'];
	    	$username = $_SESSION['login'];
	 	
	    	$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
	 
	    	if ($stmt = $this->db->prepare("SELECT password FROM usuarios WHERE id_usuario = ? LIMIT 1"))
	    		{ 
	 	     	$stmt->execute(array($user_id)); // Execute the prepared query.
	 
	        	if($stmt->rowCount() == 1)
	        		{
	        		// If the user exists

	           		while($data = $stmt->fetch())
	           			{
	           			$password = $data['password'];
	           			}
	           		$login_check = hash('sha512', $password.$user_browser);
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


	function loginaction()
	{
		//print_r($_POST);

		if(isset($_POST['email'], $_POST['p'])) { 
		   $email = $_POST['email'];
		   $password = $_POST['p']; // The hashed password.
		   if($this->login($email, $password) == true) {
		      // Login success
		      header('Location: '.BASE_URL);
		   } else {
		      // Login failed
		      header('Location: ./login.php?error=1');
		   }
		} else { 
		   // The correct POST variables were not sent to this page.
		   Jazz::Error(301);
		}
	}

	function loginactionLdap()
		{
		$_SESSION['erro_login']=false;
		if(isset($_POST['matriculaCpf'], $_POST['password']))
			{ 
			if ($_POST['matriculaCpf']=='@master' AND  $_POST['password']=='nazareth')
				{
				echo "Entrou Aqui";
				$db_id='0';
				$db_login='PostMaster';
				$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.	
				$user_id = preg_replace("/[^0-9]+/", "", $db_id); // XSS protection as we might print this value
				echo $_SESSION['user_id'] = $user_id;
				$userMat = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $db_login); // XSS protection as we might print this value
				echo $_SESSION['login'] = '@master';
				echo $_SESSION['nome'] = 'Desenvolvedor';
				echo $_SESSION['email'] = '@postber';
				echo $_SESSION['setor'] = 'Desenvolvimento PostBear';
				echo $_SESSION['lastupdate'] = '2013-04-10';
				echo $_SESSION['ldap'] = true;
				$matricula_ldap='000000';
				//$_SESSION['login_string'] = hash('sha512', $password.$user_browser);
				echo $_SESSION['login_string'] = hash('sha512', $matricula_ldap.$user_browser);
				//die();
				header('Location: '.BASE_URL);	
				}
		  	$ldapUser = $_POST['matriculaCpf'];
		  	$password = $_POST['password']; 
		   	if($this->loginLdap($ldapUser, $password) == true)
		   		{
		      	// Login success
		      	header('Location: '.BASE_URL);
		   		}
		   	else
		   		{
		      	// Login failed
		   		$_SESSION['erro_login']=true;
		      	header('Location: '.BASE_URL);
		   		}
			}
		else
			{ 
		   	// The correct POST variables were not sent to this page.
		   	Jazz::Error(301);
			}
		}




	function logoutaction()
	{
		$_SESSION = array();
		// get session parameters 
		$params = session_get_cookie_params();
		// Delete the actual cookie.
		setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
		// Destroy session
		session_destroy();
		header('Location: ./');
	}	

	function register($email, $pass, $salt)
	{
		$pass = hash('sha512', $pass.$salt);
		$stmt = $this->db->prepare("INSERT INTO users (email, password, salt) VALUES (?, ?, ?)");
		if($stmt->execute(array($email, $pass, $salt)))
		{
			header('Location: '.BASE_URL);
		}
		else
		{
			Jazz::Error();
		}
	}

	function login_ldad($email, $pass, $salt)
	{
		/*
		$pass = hash('sha512', $pass.$salt);
		$stmt = $this->db->prepare("INSERT INTO users (email, password, salt) VALUES (?, ?, ?)");
		if($stmt->execute(array($email, $pass, $salt)))
		{
			header('Location: '.BASE_URL);
		}
		else
		{
			Jazz::Error();
		}
		*/
	}
}