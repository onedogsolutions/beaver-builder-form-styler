# Beaver Builder Form Styler

A lean Beaver Builder add-on that provides styling modules for **Gravity Forms** and **Fluent Forms**, extracted from PowerPack and refactored into a standalone plugin.

## Features

- Standalone Gravity Forms and Fluent Forms styling modules.
- No PowerPack dependency.
- Vanilla JavaScript module settings helpers (no jQuery).
- Conditional **Address Block** tab that appears only when the selected form contains an address field.
- Padding and margin controls for the address block.

## Requirements

- WordPress 5.0+
- Beaver Builder (Pro or standard)
- Gravity Forms or Fluent Forms plugin (for the respective module)

## Installation

1. Upload the `beaver-builder-form-styler` folder to `/wp-content/plugins/`.
2. Activate the plugin through the WordPress **Plugins** menu.
3. The modules will appear in the Beaver Builder module panel under **BB Form Styler**.

## Module slugs

The modules use the `bbfs-` namespace to avoid conflicts with PowerPack:

- `bbfs-gravity-form`
- `bbfs-fluent-form`

## Address Block

When you select a form that contains an address field, an **Address Block** tab will appear in the module settings. Use it to set padding and margin around the address field group.

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

## Development notes

- PowerPack helpers such as `pp_get_color_value()` and `pp_hex2rgba()` have been replaced by `BBFS_Helpers` methods.
- Module settings JS is written in vanilla JavaScript and uses `fetch()` for AJAX calls.

## License

GPL-2.0+
