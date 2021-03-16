<?php
/**
 * modele.webservice[modele]
 *
 * @project	   plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/	

//::::contrôle vérifiant le passage par le super-contrôleur::::

if(!defined('PLUM_RACINE')) exit(0);

class Modele_webservice extends Plum_modele{

	public function __construct(){
		parent::__construct();//obligatoire
		
		$this->connectDb();
	}

//<!-- - - - - - - - - - - - -  query - - - - - - - - - - - -->

	public function query($sql,$data){
		
		$sth = $this->database->prepare($sql);
		
		$res=$this->execute_pdo($sth,$data);
		
		$res["tupple"]=array();
		
		if($res["error"]["errorCode"]==0){
			$res["tupple"]=$sth->fetchAll( PDO::FETCH_ASSOC);
		}
		return $res;
	}
	

//<!-- - - - - - - - - - - - -  execute - - - - - - - - - - - -->
	public function execute($sql , $data){
		
		$sth = $this->database->prepare($sql);
		
		return $this->execute_pdo($sth,$data);
	}

//<!-- - - - - - - - - - - - -  PRIVATE- - - - - - - - - - - -->
	private function execute_pdo(&$sth,$param=array()){
		
		$r["error"]["errorCode"]="0";
		$r["error"]["errorInfo"]="";
		$r["rowCount"]=0;
		
		$t=$sth->execute($param);
		
		if(!$t) {
			$r["error"]["errorCode"]=$sth->errorCode();
			$r["error"]["errorInfo"]=$sth->errorInfo();
		}
		else{
			$r["rowCount"]=$sth->rowCount();
		}
		
		return $r;
	}
}

?>