# Constalt WordPress Theme

Base structure for a custom WordPress theme.

## Current setup

- `style.css` contains theme metadata and fallback white background.
- `functions.php` + `inc/setup.php` configure theme supports and enqueue assets.
- `front-page.php` renders a full white front page.
- `template-parts/` is prepared for reusable partial templates.
- `assets/scss/` contains design-system foundations (`variables`, `mixins`, base/layout/page partials).

## Optional SCSS workflow

Use Dart Sass to compile `assets/scss/main.scss` to `assets/css/main.css`.

```bash
sass assets/scss/main.scss assets/css/main.css --watch
```
