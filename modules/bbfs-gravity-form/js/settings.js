/**
 * Gravity Form module settings helper.
 *
 * Shows the Address Block tab only while the selected form actually contains
 * an address field. The lookup table is rendered into the page by PHP as
 * window.BBFSData, so this makes no requests of its own.
 */
( () => {
	'use strict';

	const PROVIDER = 'gravity';
	const TAB_SELECTOR =
		'.fl-builder-settings-tab a[href="#fl-builder-settings-tab-address_style"]';

	const hasAddressField = ( formId ) =>
		Boolean( window.BBFSData?.addressFields?.[ PROVIDER ]?.[ String( formId ) ] );

	const settings = {
		init() {
			const form = document.querySelector( '.fl-builder-settings' );
			const select = form?.querySelector( 'select[name="select_form_field"]' );

			if ( ! select ) {
				return;
			}

			const syncAddressTab = () => {
				const tab = document.querySelector( TAB_SELECTOR );

				if ( ! tab ) {
					return;
				}

				tab.style.display =
					select.value && hasAddressField( select.value ) ? '' : 'none';
			};

			select.addEventListener( 'change', syncAddressTab );
			syncAddressTab();
		},
	};

	if ( window.FLBuilder?.registerModuleHelper ) {
		window.FLBuilder.registerModuleHelper( 'bbfs-gravity-form', settings );
	}
} )();
