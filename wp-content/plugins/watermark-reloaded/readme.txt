=== Plugin Name ===
Contributors: sverde1
Donate link: http://randomplac.es/wordpress-plugins/donate/
Tags: watermark, images, upload, Post, admin
Requires at least: 2.9
Tested up to: 3.0.1
Stable tag: 1.2.5

Add watermark to your uploaded images and customize your watermark appearance in user friendly settings page.

== Description ==

This plugin allows you to watermark your uploaded images. You can create watermark with different fonts and apply it
to different image sizes (thumbnail, medium, large, fullsize), positioning it anywhere on the image.

Requirements:

* PHP5
* GD extension for PHP
* FreeType Library

To-do:

* Bug fixing (request by: all)
* Don't display watermark on images where watermark would overflow image (request by: alex)
* Watermark background color and opacity (request by: quentin, alex, Richard, nick)
* Option to disable watermark on certain pictures (request by: anchy-9, Yannick Chauvet)
* Watermarking aditional image sizes added by other plugins (request by: twincascos)
* Watermark pictures with image (request by: Loverock, Nicolas)
* Watermarking images that were uploaded before plugin was installed (request by: anchy-9, Blogging Junction, Ashkir, Mobile Ground, Nicolas)
* Watermark text with outline (request by: James)
* ...

== Installation ==

1. Upload `watermark-reloaded/` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to Watermark RELOADED settings and enable watermark

== Frequently Asked Questions ==

= Plugin doesn't work ... =

Please specify as many informations as you can to help me debug the problem. Check in your error.log if you can.

= Error message says that I don't have GD extension installed =

Contact your hosting provider and ask him to enable GD extension for your host, because without GD extension you can
say good bye to watermarking.

= Error message says that I don't have FreeType Library =

Contact your hosting provider and ask him to install FreeType Library on your host, without it you can't make text watermarks.

= Is there any way to watermark previously uploaded images? =

No there's no way to watermark previously uploaded images and probably this feautre won't exist.

== Screenshots ==

1. Screenshot of settings page
2. Example of watermarked picture with applyed above watermark settings

== Changelog ==

= 1.0 =
* Initial release

= 1.0.1 =
* Fixed plugin URI
* Added some more fonts

= 1.0.2 =
* Added PHP 5 dependency check
* Added GD extension dependency check
* Added FreeType Library dependency check
* Rewritten error messages output
* Added donations link

= 1.2 =
* Added color picker for changing text watermark color
* Added watermark preview
* Added a little bit of a nagging for donation :)

= 1.2.1 =
* Fixed unicode chars bug

= 1.2.2 =
* Fixed "Enable watermark for" checkboxes save bug

= 1.2.3 = 
* Fixed "Could not find font" bug
* Updated donation nagging functionality

= 1.2.4 =
* Added auto-patch for font bug fixed in previous version

= 1.2.5 =
* Bugfix on upgrade to Wordpress 3.0
