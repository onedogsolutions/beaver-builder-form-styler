# State Tracker - Beaver Builder Form Styler

## Release state

**`main` is at v1.2.0** as of the dependency purge and builder-visibility fix. Previous: v1.1.0 (namespace refactor), v1.0.0 (initial release).

## Unreleased

**Removed the Gravity Forms AJAX toggle.**

The Gravity Forms module still exposed an **Enable AJAX** setting that passed an `ajax` attribute into the `[gravityform]` shortcode. Since the plugin should not use AJAX anywhere, the setting and shortcode output have been removed.

- Deleted the `form_ajax` button-group field from `modules/bbfs-gravity-form/bbfs-gravity-form.php`.
- Removed the `ajax` attribute from the generated `[gravityform]` shortcode in `modules/bbfs-gravity-form/includes/frontend.php`.

## Current Phase: v1.2.0 (Dependency Purge & Builder Visibility)

### The reported problem

The modules did not appear in the Beaver Builder content panel, so there was nothing to drag onto the page.

**Root cause.** Both modules registered with a custom `group` property. Beaver Builder treats `group` as a *separate panel view* rather than a label: `FLBuilderModel::get_module_groups()` collects every module carrying one, and the content panel renders a distinct view per group behind the "Group" dropdown. Modules without a group appear in the default view. Registering with a group therefore removed both modules from the default module list.

**Fix.** The `group` property was dropped from both constructors. The modules now appear in the default list under their own `Form Styler Modules` category.

### v1.2.0 Modifications

**Builder visibility.**

- Removed the `group` property from both module constructors.
- Removed `BBFS_Helpers::get_modules_group()`.
- Added the `bbfs_modules_category` filter so the category name can be changed.
- `BBFS_Modules::register()` now drives registration from a slug → class map, verifies each file exists and each class was defined, and logs a specific message when either check fails.
- Added an admin notice when the plugin is active without Beaver Builder.

**Removed all third-party add-on dependencies.**

- Deleted `BBFS_Gravity_Form_Module::filter_settings()` — 254 lines of legacy settings migration that were never hooked to anything, guarded behind a `class_exists()` check for an add-on class, and targeting three opacity fields (`form_background_opacity`, `input_field_background_opacity`, `button_background_opacity`) that no longer exist in either form config. This accounted for 10 of the 13 external code references.
- Converted all 26 third-party switch settings fields to Beaver Builder's core `button-group` field (16 in the Gravity module, 10 in Fluent). The `options` and `toggle` contracts are identical, so the show/hide behaviour is preserved. This raises the minimum Beaver Builder version to 2.2.
- Replaced the external tag sanitize callback with `BBFS_Helpers::esc_tags()`, which validates against an allow-list of tag names.
- Renamed the Gravity Forms theme filter into the plugin's own namespace as `bbfs_gravity_form_use_gravity_theme`.
- Removed every remaining prose reference from the plugin header, README and this file.

**Removed the editor AJAX layer.**

The settings helpers called `window.ajaxurl`, which Beaver Builder does not define in the frontend editor — its `FLBuilder._ajaxUrl()` posts back to the builder page URL, not to `admin-ajax.php`. The nonce was also injected on `admin_enqueue_scripts`, which never fires there. Both AJAX paths were dead on the frontend.

- Deleted the `bbfs_check_form_address_field` and `bbfs_gf_forms_dropdown_html` AJAX handlers.
- Deleted the `wp_ajax_nopriv_bbfs_gf_forms_dropdown_html` registration, which exposed every Gravity Form ID and title to unauthenticated visitors with no nonce and no capability check.
- Deleted the nonce plumbing and `BBFS_Loader::admin_enqueue_scripts()`.
- Added `BBFS_Modules::get_address_field_map()`, which builds a `provider → form id → bool` table server-side.
- Added `BBFS_Loader::enqueue_editor_data()`, which hands that table to the editor as `window.BBFSData`, with a footer-print fallback if the `fl-builder` script handle is unavailable.
- Added `BBFS_Helpers::is_builder_request()` and gated both form-table queries behind it, so neither runs on ordinary front-end page loads.

**JavaScript rewrite.**

- Both `settings.js` files rewritten as plain ES2020+ — optional chaining, arrow functions, `const`/`let`, early returns. No jQuery, no framework, no build step.
- Removed the `rules` validation blocks. Cross-checking every rule key against the PHP form config showed 22 of 30 Fluent rules and 1 of 18 Gravity rules referenced fields that no longer exist; the survivors are core field types that validate themselves.
- Removed the Gravity `_getForms()` / `_setForms()` pair. `gf_forms_dropdown_options()` already populates the select server-side, and the JS was overwriting it — its failure path set `innerHTML = ''`, blanking the dropdown.
- Removed a `setTimeout(…, 0)` race workaround.
- `FLBuilder._registerModuleHelper` → `FLBuilder.registerModuleHelper` (the underscore form is deprecated in Beaver Builder).
- Net: 363 lines across the two files reduced to 92.

**Frontend consistency and escaping.**

- Gravity module `.form-title` / `.form-description` renamed to `.bbfs-form-title` / `.bbfs-form-description`, matching the Fluent module and completing the v1.1.0 namespacing. Updated across the template, dynamic CSS, static CSS and the settings `preview.selector` entries. Gravity Forms' own `.gform_title` / `.gform_description` selectors were left alone.
- `custom_title` and `custom_description` are escaped with `wp_kses_post()` in both templates.
- The Fluent `title_tag` value is constrained through `BBFS_Helpers::esc_tags()` before being interpolated as a tag name.
- The Fluent form ID is cast with `absint()` before shortcode interpolation.
- Removed a commented-out shortcode block from the Gravity template.

