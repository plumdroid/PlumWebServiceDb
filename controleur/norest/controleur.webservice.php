<?php
/**
 * Controleur webservice
 *
 * @project		plum.mvc
 * @license		GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author		Thierry Bogusz <thbogusz@yahoo.fr>
*/

class Controleur_webservice extends Plum_Controleur{         
	
	private $modele;
	
	public function __construct($param){
		parent::__construct($param);//obligatoire
		
		$this->modele=$this->useModele("webservice");
	}

	//-----------------------------------------------------------------------------------*
	//---------- définir les actions
	//-----------------------------------------------------------------------------------*
	
	//---------- webservice
	
	public function action_query(){
		$v=$this->useVue("webservice");
		
		$sql=$v->data->requete;
		$data=$v->data->data;
			
		$v->data->pdo=$this->modele->query($sql,$data);
	
		$v->data->action="query";
		$v->data->etat=0;
	}
	
	public function action_execute(){
		$v=$this->useVue("webservice");
		
		$sql=$v->data->requete;
		$data=$v->data->data;
		
		$v->data->pdo=$this->modele->execute($sql,$data);
		
		$v->data->action="execute";
		$v->data->etat=0;
	}
}



?>