<?php
/**
 * Vue debug.webservice[vue]
 *
 * @project	   plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/	

//<!---------------------------------------- MENU ET ENTETE ------------------------------>
	$this->titre="WEBSERVICE";
	
	$this->useMenu("debugNoRest");

	include_once(PATH_VUE_TEMPLATE."template.entete.php");
	
//<!---------------------------------------- DONNEES DU FORMULAIRE ------------------------------>
?>
<!---------------------------------------- FORMULAIRE HTML ------------------------------>

<form method="post" name="mvc_form" action="" name="form_webservice">

	<!-- - - - - - - - - - - - - champs nécessaires au fonctionnement de plum.mvc- - - - - - - - - - - -->
	<input type="hidden" name="secure_token" value="<?php echo $this->token->getToken()?>">
	
	

	<!--------------- formulaire------------->
	
	<div class="connexion">
	<fieldset>
	<legend>query_or_execute</legend>
	<table cellspacing="0" cellpadding="2" border="0" align="left">
    <tbody>
		<tr>	
			<td>WebService</td>
		</tr>
		<tr>
			<td><input id="contact" name="contact" type="text" value="<?php echo $this->data->contact;?>" size="100"/>
			<span >Par exemple : http://127.0.0.1/PlumWebServiceDb/www/e/norest/</span>
			</td>
		</tr>
	
        <tr>
            <td>Requête Sql</td>
        </tr>
        <tr>
            <td>
				
				<textarea name="toto" rows="2" cols="100">
<?php echo $this->data->toto;?></textarea>
            </td>
        </tr>
    
        <tr>
			<td align="left">
				<?php $uri=$this->c->forgeUri($this->package,$this->controleur,'buttonQuery',array())?>
				<input type="button" name="query" value="Query" onclick="form_submit('<?php echo $uri?>',-1,0);"></input>
		
				<?php $uri=$this->c->forgeUri($this->package,$this->controleur,'buttonExecute',array())?>
				<input type="button" name="execute" value="Execute" onclick="form_submit('<?php echo $uri?>',-1,0);"></input>
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
<?php echo $this->data->response;?>
</textarea>
<!---------------------------------------- PIED ------------------------------>
<?php include_once(PATH_VUE_TEMPLATE."/template.pied.php");?>