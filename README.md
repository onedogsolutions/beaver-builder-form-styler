# Beaver Builder Form Styler

A lean Beaver Builder add-on that provides styling modules for **Gravity Forms** and **Fluent Forms**.

## Features

- Standalone Gravity Forms and Fluent Forms styling modules.
- No third-party add-on dependencies — Beaver Builder core field types only.
- Vanilla JavaScript module settings helpers. No jQuery, no framework, no build step.
- Conditional **Address Block** section inside the Inputs tab that appears only when the selected form contains an address field.
- Padding and margin-bottom controls for the address block.
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

When you select a form that contains an address field, an **Address Block** section appears inside the **Inputs** tab of the module settings. Use it to set padding and margin-bottom on the address field group.

Presence of an address field is determined server-side when the builder loads and handed to the editor as `window.BBFSData`. The settings helper reads that table directly, so switching forms toggles the section with no network round-trip.

## Troubleshooting

**The modules do not appear in the content panel.**

As of 1.2.1 the plugin defends against the usual cause on its own. If the panel is still empty:

1. **Look for the admin notice.** The plugin now verifies that Beaver Builder actually accepted each module and shows an error notice naming any that were rejected — most often because another plugin or theme already registered a module with the same filename.
2. **Clear the builder cache.** Beaver Builder caches its editor config. Use **Settings → Beaver Builder → Tools → Clear Cache** after installing or updating.
3. **Confirm Beaver Builder is active.** The plugin shows an admin notice when it is not.

### Why the modules used to disappear

Beaver Builder stores the content panel's module list in the `_fl_builder_enabled_modules` option. `FLBuilderModel::get_enabled_modules()` returns that option verbatim whenever it exists and does not contain `all`, and `get_categorized_modules()` then skips every module whose slug is missing from it.

Saving **Settings → Beaver Builder → Modules** writes an explicit slug list. Any module that was not registered at that moment — because the plugin was inactive, mid-update, or had just been renamed — is absent from the saved list, so it silently vanishes from the panel even though it registered perfectly. That is why the symptom kept coming back after being "fixed".

The plugin now hooks `fl_builder_enabled_modules` and re-adds its own slugs, so the panel reflects what the plugin provides rather than a stale saved list. Return `false` from the `bbfs_force_enable_modules` filter if you would rather honour the saved list and control visibility from the Modules tab.

These modules are registered without a module *group*, so they appear in the default module list under their own **Form Styler Modules** category heading — not behind the content panel's group dropdown. Use the `bbfs_modules_category` filter to change the category name.

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
| `bbfs_force_enable_modules` | Return `false` to stop the plugin re-adding its slugs to Beaver Builder's enabled-modules list. |
| `bbfs_gravity_form_use_gravity_theme` | Return `false` to stop the Gravity Forms shortcode requesting the `gravity` theme. |

## Development notes

- Color handling lives in `BBFS_Helpers` (`get_color_value()`, `hex_to_rgba()`, `esc_tags()`).
- Module settings JS is plain ES2020+ registered through `FLBuilder.registerModuleHelper()`.
- Form-table queries are gated behind `BBFS_Helpers::is_builder_request()` so they only run while the builder is open.
- Modules register on `init` priority 11; Beaver Builder loads its own on `init` priority 2.
- `BBFS_Modules::register()` confirms each slug in `FLBuilderModel::$modules` holds an instance of our own class, so a slug collision is reported rather than silently swallowed.

## License

GPL-2.0+
