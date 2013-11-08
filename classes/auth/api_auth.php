<?php
/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  api_auth.php
 * @version     1.0.0
 * @since       18.09.13 - 20:25
 */

namespace esit\easy_api;


class api_auth extends \Controller{


    public function __construct(){
        parent::__construct();
        $this->import('Database');
        $this->import('api_ip');
        $this->import('api_output');
        $this->api_config = api_config::getInstance();
    }

    /**
     * Prueft die Autorisierung
     * @param $strKey
     * @return bool
     */
    public function checkKey($strKey){
        if($strKey != ''){
            $objKey = api_key::getInstance($strKey);

            if($objKey->checkKey()){
                if($objKey->checkPermissions($this->api_config->strMethod, $this->api_config->table, $this->api_config->action)){
                    return true;
                } else {
                    return $this->genError($objKey->getError(), $this->strKey);
                }
            } else {
                return $this->genError($objKey->getError(), $this->strKey);
            }

        } else {
            return $this->genError('keyRequired', $this->strKey);
        }
    }


    /**
     * Gibt eine Fehlermeldung aus.
     * @param $strError
     * @param $strKey
     * @return bool
     */
    public function genError($strError, $strKey){
        $this->api_ip->saveIp($strKey);
        $this->api_output->sendToBrowser($strError);
        return false;
    }
}