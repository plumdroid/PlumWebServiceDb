<?php
/**
 * vue.debug_contact[vue]
 *
 * @project	   plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/	

	
//<!-- - - - - - - - - - - - -  MENU ET ENTETE - - - - - - - - - - - -->
	$this->titre="CONTACT";
	
	$this->useMenu("debugContact");

	include_once(PATH_VUE_TEMPLATE."template.entete.php");
	
//<!-- - - - - - - - - - - - -  DONNEES DU FORMULAIRE - - - - - - - - - - - -->
	
	
?>

<!-- - - - - - - - - - - - -  FORMULAIRE HTML - - - - - - - - - - - -->
<form method="post" action="" name="debug_contact">

	<!-- - - - - - - - - - - - - champs nécessaires au fonctionnement de plum.mvc- - - - - - - - - - - -->
	<input type="hidden" name="secure_token" value="<?php echo $this->token->getToken()?>">
	
	<!-- - - - - - - - - - - - - champs nécessaires au fonctionnement de template.plum- - - - - - - - - - - -->
	<input type="hidden" name="<?php echo $this->menu->id;?>" value="<?php echo $this->menu->actif;?>">

	<!-- - - - - - - - - - - - - formulaire- - - - - - - - - - - -->
	<table border="0">
	<tr>	
		<td>WebService</td>
		<td><input id="contact" name="contact" type="text" value="<?php echo $this->data->contact;?>" size="100"/>
		<p>Par exemple : http://127.0.0.1/PlumWebServiceDb/www/e/norest/</p>
		</td>
	</tr>
	<tr>
		<td><input type="button" name="button_contacter" value="Contacter" 
		  onclick="form_submit('<?php echo $this->c->forgeUriAction('buttonContacter',array());?>',-1,'')">
		</td>		
	</tr>
	</table>
</form>	
<h2>Résultats</h2>
<p>URL:<?php echo $this->data->url?></p>
<textarea rows="4" cols="100">
<?php echo $this->data->response?>
</textarea>
<!-- - - - - - - - - - - - -  PIED - - - - - - - - - - - -->
<?php include_once(PATH_VUE_TEMPLATE."template.pied.php");?>