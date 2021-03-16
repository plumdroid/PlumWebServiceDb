<?php
/**
 * Vue debug.authentification[vue]
 *
 * @project	   plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/	

//<!---------------------------------------- MENU ET ENTETE ------------------------------>
	$this->titre="AUTHENTIFICATION";
	
	$this->useMenu("debugAuthentification");

	include_once(PATH_VUE_TEMPLATE."template.entete.php");
	
//<!---------------------------------------- DONNEES DU FORMULAIRE ------------------------------>
?>
<!---------------------------------------- FORMULAIRE HTML ------------------------------>

<form method="post" name="mvc_form" action="" name="form_athentification">

	<!-- - - - - - - - - - - - - champs nécessaires au fonctionnement de plum.mvc- - - - - - - - - - - -->
	<input type="hidden" name="secure_token" value="<?php echo $this->token->getToken()?>">
	
	

	<!--------------- formulaire------------->
	
	<div class="connexion">
	<fieldset>
	<legend>Connexion</legend>
	<table cellspacing="0" cellpadding="2" border="0" align="left">
    <tbody>
		<tr>	
			<td>WebService</td>
		</tr>
		<tr>
			<td><input id="contact" name="contact" type="text" value="<?php echo $this->data->contact;?>" size="100"/>
			<p>Par exemple : http://127.0.0.1/PlumWebServiceDb/www/e/norest/</p>
			</td>
		</tr>
	
        <tr>
            <td>Identifiant</td>
        </tr>
        <tr>
            <td>
                <input id="user" type="text" value="<?php echo $this->data->user;?>" size="30" name="user"></input>
            </td>
        </tr>
        <tr>
            <td>Mot de passe</td>
        </tr>
        <tr>
            <td>
                <input id="password" type="password" size="20" name="password"></input>
            </td>
        </tr>
        <tr>
			<td align="right">
				<?php $uri=$this->c->forgeUri($this->package,$this->controleur,'buttonConnecter',array())?>
				<input type="button" name="connexion" value="Connexion" onclick="form_submit('<?php echo $uri?>',-1,0);"></input>
			</td>
		</tr>
    </tbody>
	</table>
	</fieldset>
	</div>
</form>	
<h2>Résultats</h2>
<p>URL:<?php echo $this->data->url?></p>
<textarea rows="4" cols="100">
<?php echo $this->data->response?>
</textarea>
<!---------------------------------------- PIED ------------------------------>
<?php include_once(PATH_VUE_TEMPLATE."/template.pied.php");?>