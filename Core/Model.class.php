<?php

class Model
{
	private $db_dsn;
	private $db_user;
	private $db_pass;
	protected  $pdo;

	public function init_connection($db_dsn, $db_user = 'root', $db_pass = 'root')
	{
		$this->db_dsn = 'mysql:db_name=';
		$this->db_user = $db_user;
		$this->db_pass = $db_pass;
		$this->getPDO()->query('CREATE DATABASE IF NOT EXISTS camagru');
		$this->db_dsn = $db_dsn;
		$this->pdo = null;
	}

	public function getPDO(){
		if ($this->pdo === null){
			$pdo = new PDO($this->db_dsn, $this->db_user, $this->db_pass);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo = $pdo;           
		}
		return $this->pdo;
	}

	public function query($statement, $one = true)
	{
		$query = $this->getPDO()->query($statement);
		if (strpos($statement, 'UPDATE') === 0 ||
			strpos($statement, 'CREATE') === 0 ||
			strpos($statement, 'INSERT') === 0 ||
			strpos($statement, 'DELETE') === 0)
		{
			return null;
		}
		$query->setFetchMode(PDO::FETCH_ASSOC);
		if (isset($one) && !empty($one))
			$data = $query->fetch();
		else
			$data = $query->fetchAll();
		return $data;
	}

	public function prepare($statement, $attributes, $one = true){
	    $req = $this->getPDO()->prepare($statement);
	    $res = $req->execute($attributes);
	    if(strpos($statement, 'UPDATE') === 0 ||
	        strpos($statement, 'INSERT') === 0 ||
	        strpos($statement, 'DELETE') === 0)
	    {
	        return $res;
	    }
		$req->setFetchMode(PDO::FETCH_ASSOC);
		if (isset($one) && !empty($one))
			$data = $req->fetch();
		else
			$data = $req->fetchAll();
	    return $data;
	}
}