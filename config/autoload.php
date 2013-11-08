<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Easy_db_api
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
$strPath        = 'system/modules/' . $module;
$strNamespace   = 'esit\\' . $module; #'easy_api';


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    $strNamespace,
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
    $strNamespace . '\api_auth'             => $strPath . '/classes/auth/api_auth.php',
    $strNamespace . '\api_ip'               => $strPath . '/classes/auth/api_ip.php',

    $strNamespace . '\api_config'           => $strPath . '/classes/config/api_config.php',
    $strNamespace . '\api_key'              => $strPath . '/classes/config/api_key.php',

    $strNamespace . '\api_decoder'          => $strPath . '/classes/decoder/api_decoder_inc.php',
    $strNamespace . '\api_decoder_json'     => $strPath . '/classes/decoder/api_decoder_json.php',

    $strNamespace . '\api_schema_db'        => $strPath . '/classes/driver/db/api_schema_db.php',
    $strNamespace . '\api_source_db'        => $strPath . '/classes/driver/db/api_source_db.php',

    $strNamespace . '\api_hook_runner'      => $strPath . '/classes/hook/api_hook_runner.php',

    $strNamespace . '\api_output'           => $strPath . '/classes/output/api_output.php',
    $strNamespace . '\api_status'           => $strPath . '/classes/output/api_status.php',

    $strNamespace . '\api_schema'           => $strPath . '/classes/source/api_schema_inc.php',
    $strNamespace . '\api_source'           => $strPath . '/classes/source/api_source_inc.php',

    $strNamespace . '\api_run'              => $strPath . '/classes/system/api_run.php',
    $strNamespace . '\myGetPageIdFromUrl'   => $strPath . '/classes/system/myGetPageIdFromUrl.php',
    $strNamespace . '\tl_api'               => $strPath . '/classes/system/tl_api.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'showkey'    => $strPath . '/templates',
));