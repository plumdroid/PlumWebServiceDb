<?php
/**
 * config.php [modele]
 *
 * @project	   PlumWebServiceDatabase
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/	

//::::contr�le v�rifiant le passage par le super-contr�leur::::

if(!defined('PLUM_RACINE')) exit(0);

$configXuMod['driver']="mysql";
$configXuMod['host']="localhost";
$configXuMod['dbname']='bdnotefrais';
$configXuMod['user']='root';
$configXuMod['pwd']='';