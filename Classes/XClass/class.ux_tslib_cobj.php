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

		$adaptiveSettings = $configuration['adaptive.'];

		// prevent recursion
		unset($configuration['adaptive'], $configuration['adaptive.']);

		$noScriptSource = '';
		$imageSources = array();
		foreach ($adaptiveSettings['breakpoints.'] as $key => $breakpointConfiguration) {

			$key = substr($key, 0, -1);
			$this->parseAdaptiveWidthByRatio($breakpointConfiguration);
			$imageSource = parent::render($breakpointConfiguration['image.']);

			if ($key == 'noScript') {
				$noScriptSource = $imageSource;
			} else {
				$imageSources[] = $key . ': \'' . addcslashes($this->removeAttributesForAdaptiveImage($imageSource), '\'') . '\'';
			}
		}

		$hash = md5($noScriptSource);
		$selectorClassName = $adaptiveSettings['cssClassPrefix'] . 'image-' . $hash;
		$adaptiveImage = PHP_EOL . '<noscript class="' . $selectorClassName . '">' . PHP_EOL;
		$adaptiveImage .= $noScriptSource . PHP_EOL;
		$adaptiveImage .= '</noscript>' . PHP_EOL;

		$pageRenderer = t3lib_div::makeInstance('t3lib_PageRenderer');

		if (count($imageSources)) {
			$inlineJS = sprintf('$(\'.%s\').adxAdaptiveImages({ %s });', $selectorClassName, implode(', ', $imageSources));
			if (isset($GLOBALS['TSFE']->pSetup['jsInline.']['1352719209'])) {
				$inlineJS = str_replace(' }); })(jQuery);', $inlineJS . ' }); })(jQuery);', $GLOBALS['TSFE']->pSetup['jsInline.']['1352719209.']['value']);
			} else {
				$inlineJS = '(function($){ $(document).ready(function(){ ' . $inlineJS . ' }); })(jQuery);';
			}
			$GLOBALS['TSFE']->pSetup['jsInline.']['1352719209'] = 'TEXT';
			$GLOBALS['TSFE']->pSetup['jsInline.']['1352719209.']['value'] = $inlineJS;
		}

		return $adaptiveImage;
	}

	/**
	 * @param array $configuration
	 * @return void
	 */
	protected function parseAdaptiveWidthByRatio(array &$configuration) {

		$imageWidth = &$configuration['image.']['file.']['width'];

		// parse width
		$imageWidth = $this->cObj->stdWrap((string) $imageWidth, (array) $configuration['image.']['file.']['width.']);

		unset($configuration['image.']['file.']['width.']);

		// if width is greater 0, than set the new width by ratio
		if ($imageWidth) {
			$ratio = $this->cObj->stdWrap($configuration['ratio'], (array) $configuration['ratio.']);
			$imageWidth = round($imageWidth * $ratio);
		}
	}

	/**
	 * @param array $configuration
	 * @return boolean
	 */
	protected function isAdaptiveImageEnabled(array $configuration) {
		return isset($configuration['adaptive.']['enable.'])
			? (boolean) $this->cObj->stdWrap((string) $configuration['adaptive.']['enable'], (array) $configuration['adaptive.']['enable.'])
			: (boolean) $configuration['adaptive.']['enable'];
	}

	/**
	 * @param string
	 * @return string
	 */
	public function getAdaptiveImageTag($imageSource) {
		return preg_replace('/.*src\s*=\s*"(\S*)".*/', '\1', $imageSource);
	}

	/**
	 * @param string
	 * @return string
	 */
	public function removeAttributesForAdaptiveImage($imageSource) {
		return preg_replace('/\swidth\s*=\s*"\d*"|\sheight\s*=\s*"\d*"/', '', $imageSource);
	}

}

?>