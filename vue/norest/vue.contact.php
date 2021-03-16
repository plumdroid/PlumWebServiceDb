<?php
/**
 * Vue Contact [vue]
 *
 * @project	plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/	

//<!---------------------------------------- retourne OK ------------------------------>
$contact=array("etat"=>0,"message"=>"","controleur"=>"contact","action"=>"hello",
	"secure_token"=>$this->token->getToken());

echo json_encode($contact);
?>