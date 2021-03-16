<?php
/**
 * Index : contrôleur principal [super-contrôleur]
 *
 * @project	   plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/

//print_r($_SERVER);die();
define('PLUM_RACINE', dirname(__FILE__).'/../');

$dirname=pathinfo($_SERVER['PHP_SELF'])['dirname'];

if($dirname=="/") {$dirname="";} //index est à la racine du serveur

Define('PATH_WWW',$dirname."/");


//----- définir EXEC_PACKAGE
			//----- fichiers de configuration 'commun' : peut ne pas exister ----
			$path_config=PLUM_RACINE."conf/config.php";
			if (!file_exists($path_config)) {
				die("Pas de fichier 'config.php' dans le répertoire 'conf' [OBLIGATOIRE]...");
			}
			include_once($path_config);
			
			//---- définir le package ----
			$exec_package="";
			
			if(isset($configXuZe['DEFAUT_PACKAGE'])) {
				$exec_package=$configXuZe['DEFAUT_PACKAGE'];
			}
			
			
			if(isset($_GET['mvc_package'])){
				$exec_package=$_GET["mvc_package"];
			}
			
			if($exec_package!="") {
				define('EXEC_PACKAGE', $exec_package);
			}
			
			if(!defined('EXEC_PACKAGE')) {
				die("Aucun PACKAGE défini...!");
			}

			

			//----- config ---------------------------------------------------------------
		
			//---- config du package -- doit exister même vide --
			$path_config=PLUM_RACINE."conf/config.".EXEC_PACKAGE.".php";
			if (!file_exists($path_config)) {
				die("Pas de fichier 'config.".EXEC_PACKAGE."' dans le répertoire 'conf' [package inconnu?]...");
			}
			include_once($path_config);
			
			//----- création des constantes à partir de $configXuZe
			
			if(isset($configXuZe)===false){
				die("Aucune instruction de configuration dans config : \$configXuZe n'est pas défini");
			}
			
			if(is_array($configXuZe)===false){
				die("Aucune instruction de configuration dans config : \$configXuZe n'est pas un tableau");
			}
			
			foreach($configXuZe as $key => $value){
				if(!is_array($value)) {define($key,$value);}
			}
			
			$configXuZe=array(); //destruction des instructions  de configuration
			
//----- path du package			
			//----- path MVC
			
			define('PATH_CONFIG',PLUM_RACINE."conf/");
			
			define('PATH_CONTROLEUR', PLUM_RACINE."controleur/".EXEC_PACKAGE."/");
			
			define('PATH_MODELE', PLUM_RACINE."modele/".EXEC_PACKAGE."/");
			
			define('PATH_VUE', PLUM_RACINE."vue/".EXEC_PACKAGE."/");
			
			//----- path fichiers secure
			define('PATH_CONTROLEUR_SECURE', PLUM_RACINE."secure/".EXEC_PACKAGE."/");//sécurité contrôleur
			
			//user : 2 choix 1) package ou 2) USER_SECURE
			//cas prioritaire : secure.user du package si existe
			
			if(!defined('USER_SECURE')){
				die("USER_SECURE non défini dans config : information obligatoire");
			}
			
			define('PATH_USER_SECURE', PLUM_RACINE."secure/".USER_SECURE."/");//sécurité user
			//echo PATH_USER_SECURE;die();
			//----- path Template
			define('PATH_VUE_TEMPLATE',PLUM_RACINE."vue/template.".TEMPLATE."/");
			
			
			define('PATH_WWW_TEMPLATE',PATH_WWW."template.".TEMPLATE."/");
			
			define('PATH_WWW_EXPOSE',PATH_WWW."expose/"); //contient les fichiers css, js et image supplémentaires.utilisé par Plum_vue

			//include des fichiers php externes
			define('PATH_INCLUDE', PLUM_RACINE."include/");
			
			define('PATH_FONCTION', PLUM_RACINE."fonction/");
			
			
			//----- includes du framework plum
			include_once (PLUM_RACINE."plum/plum.sacoche.php");
			include_once (PLUM_RACINE."plum/plum.controleur.php");
			include_once (PLUM_RACINE."plum/plum.fonction.php");

			include_once (PLUM_RACINE."plum/plum.secure.php");
			
			//----- démarrage session 'only cookie' + 'id unique pour chaque paquetage'

			Secure::session_start();
			
//----- Engine : -- démarrage du contrôleur --
class Engine extends Plum_controleur{
	
		function __construct($param){
			parent::__construct($param);
			
			$controleur=$this->paramUrl->mvc_controleur;
			$action=$this->paramUrl->mvc_action;
			
			if($controleur=="") {$controleur=DEFAUT_CONTROLEUR;}
			if($action=="") {$action=DEFAUT_ACTION;}
			
			$c=$this->execute($controleur,$action);
			
			if($c->v!=null) {$c->v->show();} //affichage de la vue
			
		}
}
$param=new Plum_data();
$param->controleur="index";
$param->action="construct";
$engine=new Engine($param);
	
?>