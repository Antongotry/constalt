<?php
/**
 * Site header template.
 *
 * @package constalt
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <script>
        (function () {
            const cacheBuster = Date.now().toString();

            const appendBuster = (id) => {
                const link = document.getElementById(id);
                if (!link || !link.href) {
                    return;
                }

                const url = new URL(link.href, window.location.origin);
                url.searchParams.set('cb', cacheBuster);
                link.href = url.toString();
            };

            window.addEventListener('DOMContentLoaded', function () {
                appendBuster('constalt-style-css');
                appendBuster('constalt-main-css');
                appendBuster('constalt-fonts-css');
            });
        })();
    </script>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
