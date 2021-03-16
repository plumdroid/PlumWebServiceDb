<?php
/**
 * Config configuration secure/USER
 *
* @project	   exemple
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/

//obligatoire. doit être différente pour chaque package secure
$configXuSec['secret']="cILEYD%IIUOOebservicedatabaseàob_cleandfjùùobligaop";

//database
// s'appuie sur une table 

$configXuSec['io']="database";
$configXuSec['driver']="mysql";
$configXuSec['host']="localhost";
$configXuSec['dbname']='bdnotefrais';
$configXuSec['tableUser']='user';
$configXuSec['user']='root';
$configXuSec['pwd']='';

//file
//$configXuSec['io']="file";