<?php
/**
 * Vue webservice[vue]
 *
 * @project	   plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/	

function utf8_encode_deep($input) {
	$output=array(); //car $inut peut etre array()
	
	foreach($input as $key =>$value){
		if (is_string($value)) {
			$value = utf8_encode($value);
		}
		
		if (is_string($key)){
			$key = utf8_encode($key);
		}
		
		if(is_array($value)){
			$value=utf8_encode_deep($value);
		}
		
		$output[$key]=$value;
	}
	
	return $output;
}
	
	$ws=array("etat"=>$this->data->etat,"message"=>"","controleur"=>"webservice","action"=>$this->data->action,"secure_token"=>$this->token->getToken(),
	"pdo"=>$this->data->pdo);

	$ws=utf8_encode_deep($ws);
	
	echo json_encode($ws);
?>