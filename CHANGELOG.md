# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.6.2] - 25/04/2018
### Changed
- Updated weglot/weglot-php library version

## [0.6.2] - 25/04/2018
### Fixed
- Exception when Twig filter `language` is used with a non-valid ISO 639-1 code

## [0.6] - 24/04/2018
### Added
- Caching implementation for Symfony 3 & 4 based on `cache.app` system service
- HrefLangs support for Twig through `{{ weglot_hreflang_render() }}` function in templates
### Changed
- Updating README with Symfony 4, 3, 2 example
### Removed
- Twig template enum (not working well)

## [0.5] - 17/04/2018
### Added
- Using [Weglot PHP library](https://github.com/weglot/weglot-php) to communicate with Weglot API.
### Removed
- Services classes

## [0.3] - 06/04/2018
### Added
- `php-cs-fixer` configuration file

### Fixed
- Symfony 4 support

### Changed
- camelCase support

## [0.2] - 07/03/2018
### Added
- README
- 2 templates for Twig with languages routes

## [0.1] - 16/11/2018
### Added
- Implement Weglot translate api with custom routing