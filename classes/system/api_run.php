<?php
/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  api_run.php
 * @version     1.0.0
 * @since       18.09.13 - 20:47
 */

namespace esit\easy_api;


class api_run extends \Controller{


    /**
     * Erstellt eine Instanz der Klasse.
     */
    public function __construct(){
        parent::__construct();
        $this->import('Database');
        $this->import('api_output');
        $this->import('api_auth');
        $this->import('api_ip');
        $this->api_config = api_config::getInstance();
    }


    /**
     * Verarbeitet die API-Anfrgen
     * @param $arrData
     */
    public function processData($arrRequest){
        #$this->sendToBrowser(var_export($arrRequest, true));

        // Anfrage aufbereiten
        $arrRequest = $this->api_config->setFragments($arrRequest);

        // Schema laden
        $this->loadSchema($arrRequest);

        // Quelle laden
        $this->loadSource();

        // Check Ip
        $this->api_ip->checkIp();

        // Autorisierung pruefen
        $this->api_auth->checkKey($this->api_config->strKey);

        // Daten verarbeiten
        switch($this->api_config->strMethod){
            case 'GET':
                $varReturn = $this->source->load();
                break;

            case 'POST':
                if($this->api_config->id){
                    $varReturn = $this->source->update();   // PUT wird nicht immer unterstuetzt, POST mit ID als Fallback!
                } else {
                    $varReturn = $this->source->create();
                }
                break;

            case 'PUT':
                $varReturn = $this->source->update();
                break;

            case 'DELETE':
                $varReturn = $this->source->delete();
                break;

            default:
                $varReturn = 'wrongMethod';
                break;
        }

        $this->api_output->sendToBrowser($varReturn);
    }


    /**
     * Laedt das Schema fuer die Reihenfolge der URL-Prarmenter.
     * @param $arrRequest
     */
    private function loadSchema($arrRequest){
        if(is_array($arrRequest)){
            $blnRtn = $this->api_config->setSchema($arrRequest);

            if(!$blnRtn){
                $this->api_output->sendToBrowser('noSchema');
            }
        }
    }


    /**
     * Laedt die Datenquelle.
     */
    private function loadSource(){
        $strSource = 'api_source_' . $this->api_config->strTreiber;
        $this->import($strSource, 'source');
    }
}