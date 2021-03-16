<?php 
/**
 * template.pied [template]
 *
 * @project    plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/	
//::::contrôle vérifiant le passage par le super-contrôleur::::

if(!defined('PLUM_RACINE')) exit(0);

include_once(PATH_VUE."config.php"); //configuration bas de page
include_once(PATH_CONFIG."version.php");
//<!---------------------------------------- FERMETURE DES DIVS------------------------------>

if (count($onglet)>0) echo "</div>";?><!------ fin emplacement formulaire----->

<div class='baspage'>
<span>[<?php echo $configXtmpVue['author'];?>]</span>
<span>[<?php echo $configXtmpVue['site'] ;?>]</span>
<?php if($configXtmpVue['aide']!="")?>
<span><a href="<?php if($configXtmpVue['aide']['href']!="") {echo $configXtmpVue['aide']['href'];} ?>" target="_blank">
	<?php if($configXtmpVue['aide']['caption']!=""){echo $configXtmpVue['aide']['caption'];} ?>
</a></span>

<span style="float:right;font-size: 9px;color: #4B4B4B;font-style:normal;">Version : <?php echo $versionXuVer['version'];?></span>
</div>
</div> <!--fin div content-->

</body>
</html> 