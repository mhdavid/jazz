<?php

class Usuarios_model extends Model {

	function loadPermission($user_id)
	{
		$stmt = $this->db->prepare('SELECT module, controller, function, status FROM groups_permissions A, post_users B, post_users_groups C WHERE B.id_post_user = ? AND A.id_post_group = B.id_post_group AND C.id_post_group = A.id_post_group');
		$stmt->execute(array($user_id));
		$row = $stmt->fetchAll();
		return $row;
	}

	function getGroups()
	{
		$return = '';
		$stmt = $this->db->prepare('SELECT * FROM post_users_groups');
		$stmt->execute();
		while($row = $stmt->fetch())
		{
			$return .= '<option value="'.$row['id_post_group'].'">'.$row['name'].'</option>';
		}
		return $return;
	}

	function getGroupName($id_group)
	{
		$return = '';
		$stmt = $this->db->prepare('SELECT name FROM post_users_groups WHERE id_post_group = ?');
		$stmt->execute(array($id_group));
		$row=$stmt->fetch();
		return $row['name'];
	}

	function getDataGroups($id_groups)
		{
		$return=$data= '';
		$stmt = $this->db->prepare('SELECT * FROM post_users_groups WHERE id_post_group= ?');
		$stmt->execute(array($id_groups));
		$row = $stmt->fetch();
		return $row;
		}

