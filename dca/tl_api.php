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

$strPath = str_replace('/dca', '', str_replace(TL_ROOT, '', dirname(__FILE__)));

/**
 * Table tl_api
 */
$GLOBALS['TL_DCA']['tl_api'] = array
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
			'fields'                  => array('name'),
			'flag'                    => 1
		),
		'label' => array
		(
			'fields'                  => array('name'),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_api']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_api']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_api']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_api']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
            'toggle' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_api']['toggle'],
                'icon'                => 'visible.gif',
                'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
                'button_callback'     => array('tl_api', 'toggleIcon')
            ),
            'genkey' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_api']['genkey'],
                'href'                => 'key=genkey',
                'icon'                => $strPath . '/assets/img/key.png'
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
		'default'                     => '{name_legend},name;{description_legend},description;{key_legend},key, keygeneratedon;{methods_legend},allowedmethods;{tables_legend},allowedtables;{active_legends},active;'
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
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'name' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_api']['name'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class' => 'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'description' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_api']['description'],
            'exclude'                 => true,
            'inputType'               => 'textarea',
            'eval'                    => array('tl_class' => 'long clr'),
            'sql'                     => "text NOT NULL"
        ),
        'key' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_api']['key'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'load_callback'           => array(array('tl_api', 'cbGetKey')),
            'eval'                    => array('maxlength' => 255, 'readonly' => true, 'tl_class' => 'long', 'style' => 'background-color: #eee'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'keygeneratedon' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_api']['keygeneratedon'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'load_callback'           => array(array('tl_api', 'cbGetTime')),
            'eval'                    => array('rgxp'=>'datim', 'datepicker'=>false, 'tl_class'=>'w50', 'readonly' => true, 'style' => 'background-color: #eee'),
            'sql'                     => "varchar(10) NOT NULL default ''"
        ),
        'allowedmethods' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_api']['allowedmethods'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'options'                 => $GLOBALS['TL_LANG']['MSC']['easy_api']['methods'],
            'eval'                    => array('mandatory'=>true, 'multiple'=>true, 'tl_class' => 'long'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'allowedtables' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_api']['allowedtables'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'options_callback'        => array('tl_api', 'cbGetTables'),
            'eval'                    => array('mandatory'=>true, 'multiple'=>true, 'tl_class' => 'long'),
            'sql'                     => "text NOT NULL"
        ),
        'active' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_api']['active'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'default'                 => true,
            'eval'                    => array('tl_class' => 'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        )
	)
);
