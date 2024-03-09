//Developer: Adam Funk
//Last Updated: 08-31-2021
define(
	[
		'jquery', 
		'ko',
		'mage/translate',
		'Swissup_Gdpr/js/model/cookie-manager',
	],
	function ($, ko, $t, cookieManager) {
		'use strict';
		// Create mixin to add URL redirect to americancpr.com home page from Swissup_Gdpr/view/frontend/web/js/view/cookie-settings.js 'acceptConsent' functions button click, after cookie:manager.updateCookie has completed.
		var mixin = {
			acceptConsent: function(component, event) { 
				$('#btn-cookie-allow').click(); // built-in cookie restriction notice

				$(event.target) 
					.width($(event.target).width())
					.addClass('gdpr-loading')
					.text($t('Saving..'));

				cookieManager.updateCookie(function () {
					$(event.target)
						.removeClass('gdpr-loading')
						.text($t('Saved'));
					
					window.location.href = "/";
				});
				
			},
		};

        return function (target) {
            return target.extend(mixin);
        };
	}
);