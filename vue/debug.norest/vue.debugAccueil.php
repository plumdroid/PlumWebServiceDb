<?php
/**
 * Vue Accueil [vue]
 *
 * @project	plum.webservice
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/	

//<!---------------------------------------- MENU ET ENTETE ------------------------------>

	$this->titre="ACCUEIL";

	include_once(PATH_VUE_TEMPLATE."template.entete.php");
?>

<!---------------------------------------- MENU TUILE ------------------------------>
<div class='tuile'>
<ul>
<a href="<?php echo $this->c->forgeUri($this->package,'debug','contact',array());?>">
	<li class="color2">Contact</li>
</a>
<a href="<?php echo $this->c->forgeUri($this->package,'debug','authentification',array());?>">
	<li class="color1">Authentification</li>
</a>
<a href="<?php echo $this->c->forgeUri($this->package,'debug','webservice',array());?>">
	<li class="color2">WebService</li>
</a>

</ul></div>

<!---------------------------------------- PIED ------------------------------>
<?php include_once(PATH_VUE_TEMPLATE."template.pied.php");?>