<?php

class Main_model extends Model 
{
	

	function listaMensagens($qtd)
	{
		$stmt = $this->db->prepare('SELECT * FROM post_news WHERE id_post_user = ? ORDER BY id_post_news DESC LIMIT 0, 10');
		$stmt->execute(array($_SESSION['id_user']));
		$data='';
		while ($row = $stmt->fetch())
		{
			$data .= '<li><a href="{{BASE_URL}}mensagens/enviadas/_review/'.$row['id_post_news'].'">'.$row['titulo'].'</a></li>';
		}
		return $data;
	}

	function getGroups($id_user)
	{
		$stmt = $this->db->prepare('SELECT * FROM post_users_groups WHERE id_post_group= ?');
		$stmt->execute(array($id_user));
		$row = $stmt->fetch();
		return $row['name'];
	}

	
		
}