<?php
/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  api_ip.php
 * @version     1.0.0
 * @since       18.09.13 - 14:15
 */

namespace esit\easy_api;


class api_ip extends \Controller{


    /**
     * Erstellt eine Instanz der Klasse.
     */
    public function __construct(){
        parent::__construct();
        $this->import('Database');
        $this->import('api_output');
    }


    /**
     * Speichert die IP beim fehlerhaften Keys.
     * @param $strKey
     */
    public function saveIp($strKey){
        $strIp      = $this->Environment->ip;
        $strQuery   = "INSERT INTO `tl_ip_blacklist` SET `ip` = '$strIp', `key` = '$strKey', `tstamp` = " . time();
        $this->Database->executeUncached($strQuery);
    }


    /**
     * Prueft, ob die IP gespert ist.
     * @return bool
     */
    public function checkIp(){
        if($this->getFaultCount() >= $GLOBALS['easy_api']['ip_error']['max_count']){
            $this->api_output->sendToBrowser('ipBlocked');
            return true;
        }

        return false;
    }


    /**
     * Gibt die Anzahl der Fehlerhaften Aufrufe der aktuellen Ip zurueck.
     * @return mixed
     */
    public function getFaultCount(){
        $strIp      = $this->Environment->ip;
        $strQuery   = "SELECT * FROM `tl_ip_blacklist` WHERE `ip` = '$strIp' AND `tstamp` >= " . (time()-60*15);
        $objResult  = $this->Database->executeUncached($strQuery);
        return $objResult->numRows;
    }


    /**
     * Gibt die Ip zurueck.
     * @return mixed
     */
    public function getIp(){
        return $this->Environment->ip;
    }
}