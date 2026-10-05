# RIVROSS Corporate WordPress Theme

This repository contains the `rivross-corporate` WordPress theme and the small `RIVROSS Theme Updates` bootstrap plugin. It does not contain WordPress core, the database, media uploads, or page content.

## Local development and releases

Edit and test the theme in the local WordPress installation. Push changes to `main`; a push does not modify the live site. When a change is ready for production:

1. Increment `Version` in `style.css` and `RIVROSS_THEME_VERSION` in `functions.php` to the same `X.Y.Z` value.
2. Push the change to `main`.
3. Create and publish a GitHub Release whose tag matches the theme version, for example `v1.0.27`.
4. The release workflow checks the tag, builds a correctly structured `rivross-corporate.zip` plus the small updater plugin ZIP, and attaches both to the release.
5. A connected live WordPress site shows the new version under Dashboard → Updates. An administrator can review and install it there.

The update package contains only theme files. WordPress content, uploads, and database records are not packaged or overwritten by the updater.

## Connect the GitHub repository

Install and activate the small `rivross-theme-updater.zip` plugin once from Plugins → Add New → Upload Plugin on the live site. Public repositories need no token. If the repository is private, open Settings → RIVROSS Theme Updates and save a GitHub fine-grained personal access token limited to this repository with **Contents: Read-only** permission. The optional token is stored as a non-autoloaded WordPress option and is never printed back into the page. Do not commit it to Git or send it in chat. A `RIVROSS_GITHUB_TOKEN` constant in `wp-config.php` may be used instead where server configuration access is available.

The updater checks the latest published stable release and supports WordPress 6.0 or later. The theme's `Update URI` header prevents WordPress.org from treating this theme as a directory theme on WordPress 6.1 and later.

## One-time live bootstrap

The live site needs the updater plugin once before it can display GitHub theme updates. Upload and activate the small plugin ZIP; this does not replace the theme or affect site content. For a public repository, no token setup is required. The plugin can offer theme releases through Dashboard → Updates. The theme ZIP is downloaded server-to-server during an update, so the browser upload limit does not apply to future releases.
