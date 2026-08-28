# Beaver Builder Form Styler

A lean Beaver Builder add-on that provides styling modules for **Gravity Forms** and **Fluent Forms**.

## Features

- Standalone Gravity Forms and Fluent Forms styling modules.
- No third-party add-on dependencies — Beaver Builder core field types only.
- Vanilla JavaScript module settings helpers. No jQuery, no framework, no build step.
- Conditional **Address Block** tab that appears only when the selected form contains an address field.
- Padding and margin controls for the address block.
- No editor AJAX: form data is rendered into the builder by PHP, so the settings panel makes no requests of its own.

## Requirements

- WordPress 5.0+
- Beaver Builder 2.2+ (the modules use the core `button-group` settings field)
- Gravity Forms or Fluent Forms plugin (for the respective module)

## Installation

1. Upload the `beaver-builder-form-styler` folder to `/wp-content/plugins/`.
2. Activate the plugin through the WordPress **Plugins** menu.
3. Open a page in Beaver Builder. The modules appear in the content panel under the **Form Styler Modules** category.

## Module slugs

- `bbfs-gravity-form`
- `bbfs-fluent-form`

## Address Block

When you select a form that contains an address field, an **Address Block** tab appears in the module settings. Use it to set padding and margin around the address field group.

Presence of an address field is determined server-side when the builder loads and handed to the editor as `window.BBFSData`. The settings helper reads that table directly, so switching forms toggles the tab with no network round-trip.

## Troubleshooting

**The modules do not appear in the content panel.**

1. **Check the Enabled Modules setting.** Under **Settings → Beaver Builder → Modules**, if anything other than *All* is selected, Beaver Builder filters newly registered modules out of the panel. Either select *All* or tick the two Form Styler modules.
2. **Clear the builder cache.** Beaver Builder caches its editor config. Use **Settings → Beaver Builder → Tools → Clear Cache** after installing or updating.
3. **Confirm Beaver Builder is active.** The plugin shows an admin notice when it is not.

Note that these modules are registered without a module *group*, so they appear in the default module list under their own **Form Styler Modules** category heading — not behind the content panel's group dropdown. Use the `bbfs_modules_category` filter to change the category name.

## File structure

```
beaver-builder-form-styler/
├── beaver-builder-form-styler.php
├── includes/
│   ├── class-bbfs-helpers.php
│   ├── class-bbfs-loader.php
│   └── class-bbfs-modules.php
└── modules/
    ├── bbfs-gravity-form/
    └── bbfs-fluent-form/
```

## Filters

| Filter | Purpose |
| --- | --- |
| `bbfs_modules_category` | Change the content-panel category the modules are listed under. |
| `bbfs_gravity_form_use_gravity_theme` | Return `false` to stop the Gravity Forms shortcode requesting the `gravity` theme. |

## Development notes

- Color handling lives in `BBFS_Helpers` (`get_color_value()`, `hex_to_rgba()`, `esc_tags()`).
- Module settings JS is plain ES2020+ registered through `FLBuilder.registerModuleHelper()`.
- Form-table queries are gated behind `BBFS_Helpers::is_builder_request()` so they only run while the builder is open.

## License

GPL-2.0+
