<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package   easy_db_api
 * @author    Patrick Froch
 * @license   LGPL
 * @copyright easy Solutions IT 2013
 */


/**
 * BACK END MODULES
 *
 * Back end modules are stored in a global array called "BE_MOD". You can add
 * your own modules by adding them to the array.
 *
 * $GLOBALS['BE_MOD'] = array
 * (
 *    'group_1' => array
 *    (
 *       'module_1' => array
 *       (
 *          'tables'       => array('table_1', 'table_2'),
 *          'callback'     => 'ClassName',
 *          'key'          => array('Class', 'method'),
 *          'icon'         => 'path/to/icon.gif',
 *          'stylesheet'   => 'path/to/stylesheet.css',
 *          'javascript'   => 'path/to/javascript.js'
 *       )
 *    )
 * );
 *
 * Not all of the keys mentioned above (like "tables", "key", "callback" etc.)
 * have to be set. Take a look at the system/modules/core/config/config.php
 * file to see how back end modules are configured.
 */
$strPath = str_replace('/config', '', str_replace(TL_ROOT, '', dirname(__FILE__)));

$GLOBALS['BE_MOD']['easy_api']['db'] = array(
    'tables'    => array('tl_api'),
    'icon'      => $strPath . '/assets/img/api.png',
    'genkey'    => array('tl_api', 'generateKey')
);

$GLOBALS['BE_MOD']['easy_api']['ip'] = array(
    'tables'    => array('tl_ip_blacklist'),
    'icon'      => $strPath . '/assets/img/ip.png'
);


/**
 * FRONT END MODULES
 *
 * Front end modules are stored in a global array called "FE_MOD". You can add
 * your own modules by adding them to the array.
 *
 * $GLOBALS['FE_MOD'] = array
 * (
 *    'group_1' => array
 *    (
 *       'module_1' => 'ModuleClass1',
 *       'module_2' => 'ModuleClass2'
 *    )
 * );
 *
 * The keys (like "module_1") are the module names, which are e.g. stored in the
 * database and used to find the corresponding translations. The values (like
 * "ModuleClass1") are the names of the classes, which will be loaded when the
 * module is rendered. The class "ModuleClass1" has to be stored in a file
 * named "ModuleClass1.php" in your module folder.
 */


/**
 * CONTENT ELEMENTS
 *
 * Content elements are stored in a global array called "TL_CTE". You can add
 * your own content elements by adding them to the array.
 *
 * $GLOBALS['TL_CTE'] = array
 * (
 *    'group_1' => array
 *    (
 *       'cte_1' => 'ContentClass1',
 *       'cte_2' => 'ContentClass2'
 *    )
 * );
 *
 * The keys (like "cte_1") are the element names, which are e.g. stored in the
 * database and used to find the corresponding translations. The values (like
 * "ContentClass1") are the names of the classes, which will be loaded when the
 * element is rendered. The class "ContentClass1" has to be stored in a file
 * named "ContentClass1.php" in your module folder.
 */


/**
 * BACK END FORM FIELDS
 *
 * Back end form fields are stored in a global array called "BE_FFL". You can
 * add your own form fields by adding them to the array.
 *
 * $GLOBALS['BE_FFL'] = array
 * (
 *    'input'  => 'FieldClass1',
 *    'select' => 'FieldClass2'
 * );
 *
 * The keys (like "input") are the field names, which are e.g. stored in the
 * database and used to find the corresponding translations. The values (like
 * "FieldClass1") are the names of the classes, which will be loaded when the
 * field is rendered. The class "FieldClass1" has to be stored in a file named
 * "FieldClass1.php" in your module folder.
 */


/**
 * FRONT END FORM FIELDS
 *
 * Front end form fields are stored in a global array called "TL_FFL". You can
 * add your own form fields by adding them to the array.
 *
 * $GLOBALS['TL_FFL'] = array
 * (
 *    'input'  => 'FieldClass1',
 *    'select' => 'FieldClass2'
 * );
 *
 * The keys (like "input") are the field names, which are e.g. stored in the
 * database and used to find the corresponding translations. The values (like
 * "FieldClass1") are the names of the classes, which will be loaded when the
 * field is rendered. The class "FieldClass1" has to be stored in a file named
 * "FieldClass1.php" in your module folder.
 */