	function listGroups()
	{
	$data = array('','');;
	$stmt = $this->db->prepare('SELECT * FROM post_users_groups');
	$stmt->execute();


	
	$cab='
	
	<table class="table table-striped">
      <thead>
        <tr>
       		<th>Grupo</th>
          	<th>Usuários</th>
          	<th colspan="4">Opções</th>
        </tr>
      </thead>
      <tbody>';

	 $foot='</tbody>
    </table>';



		while($row = $stmt->fetch())
		{
	
		$stmt2 = $this->db->prepare('SELECT count(id_post_user) FROM post_users WHERE id_post_group= ?');
			$stmt2->execute(array($row['id_post_group']));
			$row2 = $stmt2->fetch();

			$data[0].='
			<tr>
				<td>'.$row['name'].'</td>
				<td>'.$row2['count(id_post_user)'].'</td>
				<td><a href="{{BASE_URL}}postbear/usuarios/buscaLdap/'.$row['id_post_group'].'" class="editar" title="Adicionar Usuários"><i class="fa fa-plus-circle"></i></a></td>
				<td><a href="{{BASE_URL}}postbear/usuarios/_editarGrupo/'.$row['id_post_group'].'" class="editar" title="Editar Informações do Grupo"><i class="fa fa-pencil"></i></a></td>
				<td><a href="{{BASE_URL}}postbear/usuarios/_configGrupo/'.$row['id_post_group'].'" class="editar" title="Configurações do Grupo"><i class="fa fa-cog"></i></a></td>';
			if ($_SESSION['id_grupo']!=$row['id_post_group'])
			{
				$data[0].='<td><a class="excluirGrupo" id="'.$row['id_post_group'].'" href="#confirmaExclusao"  data-toggle="modal" title="Excluir Este Grupo"><i class="fa fa-trash-o"></i></a></td>
			</tr>';
			}
			else
			{
				$data[0].='<td><i class="fa fa-trash-o"></i></td>
			</tr>';
			}

				

			$data[1] .='
                $("a#'.$row['id_post_group'].'").click(function ()
                {
                      $("a#modalExcluir").attr({\'href\': \'{{BASE_URL}}postbear/usuarios/_excluirGrupoUsuarios/'.$row['id_post_group'].'\'});
                      $("#infObjeto").text("'.$row['name'].'");
                    });
            ';

		}
	if ($data[0]!='')
		{
		$data[0]=$cab.$data[0].$foot;
		}
		
	return $data;


	}

	function login($email, $password) {
	   // Using prepared Statements means that SQL injection is not possible. 
		if($stmt = $this->db->prepare('SELECT id, login, password, salt FROM users WHERE email = ? LIMIT 1'))
		{
			$stmt->execute(array($email));
			if($stmt->rowCount() == 1)
			{
				while($row = $stmt->fetch())
				{
					$db_id = $row['id'];
					$db_login = $row['login'];
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
						$_SESSION['login_string'] = hash('sha512', $password.$user_browser);
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
				return false;
			}
		}
	}

	function checkbrute($user_id) {
		// Get timestamp of current time
		$now = time();
		// All login attempts are counted from the past 2 hours. 
		$valid_attempts = $now - (2 * 60 * 60); 

		if ($stmt = $this->db->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'"))
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

	function login_check() {
	   // Check if all session variables are set
	   if(isset($_SESSION['user_id'], $_SESSION['login'], $_SESSION['login_string'])) {
	     $user_id = $_SESSION['user_id'];
	     $login_string = $_SESSION['login_string'];
	     $username = $_SESSION['login'];
	 
	     $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
	 
	     if ($stmt = $this->db->prepare("SELECT password FROM users WHERE id = ? LIMIT 1")) { 
	        $stmt->execute(array($user_id)); // Execute the prepared query.
	 
	        if($stmt->rowCount() == 1) { // If the user exists
	           while($data = $stmt->fetch())
	           {
	           		$password = $data['password'];
	           }
	           $login_check = hash('sha512', $password.$user_browser);
	           if($login_check == $login_string) {
	              // Logged In!!!!
	              return true;
	           } else {
	              // Not logged in
	              return false;
	           }
	        } else {
	            // Not logged in
	            return false;
	        }
	     } else {
	        // Not logged in
	        return false;
	     }
	   } else {
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
		   echo 'Invalid Request';
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
/*
	function register($email, $login, $pass, $grupo, $salt)
	{
		$salt = hash('sha512', $salt);
		$pass = hash('sha512', $pass);
		$pass = hash('sha512', $pass.$salt);
		$stmt = $this->db->prepare("INSERT INTO users (email, login, password, id_groups, salt) VALUES (?, ?, ?, ?, ?)");
		if($stmt->execute(array($email, $login, $pass, $grupo, $salt)))
		{
			header('Location: '.BASE_URL);
		}
		else
		{
			Jazz::Error();
		}
	}
*/
	function register($nome, $cpf, $matricula, $email, $setor, $id_post_grupo, $centro)
	{
		//$salt = hash('sha512', $salt);
		//$pass = hash('sha512', $pass);
		//$pass = hash('sha512', $pass.$salt);
	

		$stmt = $this->db->prepare("INSERT INTO post_users (nome, cpf, matricula, email, setor, id_post_group, centro ) VALUES (?, ?, ?, ?, ?, ?, ?)");
		if($stmt->execute(array($nome, $cpf, $matricula, $email, $setor, $id_post_grupo, $centro)))
		{
			header('Location: '.BASE_URL);
		}
		else
		{
			Jazz::Error();
		}
	}

	function registerGroup($nome,$descricao)
	{
		
		$stmt = $this->db->prepare("INSERT INTO post_users_groups (name, descr) VALUES (?, ?)");
		$row= $stmt->execute(array($nome,$descricao));
	
		$last_id= $this->db->lastInsertId();
		
		$pmpost=$_POST['controller'];
 		$xs=0;
		foreach ($_POST['controller'] as $key => $value)
			{
			$permissao = explode('|',$pmpost[$xs]);
			$xstmt = $this->db->prepare("INSERT INTO groups_permissions (id_post_group,module,controller,function, status) VALUES (?,?,?,?,1)");
			$xstmt->execute(array($last_id['id_post_group'],$permissao[0],$permissao[1],$permissao[2]));		
			$xs++;
			}
	if ($xstmt)
		{
		return true;
		}
	else
		{
		return false;	
		}
	}


	function updateGroup($id_group)
	{
		$stmt = $this->db->prepare("UPDATE post_users_groups SET name=? , descr=? WHERE id_post_group= ?");
		$row= $stmt->execute(array($_POST['nome_grupo'],$_POST['desc_grupo'], $id_group));

		$stmt = $this->db->prepare("UPDATE groups_permissions SET status=0 WHERE id_post_group = ?");
		$row= $stmt->execute(array($id_group));

		// $last_id= $stmt->lastInsertId();
		$pmpost=$_POST['controller'];
 		$xs=0;
		foreach ($_POST['controller'] as $key => $value)
			{
			$permissao = explode('|',$pmpost[$xs]);
			$xstmt = $this->db->prepare("UPDATE groups_permissions SET status=1  WHERE module=? AND controller=? AND function=? AND id_post_group = ?");
			$xstmt->execute(array($permissao[0],$permissao[1],$permissao[2],$id_group));	
			if($xstmt->rowCount() < 1) 	
				{
				$istmt = $this->db->prepare("INSERT INTO groups_permissions (id_post_group,module,controller,function, status) VALUES (?,?,?,?,1)");
				$istmt->execute(array($id_group,$permissao[0],$permissao[1],$permissao[2]));	
				}
			$xs++;
			}
	if ($xstmt)
		{
		return true;
		}
	else
		{
		return false;	
		}
	}

	function loadGroupPermission($id_group)
	{
		$stmt = $this->db->prepare('SELECT module, controller, function, status FROM groups_permissions WHERE id_post_group = ?');
		$stmt->execute(array($id_group));
		$row = $stmt->fetchAll();
		$_SESSION['arr']=$row;
		return true;
	}

	function loadGroupPermissionModule($id_group)
	{
		$stmt = $this->db->prepare('SELECT module, status FROM groups_permissions WHERE id_post_group = ? GROUP BY module');
		$stmt->execute(array($id_group));
		$row = $stmt->fetchAll();
		$_SESSION['arrMenu']=$row;
		return true;
	}

	function loadGroupPermissionController($id_group)
	{
		$stmt = $this->db->prepare('SELECT controller, status FROM groups_permissions WHERE id_post_group = ? GROUP BY controller');
		$stmt->execute(array($id_group));
		$row = $stmt->fetchAll();
		$_SESSION['arrCtrl']=$row;
		return true;
	}

	function deleteGroup($id_group)
	{
		$stmt = $this->db->prepare('DELETE FROM post_users_groups WHERE id_post_group = ?');	
		if ($stmt->execute(array($id_group)))
		{
			return true;
		}
		else
		{
			return false;
		}

	}

}