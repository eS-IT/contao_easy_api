<?php
/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  api_output.php
 * @version     1.0.0
 * @since       18.09.13 - 20:02
 */

namespace esit\easy_api;


class api_output {


    public function __construct(){
        $this->api_config   = api_config::getInstance();
        $this->api_status   = api_status::getInstance();
        $strDecoder         = 'api_decoder_' . $this->api_config->strFormat;

        if(class_exists($strDecoder)){
            $this->api_decoder  = new $strDecoder();
        } else {
            $this->api_decoder  = new api_decoder_json();
            $this->api_config->strFormat = 'json';
        }
    }

    /**
     * Send the file to the browser
     */
    public function sendToBrowser($varData){
        // Status setzen, wenn kein Datenarray uebergeben wurde.
        if(!is_array($varData)){
            $this->api_status->setState($varData);
            $varData = $this->api_status->getStatusMsg();
        }

        // logging
        if(isset($GLOBALS['easy_api']['log']['enable']) && $GLOBALS['easy_api']['log']['enable']){
            if($this->api_status->isError()){
                $strErrMsg = ($this->api_status->getStatusMsg()) ? $this->api_status->getStatusMsg() : $varData;

                if($varData != 'ipBlocked' || !$GLOBALS['easy_api']['ip_error']['logbanned']){
                    \System::log($strErrMsg, 'externer Zugriff über API', 'API-Zugriff');
                }
            }
        }

        // Daten aufbereiten
        $this->api_decoder->setData($varData);
        $strContent = $this->api_decoder->getOutput();

        // send header
        $this->sendMessage($strContent);
    }


    /**
     * Sendet die Header.
     * @todo Die Header sollten dynamisch gesetzt werden koennen!
     * @param $strLength
     */
    public function sendMessage($strContent){
        // Make sure no output buffer is active
        // @see http://ch2.php.net/manual/en/function.fpassthru.php#74080
        while(@ob_end_clean());

        // Prevent session locking (see #2804)
        session_write_close();

        // send header
        header('HTTP/1.1 '. $this->api_status->getStatusCode() . ' ' . $this->api_status->getHttpMsg());
        header('Content-Type: text/' . strtolower($this->api_config->strFormat));
        header('Content-Transfer-Encoding: text');
        header('Content-Length: ' . strlen($strContent));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Expires: 0');
        header('Connection: close');

        // send body
        print($strContent);

        exit;
    }
}