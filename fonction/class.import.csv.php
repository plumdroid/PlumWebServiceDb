<?php

/**
 * ClassImportCsv
 *
 * @project		plum.mvc
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thierry Bogusz <thbogusz@yahoo.fr>
*/

Class ClassImportCsv{
	private $filename;    //String
	private $file; //File
	private $colCount=0;
	private $separateur="";
	
	private $colonne=array();
	private $data=array();
	
	private $erreur=array();//tableau des messages d'erreurs
	
	/*
	*
	* filename		String			Nom du fichier
	* colCount 			int				Nombre de colonnes
	* separateur 	char 			séparateur [, ou ;]
	* colonne		Array<String>	Nom des colonnes. Facultatif.
	*
	*/
	public function __construct($filename,$colCount,$separateur,$colonne=array()){
		$this->filename=$filename;
		$this->colCount=$colCount;
		$this->separateur=$separateur;
		
		$this->erreur=Array(
						0=>"ok",
						1=>"Aucun fichier fourni",
						2=>"Nom de fichier incorrect",
						3=>"Nombre de colonne erroné",
						4=>"Fichier vide",
						5=>"Structures des données  invalides"
						);
	}
	
	/*
	*
	*
	* return	int code retour
	*/
	public function open(){
		$fileid="fichier";
		$temp="tmp_name";
		
		
		//$_FILES Aucun fichier fourni
		if (!isset($_FILES[$fileid][$temp])){
			return 1;
		}
		
		if ($_FILES[$fileid][$temp]==""){
			return 1;
		}
		
		
		//contrôle existence du fichier. Nom de fichier incorrect
		$filecsv=$_FILES[$fileid]["name"];
		
		if($filecsv!=$this->filename){
			return 2;
		}
		
		//contrôle format du fichier. format erroné
		$this->file=fopen($_FILES[$fileid][$temp], "r");//ouvrir le fichier temp
		
		$data = fgetcsv($this->file,4096, $this->separateur);
		
		if ($data==false){
			return 4;
		}
		
		if(count($data)!=$this->colCount) {
			return 3;
		}
		
		//fichier sans données ?
		$this->colonne=$data; //mémorisation des entêtes de colonne
		
		$data = fgetcsv($this->file,4096, $this->separateur);
		
		if ($data==false){
			return 4;
		}
		
		if(count($data)!=$this->colCount) {
			return 3;
		}
		
		//Tout est ok
		$this->data=$data;
		return 0;
	}
	
	/*
	*
	* return	Array	tableau associatif des données lues
	*/
	public function lire(){
		if ($this->data==false) return false;
		
		if(count($this->data)!=$this->colCount){
			die("Ligne de données : format non conforme");
		}
		
		//Mise en forme des données csv
		$lire=array();
		for($i=0;$i<count($this->colonne);$i++){
			$lire[$i]=$this->data[$i];
			$lire[$this->colonne[$i]]=$this->data[$i];
		}
		
		//lecture
		$this->data = fgetcsv($this->file,4096, $this->separateur);
	
		//Retourner la ligne lue
		return $lire;
	}
	
	public function getMessageErreur($code){
		if(!isset($this->erreur[$code])) return "...code erreur ClassImportCsv inconnu...";
		
		return $this->erreur[$code];
	}
	
	public function colCount(){
		return $this->colCount;
	}
}