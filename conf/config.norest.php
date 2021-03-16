<?php
/**
 * Config configuration du package
 *
* @project	   plumwebservice
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/

$configXuZe ['APP_NAME']="PlumWebServiceDb";//obligatoire, de préférence dans le config de chaque package

$configXuZe['USER_SECURE']='norest';//obligatoire, dans config.php ou  défini ou re-défini par le config de chaque package

$configXuZe['DEFAUT_CONTROLEUR']='authentification';//config.php ou  défini ou re-défini par le config de chaque package

$configXuZe['DEFAUT_ACTION']='connecter';//config.php ou  défini ou re-défini par le config de chaque package

$configXuZe['TEMPLATE']='plum'; //obligatoire, config.php ou  défini ou re-défini par le config de chaque package

/*
* obligatoire. 
* extension php uniquement
*
* fichiers supplémentaires à inclure présents dans \include\. s'appuie sur PATH_INCLUDE
*
* array() si aucun fichier
* chemin du fichier dans \include\. $configXuZe['INCLUDE'][0]="PHPEXCEL/PHPExcel.php"
*/
$configXuZe['INCLUDE']=array(); 