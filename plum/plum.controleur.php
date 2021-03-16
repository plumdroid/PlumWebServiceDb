<?php

Class Plum_controleur{
	
	private $package;    //String
	private $controleur; //String
	private $action; 	//String
	private $param=null;		//Plum-data paramètres fournis au moment de 'execute'
	
	private $secure;	//Secure
	private $token=null; //gestion token
	
	private $vue;		//String dernière vue useVue
	
	private $v=null;	//Plum_vue
	
	private $paramUrl=null;	//Plum_data
	
	private $sac=null;	//Plum_sacoche : "persist"
	
	 /**
     * Constructeur de contrôleur
     *
     * Si l'action n'existe pas     	: message d'erreur + die()
	 * Si non autorisé 					: message d'erreur + die()
     *
     * @param Plum_data $param			: paramètre de configuration du contrôleur
	 * 					->controleur 	: nom du controleur
	 *					->action		: nom de l'action
	 *
     * @return 							: aucun
     */
	protected function __construct($param){ 
	
		//Obtenir l'utilisateur connecter et ses autorisations
		
		$this->secure=Secure::getConnect();
		
		if($this->secure==null){
			die("Plum_controleur::execute :  objet secure non opérationnel...");
		}
		
		//mémorisation des champs
		$this->package=EXEC_PACKAGE;
		$this->controleur=$param->controleur;
		$this->action=$param->action;
		$this->param=$param->param;//paramètres fournis par execute
		
		$this->vue="";
		
		$this->paramUrl=new Plum_data();
		foreach($_GET as $key => $value){ //récup. données URL
			$this->paramUrl->$key=$value;
		}
		
		$this->sac=new PlumSacoche($this->pathControleur());
		
		$this->token=new Token();
	}
		
	 /**
     * Charge un contrôleur et exécute une action
     *
     * Si le contrôleur n'existe pas	: message d'erreur + die()
     * Si l'action n'existe pas     	: message d'erreur + die()
	 * Si non autorisé 					: message d'erreur + die()
     *
     * @param string $controleur 		nom du contôleur
	 * @param string $action     		nom de l'action
     * @return 							objet Plum_controleur
     */
	public function execute($controleur,$action,$paramexe=null){
		
		//contrôle signature numérique réalisé par Secure::getConnect() : token, ip et agent
		
		$ok=$this->secure->is_getconnect_ok();
		
		
		if($ok==false) {// pas passer par le constructeur !!
			$this->connect("ALL","ALL");
			if(defined('DEFAUT_CONTROLEUR')){
				$controleur=DEFAUT_CONTROLEUR;
				$action=DEFAUT_ACTION;
			}
			else{
				die("Plum_controleur::execute :  pas de controleur par défaut'");
			}
		}
			
		//existence du contrôleur
		if (!$this->existeControleur($controleur)) {
			$this->fatal("Le contrôleur [".$controleur."] n'existe pas");
		}
		
		//autorisation
		if ($this->secure===false) $this->fatal("Vous devez vous authentifier...");
		
			
		$t=$this->secure->isAuthorised($controleur);
		if($t===false) {
			if(defined('DEFAUT_CONTROLEUR')){
				$controleur=DEFAUT_CONTROLEUR;
				$action=DEFAUT_ACTION;
			}
			else{
				$this->fatal("Contrôleur [".$controleur."] : autorisation réfusée");
			}
		
		}//
		
		//chargement du contrôleur 
		$include_once=$this->pathControleur($controleur);
		include_once($include_once);
		
		//new controleur : Controleur_nomcontroleur($param)
		$param=new Plum_data();
		$param->controleur=$controleur;
		$param->action=$action;
		$param->param=$paramexe;
		$class="Controleur_".$controleur;
		$c=new $class($param);
		
		//existence de l'action
		if(!$this->existeAction($action,$c)){
			$this->fatal("L'action [".$action."] n'existe pas dans le contrôleur [".$controleur."]");
		}
		
		//callback
		$callback=$this->callback($action);
		$call=call_user_func_array(array($c,$callback), array()); 
		
		//return
		if (is_object($call)===true){
			if (get_parent_class($call)==="Plum_controleur") {$c=$call;}
			else {die("Plum_controleur::execute : l'objet [".get_class($call)."] retourné doit hérité de 'Plum_controleur'");}
		}
		return $c;
	}
	
	public function existeControleur($controleur){
		$path_controleur=$this->pathControleur($controleur);
		if (!file_exists($path_controleur)) return false;
		return true;
	}
	
	public function pathControleur($controleur=""){
		$cracine=$controleur;
		if($controleur==""){$cracine=$this->controleur;}
		return PATH_CONTROLEUR."controleur.".$cracine.".php";
	}
	
	public function existeAction($action,$c=null){
		$callback=$this->callback($action);
		
		$ocontroleur=$c;
		if($c==null) {$ocontroleur=$this;}
		return method_exists($ocontroleur,$callback);
	}
	
	
	private function callback($action){
		return "action_".$action;
	}
	
	public function pathVue($vue=""){
		$php="";
		$préfixe="";
		if ($vue!="") {
			$php=".php";
			$préfixe="vue.";
		}

		return PATH_VUE.$préfixe.$vue.$php;
	}
	
	
	public function existeVue($vue){
		$path_vue=$this->pathVue($vue);
		if (!file_exists($path_vue)) return false;
		return true;
	}
	
	//userVue
	public function useVue($vue){
		if ($this->existeVue($vue)===false){
			die("la vue '".$vue."' n'existe pas dans '".EXEC_PACKAGE."'");
		}
		
		$this->vue=$vue;
		
		$this->v= new Plum_vue($vue,$this);
		return $this->v;
	}
	
	public function __get($name){
		switch($name){
			case "package" : return $this->package;
			case "action" : return $this->action;
			case "secure" : return $this->secure;
			case "vue" : return $this->vue;
			case "controleur":return $this->controleur;
			case "persist":return $this->sac;
			case "v": return $this->v;
			case "paramUrl":return $this->paramUrl;
			case "param":return $this->param;
			case "token":return $this->token;
		}
		die ("le champ '".$name."' n'existe pas dans Plum_controleur !");
	}
	
	protected function useModele($modele_name){
		if (!$this->existeModele($modele_name)){
			die("Le modèle '".$modele_name."' n'existe pas dans 'modele/".EXEC_PACKAGE."' !");
		}
		
		include_once($this->pathModele($modele_name));
		
		$class_modele="Modele_".$modele_name;
		return new $class_modele();
		
	}
	
	protected function pathModele($modele_name){
		return PATH_MODELE."modele.".$modele_name.".php";
	}
	
	protected function existeModele($modele_name){
		$path_modele=$this->pathModele($modele_name);
	
		if (!file_exists($path_modele)) return false;
		return true;
	}
	
	public function connect($user,$password){
		$this->secure=Secure::connect($user,$password);
	}
	
	public function deconnect(){
		$this->secure=$this->secure->closeConnexion();
	}
	/*
	* Permet de forger une URI plum.mvc
	*
	 *
	 * @param string 		$package	 		nom du package
     * @param string		$controleur 		nom du contôleur
	 * @param string 		$action     		nom de l'action
	 * @param Plum_Data[] 	$param				array<Plum_data>
	 *						->param				nom du paramètre
	 *              		->val				valeur
	 *
     * @return 							String s/f 'e/package/controleur/action/_param_&x=y&v=z'
     */
	public function forgeUri($package,$controleur,$action,$param=array()){
	   
		$uri='e/'.$package.'/'.$controleur.'/'.$action.'/';
		
		$uri_param='_param_&secure_token='.$this->token->getToken();
		
		$p=false;
			
		foreach ($param as $p){
			$uri_param.='&'.$p->key.'='.$p->val;
		}
		
		$uri.=$uri_param;
		
		return PATH_WWW.$uri;
	}
	
	public function forgeUriAction($action,$param=array()){
		return $this->forgeUri($this->package, $this->controleur,$action,$param);
	}
	
	private function fatal($message){
		$m="<br>!!!ERREUR CONTROLEUR!!!<br>";
		die($m.$message);
	}
}

