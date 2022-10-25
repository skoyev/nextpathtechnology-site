=== Simple Basic Contact Form ===

Plugin Name: Simple Basic Contact Form
Plugin URI: https://wordpress.org/plugins/simple-basic-contact-form/
Description: A secure contact form that&rsquo;s fast and flexible.
Tags: contact, form, contact form, email, mail,  captcha, spam, anti spam, anti-spam, antispam
Author: WPKube
Author URI: https://wpkube.com/
Contributors: WPKube
Requires at least: 4.1
Tested up to: 5.9
Stable tag: 20220207
Requires PHP: 5.2
Text Domain: scf
Domain Path: /languages
License: GPL v2 or later

A clean, secure, plug-&-play contact form for WordPress.

== Description ==

[Simple Basic Contact Form](https://wordpress.org/plugins/simple-basic-contact-form/) is a clean, secure, plug-&-play contact form for WordPress. Minimal yet flexible, SBCF delivers clean code, solid performance, and ease of use. No frills, no gimmicks, just a straight-up contact form that's easy to set up and customize.

**Overview**

* Display form anywhere using shortcode or template tag
* Sends descriptive, well-formatted, plain-text messages
* Blocks spam and protects against malicious content
* Contact form is easy to configure via the plugin settings
* Provides a blazing fast, well-optimized contact form
* Code is lightweight, flexible, and standards-compliant

**Core Features**

* Optionally send a carbon copy of each email message
* Slick, toggling panels on the plugin settings screen
* Style the form via the settings screen using custom CSS
* Provides Template Tag to display SBCF anywhere in your theme
* Provides Shortcode to display SBCF on any WP Post or Page
* Displays customizable confirmation message to the sender
* Customizable success message can include email content
* Customizable placeholder text for all form fields
* Option to use PHP's `mail()` or WP's `wp_mail()`

**Anti-spam &amp; Security**

* Optionally display anti-spam captcha to visitors
* Protects against bad bots, malicious input, and other threats
* Clear error messages to help users complete required fields

**Awesome Performance**

* Built with the WP API for optimal security and performance
* Custom CSS styles load only where the contact form is displayed
* Clean source code with proper formatting, alignment and spacing
* Squeaky-clean PHP and valid HTML5 output

**More Features**

* Works perfectly without JavaScript!
* Option to reset default settings
* Options to customize many aspects of the form
* Option to specify a specific time offset for your time zone
* Option to enable, disable, and customize default SBCF styles
* Email message includes IP, host, agent, and other user details
* Customize field captions, error messages, and success message
* Optionally hide Message field to make a simple opt-in form

**What's Next?**

If you like this plugin, then please consider leaving us a rating / review. This plugin is completely free and maintained by [WPKube](https://www.wpkube.com), a WordPress resource site, where you can learn from our free WordPress tutorials like [how to start a blog](https://www.wpkube.com/start-a-wordpress-blog/), [how to install WordPress](https://www.wpkube.com/install-wordpress/), [choose the best WordPress Hosting](https://www.wpkube.com/best-wordpress-hosting/), and [more](https://www.wpkube.com/category/wordpress-tutorials/).

Our other projects:
- [MeridianThemes](https://www.meridianthemes.net) - Beautiful and hand-crafted themes for WordPress
- [Optin Forms](http://optinforms.io) - Simple and easy to use plugin for creating optin forms, works with most well know autoresponder services.

== Installation ==

**Installation**

1. Upload the plugin to your blog and activate
2. Visit the settings to configure your options

[More info on installing WP plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins)


**Usage**

Once the settings are configured, you can display the form anywhere using the Shortcode or Template Tag.


__Shortcode__

Use the SBCF Shortcode to display the contact form on any WP Post or Page:

	[simple_contact_form]


__Template tag__

Use the SBCF Template Tag to display the contact form anywhere in your theme template:

	<?php if (function_exists('simple_contact_form')) simple_contact_form(); ?>


**Upgrades**

To upgrade SBCF, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

__Note:__ uninstalling the plugin from the WP Plugins screen results in the removal of all settings from the WP database. 


**Restore Default Options**

To restore default plugin options, either uninstall/reinstall the plugin, or visit the plugin settings &gt; Restore Default Options.


**Uninstalling**

Simple Basic Contact Form cleans up after itself. All plugin settings will be removed from your database when the plugin is uninstalled via the Plugins screen.


== Upgrade Notice ==

To upgrade SBCF, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

__Note:__ uninstalling the plugin from the WP Plugins screen results in the removal of all settings from the WP database. 



== Screenshots ==

1. Simple Basic Contact Form: Displayed on WP Twenty Sixteen theme
2. Simple Basic Contact Form: Plugin settings screen (panels toggle open/closed)



== Frequently Asked Questions ==

**What is the plugin setting for the "From" email header?**

That setting enables you to customize the address used as the "From" header for email messages.
Keep in mind that if your site is example.com and you use john@somethingelse.com it's likely that your hosting provider will block the emails from being sent.
So, it's best to keep this setting to be an existing email address located on the same domain as your site.

== Changelog ==

**20220207**

* Fixed PHP undefined index notice (scf_recaptcha)
* Fixed PHP 8 deprecated notice (required parameter follows optional parameter)

**20210619**

* Blacklisted words are now case-insensitive
* Fixed PHP warning (empty needle) related to blacklisted words 

**20210409**

* The confirmation page now "jumps" to the confirmation message (it used to just remain at the top of the page which in some cases meant the confirmation message is not in view)
* Issue with Custom CSS position

**20210323**

* Google reCaptcha V3 compatibility
* Render shortcodes in all custom content
* Accesibility fixes
* Dynamic subjects
* Duplicate emails issue when form more than once on page

**20210129**

* Google reCAPTCHA now available

**20201229**

* Accessibility fix - GDPR form label
* Accessibility fix - Fieldset was missing legend

**20200901**

* Option to select the position of the GDPR message (before or after submit button)

**20200324**

* Fixed issue with translation files not having all the strings

**20200219**

* Option to add an "email confirmation" field

**20200207**

* Option to add blacklisted words and terms. If a message contains a word/term from the list it will be shown as successfully sent but it will actually NOT be sent.

**20191024**

* Ability to include date in the subject by adding shortcode [simple_contact_form_date] in the "Default Subject" option. Default format is the one set in WP admin > Settings > General. For custom format use [simple_contact_form_date]d/m/Y[/simple_contact_form_date]

**20191009**

* Option to add custom HTML right before the submit button.

**20190926**

* Ability to send to multiple email addresses

**20190621**

* Option to enable/disable the "Additional information" that's passed in the email. Defaults to disabled.

**20190305**

* Option to change the button text

**20181212**

* Implemented honeypot functionality to combat spam ( disabled by default, can be enabled in WP admin > Settings > Contact Form > Plugin Options > Antispam )

**20181001**

* Automatically scroll down to the form/success section on submit ( page reload )
* Filters added to allow adding custom fields and altering the email content ( example at https://gist.github.com/BobaWebDev/b9a3fc2fc917e860574daadc63defe52 )

**20180602**

* POT ( translation template ) file updated

**20180528**

* Adds option to show a checkbox for GDPR compatibility

**20171103**

* Removes extra `manage_options` check for settings validation
* Tests on WordPress 4.9

**20171102**

* Updates readme.txt :)
* Tests on WordPress 4.9

**20171024**

* Adds extra `manage_options` capability check to modify settings
* Streamlines Support panel in plugin settings
* Tests on WordPress 4.9

**20170801**

* Updates GPL license blurb
* Adds GPL license text file
* Tests on WordPress 4.9 (alpha)

**20170325**

* Tweaks some default form styles
* Adds setting for "From" email address
* Changes form action attribute to blank value
* Adds code tags to message results display
* Refines display of settings panels
* Updates show support panel in plugin settings
* Replaces global `$wp_version` with `get_bloginfo('version')`
* Generates new default translation template
* Tests on WordPress version 4.8

**20161117**

* Refactored entire codebase
* Improved logic of contact form
* Improved sanitization of form input
* Improved handling of character encoding
* Removed deprecated screen_icon()
* Removed deprecated offset setting
* Removed some deprecated files
* Added carbon-copy email message
* Refined plugin settings page
* Updated plugin author URL
* Updated URL for rate this plugin links
* Changed stable tag from trunk to latest version
* Return instead of echo results in `scf_process_contact_form()`
* Changed default setting for `scf_mail_function`
* Refined default settings for label values
* Improved styles for error message and fields
* Settings now accept single or double quotes
* Regenerated default language template
* Tested on WordPress version 4.7 (beta)

**20160813**

* Streamlined &amp; optimized plugin settings page
* Removed support for Intranet Plus plugin
* Removed quotes around charset attributes
* Changed menu link from "SBCF" to "Contact Form"
* Replaced `_e()` with `esc_html_e()` or `esc_attr_e()`
* Replaced `__()` with `esc_html__()` or `esc_attr__()`
* Replaced plain plugin logo with an actual icon ;)
* Added plugin icons and larger banner image
* Improved translation support
* Added more allowed attributes for custom content
* Added option to make message field optional
* Email message now includes the sender's email address
* Fine-tuned form styles
* Tested on WordPress 4.6

**20160408**

* Added Reply-To email header
* Added support for Intranet Plus plugin
* Added UTF-8 as default charset for Content-Type header
* Renamed scf-ro_RO.pot to scf-ro_RO.po
* Added French translation (thanks to mier)
* Added Romanian translation (thanks to Serge)
* Added white-space pre-wrap to form results
* Increased size of "Custom CSS styles" setting
* Added new function, scf_default_styles()
* Replaced icon with retina version
* Added screenshot to readme/docs
* Added retina version of banner
* Reorganized and refreshed readme.txt
* Tested on WordPress version 4.5 beta

**20151111**

* Updated German translation (Thanks to Sven Bamberger)
* Updated heading hierarchy in plugin settings
* Refined scf_process_contact_form()
* Added scf_sanitize_text()
* Added scf_sanitize_message()
* Added scf_full_message filter hook
* Added scf_short_results filter hook
* Added scf_full_results filter hook
* Added scf_send_email action hook
* Updated translation template file
* Updated minimum version requirement
* Tested on WordPress 4.4 beta
* Optimized email headers

**20150808**

* Tested on WordPress 4.3
* Updated minimum version requirement

**20150507**

* Tested with WP 4.2 + 4.3 (alpha)
* Changed a few "http" links to "https"
* Added Dutch translation; thanks to [Martijn van Es](https://github.com/devanes)
* Bugfix: HTML attributes were being stripped from custom error messages

**20150317**

* New! added subject field to the form
* Tested with latest version of WP (4.1)
* Increased minimum version to WP 3.8
* Removed deprecated screen_icon()
* Added $scf_wp_vers for version check
* Added UTF-8 as default for WP option used in htmlentities()
* Replace sanitize_text_field() and filter_var() with sanitize_email() for email address
* Streamline/fine-tune plugin code
* Added nonce security to the form
* Localized some missing strings
* Added Reply-To and Return-Path to email headers
* Added Text Domain and Domain Path to file header
* Replaced default .mo/.po templates with .pot template

**20140925**

* Tested on latest version of WordPress (4.0)
* Increased min-required version to WP 3.7
* Added conditional check to min-version function
* Reorganized the plugin settings page
* Added .scf class to both form div and success div
* Added scf_filter_contact_form filter to form output
* Fixed case-sensitivity bug for challenge question
* Replaced 'UTF-8' with get_option('blog_charset') in scf_process_contact_form()
* Replaced stripslashes(), htmlentities(), filter_var() with sanitize_text_field()
* Fixed weird character issue and backslash issue (related)
* Applied i18n to email content and success message
* Generated new mo/po translation files

**20140305**

* Added default templates for translation/localization
* Added language support for Spanish
* Changed default option for Time Offset

**20140123**

* Tested with latest WordPress (3.8)
* Added trailing slash to load_plugin_textdomain()
* Fixed 3 incorrect _e() tags in core file
* Localized default options

**20131107**

* Renamed `add_plugin_links` to `add_scf_links`
* Revised "Welcome" panel in plugin settings

**20131106**

* Added option to hide extra infos displayed in the success message
* Fixed logic for using `mail()` vs `wp_mail()`
* Removed "&Delta;" from `die()` for better security
* Added i18n/localization support
* Added "rate this plugin" links
* Added uninstall.php file
* Added parameters to `htmlentities` (fixes weird characters issue)
* Replaced `get_permalink()` with empty value in the form
* Changed `$date` to use WordPress settings and format
* Added German translation; thanks to [Benedikt Quirmbach](http://www.LivingDocs.de)
* Fixed character encoding via `filter_var` and `html_entity_decode` in `scf_process_contact_form()`
* Tested on latest version of WordPress (3.7)
* General code cleanup and maintenance

**Version 20130725**

* Tightened form security
* Tightened plugin security

**Version 20130712**

* Fix time offset setting
* Defined UTC as default time
* Improved localization support
* Replaced some deprecated functions
* Added options to customize placeholder text for form inputs
* Added option to use either PHP's mail() or WP's wp_mail() (default)
* Overview and Updates panels now toggled open by default
* General code check n clean

**Version 20130104**

* "Send email" (submit) button now available for translation
* Added option to disable the Captcha (challenge question/response)
* Added option to disable the automatic carbon copy
* Added margin to submit button (now required in 3.5)
* Fixed "Undefined index" warning

**Version 20121205**

* Now hides ugly fieldset borders by default
* Errors now include placeholder attributes
* Anti-spam placeholder now displays challenge question
* Removed blank line from successful message results
* You can now use markup in custom prepend/append content
* Custom CSS now loads on successful result output
* Wrapped successful result output with div #scf_success
* Segregated custom content for form and success results
* Cleaned up some code formatting
* Moved .clear div to optional custom content
* Added link to SBCF CSS Hooks in Appearance options
* Fixed the plugin's built-in time offset

**Version 20121103**

Initial release.


