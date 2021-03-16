<?php
//--------- rappel config.php
/*
$configXuSec['io']="database";
$configXuSec['driver']="mysql";
$configXuSec['host']="localhost";
$configXuSec['dbname']='bdexemple';
$configXuSec['tableUser']='table_user';
$configXuSec['user']='root';
$configXuSec['pwd']='';
*/
Class UserIoDatabase{
	//public static $_iuser=0,$_ipassword=1,$_inom=2,$_igroupe=3,$_imail=4;
	private $tchamp=array("iuser","ipassword","inom","igroupe","imail");
	
	private $database=null;
	private $dsn="";
	private $user="";
	private $pass="";
	
	private $tableUser="";
	
	public function __construct($configXuSec) {
	
		$this->dsn=$configXuSec['driver'].':host='.$configXuSec['host'].';dbname='.$configXuSec['dbname'];
		
		$this->user=$configXuSec['user'];
		$this->pass=$configXuSec['pwd'];
		
		$this->tableUser=$configXuSec['tableUser'];
		
		$this->connectDb();
	}
	
	
	private function connectDb(){
		
		$this->database=null;
		try {
				$dbh = new PDO($this->dsn, $this->user, $this->pass, 
								array( PDO::ATTR_PERSISTENT => true));
			}catch(PDOException $e){
					print "<br>Erreur userIoDdatabase::connect databaseDb() [modele".EXEC_PACKAGE."] error method connect() : ". $e->getMessage() . "<br/>";
					die();
				}
		
		$this->database=$dbh;
		$this->pass="";
}

/*
* retourne s/f tableau les utilisateurs d'un package
* respecte l'organisation décrite dans plum.secure.php
*
* @return Array toutes les informations sur tous les utilisateurs
*/
	public function getAllUser(){
		
		$projection="";
		$virgule="";
		for($i=0;$i<count($this->tchamp);$i++){
			$projection.=$virgule.$this->tchamp[$i];
			$virgule=",";
		}
		
		
		$sql="select ".$projection." from ".$this->tableUser;
		
		$sth = $this->database->prepare($sql);
		
		$t=$sth->execute();
		if(!$t) {
			print("<br>Erreur PDO::userIoDatabase::getAllUser<br>");
			print_r($sth->errorInfo());
			die("");
		}
		
		return $sth->fetchAll(PDO::FETCH_NUM);
	}
	
	
//--------------------------- A VOIR et A TESTER --------------------
public  function addNewUser($infoUser){
		//$fu=fopen($this->path_secure_file("secure.user.php"),"a");
		
	}
	
	public function deleteMe(){
		$user=$this->getUser();
		$this->deleteUser($user[$this->$_iuser]);
	}
	
	public  function deleteUser($user){
		
		return true;
	}
	
	private  function updateSecureUser($content){
		//ajouter les sauts de ligne
		
	}
}