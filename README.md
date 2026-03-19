# Constalt WordPress Theme

Base structure for a custom WordPress theme.

## Current setup

- `style.css` contains theme metadata and fallback dark background (`#051120`).
- `functions.php` + `inc/setup.php` configure theme supports and enqueue assets.
- `front-page.php` renders an empty front page placeholder.
- `template-parts/` is prepared for reusable partial templates.
- `assets/scss/` contains design-system foundations (`variables`, `mixins`, base/layout/page partials).

## Sizing convention

- Use `vw` for layout spacing and typography (desktop base width `1440`, mobile base width `390`).
- Keep technical pixel values in `px` (for example `border: 1px solid ...`).

## Optional SCSS workflow

Use Dart Sass to compile `assets/scss/main.scss` to `assets/css/main.css`.

```bash
sass assets/scss/main.scss assets/css/main.css --watch
```
