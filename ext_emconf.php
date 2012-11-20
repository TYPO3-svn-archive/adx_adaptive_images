<?php

########################################################################
# Extension Manager/Repository config file for ext "adx_adaptive_images".
#
# Auto generated 20-11-2012 16:05
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'ad: Adaptive Images',
	'description' => 'Adaptive images for responsive sites. Can be used on every image rendered with cObject IMAGE. Renders images in diffrent sizes and load them on window resize. Note: Using XCLASS for cObject IMAGE!',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '1.0.0',
	'dependencies' => 't3jquery,adx_less',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Arno Dudek',
	'author_email' => 'webmaster@adgrafik.at',
	'author_company' => 'ad:grafik',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			't3jquery' => '2.0.6-',
			'adx_less' => '1.0.0-',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:11:{s:12:"ext_icon.gif";s:4:"7598";s:17:"ext_localconf.php";s:4:"aaec";s:14:"ext_tables.php";s:4:"147e";s:14:"ext_tables.sql";s:4:"8fc1";s:38:"Classes/XClass/class.ux_tslib_cobj.php";s:4:"6410";s:38:"Configuration/TypoScript/constants.txt";s:4:"bc79";s:34:"Configuration/TypoScript/setup.txt";s:4:"5679";s:34:"Resources/Private/LESS/Styles.less";s:4:"2d2a";s:46:"Resources/Private/Language/de.locallang_db.xlf";s:4:"8d16";s:43:"Resources/Private/Language/locallang_db.xlf";s:4:"5509";s:45:"Resources/Public/JavaScript/AdaptiveImages.js";s:4:"d9b3";}',
	'suggests' => array(
	),
);

?>