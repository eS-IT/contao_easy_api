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
 * Table tl_ip_blacklist
 */
$GLOBALS['TL_DCA']['tl_ip_blacklist'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('tstamp'),
            'panelLayout'             => 'filter,search,limit',
			'flag'                    => 6
		),
		'label' => array
		(
			'fields'                  => array('ip'),
			'format'                  => '%s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_ip_blacklist']['edit'],
                'href'                => 'act=edit',
              'icon'                => 'edit.gif'
            ),/*
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_ip_blacklist']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),*/
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_ip_blacklist']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_ip_blacklist']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Edit
	'edit' => array
	(
		'buttons_callback' => array()
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{info_legend},ip,tstamp,key;'
	),

	// Subpalettes
	'subpalettes' => array
	(
		''                            => ''
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_ip_blacklist']['tstamp'],
            'exclude'                 => true,
            'flag'                    => 6,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>10, 'tl_class' => 'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'ip' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_ip_blacklist']['ip'],
			'exclude'                 => true,
            'filter'                  => true,
            'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class' => 'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
        'key' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_ip_blacklist']['key'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class' => 'long'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        )
	)
);
