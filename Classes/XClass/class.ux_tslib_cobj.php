<?php

class ux_tslib_content_Image extends tslib_content_Image {

	/**
	 * @param array
	 * @return string
	 */
	public function render($configuration = array()) {

		// if adaptive not set, nothing else to do
		if (!$this->isAdaptiveImageEnabled($configuration)) {
			return parent::render($configuration);
		}

		// prevent recursion
		unset($configuration['adaptive'], $configuration['adaptive.']);

		// get plugin settings
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$configurationManager = $objectManager->get('Tx_Extbase_Configuration_ConfigurationManager');
		$configurationManager->setContentObject($this->cObj);
		$settings = $configurationManager->getConfiguration(
			Tx_Extbase_Configuration_ConfigurationManager::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
		);
		$settings = $settings['plugin.']['tx_adxadaptiveimages.'];

		$images = array();
		$sources = array();
		foreach ($settings['breakpoints.'] as $key => $imageConfiguration) {

			$key = substr($key, 0, -1);
			$images[$key]['tag'] = parent::render($imageConfiguration);
			$images[$key]['source'] = $this->getAdaptiveImageSource($images[$key]['tag']);
			if ($key != 'noScript') {
				$sources[] = $key . ': \'' . $this->getAdaptiveImageSource($images[$key]['tag']) . '\'';
			}
		}

		$hash = md5($images['noScript']['tag']);
		$selectorClassName = $settings['cssClassPrefix'] . 'image-' . $hash;
		$adaptiveImage = PHP_EOL . '<noscript class="' . $selectorClassName . '">' . PHP_EOL;
		$adaptiveImage .= $images['noScript']['tag'] . PHP_EOL;
		$adaptiveImage .= '</noscript>' . PHP_EOL;

		$pageRenderer = t3lib_div::makeInstance('t3lib_PageRenderer');

		if (count($sources)) {
			$inlineJS = sprintf('(function($){ $(document).ready(function(){ $(\'.%s\').adxAdaptiveImages({ %s }); }); })(jQuery);', $selectorClassName, implode(', ', $sources));
			$pageRenderer->addJsInlineCode($hash, $inlineJS, $GLOBALS['TSFE']->config['config']['compressJs']);
		}

		return $adaptiveImage;
	}

	/**
	 * @param array $configuration
	 * @return boolean
	 */
	protected function isAdaptiveImageEnabled(array $configuration) {
		return isset($configuration['adaptive.'])
			? (boolean) $this->cObj->stdWrap((string) $configuration['adaptive'], (array) $configuration['adaptive.'])
			: (boolean) $configuration['adaptive'];
	}

	/**
	 * @param string
	 * @return string
	 */
	public function getAdaptiveImageSource($imageTag) {
		return preg_replace('/.*src\s*=\s*"(\S*)".*/', '\1', $imageTag);
	}

}

?>