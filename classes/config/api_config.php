<?php
/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  api_config.php
 * @version     1.0.0
 * @since       16.09.13 - 10:57
 */

namespace esit\easy_api;


class api_config {


    /**
     * API-Version
     */
    const API_VERSION = '1.0.0';


    /**
     * Platz des Treibers im URL-Array.
     * @var int
     */
    const TREIBER_KEY = 3;


    /**
     * Instanz dieser Klasse.
     * @var null
     */
    static private $instance = null;


    /**
     * Array mit dem Mapping der URL-Parameter zu Parameternamen.
     * Beipsiel: array('api', 'apiVersion', 'action', ...)
     * Der Wert aus $this->arrFragments[1] wird zurueck gegeben, wenn 'apiVersion' gesucht wird.
     * @var array
     */
    protected $arrSchema = array();


    /**
     * Nummerisches Array mit den ULR-Fragmenten.
     * Beispiel: array(0 => api, 1 => '1.0.0', 2 => 'tablelist', ...)
     * @var array
     */
    private $arrFragments = array();


    /**
     * Kein Konstruktor, da es sich um eine Singleton-Klasse handelt.
     */
    private function __construct(){}

    /**
     * Kein Klonen, da es sich um eine Singleton-Klasse handelt.
     */
    private function __clone(){}


    /**
     * Gibt die globale Instanz dieser KLasse zurueck.
     * @return api_config|null
     */
    static public function getInstance(){
        if(!self::$instance){
            self::$instance = new api_config();
        }

        return self::$instance;
    }


    /**
     * Gibt das Array mit dem Schema fuer die URL-Auflösung zurueck.
     * @return array|bool
     */
    public function getSchema(){
        if(is_array($this->arrSchema) && count($this->arrSchema)){
            return $this->arrSchema;
        }

        return false;
    }


    /**
     * Setzt das Schema fuer die URL-Aufloesung
     * @param $arrSchema
     * @return bool
     */
    public function setSchema($arrRequest){
        $strSchemaClass = 'api_schema_' . $arrRequest[self::TREIBER_KEY];
        $objSchema = new $strSchemaClass();
        $arrSchema = $objSchema->parseRequest($arrRequest);

        if(is_array($arrSchema) && count($arrSchema)){
            $this->arrSchema = $arrSchema;
            return true;
        }

        return false;
    }


    /**
     * Gibt das Array mit den URL-Fragmenten zurueck.
     * @return array|bool
     */
    public function getFragments(){
        if(is_array($this->arrFragments) && count($this->arrFragments)){
            return $this->arrFragments;
        }

        return false;
    }


    /**
     * Setzt das Array mit den URL-Fragmenten.
     * @param $arrFragments
     * @return bool
     */
    public function setFragments($arrFragments){
        $arrFragments = $this->removeAutoItem($arrFragments);
        if(is_array($arrFragments) && count($arrFragments)){
            $this->arrFragments = $arrFragments;
            return $arrFragments;
        }

        return false;
    }


    /**
     * Gibt ein Array mit den Parametern zurueck.
     * @return bool
     */
    public function getArray(){
        $varData = false;

        if(is_array($this->arrFragments) && count($this->arrFragments) && is_array($this->arrSchema) && count($this->arrSchema)){
            foreach($this->arrSchema as $intPos => $strKey){
                if(isset($this->arrFragments[$intPos])){
                    $arrData[$strKey] = $this->arrFragments[$intPos];
                }
            }
        }

        return $varData;
    }


    /**
     * Gibt den gesuchte URL-Fragment zurueck, dass dem String und dem Mapping entspricht.
     * @param $strKey
     * @return mixed
     */
    public function __get($strKey){
        // strKey auswerten
        switch($strKey){
            /*case 'API_VERSION':
                return $this->API_VERSION;
                break;*/ # Direkter Zugriff auf (public) Konstante!

            case 'strKey':
                return (\Input::get('key')) ? \Input::get('key') : false;
                break;

            case 'strFormat':
                return (\Input::get('format')) ? \Input::get('format') : 'josn';
                break;

            case 'query':
                $arrQuery = array();

                for($i = count($this->arrSchema)-1; $i < count($this->arrFragments)-1; $i+=2){ // -1 weil am Ende des Format eingefuegt wird!
                    $arrQuery[$this->arrFragments[$i]] = $this->arrFragments[$i+1];
                }

                return $arrQuery;
                break;

            default:
                // Gibt einen im Schema definierten oder als Key-Value-Paar vorliegenden Wert zurück.
                $tmpValue = $this->getItem($strKey);
                return ($tmpValue) ? $tmpValue : $this->getQueryItem($strKey);
                break;
        }
    }


    /**
     * Gibt einen Parameter des Requests zurück, der direkt in $this->arrSchema definiert ist.
     * @param $strKey
     * @return bool
     */
    private function getItem($strKey){
        $intKey = array_search($strKey, $this->arrSchema);

        if($intKey !== false && isset($this->arrFragments[$intKey])){
            // Wert direkt in $this->arrSchema definiert!
            return urldecode($this->arrFragments[$intKey]);
        }

        return false;
    }


    /**
     * Gibt einen Parameter eines der Key-Value-Paare des Queries am Ende des Requests (z.B. /lastname/Musterman) zurück!
     * @param $strKey
     * @return bool
     */
    private function getQueryItem($strKey){
        $intPos = array_search($strKey, $this->arrFragments);

        if($intPos !== false){
            return urldecode($this->arrFragments[$intPos+1]);
        }

        return false;
    }


    /**
     * Setzt ein Werte in $this->arrFragments und traegt den Key in $this->arrSchema ein.
     * @param $strKey
     * @param $varValue
     */
    public function __set($strKey, $varValue){
        $intKey = array_search($strKey, $this->arrSchema);

        if($intKey){
            $this->arrFragments[$intKey] = $varValue;
        } else {
            $this->arrFragments[]   = $varValue;
            $this->arrSchema[]      = $strKey;
        }


    }


    /**
     * Loescht den autoItem-Parameter.
     * @param $arrRequest
     */
    private function removeAutoItem($arrFragments){
        // auto_item-Parameter loeschen!
        $intPos = array_search('auto_item', $arrFragments);

        if($intPos !== false){
            unset($arrFragments[$intPos]);
        }

        return array_values($arrFragments);
    }


    /**
     * Prueft die API-Version.
     * @return bool
     */
    public function checkApiVersion(){
        if($this->strVersion == self::API_VERSION){
            return true;
        }

        return false;
    }
}