# State Tracker - Beaver Builder Form Styler

## Release state

**`main` is at v1.1.0** as of the namespace refactor that removes PowerPack collisions. Previous: v1.0.0 (initial extraction from PowerPack).

## Current Phase: v1.1.0 (Namespace Refactor)

### v1.1.0 Modifications

Refactored module identifiers from the PowerPack `pp-` namespace to the plugin's own `bbfs-` namespace. This eliminates Beaver Builder warnings and registration conflicts when both Beaver Builder Form Styler and PowerPack are active.

**Module slug changes.**

- `pp-gravity-form` → `bbfs-gravity-form`
- `pp-fluent-form` → `bbfs-fluent-form`

**Directory and file renames.**

- `modules/pp-gravity-form/` → `modules/bbfs-gravity-form/`
- `modules/pp-gravity-form/pp-gravity-form.php` → `modules/bbfs-gravity-form/bbfs-gravity-form.php`
- `modules/pp-fluent-form/` → `modules/bbfs-fluent-form/`
- `modules/pp-fluent-form/pp-fluent-form.php` → `modules/bbfs-fluent-form/bbfs-fluent-form.php`

**Code updates.**

- `includes/class-bbfs-modules.php` now loads from the new `bbfs-*` paths.
- Module `dir` and `url` properties point to the new directories.
- Gravity Form AJAX action renamed: `pp_gf_forms_dropdown_html` → `bbfs_gf_forms_dropdown_html`.
- JS module helper registrations updated:
  - `pp-gravity-form` → `bbfs-gravity-form`
  - `pp-fluent-form` → `bbfs-fluent-form`
- All frontend CSS class names updated from `pp-*` to `bbfs-*`:
  - `.pp-gf-content` → `.bbfs-gravity-form-content`
  - `.pp-gf-inner` → `.bbfs-gravity-form-inner`
  - `.pp-fluent-form-content` → `.bbfs-fluent-form-content`
  - `.pp-form-title` → `.bbfs-form-title`
  - `.pp-form-description` → `.bbfs-form-description`
- `README.md` updated to document the new module slugs.

**Version bump.**

- `beaver-builder-form-styler.php` now defines `BBFS_VERSION` as `1.1.0`.
- Plugin header version set to `1.1.0`.
- Author updated to `Ryan Waterbury, One Dog Solutions`.

**Files changed:**

- `beaver-builder-form-styler.php` — Version and author
- `includes/class-bbfs-modules.php` — New module paths
- `modules/bbfs-gravity-form/bbfs-gravity-form.php` — New `dir`/`url`, AJAX action
- `modules/bbfs-gravity-form/js/settings.js` — New helper slug and AJAX action
- `modules/bbfs-gravity-form/includes/frontend.php` — New CSS classes
- `modules/bbfs-gravity-form/includes/frontend.css.php` — New CSS classes
- `modules/bbfs-gravity-form/css/frontend.css` — New CSS classes
- `modules/bbfs-fluent-form/bbfs-fluent-form.php` — New `dir`/`url`
- `modules/bbfs-fluent-form/js/settings.js` — New helper slug
- `modules/bbfs-fluent-form/includes/frontend.php` — New CSS classes
- `modules/bbfs-fluent-form/includes/frontend.css.php` — New CSS classes
- `modules/bbfs-fluent-form/css/frontend.css` — New CSS classes
- `README.md` — Updated slugs and structure

---

## Historical Phase: v1.0.0 (Initial Extraction from PowerPack)

### v1.0.0 Modifications

Extracted the Gravity Forms and Fluent Forms styling modules from PowerPack into a standalone plugin. Removed the jQuery dependency from module settings helpers and replaced PowerPack utility functions with plugin-specific helpers.

**Architecture.**

- `BBFS_Loader` bootstraps the plugin and registers modules on `init`.
- `BBFS_Modules` registers the two Beaver Builder modules and provides shared address-field detection.
- `BBFS_Helpers` replaces PowerPack helpers such as color value and rgba conversion.
- `BBFS_Gravity_Form_Module` and `BBFS_Fluent_Form_Module` extend `FLBuilderModule`.

**Conditional Address Block tab.**

- Settings helpers detect whether the selected form contains an address field.
- If an address field is present, the **Address Block** tab is shown in the module settings.
- Detection works for both Gravity Forms and Fluent Forms.

**Vanilla JavaScript helpers.**

- Module settings JS rewritten in vanilla JS using `fetch()`.
- AJAX calls use `admin-ajax.php` with a plugin nonce for address-field checks.

**Files added:**

- `beaver-builder-form-styler.php` — Plugin bootstrap
- `includes/class-bbfs-loader.php` — Plugin loader and AJAX registration
- `includes/class-bbfs-helpers.php` — Shared helper methods
- `includes/class-bbfs-modules.php` — Module registration and address-field detection
- `modules/pp-gravity-form/` — Gravity Form module (now `modules/bbfs-gravity-form/`)
- `modules/pp-fluent-form/` — Fluent Form module (now `modules/bbfs-fluent-form/`)
- `README.md` — Documentation
- `LICENSE` — GPL-2.0+

## Project Conventions

- **Prefix:** constants use `BBFS_`; classes use `BBFS_`.
- **Class naming:** `BBFS_` prefix, PascalCase.
- **Text domain:** `bb-form-styler`.
- **Author:** Ryan Waterbury, One Dog Solutions — https://onedog.solutions/
- **License:** GPL-2.0+.
- **JS:** Vanilla ES2020+. No jQuery.
- **CSS:** Plain CSS for module frontend styles; dynamic CSS generated via `FLBuilderCSS` rules in `frontend.css.php`.
- **Storage:** No custom database tables. Reads existing Gravity Forms and Fluent Forms data only.
- **Namespace:** Module slugs, filenames, CSS classes, and AJAX actions use the `bbfs-` prefix.
