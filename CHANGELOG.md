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
