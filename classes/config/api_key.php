<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 *
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  api_key.php
 * @version     1.0.0
 * @since       06.11.13 - 12:23
 */

namespace esit\easy_api;


class api_key {


    /**
     * Instanz dieser Klasse.
     * @var null
     */
    static private $instance = null;


    /**
     * Objekt mit den Daten des Keys.
     * @var null
     */
    private static $arrKey = null;


    /**
     * Error-Key.
     * @var string
     */
    private static $strError = '';


    /**
     * Kein Konstruktor, da es sich um eine Singleton-Klasse handelt.
     */
    private function __construct(){}



    /**
     * Kein Klonen, da es sich um eine Singleton-Klasse handelt.
     */
    private function __clone(){}


    /**
     * Gibt die globale Instanz dieser KLasse zurueck.
     * @return api_config|null
     */
    static public function getInstance($strKey = false){
        if(!self::$instance){
            self::$instance = new api_key();
            self::loadKeyData($strKey);
        }

        return self::$instance;
    }


    /**
     * Laedt die Daten des Keys.
     * @param $strKey
     */
    public static function loadKeyData($strKey = ''){
        $objDb      = \Database::getInstance();

        if($strKey){
            $strQuery   = "SELECT * FROM `tl_api` WHERE `key` = '$strKey'";
        } else {
            $strQuery   = "SELECT * FROM `tl_api` WHERE `id` = '" . \Input::get('id') . "'";
        }

        $objResult  = $objDb->executeUncached($strQuery);

        if($objResult->numRows){
            self::$arrKey = $objResult->fetchAssoc();
        } else {
            self::$strError = 'keyInvalid';
        }
    }


    /**
     * Gibt einen Wert aus den Daten des Key zurueck.
     * @param $strKey
     * @return mixed
     */
    public function __get($strKey){
        if(is_array(self::$arrKey) && count(self::$arrKey) && isset(self::$arrKey[$strKey])){
            $arrData = unserialize(self::$arrKey[$strKey]);

            if(is_array($arrData)){
                return $arrData;
            } else {
                return self::$arrKey[$strKey];
            }
        }

        return false;
    }


    /**
     * Gibt den Error-Code zurueck, wenn vorhanden, sonst einen Leerstring.
     * @return string
     */
    public function getError(){
        return self::$strError;
    }


    /**
     * Prueft, ob ein Key geladen wurde.
     * @return bool
     */
    public function checkKey(){
        if(is_array(self::$arrKey) && count(self::$arrKey)){
            return true;
        }

        return false;
    }


    /**
     * Prueft die Berechtigung.
     * @param $strMetthod
     * @param $strTabel
     * @param $strAction
     * @return bool
     */
    public function checkPermissions($strMetthod, $strTabel, $strAction){
        if(self::$arrKey['active']){

            if($this->checkMethode($strMetthod)){

                if($this->checkTable($strTabel, $strAction)){
                    return true;
                } else {
                    self::$strError = 'notEnoughPermissions';
                    return false;
                }

            } else {
                self::$strError = 'notEnoughPermissions';
                return false;
            }

        } else {
            self::$strError = 'keyNotActivated';
            return false;
        }
    }


    /**
     * Prueft, ob mit dem uebergebenen Key die gewuenschte Methode genutzt werden darf.
     * @param $strMethode
     * @return bool
     */
    private function checkMethode($strMethod){
        $arrMethtods = unserialize(self::$arrKey['allowedmethods']);

        if(is_array($arrMethtods) && in_array(strtolower($strMethod), $arrMethtods)){
            return true;
        } else {

            return false;
        }
    }


    /**
     * Prueft, ob die Tabelle mit dem Key benutzt werden darf.
     * @param $strTable
     * @param $strAction
     * @return bool
     */
    private function checkTable($strTable, $strAction){
        $arrTables  = unserialize(self::$arrKey['allowedtables']);

        if($strAction == 'tablelist' || (is_array($arrTables) && in_array($strTable, $arrTables))){
            return true;
        } else {
            return false;
        }
    }


    /**
     * Erzeugen eines Keys.
     * @param string $strAlgo
     * @param string $varData
     * @return string
     */
    public function makeKey($strAlgo = 'sha512', $varData = ''){
        $strSalt = time() . uniqid() . rand(10000, 100000);
        $strKey = hash_hmac($strAlgo, $varData . $strSalt, $strSalt);
        self::$arrKey['key'] = $strKey;
        return self::$arrKey['key'];
    }


    /**
     * Speichert einen Key in der DB.
     */
    public function save(){
        if(is_array(self::$arrKey) && count(self::$arrKey) && isset(self::$arrKey['key'])){
            $objDb      = \Database::getInstance();
            $strQuery   = 'Update `tl_api` SET `key` = "' . self::$arrKey['key'] . '", `keygeneratedon` = ' . time() . ' WHERE `id` = ' . self::$arrKey['id'];
            $objDb->executeUncached($strQuery);
        }
    }
}