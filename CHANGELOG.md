# NETWAYS WP Thumbs Changelog

## Version 1.0.0 - May 27, 2025

The inaugural release of **NETWAYS WP Thumbs** adds thumbs up/down voting to single WordPress
posts.

**Thumbs up/down voting**: A `[netways_wp_thumbs]` shortcode renders 👍 / 👎 buttons with live
vote counts on single post views.

**AJAX vote counts**: Counts are fetched and submitted via AJAX so they stay accurate even
when full-page caching is in place.

**Duplicate-vote protection**: A per-post cookie (server-side) and a LocalStorage entry
(client-side) prevent a visitor from voting more than once on the same post.

**Multi-language support**: All user-facing strings use the WordPress i18n API under the
`netways-wp-thumbs` text domain, with German (de_DE) and English (en_US) translations
included.

**Theme-aware icons**: The plugin uses the built-in ETmodules icons when a Divi theme or Divi
child theme is active, and falls back to Font Awesome otherwise.
