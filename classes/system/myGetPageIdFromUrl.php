<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package   easy-api
 * @author    Patrick Froch
 * @license   LGPL
 * @copyright easy Solutions IT 2013
 */

/**
 * Namespace
 */
namespace esit\easy_api;


/**
 * Class myGetPageIdFromUrl
 *
 * @copyright  easy Solutions IT 2013
 * @author     Patrick Froch
 * @package    Devtools
 */
class myGetPageIdFromUrl extends \Controller{


    /**
     * Hook, der die Verarbeitung der Anfragen der API anstoesst.
     * @param $arrFragments
     * @return mixed
     */
    public function startApi($arrFragments){
        if(strtolower($arrFragments[0]) == 'api'){
            $arrData = $arrFragments;
            array_unshift($arrData, $_SERVER['REQUEST_METHOD']);

            $this->import('api_run');
            $this->api_run->processData($arrData);  // output and exit!
        }

        return $arrFragments;
    }
}
