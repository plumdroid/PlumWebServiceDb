<?php
Class UserIoFile{

public function __construct($configXuSec) {
}

/*
* retourne s/f tableau le contenu de secure.user.php
* respecte l'organisation décrite dans plum.secure.php
*
* @return Array toutes les informations sur tous les utilisateurs
*/
	public function getAllUser(){
		$fu=fopen($this->path_user_file("secure.user.php"),"r");
		//extraire les commentaires
		$i=0;
		while (!feof($fu)) {
			$line= $this->fgetsWithoutDelimiteur ($fu);
			if(substr($line,0,1)!="#") break;
			$comment[$i]=$line;$i++;
		}
		//liste des utilisateurs : on pensera à supprimer les utilisateurs obsolètes[deleteUser?]
		$i=0;
		while ($line!==false) {
			$userInfo=$this->explodeUser($line);
			
			$listeUser[$i]=$userInfo;
			$line= $this->fgetsWithoutDelimiteur($fu);
			
			$i++;
		}
		
		return $listeUser;
	}
	
	//user:MD5password:Nom:group:email:date:heure[HHmm]:limiteMinute
	private function explodeUser($line){
		$user=explode(":",$line);
		if(count($user)<5) {print("Fichier des utilisateurs : ligne non conforme->".$line);die("");}
		return $user;
	}
	
	//supprime les délimiteurs et retourne les données du fichier
	private function fgetsWithoutDelimiteur(&$file){
		$line= fgets ($file);
		
		if($line!==false){
		$line=str_replace("\r","",$line);
		$line=str_replace("\n","",$line);
		}
		
		return $line;
	}
	
	/*
	* Retourne le chemin du fichier de user.secure.php
	*
	* @return String le chemin complet de "/chemin.../user.secure.php"
	*/
	private function path_user_file($file){
		$type=explode(".",$file);
		$path=PATH_USER_SECURE;
		
		$path=$path.$file;
		if (!file_exists($path)) {
			die("Le fichier '".$file."' n'existe pas !!");
		}
		return $path;
}

//--------------------------- A VOIR et A TESTER --------------------
public  function addNewUser($infoUser){
		//$fu=fopen($this->path_secure_file("secure.user.php"),"a");
		$compte=$user.":".$passwd.":".$identite.":@".$groupe.":".date("Y-m-d").":".date("Hi").":".$limiteMinute;
		
		fputs($fu, "\n"); // on va a la ligne
		fputs($fu, $compte); // on écrit dans le fichier
		fclose($fu);
		return true;
	}
	
	public function deleteMe(){
		$user=$this->getUser();
		$this->deleteUser($user[$this->$_iuser]);
	}
	
	public  function deleteUser($user){
		$content=$this->getFileContentUser();
		$userFile=$content["user"];
		$t=false;
		for($i=0;$i<count($userFile);$i++){
			$userInfo=$this->explodeUser($userFile[$i]);
			if ($userInfo[$this->$_iuser]==$user) {$t=true;break;}
		} 
		if($t==false) return false;
		
		unset($userFile[$i]);
		$userFile=array_values($userFile);//réindexation du tableau après unset
		$content["user"]=$userFile;
		$this->updateSecureUser($content);
		return true;
	}
	
	private  function updateSecureUser($content){
		//ajouter les sauts de ligne
		$comments=$content["comment"];
		$fc=0;
		for($i=0;$i<count($comments);$i++){
			$fileContent[$fc]=$comments[$i]."\n";$fc++;
		}
		$users=$content["user"];
		for($i=0;$i<count($users);$i++){
			$fileContent[$fc]=$users[$i]."\n";$fc++;
		}
		$fc--;
		$fileContent[$fc]=str_replace("\n","",$fileContent[$fc]);//supprimer le dernier saut de ligne
		file_put_contents("../secure/secure.user.php",$fileContent);
	}
}