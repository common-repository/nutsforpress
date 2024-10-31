=== NutsForPress Images and Media ===

Contributors: Christian Gatti
Tags: NutsForPress,image,thumbnail,resize,rebuild,optimize,compress,title,alt,meta,media
Donate link: https://www.paypal.com/paypalme/ChristianGatti
Requires at least: 5.3
Tested up to: 6.5
Requires PHP: 7.x
Stable tag: 1.7
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

NutsForPress Images and Media is an essential tool for having your images and your meta in perfect order.


== Description ==

*Images and Media* is one of the several NutsForPress plugins providing some essential features that WordPress does not offer itself or offers only partially.  

*Images and Media* allows you to:

* define an image size threshold and automatically resize on upload the images exceeding that threshold, without involving the original image
* prevent GIF images to be resized (by this plugin and by WordPress too) to avoid risk of breaking their animation
* define a JPEG compression level and automatically compress JPEG on upload to that compression quality, without involving the original image
* bulk rebuild thumbnails (size and quality) from the original image and with WordPress native functions, filters and hooks
* bulk rebuild missing PDF preview images

Images and Media is full compliant with WPML (you don't need to translate any option value)

Take a look at the others [NutsForPress Plugins](https://wordpress.org/plugins/search/nutsforpress/)

**Whatever is worth doing at all is worth doing well**


== Installation ==

= Installation From Plugin Repository =

* Into your WordPress plugin section, press "Add New"
* Use "NutsForPress" as search term
* Click on *Install Now* on *NutsForPress Images and Media* into result page, then click on *Activate*
* Setup "NutsForPress Images and Media" options by clicking on the link you find under the "NutsForPress" menu
* Enjoy!

= Manual Installation =

* Download *NutsForPress Images and Media* from https://wordpress.org/plugins/nutsforpress
* Into your WordPress plugin section, press "Add New" then press "Load Plugin"
* Choose nutsforpress.zip file from your local download folder
* Press "Install Now"
* Activate *NutsForPress Images and Media*
* Setup "NutsForPress Images and Media" options by clicking on the link you find under the "NutsForPress" menu
* Enjoy!


== Changelog ==

= 1.7 =
* Fixed a bug that caused the reset of the options of this plugin when WPML was installed and activated after the configuration of this plugin

= 1.6 =
* Tested up to WordPress 6.2

= 1.5 =
* Now translations are provided by translate.wordpress.org, instead of being locally provided: please contribute!

= 1.3.4 =
* Automatic fill in function and bulk rebuild function for attachments meta are now migrated to "NutsForPress Indexing and SEO" plugin

= 1.3.3 =
* Fixed an annoying bug that on some conditions caused an incorrect deletion of images on WPML secondary languages

= 1.3.2 =
* Fixed a bug that displayed some option messages that should have been kept hidden by a css rule miswritten by an escape rule

= 1.3.1 =
* Fixed a bug that caused to some urls contained into some descriptions in the plugin options were showed as html code, instead of clickable urls 

= 1.3 =
* New root version, in order to welcome a new NutsForPress plugin
* Security improved by escaping echoed variables

= 1.2.5 =
* Removed the function that took care of producing the seven custom sized thumbnails, because on some servers it caused timeout problems

= 1.2.4 =
* Fixed a bug that prevented from saving local options when WPML is not active

= 1.2.3 =
* Root functions improvement

= 1.2.2 =
* Just a small style enhancement and some minor bug fix

= 1.2.1 =
* Bug correction on a WPML function that was causing an error on image upload when WPML was activated

= 1.2 =
* Please deactivate and reactivate after update and do a new set up: changed the way "NutsForPress" plugins coexist with each other

= 1.1 =
* Some minor changes into readme file
* Better method for dealing with options page

= 1.0 =
* First full working release


== Translations ==

* English: default language
* Italian: entirely translated


== Credits ==

* Very many thanks to [DkR](https://www.dkr.srl/) and [SviluppoEuropa](https://www.sviluppoeuropa.it/)!