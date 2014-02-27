<?php
// Plugin de Manipulação de Registros

class Register extends Model 
	{
	function getRegistro($identificador, $variavel)
		{
			$stmt = $this->db->prepare('SELECT valor FROM post_registros WHERE identificador = ? AND variavel= ?');
			$stmt->execute(array($identificador,$variavel));
			$row = $stmt->fetch();
			if ($row!='')
				{
				$valor=$row['valor'];
				}
			else
				{
				$valor='';	
				}
			return $valor;
		}

	function setRegistro($identificador, $variavel, $valor)
		{
		if ($this->getRegistro($identificador, $variavel)=='')
			{
			$stmt = $this->db->prepare('INSERT INTO post_registros (valor, identificador, variavel) VALUES (?, ?, ?)');
			}
		else
			{
			$stmt = $this->db->prepare('UPDATE post_registros set valor = ? WHERE identificador = ? AND  variavel = ?');
			}


		if ($stmt->execute(array($valor, $identificador,$variavel)))
			{
			$ret=true;
			}
		else
			{
			$ret=false;
			}
		return $ret;
		}

	function eraseRegistro($identificador)
		{
		$stmt = $this->db->prepare('DELETE FROM post_registros WHERE identificador = ?');
		if ($stmt->execute(array($identificador)))
			{
			$ret=true;
			}
		else
			{
			$ret=false;
			}
		return $ret;
		}
	}


?>