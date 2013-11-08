<?php
/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  tl_api.php
 * @version     1.0.0
 * @since       12.09.13 - 20:14
 */

namespace esit\easy_api;


class tl_api extends \Controller{


    /**
     * Erstellt eine Instanz der Klasse.
     */
    public function __construct(){
        parent::__construct();
        $this->import('Database');
    }


    /**
     * Gibt die Erstellungszeit eines Key zurueck, wenn er beim Anlegen des Datensatzes erstellt wird.
     * @param $varValue
     * @param $dc
     * @return int
     */
    public function cbGetTime($varValue, $dc){
        if($varValue == ''){
            return time();
        } else {
            return $varValue;
        }
    }


    /**
     * Callback: Gibt beim Erstellen eines neuen Datensatzes einen Key zurueck.
     * @param $varValue
     * @param $dc
     * @return string
     */
    public function cbGetKey($varValue, $dc){
        if($varValue == ''){
            return $this->generateKey(false);
        } else {
            return $varValue;
        }
    }

    /**
     * Gibt die Tabellen der Datenbank zurueck.
     * @return mixed
     */
    public function cbGetTables(){
        $this->import('Database');
        return $this->Database->listTables();
    }


    /**
     * Erstellt und Speichern eines API-Keys.
     * Wird als Aktion aus der Uebersicht der Keys aufgerugen.
     * @param $dc
     * @return string
     */
    public function generateKey($blnGetOutput = true){
        $objKey                 = api_key::getInstance();
        $strKey                 = $objKey->makeKey();
        $objTemplate            = new \BackendTemplate('showkey');
        $objTemplate->strKey    = $strKey;
        $objKey->save();

        if($objKey){
            $objTemplate->strKeyHeadline = 'Key erzeugt für: ' . $objKey->name;
            $objTemplate->strDescription = $objKey->description;
        } else {
            $objTemplate->strKeyHeadline = 'Key erzeugt';
            $objTemplate->strDescription = '--';
        }

        if($blnGetOutput){
            return $objTemplate->parse();
        } else{
            return $strKey;
        }
    }


    /**
     * Toggle the visibility of an element
     * @param integer
     * @param boolean
     */
    public function toggleVisibility($intId, $blnVisible){
        // set table and filed
        $strTable = 'tl_api';
        $strField = 'active';

        // Check permissions to edit
        $this->Input->setGet('id', $intId);
        $this->Input->setGet('act', 'toggle');

        // Check permissions to publish
        if (!$this->User->isAdmin && !$this->User->hasAccess($strTable . '::' . $strField, 'alexf')){
            $this->log('Not enough permissions to show/hide content element ID "'.$intId.'"', $strTable . ' toggleVisibility', TL_ERROR);
            $this->redirect('contao/main.php?act=error');
        }

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA'][$strTable]['fields'][$strField]['save_callback'])){
            foreach ($GLOBALS['TL_DCA'][$strTable]['fields'][$strField]['save_callback'] as $callback){
                $this->import($callback[0]);
                $blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
            }
        }

        // Update the database
        $this->Database->prepare("UPDATE $strTable SET tstamp=". time() .", $strField='" . ($blnVisible ? '' : 1) . "' WHERE id=?")
                       ->execute($intId);
    }


    /**
     * button_callback: Return the "toggle visibility" button
     * @param array
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @return string
     */
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes){
        // set table and field
        $strTable = 'tl_api';
        $strField = 'active';
        $blnInvert= true;  // flase bei invisible, true bei visible!

        $this->import('BackendUser', 'User');

        if($blnInvert){
            $visible = ($row[$strField]) ? 0 : 1; // visible ist invertiert zu $row['invisible']!!!
        } else {
            $visible = ($row[$strField]) ? 1 : 0;
        }

        if (strlen($this->Input->get('tid'))){
            $this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 0));
            $this->redirect($this->getReferer());
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->isAdmin && !$this->User->hasAccess($strTable . '::' . $strField, 'alexf')){
            return '';
        }

        $href .= '&amp;id='.$this->Input->get('id').'&amp;tid='.$row['id'].'&amp;state='.$visible;

        if ($visible){
            $icon = 'invisible.gif';
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
    }
}