<?php

class ux_tslib_content_Image extends tslib_content_Image {

	/**
	 * @param array
	 * @return string
	 */
	public function render($configuration = array()) {

		// if adaptive not set, nothing else to do
		if (!$this->isAdaptiveImageEnabled($configuration)) {
			return $imageTagNoScript;
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
		foreach ($settings['breakpoints.'] as $key => $value) {

			$key = substr($key, 0, -1);
			$imageConfiguration = t3lib_div::array_merge_recursive_overrule($configuration, $value);

			$images[$key]['tag'] = parent::render($imageConfiguration);
			$images[$key]['source'] = $this->getAdaptiveImageSource($images[$key]['tag']);
			if ($key != 'noScript') {
				$sources[] = $key . ': \'' . $this->getAdaptiveImageSource($images[$key]['tag']) . '\'';
			}
		}

		$selectorClassName = $settings['selectorClassName'] . '-' . md5($images['noScript']['tag']);
		$adaptiveImage = '<noscript class="' . $selectorClassName . '">' . PHP_EOL;
		$adaptiveImage .= $images['noScript']['tag'] . PHP_EOL;
		$adaptiveImage .= '</noscript>' . PHP_EOL;

		$pageRenderer = t3lib_div::makeInstance('t3lib_PageRenderer');

		if (count($sources)) {
			$inlineJS = sprintf('$(\'%s\').adxAdaptiveImages({ %s });', $selectorClassName, implode(', ', $sources));
			$pageRenderer->addJsInlineCode(md5($images['noScript']['tag']), $inlineJS, $GLOBALS['TSFE']->config['config']['compressJs']);
		}

		return $adaptiveImage;


print_r($images);
print_r($adaptiveImage);

		$images['noScript']['maxWidth'] = $this->cObj->stdWrap($settings['maxWidth.']['noScript'], (array) $settings['maxWidth.']['noScript.']);
		$images['large']['maxWidth'] = $this->cObj->stdWrap($settings['maxWidth.']['large'], (array) $settings['maxWidth.']['large.']);
		$images['default']['maxWidth'] = $this->cObj->stdWrap($settings['maxWidth.']['default'], (array) $settings['maxWidth.']['default.']);
		$images['medium']['maxWidth'] = $this->cObj->stdWrap($settings['maxWidth.']['medium'], (array) $settings['maxWidth.']['medium.']);

		$configuration['file.']['maxW'] = $images['noScript']['maxWidth'];
		$images['noScript']['tag'] = parent::render($configuration);
		$images['noScript']['source'] = $this->getAdaptiveImageSource($images['noScript']['tag']);

		$images['large']['source'] = '';
		if ($images['large']['maxWidth'] && $images['large']['maxWidth'] > $images['default']['maxWidth']) {
			$configuration['file.']['maxW'] = $images['large']['maxWidth'];
			$images['large']['tag'] = parent::render($configuration);
			$images['large']['source'] = $this->getAdaptiveImageSource($images['large']['tag']);
		}

		$images['default']['source'] = '';
		if ($images['default']['maxWidth']) {
			$configuration['file.']['maxW'] = $images['default']['maxWidth'];
			$images['default']['tag'] = parent::render($configuration);
			$images['default']['source'] = $this->getAdaptiveImageSource($images['default']['tag']);
		}

		$images['medium']['source'] = '';
		if ($images['medium']['maxWidth'] && $images['medium']['maxWidth'] < $images['default']['maxWidth']) {
			$configuration['file.']['maxW'] = $images['medium']['maxWidth'];
			$images['medium']['tag'] = parent::render($configuration);
			$images['medium']['source'] = $this->getAdaptiveImageSource($images['medium']['tag']);
		}




		// if image empty, nothing else to do
		if (!$imageTagNoScript) {
			return '';
		}

		// get default image width
		preg_match('/width="(\S*)"/', $imageTagNoScript, $matches);
		$maxWidthDefault = $matches[1];




print_r($imageSourceDefault.PHP_EOL);
print_r($imageSourceMedium.PHP_EOL);





#print_r($this->cObj);
print_r($settings);
#print_r($file.'*');
#print_r($conf);

		return $adaptiveImage;


		$adaptiveImagesScriptClass = $settings['adaptiveImages.']['scriptClass'];
		$adaptiveImagesClasses = array(
			'desktop' => $adaptiveImagesScriptClass . '-desktop',
			'table' => $adaptiveImagesScriptClass . '-table',
			'phone' => $adaptiveImagesScriptClass . '-phone',
		);
		$imageTagNoScript = $noScriptMax . 'ImageTag';

		// get default image width
		preg_match('/width="(\S*)"/', $imageTagNoScript, $matches);
		$desktopImageWidth = $matches[1];

		$tableImageTag = '';
		if ($tableMaxWidth && $tableMaxWidth < $desktopImageWidth) {
			$configuration['file.']['maxW'] = $tableMaxWidth;
			$tableImageTag = parent::render($configuration);
		}

		$phoneImageTag = '';
		if ($phoneMaxWidth && $phoneMaxWidth < $desktopImageWidth && $phoneMaxWidth < $tableMaxWidth) {
			$configuration['file.']['maxW'] = $phoneMaxWidth;
			$phoneImageTag = parent::render($configuration);
		}

		// fallback to desktop if no script image is empty
		$imageTagNoScript = $$imageTagNoScript ? $$imageTagNoScript : $imageTagNoScript;

		// set responsive image tag
#		$responsiveImage = '<script class="' . $adaptiveImagesScriptClass . '">document.write(\'<\' + \'!--\')</script><noscript>' . "\n";
		$responsiveImage .= '<script>' . "\n";
		$responsiveImage .= "
(function($){
	$(document).ready(function(){
		$('noscript.adxless-adaptive-images').adxAdaptiveImages({
			scriptClass: '" . $adaptiveImagesScriptClass . "',
			testClass: 'gallery-test',
			initialSuffix: 'uploads/pics/Home.png',
			suffixes: {
				'1': 'typo3temp/pics/Home_f72457cb43.png',
				'2': 'typo3temp/pics/Home_d56045f018.png'
			}
		});
	});
})(jQuery);
</script>" . "\n";
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