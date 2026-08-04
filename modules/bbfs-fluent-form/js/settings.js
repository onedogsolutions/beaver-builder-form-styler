/**
 * Fluent Form module settings helper.
 */
(function () {
	'use strict';

	var rules = {
		'form_border_width': {
			 number: true,
		},
		'form_border_radius': {
			 number: true,
		},
		'form_shadow': {
			 number: true,
		},
		'form_shadow_opacity': {
			 number: true,
		},
		'form_padding': {
			 number: true,
		},
		'title_margin': {
			 number: true,
		},
		'description_margin': {
			 number: true,
		},
		'input_field_height': {
			 number: true,
		},
		'input_textarea_height': {
			 number: true,
		},
		'input_field_background_opacity': {
			 number: true,
		},
		'input_field_border_width': {
			 number: true,
		},
		'input_field_border_radius': {
			 number: true,
		},
		'input_field_padding': {
			 number: true,
		},
		'input_field_margin': {
			 number: true,
		},
		'button_width_size': {
			 number: true,
		},
		'button_background_opacity': {
			 number: true,
		},
		'button_border_width': {
			 number: true,
		},
		'button_border_radius': {
			 number: true,
		},
		'button_padding': {
			 number: true,
		},
		'title_font_size': {
			 number: true,
		},
		'title_line_height': {
			 number: true,
		},
		'description_font_size': {
			 number: true,
		},
		'description_line_height': {
			 number: true,
		},
		'label_font_size': {
			 number: true,
		},
		'input_font_size': {
			 number: true,
		},
		'input_desc_font_size': {
			 number: true,
		},
		'input_desc_line_height': {
			 number: true,
		},
		'button_font_size': {
			 number: true,
		},
		'validation_error_font_size': {
			 number: true,
		},
		'success_message_font_size': {
			 number: true,
		},
	};

	var settings = {
		rules: rules,

		init: function () {
			this._initAddressTabToggle();
		},

		_initAddressTabToggle: function () {
			var self       = this;
			var form       = document.querySelector( '.fl-builder-settings' );
			var select     = form ? form.querySelector( 'select[name="select_form_field"]' ) : null;
			var savedValue = '';

			if ( ! select ) {
				return;
			}

			if ( typeof FLBuilderSettingsForms !== 'undefined' && FLBuilderSettingsForms.config && FLBuilderSettingsForms.config.settings ) {
				savedValue = FLBuilderSettingsForms.config.settings.select_form_field || '';
			}

			select.addEventListener( 'change', function () {
				self._toggleAddressTab( select.value );
			} );

			this._toggleAddressTab( select.value || savedValue );
		},

		_toggleAddressTab: function ( formId ) {
			var tab = document.querySelector( '.fl-builder-settings-tab a[href="#fl-builder-settings-tab-address_style"]' );
			if ( ! tab ) {
				return;
			}

			if ( ! formId ) {
				tab.style.display = 'none';
				return;
			}

			this._checkAddressField( formId, function ( hasAddress ) {
				tab.style.display = hasAddress ? '' : 'none';
			} );
		},

		_checkAddressField: function ( formId, callback ) {
			var url = window.ajaxurl || '';
			fetch( url, {
				method: 'POST',
				credentials: 'same-origin',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: new URLSearchParams( {
					action:   'bbfs_check_form_address_field',
					provider: 'fluent',
					form_id:  formId,
					nonce:    typeof bbfs !== 'undefined' && bbfs.nonce ? bbfs.nonce : '',
				} ).toString(),
			} )
			.then( function ( response ) { return response.json(); } )
			.then( function ( data ) {
				callback( data && data.success && data.data && data.data.has_address );
			} )
			.catch( function () { callback( false ); } );
		},
	};

	if ( typeof FLBuilder !== 'undefined' && FLBuilder._registerModuleHelper ) {
		FLBuilder._registerModuleHelper( 'bbfs-fluent-form', settings );
	}
})();
