<?php
/**
 * Menu Exemple [menu]
 *
 * @project	   plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/
	
	//:::: items du menu ::::
	$m=0;
	$items[$m]=new Plum_data();
	$items[$m]->controleur="debug";
	$items[$m]->action="authentification";
	$items[$m]->caption="Authentification";
	
	$m++;
	$items[$m]=new Plum_data();
	$items[$m]->controleur="debugAccueil";
	$items[$m]->action="init";
	$items[$m]->caption="FERMER";
	
	$this->items=$items; //indispensable
	
	//onglet actif par défaut si aucun menu choisi (controleur ou url)
	$this->actif=0;
?>