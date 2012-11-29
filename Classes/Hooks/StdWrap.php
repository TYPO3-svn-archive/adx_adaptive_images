<?php

class Tx_AdxAdaptiveImages_Hooks_StdWrap implements tslib_content_stdWrapHook {

	/**
	 * @var array
	 */
	protected $frontEndResourceTypes = array(
		'headerData.',
		'footerData.',
		'includeCSS.',
		'cssInline.',
		'includeJSlibs.',
		'includeJSFooterlibs.',
		'includeJS.',
		'includeJSFooter.',
		'jsInline.',
		'jsFooterInline.',
	);

	/**
	 * @var array
	 */
	protected $frontEndResourceCArrayTypes = array(
		'headerData.',
		'footerData.',
		'cssInline.',
		'jsInline.',
		'jsFooterInline.',
	);

	/**
	 * stdWrapPreProcess
	 *
	 * @param string $content
	 * @param array $configuration
	 * @param tslib_cObj $parentObject
	 * @return string
	 */
	function stdWrapPreProcess($content, array $configuration, tslib_cObj &$parentObject) {
		return $content;
	}

	/**
	 * stdWrapOverride
	 *
	 * @param string $content
	 * @param array $configuration
	 * @param tslib_cObj $parentObject
	 * @return string
	 */
	function stdWrapOverride($content, array $configuration, tslib_cObj &$parentObject) {
		return $content;
	}

	/**
	 * stdWrapProcess
	 *
	 * @param string $content
	 * @param array $configuration
	 * @param tslib_cObj $parentObject
	 * @return string
	 */
	function stdWrapProcess($content, array $configuration, tslib_cObj &$parentObject) {
		return $content;
	}

	/**
	 * stdWrapPostProcess
	 *
	 * @param string $content
	 * @param array $configuration
	 * @param tslib_cObj $parentObject
	 * @return string
	 */
	function stdWrapPostProcess($content, array $configuration, tslib_cObj &$parentObject) {

		if (isset($configuration['includeFrontEndResources.'])) {
			foreach ($configuration['includeFrontEndResources.'] as $type => $cObjectConfiguration) {
				// Check if valid.
				if (in_array($type, $this->frontEndResourceTypes)) {
					// Create array if it's not.
					if (!is_array($GLOBALS['TSFE']->pSetup[$type])) {
						$GLOBALS['TSFE']->pSetup[$type] = array();
					}

					// If is inline type, parse it and create a HTML cObject.
					if (in_array($type, $this->frontEndResourceCArrayTypes)) {
						foreach ($cObjectConfiguration as $key => $configuration) {
							// Render only if forceParse is set.
							if (is_array($configuration) && isset($configuration['forceParse'])) {
								unset($configuration['forceParse']);
								// override cObject configuration
								$cObjectConfiguration = array(
									substr($key, 0, -1) => 'TEXT',
									$key => array(
										'value' => $parentObject->cObjGet($cObjectConfiguration, $key),
									),
								);
							}
						}
					}

					$GLOBALS['TSFE']->pSetup[$type] = t3lib_div::array_merge_recursive_overrule($GLOBALS['TSFE']->pSetup[$type], $cObjectConfiguration);
				}
			}
		}

		return $content;
	}

}

?>