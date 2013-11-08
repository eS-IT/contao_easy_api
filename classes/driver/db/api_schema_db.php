<?php
/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  api_schema_db.php
 * @version     1.0.0
 * @since       18.09.13 - 20:55
 */

namespace esit\easy_api;


class api_schema_db extends api_schema {


    /**
     * Umsetzung der URL-Schema.
     * @var array
     */
    protected $arrSchema = array(
        'datarow'   => array('strMethod', 'api', 'strVersion', 'strTreiber')
    );


    /**
     * Liesst die Informationen der Anfrage aus.
     * @param $arrRequest
     */
    public function parseRequest($arrRequest){

        return $this->arrSchema['datarow'];
    }
}