//*----------------------------------------- CLASS Plum_data

class Plum_data{
	private $data=array();
	
	public function __set($name,$value){
		$this->data[$name]=$value;
	}
	
	public function __get($name){
		if(array_key_exists($name,$this->data)){
			return $this->data[$name];
		}
		
		return null;
	}
	
	public function toArray(){
		return $this->data;
	}
}


//*----------------------------------------- CLASS Plum_vue
class Plum_vue{

		public $titre;		//string titre de la vue
		
		public $message;	 //string : message à afficher
		
		private $actionAfterMessage;  // chaine indicant l'action a appelé après l'affichage du message
		
		public $focus;		// string : champ prenant le focus
		
		private $data; 		 //Plum_data : données de la vue
		
		private $c;          //type Controleur
		
		private $vue;	    //String nom de la vue
		
		private $path_view;
		
		public $menu;//Plum_menu
	
	public function __construct($vue,&$c){
		$this->c=$c;
		
		$this->vue=$vue;
		$this->path_view=$c->pathVue($vue);
		
		$this->data=new Plum_Data();
		
		foreach($_POST as $key => $value){ //récup. données formulaires
			$this->data->$key=$value;
		}
	}
	
	public function __get($name){
		switch($name){
			case "package": return $this->c->package;
			case "controleur": return $this->c->controleur;
			case "action" : return $this->c->action;
			case "secure" : return $this->c->secure;
			case "token" : return $this->c->token;
			case "vue" : return $this->vue;
			case "data" : return $this->data;
			case "path-view":return $this->path_view;
			case "c":return $this->c;
			case "actionAfterMessage":return $this->actionAfterMessage;
		}
		die ("le champ '".$name."' n'existe pas dans Plum_vue::__get() !");
	}
	
	
	
