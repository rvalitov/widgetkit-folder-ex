![Version](https://img.shields.io/badge/Release-v1.2.7-green.svg?style=flat) ![Widgetkit](https://img.shields.io/badge/Widgetkit-v2.4.x+-green.svg?style=flat) ![Widgetkit 3](https://img.shields.io/badge/Widgetkit_3-not_supported-red.svg?style=flat) ![Joomla](https://img.shields.io/badge/Joomla!-v3.4.x+-yellow.svg?style=flat) ![Wordpress](https://img.shields.io/badge/Wordpress-v4.4.x+-yellow.svg?style=flat) ![PHP7](https://img.shields.io/badge/PHP7-compatible-blue.svg?style=flat) ![YoothemePro](https://img.shields.io/badge/YoothemePro-compatible-blue.svg?style=flat)

![FolderEx Widgetkit Content Provider logo](https://raw.githubusercontent.com/wiki/rvalitov/widgetkit-folder-ex/images/logo.jpg)

**Attention! This is a content plugin, not a widget! Follow the installation instructions carefully.**

__Notice about Widgetkit 3 and status of this project__: Yootheme [announced](https://yootheme.com/blog/2021/01/26/widgetkit-3.0-completely-rebuilt-with-uikit-3) a third version of Widgetkit on January 26th, 2021.
I received reports that after upgrade to Widgetkit 3 my widgets do not work properly.
I'm very sorry that I currently not able to devote my time to this project to develop it further.
In its current state it's "bug free" and works with Widgetkit 2 and Joomla 3.
Currently, I don't have plans to add support for Widgetkit 3 or add any other serious improvements.
This project has been my pet project that I was doing in my free time, and I've been happy to share it for free with the community.
As I stopped using Widgetkit in my own websites, I lost motivation in further updates to this project.
I'm happy if my work and widgets were of any help or use in your websites!

# Overview
**FolderEx** is a Content Provider plugin for [Yootheme Widgetkit2](https://yootheme.com/widgetkit). It's a superior version of a standard Folder Content Provider that allows to use files as items for a widget. After installation it becomes available for any standard or custom widgets. Especially the FolderEx is optimal for use with image related widgets, for example:

* Standard Widgets
	* [Gallery Widget](http://yootheme.com/demo/widgetkit/joomla/index.php/home/gallery)
	* [Slideshow Widget](http://yootheme.com/demo/widgetkit/joomla/index.php/home/slideshow)
	* [Slideset Widget](http://yootheme.com/demo/widgetkit/joomla/index.php/home/slideset)
* Our custom Extended Widgets 
	* [SlideshowEx Widget](https://github.com/rvalitov/widgetkit-slidesetlightbox)
	* [Slideset Lightbox Widget](https://github.com/rvalitov/widgetkit-slidesetlightbox)

## Features
For detailed information, please refer to the [manual](https://github.com/rvalitov/widgetkit-folder-ex/wiki). Quick comparison between Folder and FolderEx is [here](https://github.com/rvalitov/widgetkit-folder-ex/wiki/Quick-comparison-Folder-VS-FolderEx).

### Basic Features

* **Select a source folder** - it's a directory that contains files that will be used as a source for content items of a widget.
* **Ordering options** - the files can be sorted in direct and reverse order alphabetically, by modification date and randomly.
* **Limit number of items** - the maximum number of files that will be loaded can be limited.
* **Backward compatibility** - all other behavior, styling and features of the original Folder Content Provider are preserved.
* **Use with your existing data** - you can easily convert your existing widgets to use FolderEx as a content provider.

### Unique Features
The new features that the FolderEx has and that are not available in the original Folder Content Provider:
 
* **Sophisticated Filtering** - complete freedom to apply any filtering of files using RegExp patterns, [read more](https://github.com/rvalitov/widgetkit-folder-ex/wiki/Filtering-Patterns).
* **Better control of titles** - more options are available to control how the titles are created from the file names, e.g. replacement of dashes and/or underscores into space character.
* **Non Latin characters in file names** - you can name the files as you want in your native language, using non Latin characters, e.g. accents or Cyrillic characters. For example: `équipe.jpg`, `Животное.jpg`, `Übergabe.jpg`.
* **Offset** - defines how many images should be skipped from the start. See [Use Case: Large Galleries with Lots of Photos](https://github.com/rvalitov/widgetkit-folder-ex/wiki/Large-galleries-with-lots-of-photos)
* **Tooltips for all options** - it's much easier to use the widget, because tooltips are available for all settings.
* **Update notifications** - you will be notified if new versions of the plugin are available.
* **Multilingual interface**, translated into languages:
	* **English** (en_GB)
	* **Русский** (ru_RU)
	* **Deutsch** (de_DE)
	* Your language not listed? You can help with translation, [read more](https://github.com/rvalitov/widgetkit-folder-ex/wiki/Translation-issues). 

# Supported platforms
* The initial code is based on Widgetkit 2.7.3 and was updated if necessary. It should work with any Widgetkit 2.4.x and later (recommended 2.5.0+). Tested in Widgetkit 2.7.x, 2.8.x, 2.9.x.
* The following CMS are supported:
	* Joomla 3.4.x or later. Tested in Joomla 3.4.x, 3.5.x, 3.6.x.
	* Wordpress 4.4.x or later

**Read full system requirements [here](https://github.com/rvalitov/widgetkit-folder-ex/wiki/System-requirements).** 

# How to install?
The installation procedure is described [here](https://github.com/rvalitov/widgetkit-folder-ex/wiki/How-to-install).

# The manual
The manual is available in the [Wiki area](https://github.com/rvalitov/widgetkit-folder-ex/wiki).

# Authors, Contributors and Acknowledgment
* This plugin is created by [Ramil Valitov](http://www.valitov.me).
* The code is based on the original Folder Content Provider by [Yootheme](http://yootheme.com/).
* Icon designed by [iSuite Revoked](http://prax-08.deviantart.com/) is used in logo.
* Thanks to [Marco Rensch](https://github.com/marcorensch) for making translation to German language.

## Disclaimer
This project is NOT affiliated with, endorsed, or sponsored by the Yootheme. Widgetkit, its name, trademark, and other aspects of the app are trademarked and owned by their respective owners.

# Feedback
Your feedback is very appreciated. If you want to see new features in this module, please, post your ideas and feature requests in the [issue tracker](https://github.com/rvalitov/widgetkit-folder-ex/issues).

# Donations
This is a free project that I do in my spare time. If you find it useful, then you can support it by donating some amount of money. This will help to keep the project alive and making it better: develop new features, make new releases, fix bugs, update the [manuals](https://github.com/rvalitov/widgetkit-folder-ex/wiki), and provide at least some minimal technical support (there's an [issue tracker here](https://github.com/rvalitov/widgetkit-folder-ex/issues)).

You can choose any payment method you prefer:

Your Currency | Payment Method
------------ | -------------
Euro € | [![Card](https://img.shields.io/badge/EURO-Debit/Credit%20Card-6f202b.svg?style=flat)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=BJJF3E6DBRYHA) [![PayPal](https://img.shields.io/badge/EURO-PayPal-blue.svg?style=flat)](https://www.paypal.me/valitov/0eur) 
USD $ | [![Card](https://img.shields.io/badge/USD-Debit/Credit%20Card-6f202b.svg?style=flat)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=B8VMNU7SEAU8J) [![PayPal](https://img.shields.io/badge/USD-PayPal-blue.svg?style=flat)](https://www.paypal.me/valitov/0usd) 
Russian Ruble ₽ | [![Card](https://img.shields.io/badge/RUB-Debit/Credit%20Card-6f202b.svg?style=flat)](https://money.yandex.ru/to/410011424143476) [![PayPal](https://img.shields.io/badge/RUB-PayPal-blue.svg?style=flat)](https://www.paypal.me/valitov/0rub) [![YandexMoney](https://img.shields.io/badge/RUB-YandexMoney-5b0d56.svg?style=flat)](https://money.yandex.ru/to/410011424143476)
Other | [![Card](https://img.shields.io/badge/OTHER-Debit/Credit%20Card-6f202b.svg?style=flat)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=BJJF3E6DBRYHA) [![PayPal](https://img.shields.io/badge/OTHER-PayPal-blue.svg?style=flat)](https://www.paypal.me/valitov)

# Support or Contact
Having trouble with FolderEx Content Provider? May be something has already been described in the [Wiki area](https://github.com/rvalitov/widgetkit-folder-ex/wiki) or reported in the [issue tracker](https://github.com/rvalitov/widgetkit-folder-ex/issues). If you don't find your problem there, then, please, add your issue there. 

Being a free project which I do in my spare time, I hope you understand that I can't offer 24/7 support:) You may contact me via e-mail ramilvalitov@gmail.com, I will try to answer to all of them (if such messages imply an answer), however, not immediately, it may take a few days or a week... so, just be patient. 

Note, that I can answer only to questions and problems directly related to FolderEx plugin. Answers to basic questions about the widgetkit nature and simple help about how to use widgets in general or how to use Joomla you can find in appropriate forums:

* [Joomla](http://forum.joomla.org/)
* [Widgetkits](https://yootheme.com/support)
