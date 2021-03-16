<?php
/**
 * @package		plum
 * @subpackage	
 * @author		Thierry Bogusz
 * @copyright	Plum TH
 * @link		
 * @license	
 */

/**
 * Classe de persistance des informations provenant de l'URL
	*	permet également de mémoriser des données de façon interne
 * 
 * @author		Thierry Bogusz
 * @copyright	Plum TH
 * @package		plum
 * @subpackage	
 */

Class PlumSacoche
{

  private $idSacoche;        	//identifiant de la sacoche, par défaut le nom du script courant
		private $getParamUrl;		//inhibe (false) ou active (true)  la prise en compte des param. URL
		
		/**
		* Constructeur
		*
		* @access public
		*@param	string	$idSacoche identifiant de la sacoche. 
		*@param	boolean 	$paramUrl . True mémorise les paramètres de l'URL (défaut=true)
		*/
   public function __construct($idSacoche){
				//ouvrir une session
				if (!isset($_SESSION)) { session_start();}
				$this->idSacoche=$idSacoche;
				//---- construire une entrée vide pour la sacoche si nécessaire
				$id=$this->constructIdSacoche();
				if (!isset($_SESSION[$id]))
					{$this->removeAll();}//construction d'un tableau vide si la sacoche n'existe pas	
				
				$this->refresh();//mémorisarion des paramètres de l'URL
		}
	
		/**
		* Supprime une sacoche, détruit les données et retourne la valeur null
		*
		* @access public
		* @return null  exemple : maSacoche=maSacoche->terminate()
		*/
		public function terminate(){ 
			   $this->removeAll();
			   return null;
		}	

		/**
		* retourne l'identifiant de la sacoche
		*
		* @access public
		* @return string  identifiant de la sacoche
		*/
  public function getIdSacoche (){
    return $this->idSacoche;
  }

		/**
		* Retourne le contenu d'un champ de la sacoche
		* <code>
		*	$nom=$sac->get("nom");	//retourne la valeur contenue dans le champ "nom"
		* </code>
		* @access public
		*@param	string $unChamp nom du champ.
		* @return mixed  le contenu du champ (valeur, Array, adresse objet), si le champ n'existe pas retourne ""
		*/
		public function get($unChamp){ 
    $valGet=$this->get_arraySacoche();
				if (!array_key_exists($unChamp, $valGet))
				{return "";}
    return $valGet[$unChamp];
  }
	
		/**
		* Mémorise un contenu dans $unChamp
		**<code>
		*	 $sac->set("nom","Bogusz");	//mémorise "Bogusz" dans le champ "nom"
		* </code>
		* @access public
		*@param	string $unChamp nom du champ.
		*@param mixed $valChamp le contenu du champ (valeur, Array, adresse objet)
		*/
  public function set($unChamp,$valChamp){
   $valGet=$this->get_arraySacoche();
   $valGet[$unChamp]=$valChamp;
   $this->set_arraySacoche($valGet);
  }
		
		/**
		* Indique si le champ existe
		*
		* @access public
		*	@param	string $unChamp nom du champ
		* @return booléen  True si le champ existe, sinon False
		*/
 public function existe($unChamp){ 
   $valGet=$this->get_arraySacoche();
   return isset($valGet[$unChamp]);
  }

		/**
		* Supprime un champ 
		*
		* @access public
		*	@param	string $unChamp nom du champ
		*/
   public function remove($unChamp){
				$sac=$this->get_arraySacoche();
				unset($sac[$unChamp]);
				$this->set_arraySacoche($sac);
			}

		/**
		* Supprime tous les champs de la sacoche
		*
		* @access public
		*/
  public function removeAll (){
		$this->set_arraySacoche(Array());}

  /**
		* Actualise le contenu des champs depuis les paramètres de l'URL, si getParamUrl est à True
		*
		* @access public
		*/
		public function refresh(){
			//if (substr_count($this->idSacoche,"form1")>0) {echo "refresh form1";}
			if($this->getParamUrl===false) {return false;}
			$valGet=$this->get_arraySacoche();
			foreach($_GET as $clé => $val){
  				$this->set($clé,$val);}

			foreach($_POST as $clé => $val){
  				$this->set($clé,$val);}
		}

		/**
		* construit l'identifiant de la sacoche dans $_Session
		*
		* @access private
		*/
  private function constructIdSacoche (){
   $id=$this->idSacoche;
   return "___Csacoche_id__".$id;
  }

		/**
		* retourne un tableau associatif des données mémorisées
		*
		* @access private
		*/
		private function get_arraySacoche()
		{
			$id=$this->constructIdSacoche();
			return $_SESSION[$id];
		}

		/**
		* mémorise un tableau associatif des données dans $_SESSION
		*
		* @access private
		*@param Array $arrayInfo tableau associatif des données à mémoriser
		*/
		private function set_arraySacoche($arrayInfo)
		{
			$id=$this->constructIdSacoche();
			$_SESSION[$id]=$arrayInfo;
		}
		
		


}//_____________Fin de la classe PlumSacoche___________________________

?>
