# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.7.2] 2018-07-10
### Added
- Api host optional parameter

## [0.7.1] 2018-07-05
### Changed
- Updating `composer.json`

## [0.7.0] 2018-05-31
### Added
- Creating our own cache adapter `weglot.translations`
- New command to clear our cache adapter
- Using clean Symfony cache pool
### Removed
- `cache.app` usage has been removed
### Changed
- Updating `composer.json`

## [0.6.11] 2018-05-24
### Fixed
- Removing too early service import

## [0.6.10] - 2018-05-23
### Fixed
- Missing import in DI

## [0.6.9] - 2018-05-15
### Changed
- Implementing Util.Url class for HrefLangs links

## [0.6.8] - 2018-05-15
### Changed
- Updated weglot/weglot-php library version

## [0.6.7] - 2018-05-07
### Fixed
- removing useless subscribed event

## [0.6.6] - 2018-05-07
### Fixed
- user-agent customization

## [0.6.5] - 2018-05-07
### Added
- Adding custom user-agent when using library

## [0.6.4] - 2018-05-07
### Added
- Adding slack tag in README
### Changed
- Updated weglot/weglot-php library version

## [0.6.3] - 2018-04-25
### Changed
- Updated weglot/weglot-php library version

## [0.6.2] - 2018-04-25
### Fixed
- Exception when Twig filter `language` is used with a non-valid ISO 639-1 code

## [0.6] - 2018-04-24
### Added
- Caching implementation for Symfony 3 & 4 based on `cache.app` system service
- HrefLangs support for Twig through `{{ weglot_hreflang_render() }}` function in templates
### Changed
- Updating README with Symfony 4, 3, 2 example
### Removed
- Twig template enum (not working well)

## [0.5] - 2018-04-17
### Added
- Using [Weglot PHP library](https://github.com/weglot/weglot-php) to communicate with Weglot API.
### Removed
- Services classes

## [0.3] - 2018-04-06
### Added
- `php-cs-fixer` configuration file

### Fixed
- Symfony 4 support

### Changed
- camelCase support

## [0.2] - 2018-03-07
### Added
- README
- 2 templates for Twig with languages routes

## [0.1] - 2018-11-16
### Added
- Implement Weglot translate api with custom routing
