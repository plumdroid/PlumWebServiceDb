<?php
/**
 * Controleur Authentification
 *
 * @project	   plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/
include (PATH_FONCTION."class.accessoire.Debug.php");
Debug::$status=Debug::$OFF; //debug activé

class Controleur_authentification extends Plum_Controleur{         
	
	public function __construct($param){
		parent::__construct($param);//obligatoire
		
	}

	//-----------------------------------------------------------------------------------*
	//---------- définir les actions
	//-----------------------------------------------------------------------------------*
	
	function action_connecter(){
		$v=$this->useVue("authentification");
		
		$user=$v->data->user;
		$password=$v->data->password;
		
		$this->connect($user,$password);
			
		$v->data->action="connecter";
		
		Debug::print_json("user",$user);
		
		if($this->secure===false){
			$v->data->etat=100;//erreur authentification
			$v->data->message="Erreur authentification";
			$v->data->password="";
			$v->data->user="";
		}
		else{
			$v->data->etat=0;//authentification OK
			$v->data->message="";
			$v->data->password=""; //ne pas se souvenir de l'identifiant
			$v->data->user="";
		}
	}

	function action_deconnecter()
	{
		$this->deconnect();
		$v=$this->useVue("authentification");
		$v->data->action="deconnecter";
		$v->data->etat=0;
	}
}
?>