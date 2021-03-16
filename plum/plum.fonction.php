<?php
function func_date_us_vers_francais($date){
	$dateTab = explode("-", $date);
	$jour = $dateTab[2];
	$mois = $dateTab[1];
	$annee = $dateTab[0];
	
	return $jour.'/'.$mois.'/'.$annee;
}

function func_date_fr_vers_us($date){
	$dateTab = explode("/", $date);
	$jour = $dateTab[0];
	$mois = $dateTab[1];
	$annee = $dateTab[2];
	
	return $annee.'-'.$mois.'-'.$jour;
}


function validateDate($date, $format = 'd/m/Y')
{
    $d = DateTime::createFromFormat($format, $date);

    if(!$d){
    	return false;
    }

    if($d->format($format) != $date){
    	return false;
    }

    $dateTab = explode("/", $date);
	$jour = $dateTab[0];
	$mois = $dateTab[1];
	$annee = $dateTab[2];

    return checkdate($mois, $jour, $annee);

}

function compareDate($date1, $date2, $format = 'd/m/Y'){

	$d1 = DateTime::createFromFormat($format, $date1);
	$d2 = DateTime::createFromFormat($format, $date2);
	$d1 = $d1->format('Ymd');
	$d2 = $d2->format('Ymd');

	if($d1>$d2){
		return 1;
	}
	if($d1<$d2){
		return -1;
	}

	return 0;
}

function betweenDate($dateB1, $dateB2, $date, $format = 'd/m/Y'){
	if(compareDate($date, $dateB1) != -1 && compareDate($date, $dateB2) != 1){
		return true;
	}
	return false;
}



//----------------------------- utilitaires -------------------------------------------

/**
* source : thbogusz@yahoo.fr
*
* Affiche l'arborescence en profondeur d'un tableau
*/
function print_array_arbo($arr,$niveau=""){
	$arbo="";//
	$decalage="....";
	$LF="<br>";
	
	foreach($arr as $key => $value){
		print($LF.$niveau.$arbo."<strong>[".$key."]</strong>");
		if(is_array($value)){
			print_array_arbo($value,$niveau.$decalage);
		}
		else{
			print("<strong>=></strong>".$value);
		}
	}
}

/**
* source : thbogusz@yahoo.fr
*
* Debug d'une variable
*/
function print_debug($titre,$var){
	print('<div class="debug" style="margin-top:3px;font-size: 12px;background-color:#C0C0C0;">');
	print('<h3>'.$titre.'</h3>');
	if(is_array($var)) {print_array_arbo($var);}
	else {print($var);}
	print('</div>');
}

//____________________________________ CLASSE HTML ____________________________________________________________
//
//------------------------------------------------------------------------------------------------------------
Class HTML{
	public static function showHtmlSelect($donnees,$nameListe="maListe",$id="id",$val="val",$message="",$choix="",$onChange=""){
 
	  //<select name="maListe">
	  $onChangeOp="";
	  if($onChange!=""){$onChangeOp='onChange="'.$onChange.'"';}
	  echo '<select name="'.$nameListe.'"'.' '.$onChangeOp.'>';
	 
	  if($message!=""){
		echo '<option value="" selected disabled >'.$message.'</option>';
	  }
	 
	  for($i=0;$i<count($donnees);$i++){
		  $selected="";
		  if($donnees[$i][$id]==$choix){
			  $selected="selected";
		  }
	 
		  echo '<option value="'.$donnees[$i][$id].'" '.$selected.'>';
			echo $donnees[$i][$val];
		  echo '</option>';
	  }
	 
	  echo '</select>';
 
 
	}
}


//------------------------------ CLASSE UTIL------------------------------------------------
//------------------------------------------------------------------------------------------
Class UTIL{
	
	/*
	* stripAccents
	*
	* @param	String		$string La chaîne à examiner
	* @return	String		La chaîne initiale sans les accents
	* Émeulan É   Élise
	*/
	public static function replaceAccents($string){
		return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
							 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	}
}