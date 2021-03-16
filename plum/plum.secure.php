<?php
include_once (PLUM_RACINE."plum/plugin.secure/user.io.file.php");
include_once (PLUM_RACINE."plum/plugin.secure/user.io.database.php");


//******A VOIR sur déconnexion faire une reconnexion ALL voir pb template et logique : il doit tjours y avoir une connexion par défaut ALL*********

/** 
 * Class Secure
 * Toutes les méthodes pour la gestion des utilisateur et des accès aux contrôleurs
 * ATTENTION : nécessite l'usage de $_SESSION
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
 */
class Secure {
	//user:MD5password:Nom:group:email:date:heure:limiteMinute
	public static $_iuser=0,$_ipassword=1,$_inom=2,$_igroupe=3,$_imail=4;
	private static $iou=null;
	
	private static $_session_start_on=false;
	
	private static $_getconnect_ok=false;
	
	public $token=null;

	private function __construct(&$token) {
		if(self::$_session_start_on==false){
			die("Secure::construct : Vous devez utiliser Secure::session_start()");
		}	
		$this->token=$token;
	}  
   
   //-------------------------------------------- public static function ----------------------------------------------------------
   
   /**
	* Permet et garanti :
	*   - session_start uniquement avec cookie
	*   - un id de session par paquetage
	*
	* return void
	*/
	public static function session_start(){
		ini_set('session.use_cookies', 1);       // Use cookies to store session.
		ini_set('session.use_only_cookies', 1);  // phpsessionID interdit via URL
		ini_set('session.use_trans_sid', 0); // Éviter d'utiliser php sessionID dans l'URL si les cookies sont désactivés.
		
		
		
		session_set_cookie_params(0,"/");
		
		self::session_name();//pour différencier les ids sessions entres paquetage ; par ex : 'plummvc_exemple' pour le paquetage "exemple"
		session_start();
		
		self::$_session_start_on=true;	
	}
	
    private static function session_name(){
		$sessionName="plummvc_".EXEC_PACKAGE;
		
		if(session_name()!=$sessionName){
			session_name($sessionName);
		}
		
		return $sessionName;
   }
   /**
   /* Authentification à plum.mvc
   /* - Par user/mot de pass
   /*
   /* @return un objet Secure ou false [si échec d'autentification]
   */
	public static function connect($user,$motdepasse){
		
		Secure::closeConnect();
		
		if($user=="") return false;
		
		if($motdepasse=="") return false;
	
		$userget=self::getSecureUser($user);	
		if($userget===false) return false;
			
		if($userget[self::$_ipassword]!=$motdepasse) return false;
	
		$controleurs=self::getSecureControleur($userget[self::$_igroupe]);
	
		//--- mémorisation des données de connexion
		
		$_SESSION[self::getIdSecure()]["user"]=$userget;
	    $_SESSION[self::getIdSecure()]["controleurs"]=$controleurs;
		
		$token=new Token();
		$token->newToken();
		
		//--- création de l'objet secure	
		
		return new Secure($token);//connexion réussie!
	}
	
	/**
     * Retourne la dernière connexion valide
     *
	 * @return un objet Secure ou un accès @ALL [public]
     */
	public static function getConnect(){
		//-- retourne un accès authentifié si existe
		//-- on contrôle le token, ip  et agent
		$token=new Token();
		
		self::$_getconnect_ok=false; //authentifie l'accès getConnect()
		
		
		
		if (isset($_SESSION[self::getIdSecure()]) &&
				$token->isOkTokenIpAgent())
		{
			self::$_getconnect_ok=true;//authentifie l'accès getConnect()
			return new Secure($token);
		}
		
	
		//Authentification anonyme instanciée @ALL
		self::$_getconnect_ok=true;
		return Secure::connect("ALL","ALL");
	}
	
	public function is_getconnect_ok(){
		return self::$_getconnect_ok;
	}
	/**
     * clôture une connexion et retourne null pour détruire l'objet
     *
	 * @return null : $secure=$secure->closeConnexion();
     */
	public static function closeConnect(){

		$_SESSION=array();
		
		new Token();//régénération du token
	}
	
	/*
	* Retourne le chemin d'un fichier dans secure
	* @return String le chemin complet de "/chemin.../controleur.secure.php"
	*/
	public static function pathFile($file,$chemin=""){
		$path=$chemin;
		if($path=="") {
			$path=PATH_CONTROLEUR_SECURE;
		}
		
		$path=$path.$file;
		if (!file_exists($path)) {
			die("Répertoire 'secure': le fichier '".$path."' n'existe pas !!");
		}
		return $path;
	}
	
//-------------------------------------------- public function ----------------------------------------------------------

	/**
     * clôture une connexion et retourne false pour détruire l'objet
     *
	 * @return false : $secure=$secure->closeConnexion();
     */
	public function closeConnexion(){
		Secure::closeConnect();
	  
		return false;
	}
	
	 /**
     * Indique si le le groupe est autorisé à exécuter le controleur
     *
	 * @return true authorised ; false not authorised
     */
	public function isAuthorised($controleur){
		if(isset($_SESSION[self::getIdSecure()])==false) die("Secure:Connexion clôturée...");
		
		if($controleur=="") return false;
		
		$lescontroleurs=$_SESSION[self::getIdSecure()]["controleurs"];
		
		for($i=0;$i<count($lescontroleurs);$i++){
			if($lescontroleurs[$i]==$controleur) return true;
		}
		
		return false; 
	}
	
	public function getNom(){
		/*echo "getNom:";
		print_r($_SESSION[self::getIdSecure()]);
		die("");*/
		return $_SESSION[self::getIdSecure()]["user"][self::$_inom];
	}
	
