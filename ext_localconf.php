<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

// add XCLASS to image cObject
$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['tslib/content/class.tslib_content_image.php'] = t3lib_extMgm::extPath($_EXTKEY) . 'Classes/XClass/class.ux_tslib_cobj.php';
// Register stdWrap hook for includeFrontEndResources. Using "adx*" key to prevent colliding of other adx-extensions using the same hook.
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['stdWrap']['adxIncludeFrontEndResources'] = 'EXT:' . $_EXTKEY . '/Classes/Hooks/StdWrap.php:&Tx_AdxAdaptiveImages_Hooks_StdWrap';

// load user function
include_once(t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Service/UserFunc.php');

?>