<?php
/**
 * Controleur debug.accueil 
 *
 * @project	   plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/

class Controleur_debugAccueil extends Plum_Controleur{         
	
	public function __construct($param){
		parent::__construct($param);//obligatoire
	}

	//-----------------------------------------------------------------------------------*
	//---------- définir les actions
	//-----------------------------------------------------------------------------------*
	
	function action_init(){
		$v=$this->useVue("debugAccueil");
	}
}
?>