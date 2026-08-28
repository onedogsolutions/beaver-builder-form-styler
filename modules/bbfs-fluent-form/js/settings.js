/**
 * Fluent Form module settings helper.
 *
 * Shows the Address Block section inside the Inputs tab only while the
 * selected form actually contains an address field. The lookup table is
 * rendered into the page by PHP as window.BBFSData, so this makes no requests
 * of its own.
 */
( () => {
	'use strict';

	const PROVIDER = 'fluent';
	const SECTION_SELECTOR = '#fl-builder-settings-section-address_block';

	const hasAddressField = ( formId ) =>
		Boolean( window.BBFSData?.addressFields?.[ PROVIDER ]?.[ String( formId ) ] );

	const settings = {
		init() {
			const form = document.querySelector( '.fl-builder-settings' );
			const select = form?.querySelector( 'select[name="select_form_field"]' );

			if ( ! select ) {
				return;
			}

			const syncAddressSection = () => {
				const section = document.querySelector( SECTION_SELECTOR );

				if ( ! section ) {
					return;
				}

				section.style.display =
					select.value && hasAddressField( select.value ) ? '' : 'none';
			};

			select.addEventListener( 'change', syncAddressSection );
			syncAddressSection();
		},
	};

	if ( window.FLBuilder?.registerModuleHelper ) {
		window.FLBuilder.registerModuleHelper( 'bbfs-fluent-form', settings );
	}
} )();
