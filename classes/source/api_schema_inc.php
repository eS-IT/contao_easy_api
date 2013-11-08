<?php
/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  api_schema.php
 * @version     1.0.0
 * @since       19.09.13 - 10:40
 */

namespace esit\easy_api;


abstract class api_schema {


    /**
     * Array mit Arrays mit Zuordnungsschemata.
     * Beispiel:
     * =========
     * $this->arrSchemata['schema1'] = array(
     *     'schema1' => array('apiVersion', 'driver', ...),
     *     'schema2' => array('apiVersion', 'driver' ...)
     * );
     * @var array
     */
    protected $arrSchemata = array();


    /**
     * Implementiert die Logik, die anhand der URL-Fragmente in $arrRequest entescheidet,
     * welches Schema gültig ist.
     * @param $arrRequest
     * @return mixed
     */
    abstract public function parseRequest($arrRequest);
}
