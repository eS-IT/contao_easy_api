<?php
/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  api_source_db.php
 * @version     1.0.0
 * @since       18.09.13 - 14:34
 */

namespace esit\easy_api;


class api_source_db extends api_source{


    /**
     * Konfig-Objekt
     * @var api_config|null
     */
    private $api_config = null;


    /**
     * Erstellt eine Instanz der Klasse.
     */
    public function __construct(){
        parent::__construct();
        $this->import('Database');
        $this->import('api_output');
        $this->import('api_hook_runner');

        $this->api_config = api_config::getInstance();
        $this->api_status = api_status::getInstance();
    }


    /**
     * Speichert einen Datensatz in der DB.
     */
    public function create(){
        $arrFields  = $this->Database->listFields($this->api_config->table);
        $arrData    = array();

        foreach($arrFields as $arrField){
            $strField = $arrField['name'];
            $varValue = $this->Input->post($strField);

            if($varValue){
                $arrData[$strField] = $varValue;
            }
        }

        // Hooks ausfuehren
        $arrData = $this->api_hook_runner->runHooks('post', $arrData);

        if(is_array($arrData['data']) && count($arrData['data'])){
            $this->Database->prepare('INSERT INTO `' . $this->api_config->table . '` %s')
                ->set($arrData['data'])
                ->execute();
            return 'dataSaved';
        }

        return 'notSaved';
    }


    /**
     * Aendert die Daten in der DB.
     */
    public function update(){
        #return 'notUpdated';

        if($this->api_config->id){
            $arrFields  = $this->Database->listFields($this->api_config->table);
            $arrData    = array();

            // Daten einlesen
            parse_str(file_get_contents("php://input"),$varValue);

            if(!$varValue){
                $varValue = $this->Input->post(null);
            }

            if($varValue){
                // Nur Felder einlesen, die es in der Tabelle auch gibt
                // und nur Felder aus der Anfrage, die auch Daten enthalten.
                foreach($arrFields as $arrField){
                    $strField = $arrField['name'];

                    if(isset($varValue[$strField])){
                        $arrData[$strField] = $varValue[$strField];
                    }
                }
            }

            // Hooks ausfuehren
            $arrData = $this->api_hook_runner->runHooks('put', $arrData);

            if(is_array($arrData['data']) && count($arrData['data'])){
                $strQuery   = 'UPDATE `' . $this->api_config->table . '` SET ';

                foreach($arrData['data'] as $k => $v){
                    $strQuery .= "`$k` = '$v', ";
                }

                $strQuery = substr($strQuery, 0, -2);
                $strQuery .= ' WHERE `id` = ' . $this->api_config->id;
                $this->Database->executeUncached($strQuery);
                return 'dataUpdated';
            }

            return 'notUpdated';
        }

        return 'idRequired';
    }


    /**
     * Loescht einen Datensatz aus der DB.
     */
    public function delete(){
        if($this->api_config->id){
            // Hooks ausfuehren
            $this->api_hook_runner->runHooks('delete', array());

            // Delete Data
            $strQuery   = 'DELETE FROM `' . $this->api_config->table . '` WHERE `id` = ' . $this->api_config->id;
            $this->Database->executeUncached($strQuery);
            return 'dataDeleted';
        } else {
            return 'idRequired';
        }
    }


    /**
     * Regelt die Verarbeitung eines GET-Requests.
     */
    public function load(){
        switch($this->api_config->action){
            case 'tablelist':
                return $this->loadTables();
                break;

            case 'fieldlist':
                return $this->loadFields();
                break;

            case 'idlist':
            case 'details':
            default:
                if(substr_count($this->api_config->action, 'list') == 0){
                    return $this->loadData();
                } else {
                    return $this->loadList();
                }
                break;
        }
    }


    /**
     * Laedt die Daten aus der DB.
     * @param $arrRequest
     * @return bool
     */
    public function loadData(){
        $arrQuery = $this->api_config->query;

        if($this->Database->tableExists($this->api_config->table) && is_array($arrQuery) && count($arrQuery)){
            $strQuery   = 'SELECT * FROM `' . $this->api_config->table . '` WHERE ';

            foreach($arrQuery as $strKey => $strValue){
                if($this->Database->fieldExists($strKey, $this->api_config->table)){
                    $strQuery .= "`$strKey` = '$strValue' AND ";
                }
            }

            $strQuery = substr($strQuery, 0, -5);

            $objResult  = $this->Database->executeUncached($strQuery);

            if($objResult->numRows){
                $arrData = $objResult->fetchAllAssoc();

                // Hooks ausfuehren
                $arrData = $this->api_hook_runner->runHooks('get', $arrData);

                // send to browser
                $this->api_status->setState('dataLoaded');
                return $arrData;
            }
        }

        return 'noData';
    }


    /**
     * Gibt eine Liste der gefundenen Tabellen aus.
     */
    private function loadTables(){
        $objKey         = api_key::getInstance($this->api_config->strKey);
        $arrKeyTables   = $objKey->allowedtables;
        $arrTables      = array();

        // Pruefen, ob die Tabellen in der DB existieren,
        // koennte sich durch Deinstallation von Erweiterungen geaendert haben.
        foreach($arrKeyTables as $strTabel){
            if($this->Database->tableExists($strTabel)){
                $arrTables[] = $strTabel;
            }
        }

        $arrTables = $this->api_hook_runner->runHooks('tablelist', $arrTables);
        $this->api_status->setState('dataLoaded');

        return $arrTables;
    }


    /**
     * Gibt eine Liste der gefundenen Tabellen aus.
     */
    private function loadFields(){
        $arrFields = $this->Database->listFields($this->api_config->table);
        $arrFields = $this->api_hook_runner->runHooks('fieldlist', $arrFields);
        $this->api_status->setState('dataLoaded');
        return $arrFields;
    }


    /**
     * Gibt ein Liste mit den Ids aus der gewählten Tabelle zurueck.
     * @return bool
     */
    private function loadList(){
        $strQuery   = 'SELECT * FROM `' . $this->api_config->table . '` WHERE 1';
        $objResult  = $this->Database->executeUncached($strQuery);

        if($objResult->numRows){
            $arrData = $objResult->fetchEach('id');
            $this->api_status->setState('dataLoaded');
            $arrData = $this->api_hook_runner->runHooks('idlist', $arrData);
            return $arrData;
        }

        return 'noData';
    }
}