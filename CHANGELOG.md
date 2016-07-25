# Change Log

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
### Added

* This changelog

### Changed

* License is now markdown

### Fixed

* versioneye.com link was wrong in README.

## [1.1.1] - 2016-07-24

The purpose of this release is to add some glam to the readme

### Added

* Added coveralls
* Added some new badges to the README

## [1.1.0] - 2016-07-24

The focus of this release is moving away from this being tied to twig.

### Changed

* Business logic now all in [PurpleBooth/htmlstrip]

### Deprecated

* `HtmlStripperExtension->toText($html)` - Use the client library instead.

## [1.0.2] - 2016-07-24

The primary focus of this release is to tidy up the code.

### Added

* Added basic editor type hinting via [.editorconfig](http://editorconfig.org/)
* Started following the PSR standards
* Added tests for our PSR compliant coding standard using Scrutinizer

### Changed

* Fixed the build on Travis
* Started testing against: 5.4, 5.5, 5.6, 7.0, and the nightly builds of PHP

### Removed

* PHP 5.3 is no longer supported, as we use short array syntax.
* Removing composer lock file, it's not used by projects that include us anyway

### Fixed

* Fix a memory leak where we don't correctly clear down the stacks,
  which could cause the library to use more memory in a long running
  process or when parsing a large document.

## [1.0.1] - 2014-02-05

### Added

Links are now transformed like:

 Input:
  ```html
 <a href="http://pleasestopbeingsad.tumblr.com/">Quote source</a>
 ```

 Output:
 ```
 Quote source (http://pleasestopbeingsad.tumblr.com/)
 ```

## [1.0.0] - 2014-02-04

### Added

Everything.

Has support for

* Divs
* Paragraphs
* Lists
* Block Quotes

[Unreleased]: https://github.com/PurpleBooth/twig-htmlstrip/compare/v1.1.1...HEAD
[1.1.1]: https://github.com/PurpleBooth/twig-htmlstrip/compare/v1.1.0...v1.1.1
[1.1.0]: https://github.com/PurpleBooth/twig-htmlstrip/compare/v1.0.2...v1.1.0
[1.0.2]: https://github.com/PurpleBooth/twig-htmlstrip/compare/v1.0.1...v1.0.2
[1.0.1]: https://github.com/PurpleBooth/twig-htmlstrip/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/PurpleBooth/twig-htmlstrip/commit/793194072d2f491e9f7b75a1130239793403b65e
[PurpleBooth/htmlstrip]: https://github.com/PurpleBooth/htmlstrip