/**
 * PAGE TYPES
 *
 * Page types are stored in a global array called "TL_PTY". You can add your own
 * page types by adding them to the array.
 *
 * $GLOBALS['TL_PTY'] = array
 * (
 *    'type_1' => 'PageType1',
 *    'type_2' => 'PageType2'
 * );
 *
 * The keys (like "type_1") are the field names, which are e.g. stored in the
 * database and used to find the corresponding translations. The values (like
 * "PageType1") are the names of the classes, which will be loaded when the
 * page is rendered. The class "PageType1" has to be stored in a file named
 * "PageType1.php" in your module folder.
 */


/**
 * MODEL MAPPINGS
 *
 * Model names are usually built from the table names, e.g. "tl_user_group"
 * becomes "UserGroupModel". There might be situations, however, where you need
 * to specify a custom mapping, e.g. when you are using nested namespaces.
 *
 * $GLOBALS['TL_MODELS'] = array
 * (
 *    'tl_user'       => 'Vendor\Application\UserModel',
 *    'tl_user_group' => 'Vendor\Application\UserGroupModel'
 * );
 *
 * You can register your mappings in the config.php file of your extension.
 */


/**
 * MAINTENANCE MODULES
 *
 * Maintenance modules are stored in a global array called "TL_MAINTENANCE". You
 * can add your own maintenance modules by adding them to the array.
 *
 * $GLOBALS['TL_MAINTENANCE'] = array
 * (
 *    'ClearCache',
 *    'RebuildSearchIndex'
 * );
 *
 * Take a look at the system/modules/core/classes/PurgeData.php file to see how
 * maintenance modules are set up. The class "ClearCache" has to be stored in a
 * file named "ClearCache.php" in your module folder.
 */


/**
 * PURGE JOBS
 *
 * Purge jobs are stored in a global array called "TL_PURGE". You can add your
 * own purge jobs by adding them to the array.
 *
 * $GLOBALS['TL_PURGE'] = array
 * (
 *    'job_1' => array
 *    (
 *       'tables' => array
 *       (
 *          'index' => array
 *          (
 *             'callback' => array('Automator', 'purgeSearchTables'),
 *             'affected' => array('tl_search', 'tl_search_index')
 *          ),
 *       )
 *   );
 *
 * There are three categories: "tables" stores jobs which truncate database
 * tables, "folders" stores jobs which purge folders and "custom" stores jobs
 * which only trigger a callback function.
 */


/**
 * CRON JOBS
 *
 * Cron jobs are stored in a global array called "TL_CRON". You can add your own
 * cron jobs by adding them to the array.
 *
 * $GLOBALS['TL_CRON'] = array
 * (
 *    'monthly' => array
 *    (
 *       array('Automator', 'purgeImageCache')
 *    ),
 *    'weekly'   => array(),
 *    'daily'    => array(),
 *    'hourly'   => array(),
 *    'minutely' => array()
 * );
 *
 * Note that this is rather a command scheduler than a cron job, which does not
 * guarantee an exact execution time. You can replace the command scheduler with
 * a real cron job though.
 */


/**
 * HOOKS
 *
 * Hooks are stored in a global array called "TL_HOOKS". You can register your
 * own functions by adding them to the array.
 *
 * $GLOBALS['TL_HOOKS'] = array
 * (
 *    'hook_1' => array
 *    (
 *       array('MyClass', 'myPostLogin'),
 *       array('MyClass', 'myPostLogout')
 *    )
 * );
 *
 * Hooks allow you to add functionality to the core without having to modify the
 * source code by registering callback functions to be executed on a particular
 * event. For more information see https://contao.org/manual.html.
 */
$GLOBALS['TL_HOOKS']['getPageIdFromUrl'][] = array('myGetPageIdFromUrl', 'startApi');


