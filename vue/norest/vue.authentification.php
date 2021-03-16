<?php
/**
 * Vue Authentification[vue]
 *
 * @project	   plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/	


	$auth=array("etat"=>$this->data->etat,"message"=>$this->data->message,"controleur"=>"authentification","action"=>$this->data->action,
	"secure_token"=>$this->token->getToken());
	
	echo json_encode($auth);
?>