	public function getUser(){
	 return  $_SESSION[self::getIdSecure()]["user"][self::$_iuser];
	
	}
	
	public function getGroupe(){
	 return  $_SESSION[self::getIdSecure()]["user"][self::$_igroupe];
	
	}
	
   
//-------------------------------------------- private function ----------------------------------------------------------
	
	
//-------------------------------------------- private static function ----------------------------------------------------------
	//retourne s/f tableau : le compte d'un utilisateur 
	//si utilisateur n'existe pas retourne false
	private static function getSecureUser($user){
					
			$allUser=self::iou()->getAllUser();
			
			//ajout de @ALL
			//public static $_iuser=0,$_ipassword=1,$_inom=2,$_igroupe=3,$_imail=4;
			//ALL:ALL:ANONYME:@ALL:no mail
			$i=count($allUser);
			$allUser[$i][0]="ALL";
			$allUser[$i][1]="ALL";
			$allUser[$i][2]="ANONYME";
			$allUser[$i][3]="@ALL";
			$allUser[$i][4]="no mail";
			
			for($i=0;$i<count($allUser);$i++){
				if ($allUser[$i][self::$_iuser]==$user) {return $allUser[$i];}
			} 
			return false;
	}
	
    //retourne s/f tableau : la liste des contrôleurs pour $groupe
	private static function getSecureControleur($groupe){
		$lcontroleur=self::getFileContentControleur();
		$gcontroleur=array();
		$g=0;
		for($i=0;$i<count($lcontroleur);$i++){
			for($j=1;$j<count($lcontroleur[$i]);$j++){
				if($lcontroleur[$i][$j]==$groupe || $lcontroleur[$i][$j]=="@ALL") {$gcontroleur[$g]=$lcontroleur[$i][0];$g++;}
			}
		}
		return $gcontroleur;
	}
	
	//retourne s/f tableau : secure.controleur.php
	private static function getFileContentControleur(){
		$fc=fopen(self::pathFile("secure.controleur.php"),"r");
		
		//passe les commentaires
		while (feof($fc)===false) {
			$line= self::fgetsWithoutDelimiteur ($fc);
			if(substr($line,0,1)!="#") break;
		}
		//liste des contôleurs: on pensera à supprimer les utilisateurs obsolètes[deleteUser?]
		$listeControleur[0]=explode(":",$line);
		$i=0;
		while(feof($fc)===false){
			$line= self::fgetsWithoutDelimiteur ($fc);
			$controleur=explode(":",$line);
			if(count($controleur)<2) {print("Fichier des controleurs : ligne non conforme");die("");}
			$i++;
			$listeControleur[$i]=$controleur;
		}
		
		return $listeControleur;
	}

	//supprime les délimiteurs et retourne les données du fichier
	private  static function fgetsWithoutDelimiteur($file){
		$line= fgets ($file,4096);
		$line=str_replace("\r","",$line);
		$line=str_replace("\n","",$line);
		return $line;
	}
	
	// iou : le fichier config.php désigné par USER_SECURE
	private static function iou(){
		include (Secure::pathFile("config.php",PATH_USER_SECURE));
		
		$io=$configXuSec['io'];
		switch ($io){
			case 'file':
				return new UserIoFile($configXuSec);		
			case 'database':
				return new UserIoDatabase($configXuSec);
			case 'ldap':
			    return null;
		}
		die("plum.secure.php::iou() mode 'io' inconnu pour [".PATH_CONTROLEUR_SECURE."]");
	}
	
	
	private static function getidSecure(){
		return "_Secure_idhhhLLJHHGSZJJHhghsdy2345RAFSGhGGSFé";
	}
	
	
}
//
//---- contrôle token, ip et agent
//
class Token{

	public function __construct(){

		if(!isset($_SESSION[self::getIdToken()])){
		
				$_SESSION[self::getIdToken()]["ip_client"]=self::getClientIp();
				$_SESSION[self::getIdToken()]["agent"]=$_SERVER['HTTP_USER_AGENT'];		
				self::newToken();
		}
	}
	
	public  function isOkTokenIpAgent(){
		$token="";
		if (isset($_GET['secure_token'])){
			$token=$_GET['secure_token'];
		}		
		if (isset($_POST['secure_token'])){
			$token=$_POST['secure_token'];
		}
		
		$ip=self::getClientIp();
		
		$agent=$_SERVER['HTTP_USER_AGENT'];
		
		
		if($token!=$_SESSION[self::getIdToken()]["token"]) return false;
		
		if($ip!=$_SESSION[self::getIdToken()]["ip_client"]) return false;
		
		if($agent!=$_SESSION[self::getIdToken()]["agent"]) return false;
		
		return true;
	}
	
	public function getToken(){
		return $_SESSION[self::getidToken()]['token'];
	}
	
	public  function newToken(){
		include (PATH_CONTROLEUR_SECURE."config.php");
		
		$secret=$configXuSec['secret'];
		$ip=self::getClientIp();
		$agent=$_SERVER['HTTP_USER_AGENT'];
		
		$token=$secret.$ip.$agent.date("c");

		$token=md5($token);
		
		$idToken=self::getidToken();
		$_SESSION[$idToken]['token']=$token;
		
		$_GET['secure_token']=$token;
		$_POST['secure_token']=$token;
	}
	
	public static function getClientIp() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
	 
		return $ipaddress;
	}

	private static function getIdToken(){
		return "__Token_kdFGCSDOPP£27---_çdyxdjPPPUHHSE33.";
	}
}