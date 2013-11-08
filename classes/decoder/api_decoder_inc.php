<?php
/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  api_decoder.php
 * @version     1.0.0
 * @since       18.09.13 - 13:55
 */

namespace esit\easy_api;


abstract class api_decoder {


    /**
     * Daten fuer die Ausgabe
     * @var null
     */
    protected $varData = null;


    /**
     * Setzt die Daten fuer die Ausgabe.
     * @param $varData
     */
    public function setData($varData){
        $this->varData = $varData;
    }


    /**
     * Gibt die gesetzten Daten zurueck.
     * @return null
     */
    public function getData(){
        return $this->varData;
    }


    /**
     * Implementiert die Ausgabe der Daten gemaess dem gewaehlten Format.
     */
    abstract public function getOutput();
}