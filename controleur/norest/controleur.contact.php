<?php
/**
 * Controleur Contact
 * Retourne un message indiquant que le webservice est OK
 *
 * @project	   plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/

class Controleur_contact extends Plum_Controleur{         
	
	public function __construct($param){
		parent::__construct($param);//obligatoire
	}

	//-----------------------------------------------------------------------------------*
	//---------- définir les actions
	//-----------------------------------------------------------------------------------*
	
	function action_hello(){
		$v=$this->useVue("contact");
	}
}
?>