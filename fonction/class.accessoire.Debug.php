<?php
/**
 * Class plum.debug
 *
 * Outils de déboggage
 *
 * @project	   plum.debug
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/

class Debug {         
	
	public static  $ON=1;//ne pas modifier
	public static  $OFF=0;//ne pas modifier
	
	public static $status=1; //0 debug désactivé ; 1 debug activé
	
	static function print_array_arbo($arr,$niveau=""){
	$arbo="";//
	$decalage="....";
	$LF="<br>";
	
	foreach($arr as $key => $value){
		if (self::$status!=self::$ON) {return;}
		
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
	static function print_div($name="",$var){
		if (self::$status!=self::$ON) {return;}
	
		print('<div class="debug" style="margin-top:3px;font-size: 12px;background-color:#C0C0C0;">');
		print('<h3>'.$name.'</h3>');
		if(is_array($var)) {print_array_arbo($var);}
		else {print($var);}
		print('</div>');
	}
	
	static function print_json($name="",$var){
		if (self::$status!=self::$ON) {return;}
		
		$debug["debug"]="Debug";
		$debug["name"]=$name;
		$debug["value"]=$var;
		
		print(json_encode($debug));
	}
}