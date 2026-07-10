# NETWAYS WP Thumbs

A lightweight WordPress plugin that adds thumbs up/down voting to single blog posts.

## Overview

NETWAYS WP Thumbs renders a pair of 👍 / 👎 buttons on single posts via a shortcode. Votes
are counted per post and loaded through AJAX so the counts stay correct even behind full-page
caching. Icons adapt to the active theme: the plugin uses the built-in ETmodules icons when
Divi (or a Divi child theme) is active, and falls back to Font Awesome otherwise.

## Key Features

- 👍 / 👎 vote buttons rendered by a simple shortcode
- Vote counts loaded via AJAX to survive page caching
- LocalStorage and cookies prevent multiple votes per user and post
- Divi/ETmodules icons when Divi is active, Font Awesome fallback otherwise
- Multi-language ready via the standard WordPress i18n API (de_DE / en_US included)

## Installation

1. Download or clone the plugin into your WordPress plugins directory as
   `wp-content/plugins/netways-wp-thumbs`:

   ```bash
   git clone https://github.com/NETWAYS/netways-wp-thumbs.git \
     wp-content/plugins/netways-wp-thumbs
   ```

   Alternatively, download the ZIP from GitHub and upload it via
   **Plugins → Add New → Upload Plugin** in the WordPress admin.
2. Activate **NETWAYS WP Thumbs** in the WordPress admin under **Plugins**.
3. Add the shortcode `[netways_wp_thumbs]` to any post where the voting UI should appear.

## Usage

Insert the shortcode into the body of any post:

```
[netways_wp_thumbs]
```

The buttons render only on single post views. When a visitor votes, the count updates via
AJAX and a per-post cookie plus LocalStorage entry prevents them from voting again.

## Requirements

- WordPress ≥ 6.0
- PHP ≥ 7.4

## Icons & External Assets

When a Divi (ETmodules) theme is active, icons are rendered from the theme's built-in icon
font — no external requests are made. When Divi is **not** active, the plugin loads Font
Awesome from `https://cdnjs.cloudflare.com`. If you operate under the GDPR and want to avoid
third-party requests, consider self-hosting Font Awesome or running a Divi-based theme.

## Uninstall

Deactivating the plugin only stops the shortcode from rendering; it leaves the collected data
in place. Vote counts are stored as post meta (`_netways_thumb_up` and `_netways_thumb_down`)
on each post and are not removed automatically.

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for the release history.

## License

GPLv2 or later. See the [`LICENSE`](LICENSE) file for details.

## Author

[NETWAYS](https://netways.de)