**Version bump.**

- `beaver-builder-form-styler.php` defines `BBFS_VERSION` as `1.2.0`; plugin header version set to `1.2.0`.

**Files changed:**

- `beaver-builder-form-styler.php` — Version, description
- `includes/class-bbfs-helpers.php` — Added `esc_tags()`, `is_builder_request()`; removed `get_modules_group()`; added category filter
- `includes/class-bbfs-loader.php` — Removed AJAX and nonce handling; added editor data injection and admin notice
- `includes/class-bbfs-modules.php` — Added address-field map and registration hardening
- `modules/bbfs-gravity-form/bbfs-gravity-form.php` — Removed `filter_settings()` and the AJAX handler; `button-group` fields; namespaced selectors
- `modules/bbfs-gravity-form/js/settings.js` — Rewritten
- `modules/bbfs-gravity-form/includes/frontend.php` — Namespaced classes, escaping, filter rename
- `modules/bbfs-gravity-form/includes/frontend.css.php` — Namespaced selectors
- `modules/bbfs-gravity-form/css/frontend.css` — Namespaced selectors
- `modules/bbfs-fluent-form/bbfs-fluent-form.php` — `button-group` fields; sanitize callback
- `modules/bbfs-fluent-form/js/settings.js` — Rewritten
- `modules/bbfs-fluent-form/includes/frontend.php` — Escaping, tag constraint, `absint()`
- `README.md` — Rewritten with troubleshooting and filter reference

### Verification performed

- `php -l` clean across all 12 PHP files; `node --check` clean on both JS files.
- Repository-wide search for external add-on references returns zero matches.
- Every `button-group` field confirmed to carry an `options` map.
- Settings JS rule keys cross-checked against the PHP form config.

### Not verified

No WordPress runtime was available in the build environment, so all verification is static. The content panel, the settings forms and the Address Block tab still need confirmation in a live Beaver Builder install.

---

## Historical Phase: v1.1.0 (Namespace Refactor)

Moved module identifiers onto the plugin's own `bbfs-` namespace to eliminate Beaver Builder warnings and registration conflicts with other form-styling add-ons.

- Module slugs became `bbfs-gravity-form` and `bbfs-fluent-form`.
- Module directories and their class files were renamed to match.
- `includes/class-bbfs-modules.php` loads from the new paths; module `dir` and `url` properties updated.
- The Gravity Forms dropdown AJAX action was renamed to `bbfs_gf_forms_dropdown_html` (since removed in v1.2.0).
- JS module helper registrations updated to the new slugs.
- Frontend CSS classes moved to `bbfs-*`: `.bbfs-gravity-form-content`, `.bbfs-gravity-form-inner`, `.bbfs-fluent-form-content`, `.bbfs-form-title`, `.bbfs-form-description`. The Gravity module's title and description classes were missed at the time and were completed in v1.2.0.
- Author set to `Ryan Waterbury, One Dog Solutions`; version set to `1.1.0`.

## Historical Phase: v1.0.0 (Initial Release)

Established the Gravity Forms and Fluent Forms styling modules as a standalone plugin.

**Architecture.**

- `BBFS_Loader` bootstraps the plugin and registers modules on `init`.
- `BBFS_Modules` registers the two Beaver Builder modules and provides shared address-field detection.
- `BBFS_Helpers` provides color value and rgba conversion utilities.
- `BBFS_Gravity_Form_Module` and `BBFS_Fluent_Form_Module` extend `FLBuilderModule`.

**Conditional Address Block tab.**

- Settings helpers detect whether the selected form contains an address field.
- If an address field is present, the **Address Block** tab is shown in the module settings.
- Detection works for both Gravity Forms and Fluent Forms.

**Files added:**

- `beaver-builder-form-styler.php` — Plugin bootstrap
- `includes/class-bbfs-loader.php` — Plugin loader
- `includes/class-bbfs-helpers.php` — Shared helper methods
- `includes/class-bbfs-modules.php` — Module registration and address-field detection
- `modules/bbfs-gravity-form/` — Gravity Form module
- `modules/bbfs-fluent-form/` — Fluent Form module
- `README.md` — Documentation
- `LICENSE` — GPL-2.0+

## Project Conventions

- **Prefix:** constants use `BBFS_`; classes use `BBFS_`.
- **Class naming:** `BBFS_` prefix, PascalCase.
- **Text domain:** `bb-form-styler`.
- **Author:** Ryan Waterbury, One Dog Solutions — https://onedog.solutions/
- **License:** GPL-2.0+.
- **JS:** Vanilla ES2020+. No jQuery, no framework, no build step. Beaver Builder's module settings surface is Backbone/Underscore with no React mount point, so settings helpers are plain DOM.
- **CSS:** Plain CSS for module frontend styles; dynamic CSS generated via `FLBuilderCSS` rules in `frontend.css.php`.
- **Settings fields:** Beaver Builder core field types only. No third-party field types.
- **Editor data:** No AJAX from module settings. Data the editor needs is computed server-side behind `BBFS_Helpers::is_builder_request()` and injected as `window.BBFSData`.
- **Storage:** No custom database tables. Reads existing Gravity Forms and Fluent Forms data only.
- **Namespace:** Module slugs, filenames, CSS classes and filters use the `bbfs-` / `bbfs_` prefix.
