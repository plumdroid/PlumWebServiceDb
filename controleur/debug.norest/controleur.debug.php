<?php
/**
 * Controleur Debug
 *
 * Tester :
 * - l'authentification
 * _ le webservice
 *
 * @project	   plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/


/*
<?php
$homepage = file_get_contents('http://www.example.com/');
echo $homepage;
?>
*/

class Controleur_debug extends Plum_Controleur{         
	var $ARRAY_AUTHENTIFICATION_RESULT="ARRAY_AUTHENTIFICATION_RESULT";
	
	public function __construct($param){
		parent::__construct($param);//obligatoire
		
		
	}

	
	
	//-----------------------------------------------------------------------------------*
	//---------- définir les actions
	//-----------------------------------------------------------------------------------*
	
	//----------------------------------------------------------------*
	//---------- CONTACT
	//----------------------------------------------------------------*
	function action_contact(){
	
		$v=$this->useVue("debugContact");
		
		$v->data->contact= "";
		$v->data->password="";
		$v->data->user="";
		
		$v->focus="user";
	}
	
	function action_buttonContacter(){
		$v=$this->useVue("debugContact");
		
		
		$v->data->response="";
		
		/*if(!file_exists ( $v->data->contact)){
			$v->message="URL inexistante!!";
			return;
		}*/
		
		$v->data->url=$v->data->contact."contact/hello/";
		$context=$this->context();
		$v->data->response=$this->myFile_get_contents($v->data->url);
	}
	
	//----------------------------------------------------------------*
	//---------- AUTHENTIFICATION
	//----------------------------------------------------------------*
	function action_authentification(){
	
		$v=$this->useVue("debugAuthentification");
		
		$v->data->password="";
		$v->data->user="";
		
		$v->focus="user";
	}
	
	function action_buttonConnecter(){
		$v=$this->useVue("debugAuthentification");
		
		$v->data->response="";
		
		$v->data->url=$v->data->contact."authentification/connecter/";
		
		$data['user']=$v->data->user;
		$data['password']=$v->data->password;
		
		$v->data->response=$this->myFile_get_contents($v->data->url,$data);
		
		//mémorisation de la réponse
		$decodeJson=json_decode($v->data->response,true);
		$this->persist->set($this->ARRAY_AUTHENTIFICATION_RESULT,$decodeJson);
	}
	
	//----------------------------------------------------------------*
	//---------- WEBSERVICE : query et execute
	//----------------------------------------------------------------*
	function action_webservice(){
		
		$v=$this->useVue("debugNoRest");
		$v->data->response="";
		$v->data->toto="";
	}
	
	function action_buttonQuery(){
		
		$v=$this->useVue("debugNoRest");
		$v->data->response="";
		
		$v->data->url=$v->data->contact."webservice/query/";
		
		$data['requete']=$v->data->toto;
		
		$data['secure_token']="";
		$auth=$this->persist->get($this->ARRAY_AUTHENTIFICATION_RESULT);
		
		if(isset($auth['secure_token'])){
			$data['secure_token']=$auth['secure_token'];
		}
	
		$v->data->response=$this->myFile_get_contents($v->data->url,$data);
	}
	
	function action_buttonExecute(){
		
		$v=$this->useVue("debugNoRest");
		$v->data->response="";
		
		$v->data->url=$v->data->contact."webservice/execute/";
		
		$data['requete']=$v->data->toto;
		
		$data['secure_token']="";
		$auth=$this->persist->get($this->ARRAY_AUTHENTIFICATION_RESULT);
		
		if(isset($auth['secure_token'])){
			$data['secure_token']=$auth['secure_token'];
		}
	
		$v->data->response=$this->myFile_get_contents($v->data->url,$data);
	}
	//----------------------------------------------------------------*
	//---------- DECONNEXION
	//----------------------------------------------------------------*
	function action_deconnection(){
		$v=$this->useVue("debugDeconnexion");
	}
	
	function action_buttonDeconnecter(){
		$v=$this->useVue("debugDeconnexion");
		
		$v->data->url=$v->data->contact."authentification/deconnecter/";
		$v->data->response=$this->myFile_get_contents($v->data->url);
	}
	
	//----------------------------------------------------------------*
	//---------- PRIVATE
	//----------------------------------------------------------------*
	private function myFile_get_contents($url,$data=array()){
	
	$content=@file_get_contents($url,false,$this->context($data)) or
			$content="URL inconnu";
		
	return $content;
	}
	
	private function context($data=array()){
		//'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		//application/x-www-form-urlencoded
		//'content' => http_build_query($data),
		//'method' => 'POST',
		$options  = array(
		'http' => array(
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'method' => 'POST',
			'content' => http_build_query($data),
			'user_agent' => 'debug.plumwebservice',
			
		),
		);
		return stream_context_create($options);
	}
}

