<?php
/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  api_status.php
 * @version     1.0.0
 * @since       15.09.13 - 09:32
 */

namespace esit\easy_api;


class api_status{


    /**
     * Instanz dieser Klasse
     * @var null
     */
    static private $instance = null;


    /**
     * Quelle mit den Statusmeldungen
     * @var array
     */
    private $arrStateSource = array();


    /**
     * HTTP status codes
     * @var array
     */
    private $arrHttpCodes = array();


    /**
     * Statuscode
     * @var int
     */
    private $statusCode = 0;


    /**
     * Statusmeldung
     * @var string
     */
    private $statusMsg = '';


    /**
     * Kein Konstruktor, da es sich um eine Singleton-Klasse handelt.
     */
    private function __construct(){}


    /**
     * Kein Klonen, da es sich um eine Singleton-Klasse handelt.
     */
    private function __clone(){}


    /**
     * Gibt die globale Instanz der Klasse zurueck.
     * @return api_status|null
     */
    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new api_status();
        }

        return self::$instance;
    }


    /**
     * Setzt die Arrays mit den Werten fuer die Status.
     * @param null $arrStateSource
     */
    public function setup($arrStateSource = null){
        $strLanguageFile = str_replace('classes/output', 'config/', dirname(__FILE__)) . 'config.php';
        include($strLanguageFile);

        if(!count($this->arrStateSource)){
            if($arrStateSource){
                $this->arrStateSource = $arrStateSource;
            } else {
                $this->arrStateSource = $GLOBALS['easy_api']['state'];
            }
        }

        if(!count($this->arrHttpCodes)){
            $this->arrHttpCodes = $GLOBALS['easy_api']['http_codes'];
        }
    }


    /**
     * Setzt die Fehlerinformationen.
     * @param $strError
     */
    public function setState($strState){
        $this->setup();
        if(isset($this->arrStateSource[$strState])){
            $this->statusCode   = $this->arrStateSource[$strState][0];
            $this->statusMsg    = $this->arrStateSource[$strState][1];
        } else {
            $this->statusCode   = 409;
            $this->statusMsg    = 'ERROR: invalid status code';
        }
    }


    /**
     * Gibt den Text zu einem HTTP-Status zurueck.
     * @return bool
     */
    public function getHttpMsg(){
        $this->setup();
        if($this->statusCode > 0 && isset($this->arrHttpCodes[$this->statusCode])){
            return $this->arrHttpCodes[$this->statusCode];
        }

        return false;
    }

    /**
     * Gibt den Error-Code zurueck.
     * @return bool|int
     */
    public function getStatusCode(){
        $this->setup();
        if($this->statusCode > 0){
            return $this->statusCode;
        }

        return false;
    }

    /**
     * Gibt die Error-Meldung zurueck.
     * @return bool|string
     */
    public function getStatusMsg(){
        $this->setup();
        if($this->statusMsg != ''){
            return $this->statusMsg;
        }

        return false;
    }


    /**
     * Prueft, ob ein Status gesetzt ist.
     * @return bool
     */
    public function statusExists(){
        $this->setup();
        if($this->statusCode > 0 && $this->statusMsg != ''){
            return true;
        }

        return false;
    }

    /**
     * Wenn der Statuscode >= 400 ist wird true zurueck gegeben.
     * @return bool
     */
    public function isError(){
        $this->setup();
        if($this->statusCode >= 400 || $this->statusCode == 0 || $this->statusMsg == ''){
            return true;
        }

        return false;
    }
}