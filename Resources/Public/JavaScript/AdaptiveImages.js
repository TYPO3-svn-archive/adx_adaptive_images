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
			self = this;

		if (!adxAdaptiveImagesTest){
			$('body').prepend($('<div class="' + cssClassPrefix + 'test" style="position: absolute; top: -100em" />'));
			adxAdaptiveImagesTest = true;
		}

		this.before('<div class="' + cssClassPrefix + 'container ' + className + '-image" />');

		var loadedIndex = false;

		$(window)
			.on('resize', function(){
				var index = $('.' + cssClassPrefix + 'test').width();
				if (loadedIndex !== index && options[index]){
					$('.' + className + '-image').html($(options[index]));
					loadedIndex = index;
				}
			})
			.trigger('resize');
	}

})(jQuery);