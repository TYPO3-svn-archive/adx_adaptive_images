<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

// Add static TypoScript
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'ad: Adaptive Images');

/**
 * Add-ons for tt_content
 */
$tempColumns = array(
	'tx_adxadaptiveimages_adaptive' => array(		
		'label' => 'LLL:EXT:adx_adaptive_images/Resources/Private/Language/locallang_db.xlf:tx_adxadaptiveimages_adaptive',
		'exclude' => 1,		
		'config' => array(
			'type' => 'check',
			'items' => array(
				'1'	=> array(
					'0' => 'LLL:EXT:lang/locallang_core.xml:labels.enabled',
				),
			),
		),
	),
);

t3lib_div::loadTCA('tt_content');
t3lib_extMgm::addTCAcolumns('tt_content', $tempColumns, 1);
t3lib_extMgm::addFieldsToPalette('tt_content', 'image_settings', 'tx_adxadaptiveimages_adaptive', 'after:imageborder');

?>
