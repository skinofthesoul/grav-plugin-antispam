# Antispam Plugin

This **Antispam** Plugin is for [Grav CMS](http://github.com/getgrav/grav). It will look for plaintext email addresses in your Grav pages and turn them into javascript encoded mailto links.

## Installation

Installing the Antispam plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line). From the root of your Grav install type:

    bin/gpm install antispam

This will install the antispam plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/antispam`.

If you have the Admin plugin installed, you can also install it there under `plugins > add`.

### Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `antispam`. You can find these files on [GitHub](https://github.com/skinofthesoul/antispam).

You should now have all the plugin files under

    /your/site/grav/user/plugins/antispam

> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav) and the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) to operate.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/antispam/antispam.yaml` to `user/config/plugins/antispam.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
```

Note that if you use the admin plugin, a file with your configuration, and named antispam.yaml will be saved in the `user/config/plugins/` folder once the configuration is saved in the admin.

### Disable for individual pages

Putting `antispam: false` in the frontmatter of a page will disable the processing for this page. This may be useful if you have a form where people enter their email addresses, Antispam may break the processing of such a form.

### Custom noscript text
If you want to change the text that will appear in the `<noscript>` section of the encrypted addresses, copy the language contents of `user/plugins/antispam/languages.yaml` that you wish to change to `user/languages/en.yaml` or another language file respectively, and change that so your custom text will not get overridden when the plugin is updated.

### Notes

Please keep in mind that this script will not find everything that might be a valid email address as it uses a fairly simple regex expression. If you have a use case with email addresses that do not get converted, please open an issue and I'll see what I can do!

This especially includes email addresses of domains that only consist of a digit followed by an x. These will not get converted to avoid clashes with responsive images like `image@2x.jpg`.

As of version 1.3, you can also wrap an image in a mailto link and it will get encrypted correctly. However, this has made the regular expressions in my code a lot more complex and thus error prone, so you may well run into issues I have not foreseen. For the moment this means that plain text email addresses must be preceded by either whitespace or the `>` character *in the html code that the markdown gets turned into*. This should usually be the case, but if you should happen to get unexpected results on your page, please file an issue and **let me know what your input was**.

Please notice also that the inline javascript is not wrapped in CDATA tags (nor html comment tags). If you need XHTML compatibility, please file an issue and I'll see what I can do!

## Usage

Just install and enable it and enjoy spam protection for your email addresses! Please note that **you do not need to put any mailto links around your email addresses in your pages** (but you can, as of v1.2.5). Those will be added by the plugin.

## Credits

All credit goes to the creators of the original script, which I simply assembled in this plugin:

* Email obfuscator script 2.1 by Tim Williams, University of Arizona
* Random encryption key feature by Andrew Moulden, Site Engineering Ltd
* PHP version coded by Ross Killen, Celtic Productions Ltd

You can find this script along with an article by Ross Killen on email obfuscation at [celticproductions.net](http://www.celticproductions.net/articles/10/email/php-email-obfuscator.html).

