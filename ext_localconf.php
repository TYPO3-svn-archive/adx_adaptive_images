<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

// add XCLASS to image cObject
$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['tslib/content/class.tslib_content_image.php'] = t3lib_extMgm::extPath($_EXTKEY) . 'Classes/XClass/class.ux_tslib_cobj.php';

?>