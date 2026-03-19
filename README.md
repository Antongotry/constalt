# Constalt WordPress Theme

Base structure for a custom WordPress theme.

## Current setup

- `style.css` contains theme metadata and fallback dark background (`#051120`).
- `functions.php` + `inc/setup.php` configure theme supports and enqueue assets.
- `front-page.php` renders an empty front page placeholder.
- `template-parts/` is prepared for reusable partial templates.
- `assets/scss/` contains design-system foundations (`variables`, `mixins`, base/layout/page partials).

## Sizing convention

- Core rule: convert design `px` to `vw` with desktop formula `px / 1440 * 100vw`.
- Mobile rule: use `px / 390 * 100vw` only for explicit mobile values.
- Keep technical pixel values in `px` (for example `border: 1px solid ...`).
- Global font: `Inter Tight` (loaded in all weights via Google Fonts).
- Front-page hero placeholder uses `height: 100svh`.

## Optional SCSS workflow

Use Dart Sass to compile `assets/scss/main.scss` to `assets/css/main.css`.

```bash
sass assets/scss/main.scss assets/css/main.css --watch
```
