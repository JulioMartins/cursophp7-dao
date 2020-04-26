<?php

class Usuario {

	private $idusuario;
	private $deslogin;
	private $desenha;
	private $dtcadastro;

	public function getIdUsuario() {

		return $this->idusuario;
	}

	public function setIdUsuario($idusuario) {

		$this->idusuario = $idusuario;
	}

	public function getDeslogin() {

		return $this->deslogin;
	}

	public function setDeslogin($value) {

		$this->deslogin = $value;
	}

	public function getDesenha() {

		return $this->desenha;
	}

	public function setDesenha($value) {

		$this->desenha = $value;
	}

	public function getDtCadastro() {

		return $this->dtcadastro;
	}

	public function setDtCadastro($value) {

		$this->dtcadastro = $value;
	}

	public function loadById($id) {

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));

		if (count($results) > 0) {

			$row = $results[0];

			$this->setIdUsuario($row["idusuario"]);
			$this->setDeslogin($row["deslogin"]);
			$this->setDesenha($row["desenha"]);
			$this->setDtCadastro(new DateTime($row["dtcadastro"]));

		}
	}

	public static function getList() {

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios ORDER BY  deslogin;");
	}

	public static function search($login) {

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin;",
			array(":SEARCH"=>"%" . $login . "%"));	
	}

	public function login($login, $password) {

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN and desenha = :PASSWORD", array(				
				":LOGIN"=>$login,
				":PASSWORD"=>$password));

		if (count($results) > 0) {

			$row = $results[0];

			$this->setIdUsuario($row["idusuario"]);
			$this->setDeslogin($row["deslogin"]);
			$this->setDesenha($row["desenha"]);
			$this->setDtCadastro(new DateTime($row["dtcadastro"]));

		} else {

			throw new Exception("Login e/ou senha inválidos.");
		}
	}

	public function __toString() {

		return json_encode(array(
			"idusuario"=>$this->getIdUsuario(),
			"deslogin"=>$this->getDeslogin(),
			"desenha"=>$this->getDesenha(),
			"dtcadastro"=>$this->getDtCadastro()
		));
	}

}

?>