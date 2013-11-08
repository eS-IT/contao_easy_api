<?php
/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  api_decoder_json.php
 * @version     1.0.0
 * @since       18.09.13 - 13:51
 */

namespace esit\easy_api;


class api_decoder_json extends api_decoder{


    /**
     * Gibt die Daten kodiert fuer die Ausgabe zurueck.
     * @return bool|string
     */
    public function getOutput(){
        if($this->varData != null){
            return json_encode($this->varData);
        }

        return false;
    }
}