/**
 * AUTO ITEMS
 *
 * Auto items are stored in a global array called "TL_AUTO_ITEM". You can
 * register your own auto items by adding them to the array.
 *
 * $GLOBALS['TL_AUTO_ITEM'] = array('items', 'events');
 *
 * Auto items are keywords, which are used as parameters by certain modules.
 * When rebuilding the search index URLs, Contao needs to know about these
 * keywords so it can handle them properly.
 */


/**
 * HTTP ERROR CODES
 */
$GLOBALS['easy_api']['http_codes'] = array(
    100 => 'Continue',
    101 => 'Switching Protocols',
    102 => 'Processing',
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    207 => 'Multi-Status',
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    306 => 'Switch Proxy',
    307 => 'Temporary Redirect',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Requested Range Not Satisfiable',
    417 => 'Expectation Failed',
    418 => 'I\'m a teapot',
    422 => 'Unprocessable Entity',
    423 => 'Locked',
    424 => 'Failed Dependency',
    425 => 'Unordered Collection',
    426 => 'Upgrade Required',
    449 => 'Retry With',
    450 => 'Blocked by Windows Parental Controls',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    506 => 'Variant Also Negotiates',
    507 => 'Insufficient Storage',
    509 => 'Bandwidth Limit Exceeded',
    510 => 'Not Extended'
);


/**
 * API-Errors
 */
$GLOBALS['easy_api']['state']['wrongMethod']            = array(405, 'ERROR: wrong method');
$GLOBALS['easy_api']['state']['wrongApiLevel']          = array(400, 'ERROR: wrong API level');
$GLOBALS['easy_api']['state']['notEnoughPermissions']   = array(403, 'ERROR: not enough permissions for this action');
$GLOBALS['easy_api']['state']['keyNotActivated']        = array(403, 'ERROR: key not activated');
$GLOBALS['easy_api']['state']['keyRequired']            = array(401, 'ERROR: key required');
$GLOBALS['easy_api']['state']['keyInvalid']             = array(403, 'ERROR: key invalid');
$GLOBALS['easy_api']['state']['noData']                 = array(404, 'ERROR: no data');
$GLOBALS['easy_api']['state']['notSaved']               = array(409, 'ERROR: data could not be saved');
$GLOBALS['easy_api']['state']['notImplemented']         = array(501, 'ERROR: action not implemented');
$GLOBALS['easy_api']['state']['notUpdated']             = array(409, 'ERROR: data could not be updated');
$GLOBALS['easy_api']['state']['idRequired']             = array(400, 'ERROR: id required');
$GLOBALS['easy_api']['state']['ipBlocked']              = array(403, 'ERROR: ip blocked');
$GLOBALS['easy_api']['state']['noDecoder']              = array(500, 'ERROR: no decoder loaded');
$GLOBALS['easy_api']['state']['noSchema']               = array(500, 'ERROR: no schema loaded');

$GLOBALS['easy_api']['state']['dataLoaded']             = array(200, 'SUCCESS: data loaded');   // wird nicht zurueck gegeben, aber als Error ausgewertet, wenn nicht vorhanden!
$GLOBALS['easy_api']['state']['dataSaved']              = array(200, 'SUCCESS: data saved');
$GLOBALS['easy_api']['state']['dataUpdated']            = array(202, 'SUCCESS: data updated');
$GLOBALS['easy_api']['state']['dataDeleted']            = array(200, 'SUCCESS: data deleted');


/**
 * MAX IP ERROR COUNT
 * Anzahl der fehlerhaften Zugriffe, bevor eine IP gespert wird.
 */
$GLOBALS['easy_api']['ip_error']['max_count']           = 3;


/**
 * LOG REQUESTS FROM BANNED IPS
 * Sollen Zugriffsversuche von gespeerte IPs in das Systemlog eingetragen werden?
 */
$GLOBALS['easy_api']['ip_error']['logbanned']           = true;


/**
 * ENABLE LOGGING
 * Meldungen der API in das Contao-Systemlog eintragen.
 */
$GLOBALS['easy_api']['log']['enable']                   = true;