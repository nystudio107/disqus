# Disqus Changelog

## 1.1.0 - 2017.03.18
### Added
* All settings can now be overridden via `config.php` in a multi-environment friendly way
* Added multi-lingual support for both the Disqus embed and comments
* Added Composer support
* Broke out the changelog into `CHANGELOG.md`

### Changed
* Separated the various tags out into Twig templates
* Cleaned up & refactored the templates & code

### 1.0.3 - 2016.10.03
 
 * [Fixed] Resolve broken $disqusIdentifier encoding when set as a string.
 * [Fixed] Fixes Disqus from loading when encoding the URL
 * [Improved] Updated README.md
 
 ### 1.0.2 - 2016.09.19
 
 * [Improved] We now JSON-encode the data in the Disqus embed
 * [Improved] Added data-cfasync=false to the script tags for CloudFlare RocketScript support
 * [Improved] Updated README.md
 
 ### 1.0.1 - 2015.11.23
 
 * Added support for Craft 2.5 new plugin features
 * Added a controller to handle the custom logout URL
 * Fixed an issue where custom avatars no longer appeared
 
 ### 1.0.0 - 2015.05.09
 
 * Initial release

Brought to you by [nystudio107](http://nystudio107.com)