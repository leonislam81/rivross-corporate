# RIVROSS Corporate WordPress Theme

This repository contains only the `rivross-corporate` WordPress theme. It does not contain WordPress core, the database, media uploads, or page content.

## Local development

Edit the theme in the local WordPress installation, then commit and push changes to the `main` branch. A push will start the GitHub Actions deployment workflow once the production SSH secrets below have been configured.

## Safe live deployment

The workflow copies theme files over SSH/rsync into the existing live theme directory. It does not connect to WordPress's database, overwrite site content, or use `rsync --delete`; files removed from Git are therefore not automatically removed from the server.

Configure these GitHub Actions secrets for the `production` environment:

- `LIVE_SSH_HOST` — hosting SSH hostname
- `LIVE_SSH_PORT` — SSH port, commonly `22`
- `LIVE_SSH_USER` — SSH username
- `LIVE_SSH_PRIVATE_KEY` — private key for a deploy account/key authorized by the hosting provider
- `LIVE_SSH_KNOWN_HOSTS` — verified SSH host-key line(s) for that server
- `LIVE_THEME_PATH` — absolute path to `wp-content/themes/rivross-corporate` on the server

The hosting provider must enable SSH access and provide the server path. cPanel is not required, but GitHub cannot deploy without a working SSH account/key and the exact theme path. Never commit private keys or passwords to this repository.
