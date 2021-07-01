# v1.5.2
##  10-07-2021

1. [](#improved)
    * new option in settings to add encryption on output (without caching), to avoid conflict with other output-altering plugins such as Automagic Images

# v1.5.1
##  25-05-2021

1. [](#improved)
    * changed code to add encryption before caching, not on output
    * removed mention of an old bug that has since been fixed from README

# v1.5
##  16-03-2021

1. [](#bugfix)
    * fixed output of mailto links with title tags
    * added default settings for target (thanks @JohnWalkerx!)

# v1.4.2
##  13-02-2021

1. [](#improved)
    * added option in plugin settings to set target="\_blank" on mailto links

# v1.4.1
##  24-11-2020

1. [](#bugfix)
    * changed curly braces to square ones for accessing array items since that notation is deprecated as of PHP 7.4

# v1.4
##  13-07-2020

1. [](#bugfix)
    * email addresses wrapped in mailto: tags now get properly encrypted in the linked text as well

# v1.3
##  26-12-2019

1. [](#new)
    * you can now wrap images in a mailto link and these will also get encrypted; please refer to the README for caveats
1. [](#bugfix)
    * the bug where every other noscript text was getting vanished when javascript was disabled seems to have gone away now

# v1.2.6
##  28-11-2019

1. [](#improved)
    * the plugin can now be disabled for individual pages
    * README.md updated to reflect this change

# v1.2.5
##  17-09-2019

1. [](#improved)
    * existing mailto links are now converted properly too (fixes a compatibility issue with the flex-directory plugin)
    * README.md updated to reflect this change

# v1.2.4
##  02-08-2019

1. [](#bugfix)
    * fixed link to README in `blueprints.yaml`

# v1.2.3
##  18-07-2019

1. [](#improved)
    * took out html comment tags around the inline javascript to fix a [compatibility issue](https://github.com/skinofthesoul/grav-plugin-antispam/issues/3) with the [minifyHTML](https://github.com/jimblue/grav-plugin-minify-html) plugin

# v1.2.2
##  02-07-2019

1. [](#bugfix)
    * bumped the version number in `blueprints.yaml`

# v1.2.1
##  01-07-2019

1. [](#improved)
    * modified regex again to only exclude domains that consist of only a digit followed by an x

# v1.2.0
##  01-07-2019

1. [](#bugfix)
    * changed regex to exclude domains that start with a digit, to avoid replacing responsive images like `image@2x.jpg`

# v1.1.3
##  14-05-2019

1. [](#bugfix)
    * fixed Github links in `blueprints.yaml`

# v1.1.2
##  10-05-2019

1. [](#bugfix)
    * email addresses containing hyphens or underscores work now

# v1.1.1
##  30-04-2019

1. [](#improved)
    * changed icon from plug to at
    * minor edits and more todo in readme

# v1.1.0
##  08-04-2019

1. [](#new)
    * configurable noscript text with language support
    * installation via GPM
2. [](#improved)
    * minor edits in readme and blueprints
    * changed license from GNU GPL3 to MIT

# v1.0.0
##  06-04-2019

1. [](#new)
    * Initial release
