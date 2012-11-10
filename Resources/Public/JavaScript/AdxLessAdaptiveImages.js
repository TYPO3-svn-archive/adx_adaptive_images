/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 ************************************************************************************************
 *
 * @copyright 2012, Arno Dudek, http://www.adgrafik.at
 * @license The GNU General Public License, http://www.gnu.org/copyleft/gpl.html.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 *
 ************************************************************************************************
 ** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


(function($){

	var adxAdaptiveImagesTest = false;

	$.fn.adxAdaptiveImages = function(options){

		var className = this.attr('class'),
			cssClassPrefix = className.substr(0, className.indexOf('-') + 1),
			imageClassName = cssClassPrefix + 'image',
			insertClassName = className + '-insert',
			insertSelector = '.' + insertClassName,
			testClassName = cssClassPrefix + 'test',
			testSelector = '.' + testClassName,
			self = this;

		if (!adxAdaptiveImagesTest){
			$('body').prepend($('<div class="' + testClassName + '" style="position: absolute; top: -100em" />'));
			adxAdaptiveImagesTest = true;
		}

		this.before('<img src="" class="' + insertClassName + ' ' + imageClassName + '" />');

		$(window)
			.on('resize', function(){
				var index = $(testSelector).width();
				if (options[index]){
					$(insertSelector).attr('src', options[index])
				}
			})
			.trigger('resize');
	}

})(jQuery);