	public function show(){
		include_once($this->path_view);
	}
	
	public function useMenu($menu_name){
		$this->menu=new Plum_menu($menu_name,$this);
		
		return $this->menu;
	}
	
	public function setActionAfterMessage($message,$action){
		$this->message=$message;
		$this->actionAfterMessage=$this->c->forgeUriAction($action);
	}
	
	
}

//*----------------------------------------- CLASS Plum_menu
class Plum_menu{

	public $id=null; //identifiant du menu [string]
	
	public $items=null; //items du menu [arrays Plum_data -> controleur; ->action ; ->caption]
	
	public $actif=""; //index du menu actif
	
	private $actifPrioritaire="";//modifier par setActifMenu(indice)
	
	public $v=null; //Plum_vue contenant le menu
	
	public function __construct($menu_name,&$vue){
	
		if (!Plum_menu::existeMenu($menu_name)) {
			die("le menu '".$menu_name."' n'existe pas !");
		}
		
		$this->v=$vue;
		
		$this->id="vue_menu_id_".md5_file(Plum_menu::pathMenu($menu_name));
		
		$this->items=array();
		
		$this->actif="";
	
		//---- récupération des items du menu
		include_once(Plum_menu::pathMenu($menu_name));
		
		//----- info URL [id du menu actif]
		
		if(isset($_POST[$this->id])){
			$this->actif=$_POST[$this->id];
		}
		
		if(isset($_GET[$this->id])){
			$this->actif=$_GET[$this->id];
		}
	}
	
	public static function existeMenu($menu_name){
		$path_menu=Plum_menu::pathMenu($menu_name);
		if (!file_exists($path_menu)) return false;
		return true;
	}
	
	public static function pathMenu($menu_name){
		return PATH_VUE."menu.".$menu_name.".php";
	}

}


//*----------------------------------------- CLASS Plum_modele

class Plum_modele{
	private $dsn=null;
	private $user=null;
	private $pass=null;
	
	protected $secret=null;
	
	protected $database=null;

	protected function __construct(){
		if (!$this->existeConf()){
			die("le fichier 'config.php' n'existe pas dans 'modele.".EXEC_PACKAGE."' !");
		}

		include($this->pathConf());
		
		$this->dsn=$configXuMod['driver'].':host='.$configXuMod['host'].';dbname='.$configXuMod['dbname'];
		$this->user=$configXuMod['user'];
		$this->pass=$configXuMod['pwd'];
		
		if(isset($configXuMod['secret'])) {$this->secret=$configXuMod['secret'];}
	}
	
	protected function connectDb(){
		
		$this->database=null;
		try {
				$dbh = new PDO($this->dsn, $this->user, $this->pass, 
								array( PDO::ATTR_PERSISTENT => true));
			}catch(PDOException $e){
					print "<br>Erreur Plum_Modele::connect databaseDb() [modele".EXEC_PACKAGE."] error method connect() : ". $e->getMessage() . "<br/>";
					die();
				}
		
		$this->database=$dbh;
		$this->pass="";//par précaution!
	}
		
	
	private function pathConf(){
		return PATH_MODELE."config.php";
	}
	
	private function existeConf(){
		$path_conf=$this->pathConf();
		
		if (!file_exists($path_conf)) return false;
		return true;
	}
}
?>