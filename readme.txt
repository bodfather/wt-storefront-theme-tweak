=== WooTweaks Storefront Theme Tweak ===
Contributors: bodfather
Tags: storefront, woocommerce, customization, theme, admin
Requires at least: 5.0
Tested up to: 6.7.2
Stable tag: 0.0.2
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Customize the Storefront theme with real-time toggles, CSS editors, and secure GitHub updates.

== Description ==

WooTweaks Storefront Theme Tweak supercharges the Storefront theme for WooCommerce with powerful, user-friendly customization options right in the WordPress admin. Built for developers and store owners, it delivers instant toggles, CSS editing with CodeMirror’s syntax highlighting, and automatic GitHub updates—now with enhanced security and seamless upgrades from private repositories.

Key features:

* Real-time toggles for Storefront styles, middle menu, and admin CSS visibility.
* Edit front-end and admin CSS directly, saved to files with CodeMirror’s modern editor (syntax highlighting, autocomplete).
* Secure API token storage for private GitHub repo updates, with manual save enforcement.
* Streamlined tabbed admin interface—General tab for tweaks, API Token tab for updates.
* Automatic migration of legacy API keys during upgrades.
* Nonce-secured CSS saves for added safety.

== Installation ==

1. Grab `wt-storefront-theme-tweak.zip` from [releases](https://github.com/bodfather/wt-storefront-theme-tweak/releases).
2. Upload via **Plugins > Add New > Upload Plugin** in WordPress.
3. Activate from the **Plugins** menu.
4. Head to **WooTweaks > WT StoreFront Theme Tweak** to start tweaking.

== Frequently Asked Questions ==

= How do I update the plugin? =
It auto-checks GitHub for updates. For private repos, add a GitHub API token in the **API Token** tab and click "Save Changes".

= Can I edit CSS without coding skills? =
Yep—CodeMirror highlights syntax and supports autocomplete, making CSS tweaks a breeze.

= How do I use a private GitHub repository? =
Set your repo to private, generate a Personal Access Token (repo scope), and save it in the **API Token** tab.

= How do I enable the middle menu? =
Flip the "Activate Middle Menu" toggle in the General tab, then assign a menu in **Appearance > Menus > Manage Locations**.

= Where’s support at? =
Hit up the [GitHub Issues page](https://github.com/bodfather/wt-storefront-theme-tweak/issues).

== Screenshots ==

1. General tab: Real-time toggles and CSS editors with syntax highlighting and autocomplete.
2. API Token tab: Securely save your GitHub token for private repo updates.

== Changelog ==

= 0.0.2 =
* Enhanced toggle system with AJAX for instant updates (Storefront style, middle menu, admin CSS visibility).
* Shifted CSS saving to standalone files (front-end and admin) with nonce security for safer submissions.
* Improved API token handling: Manual "Save Changes" required, auto-migrates old tokens to new storage, and cleans up legacy options.
* Optimized admin interface: Removed "Save Changes" from General tab (uses AJAX/custom saves), streamlined scripts (renamed to `wt-sftt-admin.js`).
* Added CodeMirror autocomplete for smarter CSS editing.

= 0.0.1 =
* Initial release.
* Toggles for Storefront style and middle menu.
* CodeMirror CSS editors with syntax highlighting and color swatches.
* GitHub update checker with private repo support.
* Tabbed admin interface.

== Upgrade Notice ==

= 0.0.2 =
Upgrade for real-time toggles, secure CSS saves, and smoother API token management.

= 0.0.1 =
Initial release—get tweaking!

== Contributing ==

Love to have you aboard! Fork the repo, tweak away, and send a pull request to the `main` branch at [GitHub](https://github.com/bodfather/wt-storefront-theme-tweak).