<?php
/**
 * template.entete [template]
 *
 * @project	   plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/	

//::::contrôle vérifiant le passage par le super-contrôleur::::

if(!defined('PLUM_RACINE')) exit(0);
	
//<!-- - - - - - - - - - - - - DONNEES template.entete- - - - - - - - - - - -->
	
$message=$this->message;
$message=str_replace("'","\'",$message);
$message=str_replace('"','\"',$message);

$actionAfterMessage=$this->actionAfterMessage;//fournit à form_alert_focus pour redirection uri après lecture du message

$champFocus=$this->focus;

$titrePage=$this->titre;

//A VOIR sur déconnexion faire une reconnexion ALL
$user="";
if($this->c->secure!=false && $this->c->secure->getUser()!="ALL"){
	$user="Utilisateur : ".$this->c->secure->getUser();
}

$onglet=array();
if($this->menu!=null){//un menu a été défini
	$onglet_actif=$this->menu->actif;
	$onglet=$this->menu->items;

	$id_menu=$this->menu->id;;
}


?>

<!-- - - - - - - - - - - - - AFFICHAGE DE L ENTETE - - - - - - - - - - - -->
<!DOCTYifPE html>
<html lang="fr" dir="ltr">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<title><?php echo APP_NAME?></title>
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo PATH_WWW_TEMPLATE."image/favicon_0.ico";?>"/>
		<link rel="stylesheet" href="<?php echo PATH_WWW_TEMPLATE."css/a1.css";?>" type="text/css" />
		<script src="<?php echo PATH_WWW_TEMPLATE."js/a1.js"?>" type="text/javascript"></script>
</head>

<body 
onload="form_alert_focus('<?php echo $message;?>','<?php echo $champFocus;?>','<?php echo $actionAfterMessage;?>')";>

<div class='content'>

		<div class="titre">
				<img src="<?php echo PATH_WWW_TEMPLATE."image/form.bmp";?>" title="<?php echo $titrePage;?>" alt="<?php echo $titrePage;?>">
					<?php echo $titrePage; ?>
				<span class="utilisateur"><?php echo $user; ?></span>
		</div>
		
		
		<div class='menu'><ul>
		<?php
			//affichage du MENU des pages "form"
			$fermer=false;
			for($i=0;$i<count($onglet);$i++){
				if($onglet[$i]->caption=="FERMER") {$fermer=$i;continue;}
				entete_affiche_onglet($onglet,$i,$onglet_actif,$id_menu,$this);			
			}
						
			//:::: Affichage du bouton "FERMER" par défaut
			if(count($onglet)>0 && $fermer!==false ) {
				entete_affiche_onglet($onglet,$fermer,$onglet_actif,"fermer",$this);	
			}	
			
		function entete_affiche_onglet($onglet,$i,$onglet_actif,$id_menu,$v){
			
			$action=$onglet[$i]->action; 
			$controleur=$onglet[$i]->controleur;
			$caption=$onglet[$i]->caption;
					
			$class="standard";
			if($i==$onglet_actif) {$class="actif";}
			if($caption=="FERMER") {$class="close";}
			
			$param[0]=new Plum_Data;
			$param[0]->key=$id_menu;
			$param[0]->val=$i;
			//::::affichage de l'onglet::::
			echo '<li class="'.$class.'">'
					.'<a href="'.$v->c->forgeUri($v->package,$controleur,$action,$param).'">'
					.$caption
					.'</a></li>';
		}
		
?>
		</ul></div>
		
<!-- - - - - - - - - - - - - BALISE 'form' - - - - - - - - - - - -->
<?php if (count($onglet)>0) echo "<div class='form'>";?>