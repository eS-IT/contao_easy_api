<?php
/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  api_hook_runner.php
 * @version     1.0.0
 * @since       18.09.13 - 14:21
 */

namespace esit\easy_api;


class api_hook_runner extends \Controller{


    /**
     * Ruft die Hooks fuer die einzelnen Verarbeitungsschritte auf.
     * @param $strHook
     * @param $varData
     * @return mixed
     */
    public function runHooks($strHook, $varData){
        $objConfig          = api_config::getInstance();
        $arrParam           = $objConfig->getArray();
        $arrParam['data']   = $varData;

        if (isset($GLOBALS['TL_HOOKS']['easy_api'][$strHook]) && is_array($GLOBALS['TL_HOOKS']['easy_api'][$strHook])){
            foreach ($GLOBALS['TL_HOOKS']['easy_api'][$strHook] as $callback){
                $this->import($callback[0]);
                $arrParam['data'] = $this->$callback[0]->$callback[1]($arrParam);
            }
        }

        return $arrParam;
    }
}